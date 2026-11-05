<?php

declare(strict_types=1);

/**
 * Request-scoped CSP header emitter for PHP HTML entrypoints.
 *
 * Enforced policy keeps 'unsafe-inline' (no nonce in the header): CSP3 ignores
 * 'unsafe-inline' when a nonce/hash is present, which would break consent-gated
 * Clarity/GTM paths that still need the current allowlist.
 *
 * Report-Only adds 'nonce-…' to script-src (still without 'unsafe-inline') so
 * first-party nonced inline scripts can be measured before enforcement.
 *
 * Static HTML continues to receive CSP from .htaccess (FilesMatch); this
 * bootstrap owns headers for PHP document responses only.
 */

require_once __DIR__ . '/csp-nonce.php';
require_once __DIR__ . '/csp-report-handler.php';

/**
 * Enforced CSP body (identical to the static .htaccess policy for HTML assets).
 */
function nephrosite_csp_enforced_policy(): string
{
    return implode('; ', [
        "default-src 'self'",
        "base-uri 'self'",
        "object-src 'none'",
        "frame-ancestors 'self'",
        "form-action 'self'",
        "script-src 'self' 'unsafe-inline' https://www.googletagmanager.com https://www.clarity.ms https://scripts.clarity.ms https://fastbase.com",
        "style-src 'self' 'unsafe-inline'",
        "font-src 'self'",
        "img-src 'self' https://polascin.net https://www.google.sk https://www.google.com https://www.google-analytics.com https://*.clarity.ms https://c.bing.com",
        "frame-src 'self' https://sk.polascin.net",
        "media-src 'self'",
        "connect-src 'self' https://www.google-analytics.com https://*.google-analytics.com https://analytics.google.com https://*.analytics.google.com https://stats.g.doubleclick.net https://*.clarity.ms https://fastbase.com https://*.fastbase.com",
        'report-uri ' . NEPHROSITE_CSP_REPORT_PATH,
        'report-to ' . NEPHROSITE_CSP_REPORT_GROUP,
    ]);
}

/**
 * Report-Only CSP body. When $withNonce is true, script-src includes the
 * current request nonce (PHP pages). Static .htaccess RO omits the nonce.
 */
function nephrosite_csp_report_only_policy(bool $withNonce = true): string
{
    $scriptSrc = ["'self'"];
    if ($withNonce) {
        $scriptSrc[] = "'nonce-" . nephrosite_csp_nonce() . "'";
    }

    return implode('; ', [
        "default-src 'self'",
        "base-uri 'self'",
        "object-src 'none'",
        "frame-ancestors 'self'",
        "form-action 'self'",
        'script-src ' . implode(' ', $scriptSrc),
        "style-src 'self' 'unsafe-inline'",
        "font-src 'self'",
        "img-src 'self' https://polascin.net",
        "frame-src 'self'",
        "media-src 'self'",
        "connect-src 'self'",
        'report-uri ' . NEPHROSITE_CSP_REPORT_PATH,
        'report-to ' . NEPHROSITE_CSP_REPORT_GROUP,
    ]);
}

/**
 * Emit enforced + Report-Only CSP headers once per request (before body output).
 */
function nephrosite_csp_send_headers(): void
{
    static $sent = false;
    if ($sent || headers_sent()) {
        return;
    }
    $sent = true;

    header('Content-Security-Policy: ' . nephrosite_csp_enforced_policy());
    header('Content-Security-Policy-Report-Only: ' . nephrosite_csp_report_only_policy(true));
}
