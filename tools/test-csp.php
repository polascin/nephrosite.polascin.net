<?php

declare(strict_types=1);

// No network or deployed configuration changes: render public PHP pages locally.
$root = dirname(__DIR__);
chdir($root);

require_once $root . '/blocks/csp-report-handler.php';
require_once $root . '/blocks/csp-nonce.php';
require_once $root . '/blocks/csp-bootstrap.php';

function check(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

function parsePolicy(string $policy): array
{
    $directives = [];
    foreach (explode(';', $policy) as $directive) {
        $tokens = preg_split('/\s+/', trim($directive));
        $name = array_shift($tokens);
        check($name !== '' && !isset($directives[$name]), 'Empty or duplicate CSP directive.');
        if ($name === 'report-uri') {
            check(
                $tokens === ['/csp-report.php']
                || $tokens === ['https://nephrosite.polascin.net/csp-report.php'],
                'Only the approved first-party report-uri is allowed.'
            );
            $directives[$name] = $tokens;
            continue;
        }
        if ($name === 'report-to') {
            check($tokens === [NEPHROSITE_CSP_REPORT_GROUP], 'Only the approved report-to group "csp" is allowed.');
            $directives[$name] = $tokens;
            continue;
        }
        check(count($tokens) > 0, 'Empty CSP source list: ' . $name);
        foreach ($tokens as $token) {
            check(
                in_array($token, ["'self'", "'none'", "'unsafe-inline'"], true)
                || preg_match("~^'nonce-[A-Za-z0-9_-]+'$~D", $token) === 1
                || preg_match('~^https://(?:\*\.)?[a-z0-9.-]+$~D', $token) === 1,
                'Unexpected or broad CSP source: ' . $token
            );
        }
        $directives[$name] = $tokens;
    }
    return $directives;
}

function permits(array $directives, string $directive, string $url): bool
{
    $sources = $directives[$directive] ?? $directives['default-src'];
    if (str_starts_with($url, '//')) {
        $url = 'https:' . $url;
    }
    $host = parse_url($url, PHP_URL_HOST);
    $scheme = parse_url($url, PHP_URL_SCHEME);
    if ($host === null && $scheme === null) {
        return in_array("'self'", $sources, true);
    }
    if ($scheme !== 'https' || parse_url($url, PHP_URL_PORT) !== null) {
        return false;
    }
    if ($host === 'nephrosite.polascin.net') {
        return in_array("'self'", $sources, true);
    }
    foreach ($sources as $source) {
        if (str_starts_with($source, 'https://*.')) {
            $suffix = substr($source, strlen('https://*'));
            if (is_string($host) && str_ends_with($host, $suffix)) {
                return true;
            }
        }
    }
    return in_array('https://' . $host, $sources, true) && $host !== false;
}

function hasMetaCsp(string $html): bool
{
    preg_match_all('~<meta\b(?:[^>"\']+|"[^"]*"|\'[^\']*\')*>~i', $html, $metaTags);
    foreach ($metaTags[0] as $tag) {
        $attributes = substr($tag, 5, -1);
        $hasHttpEquiv = false;
        $httpEquiv = null;
        while (preg_match(
            '~^\s*(?<name>[^\s"\'<>/=]+)(?:\s*=\s*(?:"(?<double>[^"]*)"|\'(?<single>[^\']*)\'|(?<unquoted>[^\s"\'`=<>]+)))?~s',
            $attributes,
            $match,
            PREG_UNMATCHED_AS_NULL
        )) {
            $attributes = substr($attributes, strlen($match[0]));
            if (!$hasHttpEquiv && strtolower($match['name']) === 'http-equiv') {
                $hasHttpEquiv = true;
                $httpEquiv = $match['double'] ?? $match['single'] ?? $match['unquoted'];
            }
        }
        if (
            $httpEquiv !== null
            && strcasecmp(
                trim(html_entity_decode($httpEquiv, ENT_QUOTES | ENT_HTML5, 'UTF-8')),
                'Content-Security-Policy'
            ) === 0
        ) {
            return true;
        }
    }
    return false;
}

function checkWorkflowWatchesTest(string $workflow, string $event): void
{
    $paths = [];
    $inEvent = false;
    $inPaths = false;
    foreach (preg_split('/\R/', $workflow) as $line) {
        if (preg_match('/^  ([A-Za-z_][A-Za-z0-9_-]*):\s*$/', $line, $match)) {
            $inEvent = $match[1] === $event;
            $inPaths = false;
            continue;
        }
        if (!$inEvent) {
            continue;
        }
        if (preg_match('/^    paths:\s*$/', $line)) {
            $inPaths = true;
            continue;
        }
        if (!$inPaths) {
            continue;
        }
        if (!preg_match('/^      -\s*(.*?)\s*$/', $line, $match)) {
            $inPaths = false;
            continue;
        }
        $paths[] = trim($match[1], "'\"");
    }
    check(in_array('tools/test-csp.php', $paths, true), "$event path filter must watch tools/test-csp.php.");
}

function checkMarkup(array $directives, string $html, string $file): void
{
    check(!hasMetaCsp($html), "$file: meta CSP.");
    preg_match_all('~<(script|link|img|iframe|video|audio|source|embed|object)\b([^>]*)>~i', $html, $tags, PREG_SET_ORDER);
    foreach ($tags as $tag) {
        preg_match_all('~([\w-]+)\s*=\s*(["\'])(.*?)\2~s', $tag[2], $matches, PREG_SET_ORDER);
        $attrs = [];
        foreach ($matches as $match) {
            $attrs[strtolower($match[1])] = html_entity_decode($match[3], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
        $name = strtolower($tag[1]);
        $directive = [
            'script' => 'script-src', 'img' => 'img-src', 'iframe' => 'frame-src',
            'video' => 'media-src', 'audio' => 'media-src', 'source' => 'media-src',
            'object' => 'object-src', 'embed' => 'object-src',
        ][$name] ?? null;
        $url = $attrs[$name === 'object' ? 'data' : 'src'] ?? null;
        if ($name === 'link') {
            $rel = strtolower($attrs['rel'] ?? '');
            $directive = match ($rel) {
                'stylesheet' => 'style-src', 'icon', 'apple-touch-icon' => 'img-src',
                'manifest' => 'default-src',
                'preload' => ($attrs['as'] ?? '') === 'image' ? 'img-src' : null,
                default => null,
            };
            $url = $attrs['href'] ?? null;
        }
        if ($directive !== null && $url !== null) {
            check(permits($directives, $directive, $url), "$file: $directive does not cover $url");
        }
        if (isset($attrs['poster'])) {
            check(permits($directives, 'img-src', $attrs['poster']), "$file: video poster not covered.");
        }
    }
    if (preg_match('~<script\b(?![^>]*\bsrc\s*=)[^>]*>~i', $html)) {
        check(in_array("'unsafe-inline'", $directives['script-src'], true), "$file: inline scripts not covered.");
    }
    if (preg_match('~<style\b|\bstyle\s*=~i', $html)) {
        check(in_array("'unsafe-inline'", $directives['style-src'], true), "$file: inline styles not covered.");
    }
}

function checkReportingConfigured(string $configuration, array $enforced, array $reportOnly): void
{
    check(
        preg_match(
            '/^\s*Header always set Reporting-Endpoints "csp=\\\\"\/csp-report\.php\\\\""\s*$/m',
            $configuration
        ) === 1,
        'Expected Reporting-Endpoints for group csp → /csp-report.php.'
    );
    check(($enforced['report-uri'] ?? null) === ['/csp-report.php'], 'Enforced CSP must report to /csp-report.php.');
    check(($enforced['report-to'] ?? null) === ['csp'], 'Enforced CSP must use report-to csp.');
    check(($reportOnly['report-uri'] ?? null) === ['/csp-report.php'], 'Report-Only CSP must report to /csp-report.php.');
    check(($reportOnly['report-to'] ?? null) === ['csp'], 'Report-Only CSP must use report-to csp.');
    check(is_file('csp-report.php'), 'Missing public csp-report.php endpoint.');
    check(is_file('blocks/csp-report-handler.php'), 'Missing CSP report handler.');
    check(is_file('private/.htaccess') && str_contains(file_get_contents('private/.htaccess'), 'Require all denied'), 'private/ must deny HTTP access.');
    check(is_file('private/csp-reports/.htaccess'), 'CSP report log directory must deny HTTP access.');
}

function checkNonceHelpers(): void
{
    check(is_file('blocks/csp-nonce.php'), 'Missing CSP nonce helper.');
    $a = nephrosite_csp_nonce();
    $b = nephrosite_csp_nonce();
    check($a === $b && strlen($a) >= 16, 'Nonce must be stable per request and non-trivial.');
    check(str_contains(nephrosite_csp_nonce_attr(), $a), 'Nonce attribute helper must embed the nonce.');
    foreach (['blocks/scripts.sk.php', 'blocks/metatags.sk.php', 'blocks/current.sk.php'] as $file) {
        $source = file_get_contents($file);
        check(str_contains($source, 'nephrosite_csp_nonce_attr()'), "$file must emit a CSP nonce attribute.");
    }
}

function stripNonceSources(array $tokens): array
{
    return array_values(array_filter(
        $tokens,
        static fn (string $token): bool => preg_match("~^'nonce-~", $token) !== 1
    ));
}

function checkPhpBootstrap(string $htaccessEnforced, string $htaccessReportOnly): void
{
    check(is_file('blocks/csp-bootstrap.php'), 'Missing CSP bootstrap.');
    $phpEnforced = nephrosite_csp_enforced_policy();
    check($phpEnforced === $htaccessEnforced, 'PHP enforced CSP must match static .htaccess CSP.');
    check(
        nephrosite_csp_report_only_policy(false) === $htaccessReportOnly,
        'PHP Report-Only without nonce must match static .htaccess Report-Only.'
    );

    $enforced = parsePolicy($phpEnforced);
    check(in_array("'unsafe-inline'", $enforced['script-src'] ?? [], true), 'Enforced script-src must keep unsafe-inline this loop.');
    foreach ($enforced['script-src'] ?? [] as $token) {
        check(preg_match("~^'nonce-~", $token) !== 1, 'Enforced CSP must not list a nonce (CSP3 would ignore unsafe-inline).');
    }

    $reportOnly = parsePolicy(nephrosite_csp_report_only_policy(true));
    $nonceToken = "'nonce-" . nephrosite_csp_nonce() . "'";
    check(
        ($reportOnly['script-src'] ?? []) === ["'self'", $nonceToken],
        'PHP Report-Only script-src must be self + matching request nonce.'
    );
    check(!in_array("'unsafe-inline'", $reportOnly['script-src'] ?? [], true), 'PHP Report-Only must not allow unsafe-inline.');
    check(stripNonceSources($reportOnly['script-src'] ?? []) === ["'self'"], 'PHP Report-Only without nonce token must stay self-only.');

    foreach (['index.php', 'blocks/topic-page.php'] as $entry) {
        $source = file_get_contents($entry);
        check(str_contains($source, 'csp-bootstrap.php'), "$entry must load CSP bootstrap.");
        check(str_contains($source, 'nephrosite_csp_send_headers()'), "$entry must emit CSP headers.");
    }

    check(
        str_contains(file_get_contents('.htaccess'), '<FilesMatch "\\.(html?|'),
        '.htaccess must scope static CSP to FilesMatch (hybrid with PHP bootstrap).'
    );
    check(
        !preg_match('/^\s*Header always set Content-Security-Policy "/m', preg_replace('/<FilesMatch[\s\S]*?<\/FilesMatch>/', '', file_get_contents('.htaccess'))),
        'Global (non-FilesMatch) enforced CSP must not remain — PHP owns document CSP.'
    );

    $htaccess = file_get_contents('.htaccess');
    check(
        str_contains($htaccess, 'Cache-Control "public, max-age=31536000, immutable"')
            && str_contains($htaccess, '\\.(woff2|ofl)$'),
        '.htaccess must long-cache self-hosted fonts (woff2/ofl).'
    );
    check(
        str_contains($htaccess, 'Cache-Control "public, max-age=604800"')
            && str_contains($htaccess, 'fonts\\.css'),
        '.htaccess must cache fonts.css / legal assets for a week.'
    );
    check(
        is_file('tools/csp-report-summary.ps1'),
        'CSP report summary tool must exist for private SSH telemetry review.'
    );
}

function checkReportHandlerUnit(): void
{
    $legacy = nephrosite_csp_sanitize_reports([
        'csp-report' => [
            'document-uri' => 'https://nephrosite.polascin.net/',
            'violated-directive' => 'script-src',
            'blocked-uri' => 'https://evil.example/x.js',
            'original-policy' => str_repeat('a', 600),
            'script-sample' => str_repeat('b', 80),
            'password' => 'should-drop',
        ],
    ]);
    check(count($legacy) === 1, 'Legacy csp-report envelope must yield one report.');
    check(!isset($legacy[0]['password']), 'Unknown fields must be dropped.');
    check(strlen($legacy[0]['original-policy']) === 512, 'original-policy must be truncated.');
    check(strlen($legacy[0]['script-sample']) === 40, 'script-sample must be truncated.');

    $reportingApi = nephrosite_csp_sanitize_reports([
        [
            'type' => 'csp-violation',
            'body' => [
                'effective-directive' => 'script-src',
                'blocked-uri' => 'inline',
                'disposition' => 'report',
            ],
        ],
        ['type' => 'other', 'body' => ['blocked-uri' => 'ignore']],
    ]);
    check(count($reportingApi) === 1, 'Reporting API payload must keep only csp-violation bodies.');
    check(($reportingApi[0]['disposition'] ?? '') === 'report', 'Reporting API body fields must be preserved.');
}

try {
    $configuration = file_get_contents('.htaccess');
    $workflow = file_get_contents('.github/workflows/csp-regression.yml');
    checkWorkflowWatchesTest($workflow, 'pull_request');
    checkWorkflowWatchesTest($workflow, 'push');
    check(preg_match_all('/^\s*Header always set Content-Security-Policy "([^"]+)"\s*$/m', $configuration, $headers) === 1, 'Expected exactly one enforced CSP header.');
    check(preg_match_all('/^\s*Header always set Content-Security-Policy-Report-Only "([^"]+)"\s*$/m', $configuration, $reportOnly) === 1, 'Expected exactly one Report-Only CSP header.');
    $reportOnlyPolicy = trim($reportOnly[1][0]);
    $reportOnlyDirectives = parsePolicy($reportOnlyPolicy);
    check(($reportOnlyDirectives['script-src'] ?? []) === ["'self'"], 'Report-Only CSP must keep script-src self-only for tightening.');
    check(!in_array("'unsafe-inline'", $reportOnlyDirectives['script-src'] ?? [], true), 'Report-Only script-src must not allow unsafe-inline.');
    check(($reportOnlyDirectives['style-src'] ?? []) === ["'self'", "'unsafe-inline'"], 'Report-Only style-src must be self + unsafe-inline after Google Fonts self-host.');
    check(($reportOnlyDirectives['font-src'] ?? []) === ["'self'"], "Report-Only font-src must be 'self' after Google Fonts self-host.");
    check(!str_contains($reportOnlyPolicy, 'fonts.googleapis.com') && !str_contains($reportOnlyPolicy, 'fonts.gstatic.com'), 'Report-Only must not list Google Fonts hosts after self-host.');
    check(!str_contains($reportOnlyPolicy, 'clustrmaps.com'), 'Report-Only must not list clustrmaps.com after first-party visitor map SVG.');
    check(($reportOnlyDirectives['media-src'] ?? []) === ["'self'"], "Report-Only media-src must be 'self' (homepage videos are same-origin).");
    check(($reportOnlyDirectives['frame-src'] ?? []) === ["'self'"], "Report-Only frame-src must be 'self' (current iframes are same-origin).");
    check(!in_array('data:', $reportOnlyDirectives['img-src'] ?? [], true), 'Report-Only img-src must not allow data: (no data: images in markup).');
    check(!str_contains($reportOnlyPolicy, 'googletagmanager') && !str_contains($reportOnlyPolicy, 'clarity.ms') && !str_contains($reportOnlyPolicy, 'fastbase.com'), 'Report-Only must keep analytics hosts out of allowlists so consent loads are measurable.');
    $enforcedPolicy = trim($headers[1][0]);
    $directives = parsePolicy($enforcedPolicy);
    checkReportingConfigured($configuration, $directives, $reportOnlyDirectives);
    checkNonceHelpers();
    checkPhpBootstrap($enforcedPolicy, $reportOnlyPolicy);
    checkReportHandlerUnit();

    foreach (['default-src', 'base-uri', 'frame-ancestors', 'form-action', 'media-src'] as $name) {
        check(($directives[$name] ?? []) === ["'self'"], "Expected $name 'self'.");
    }
    check(($directives['object-src'] ?? []) === ["'none'"], "Expected object-src 'none'.");
    check(($directives['font-src'] ?? []) === ["'self'"], "Enforced font-src must be 'self' after Google Fonts self-host.");
    check(!str_contains($enforcedPolicy, 'fonts.googleapis.com') && !str_contains($enforcedPolicy, 'fonts.gstatic.com'), 'Enforced CSP must not list Google Fonts hosts after self-host.');
    check(!str_contains($enforcedPolicy, 'clustrmaps.com'), 'Enforced CSP must not list clustrmaps.com after first-party visitor map SVG.');
    foreach (['https://region1.analytics.google.com', 'https://stats.g.doubleclick.net'] as $url) {
        check(permits($directives, 'connect-src', $url), 'Observed connection missing: ' . $url);
    }
    check(permits($directives, 'img-src', 'https://www.google.sk/example'), 'Observed Google image source missing.');
    $cspBootstrapAllowlist = [
        'csp-report.php',
        'csp-report-handler.php',
        'csp-nonce.php',
        'csp-bootstrap.php',
    ];
    foreach (array_merge(glob('*.php'), glob('blocks/*.php'), glob('files/*.html')) as $file) {
        if (in_array(basename($file), $cspBootstrapAllowlist, true)) {
            continue;
        }
        check(!str_contains(file_get_contents($file), 'Content-Security-Policy'), "$file: must not embed CSP meta/header literals outside the bootstrap.");
    }

    $pages = ['index.php', 'dialyza.php', 'nefrologia.php', 'purifikacia.php',
        'transplantacia.php', 'usgo.php', 'nefamb.php', 'lipton-tx.php'];
    foreach ($pages as $page) {
        $pipes = [];
        $process = proc_open([PHP_BINARY, '-d', 'display_errors=stderr', $page], [
            1 => ['pipe', 'w'], 2 => ['pipe', 'w'],
        ], $pipes, $root);
        check(is_resource($process), 'Cannot render ' . $page);
        $html = stream_get_contents($pipes[1]);
        $errors = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $exitCode = proc_close($process);
        check($exitCode === 0 && $errors === '', "$page render failed: $errors");
        check(str_contains($html, '<main id="content">'), "$page did not render its content.");
        checkMarkup($directives, $html, $page);
        check(preg_match('/<script\b[^>]*\bnonce="[A-Za-z0-9_-]+"/', $html) === 1
            || substr_count($html, 'nonce="') >= 2, "$page: expected nonce attributes on inline scripts.");
    }
    foreach (['files/privacy.html', 'files/terms.html', 'ipvrm.htm'] as $file) {
        checkMarkup($directives, file_get_contents($file), $file);
    }
    preg_match_all('~loadScript\("([^"]+)"~', file_get_contents('blocks/scripts.sk.php'), $scripts);
    check(count($scripts[1]) === 3, 'Review changed dynamic script loaders.');
    foreach ($scripts[1] as $url) {
        check(permits($directives, 'script-src', $url), 'Dynamic script not covered: ' . $url);
    }

    $fontLinks = file_get_contents('blocks/links.sk.php');
    check(!str_contains($fontLinks, 'fonts.googleapis.com') && !str_contains($fontLinks, 'fonts.gstatic.com'), 'Google Fonts hosts must be removed from links.sk.php after self-host.');
    check(str_contains($fontLinks, '/css/fonts.css'), 'Expected local /css/fonts.css stylesheet link.');
    $fontCss = file_get_contents('css/fonts.css');
    foreach (['Blinker', 'Blaka', 'Fenix'] as $family) {
        check(str_contains($fontCss, "font-family: '$family'"), "Missing @font-face for $family in css/fonts.css");
        check(str_contains($fontCss, 'font-display: swap'), "font-display: swap missing for self-hosted fonts");
    }
    foreach (['Archivo', 'Babylonica', 'Lancelot', 'Literata', 'Imprima', 'Akronim', 'Arizonia', 'Birthstone', 'Cabin'] as $unused) {
        check(!str_contains($fontLinks, $unused) && !str_contains($fontCss, $unused), "Unused Google Font still referenced: $unused");
    }
    foreach ([
        'fonts/blinker-400-latin.woff2',
        'fonts/blinker-600-latin.woff2',
        'fonts/blinker-700-latin.woff2',
        'fonts/blaka-400-latin.woff2',
        'fonts/fenix-400-latin.woff2',
        'fonts/OFL-Blinker.ofl',
        'fonts/OFL-Blaka.ofl',
        'fonts/OFL-Fenix.ofl',
    ] as $fontAsset) {
        check(is_file($fontAsset) && filesize($fontAsset) > 0, "Missing self-hosted font asset: $fontAsset");
    }

    $negativeCases = [
        fn () => parsePolicy('default-src'),
        fn () => parsePolicy("default-src 'self'; default-src 'none'"),
        fn () => parsePolicy("default-src https:"),
        fn () => parsePolicy("script-src 'unsafe-eval'"),
        fn () => parsePolicy("default-src *"),
        fn () => parsePolicy("default-src 'self'; report-uri https://example.test"),
        fn () => parsePolicy("default-src 'self'; report-to invented"),
        fn () => parsePolicy("default-src 'self'; report-uri /other-report.php"),
        fn () => checkMarkup($directives, '<img src="https://unexpected.test/x">', 'negative fixture'),
        fn () => checkMarkup($directives, '<img src="data:image/png;base64,AA==">', 'negative fixture'),
        fn () => checkMarkup($directives, '<meta content="x" http-equiv="Content-Security-Policy">', 'negative fixture'),
        fn () => checkMarkup($directives, '<META HTTP-EQUIV="cOnTeNt-SeCuRiTy-PoLiCy">', 'negative fixture'),
        fn () => checkMarkup($directives, '<META content="x" HTTP-EQUIV=Content-Security-Policy>', 'negative fixture'),
        fn () => checkMarkup($directives, '<meta content="x"  HTTP-EQUIV =  Content-Security-Policy>', 'negative fixture'),
    ];
    foreach ($negativeCases as $test) {
        $rejected = false;
        try {
            $test();
        } catch (RuntimeException $error) {
            $rejected = true;
        }
        check($rejected, 'Negative regression fixture was incorrectly accepted.');
    }
    checkMarkup($directives, '<meta http-equiv=refresh content="0">', 'non-CSP pragma fixture');

    // Approved reporting tokens must parse.
    $approved = parsePolicy("default-src 'self'; report-uri /csp-report.php; report-to csp");
    check(($approved['report-uri'] ?? null) === ['/csp-report.php'], 'Approved report-uri must parse.');
    check(($approved['report-to'] ?? null) === ['csp'], 'Approved report-to must parse.');

    echo 'PASS: 8 rendered PHP pages, 3 static documents, 3 dynamic loaders, '
        . count($negativeCases) . ' negative fixtures; hybrid PHP/Apache CSP + Report-Only nonce + first-party reporting validated.' . PHP_EOL;
} catch (Throwable $error) {
    fwrite(STDERR, 'FAIL: ' . $error->getMessage() . PHP_EOL);
    exit(1);
}
