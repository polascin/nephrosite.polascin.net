<?php

declare(strict_types=1);

/**
 * First-party CSP report sink (Report-Only + enforced report-uri / report-to).
 *
 * Safety goals: POST-only, size-capped, no reflected output, no PII beyond
 * what browsers already put in CSP reports, append-only JSONL under private/.
 */

const NEPHROSITE_CSP_REPORT_MAX_BYTES = 8192;
const NEPHROSITE_CSP_REPORT_LOG_MAX_BYTES = 524288; // 512 KiB rotate threshold
const NEPHROSITE_CSP_REPORT_GROUP = 'csp';
const NEPHROSITE_CSP_REPORT_PATH = '/csp-report.php';

/**
 * Absolute path to the append-only JSONL log (created on demand).
 */
function nephrosite_csp_report_log_path(): string
{
    return dirname(__DIR__) . '/private/csp-reports/reports.jsonl';
}

/**
 * Keep only known CSP report fields; truncate long strings.
 *
 * @param mixed $payload
 * @return list<array<string, mixed>>
 */
function nephrosite_csp_sanitize_reports(mixed $payload): array
{
    $items = [];
    if (!is_array($payload)) {
        return $items;
    }

    // Legacy report-uri: { "csp-report": { ... } }
    if (isset($payload['csp-report']) && is_array($payload['csp-report'])) {
        $items[] = $payload['csp-report'];
    }

    // Reporting API: [ { "type":"csp-violation", "body":{...} }, ... ]
    $isList = array_is_list($payload);
    if ($isList) {
        foreach ($payload as $entry) {
            if (!is_array($entry)) {
                continue;
            }
            $type = $entry['type'] ?? '';
            if ($type === 'csp-violation' && isset($entry['body']) && is_array($entry['body'])) {
                $items[] = $entry['body'];
            }
        }
    } elseif ($items === [] && isset($payload['blocked-uri'])) {
        $items[] = $payload;
    }

    $allowed = [
        'document-uri',
        'referrer',
        'violated-directive',
        'effective-directive',
        'original-policy',
        'disposition',
        'blocked-uri',
        'status-code',
        'script-sample',
        'source-file',
        'line-number',
        'column-number',
    ];

    $clean = [];
    foreach ($items as $report) {
        if (!is_array($report)) {
            continue;
        }
        $row = [];
        foreach ($allowed as $key) {
            if (!array_key_exists($key, $report)) {
                continue;
            }
            $value = $report[$key];
            if (is_int($value) || is_float($value)) {
                $row[$key] = $value;
                continue;
            }
            if (!is_string($value)) {
                continue;
            }
            $limit = match ($key) {
                'original-policy' => 512,
                'script-sample' => 40,
                default => 256,
            };
            $row[$key] = mb_substr($value, 0, $limit, 'UTF-8');
        }
        if ($row !== []) {
            $clean[] = $row;
        }
    }

    return $clean;
}

/**
 * Append sanitized reports to the private JSONL log. Best-effort; never throws to client.
 *
 * @param list<array<string, mixed>> $reports
 */
function nephrosite_csp_append_reports(array $reports): void
{
    if ($reports === []) {
        return;
    }

    $path = nephrosite_csp_report_log_path();
    $dir = dirname($path);
    if (!is_dir($dir) && !@mkdir($dir, 0750, true) && !is_dir($dir)) {
        return;
    }

    if (is_file($path) && filesize($path) >= NEPHROSITE_CSP_REPORT_LOG_MAX_BYTES) {
        $rotated = $path . '.' . gmdate('YmdHis') . '.rotated';
        @rename($path, $rotated);
    }

    $lines = '';
    $now = gmdate('c');
    foreach ($reports as $report) {
        $lines .= json_encode(
            ['ts' => $now, 'report' => $report],
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        ) . "\n";
    }

    @file_put_contents($path, $lines, FILE_APPEND | LOCK_EX);
}

/**
 * Handle an HTTP CSP report request. Always exits.
 */
function nephrosite_handle_csp_report(): void
{
    header('Cache-Control: no-store');
    header('Referrer-Policy: no-referrer');
    header('X-Content-Type-Options: nosniff');
    header('X-Robots-Tag: noindex, nofollow, noarchive');

    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    if ($method === 'OPTIONS') {
        // Browsers rarely preflight report-uri; keep a minimal response.
        http_response_code(204);
        exit;
    }
    if ($method !== 'POST') {
        http_response_code(405);
        header('Allow: POST, OPTIONS');
        exit;
    }

    $lengthHeader = $_SERVER['CONTENT_LENGTH'] ?? '';
    if (is_numeric($lengthHeader) && (int) $lengthHeader > NEPHROSITE_CSP_REPORT_MAX_BYTES) {
        http_response_code(413);
        exit;
    }

    $raw = file_get_contents('php://input', false, null, 0, NEPHROSITE_CSP_REPORT_MAX_BYTES + 1);
    if ($raw === false) {
        http_response_code(400);
        exit;
    }
    if (strlen($raw) > NEPHROSITE_CSP_REPORT_MAX_BYTES) {
        http_response_code(413);
        exit;
    }
    if ($raw === '') {
        http_response_code(204);
        exit;
    }

    $decoded = json_decode($raw, true);
    if (!is_array($decoded)) {
        // Acknowledge malformed reports to avoid browser retry storms.
        http_response_code(204);
        exit;
    }

    nephrosite_csp_append_reports(nephrosite_csp_sanitize_reports($decoded));
    http_response_code(204);
    exit;
}
