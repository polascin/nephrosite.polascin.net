<?php

declare(strict_types=1);

// No network or deployed configuration changes: render public PHP pages locally.
$root = dirname(__DIR__);
chdir($root);

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
        check(!in_array($name, ['report-uri', 'report-to'], true), 'No approved reporting endpoint.');
        check(count($tokens) > 0, 'Empty CSP source list: ' . $name);
        foreach ($tokens as $token) {
            check(
                in_array($token, ["'self'", "'none'", "'unsafe-inline'"], true)
                || preg_match('~^https://[a-z0-9.-]+$~D', $token) === 1,
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
    return in_array('https://' . $host, $sources, true)
        && $host !== false;
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

try {
    $document = file_get_contents('docs/CSP-REPORT-ONLY.md');
    $workflow = file_get_contents('.github/workflows/csp-regression.yml');
    checkWorkflowWatchesTest($workflow, 'pull_request');
    checkWorkflowWatchesTest($workflow, 'push');
    check(preg_match_all('/^Content-Security-Policy-Report-Only: (.+)$/m', $document, $headers) === 1, 'Expected exactly one documented candidate.');
    $directives = parsePolicy(trim($headers[1][0]));
    foreach (['default-src', 'base-uri', 'frame-ancestors', 'form-action', 'media-src'] as $name) {
        check(($directives[$name] ?? []) === ["'self'"], "Expected $name 'self'.");
    }
    check(($directives['object-src'] ?? []) === ["'none'"], "Expected object-src 'none'.");
    check(permits($directives, 'font-src', 'https://fonts.gstatic.com/example.woff2'), 'Google Fonts font source missing.');
    foreach (['https://region1.analytics.google.com', 'https://stats.g.doubleclick.net'] as $url) {
        check(permits($directives, 'connect-src', $url), 'Observed connection missing: ' . $url);
    }
    check(permits($directives, 'img-src', 'https://www.google.sk/example'), 'Observed Google image source missing.');
    check(!preg_match('/^\s*Header\b[^\r\n]*Content-Security-Policy/im', file_get_contents('.htaccess')), 'Proposal must not activate a CSP header.');
    foreach (array_merge(glob('*.php'), glob('blocks/*.php'), glob('files/*.html')) as $file) {
        check(!str_contains(file_get_contents($file), 'Content-Security-Policy'), "$file: proposal must not activate PHP/meta CSP.");
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
    }
    foreach (['files/privacy.html', 'files/terms.html', 'ipvrm.htm'] as $file) {
        checkMarkup($directives, file_get_contents($file), $file);
    }
    preg_match_all('~loadScript\("([^"]+)"~', file_get_contents('blocks/scripts.sk.php'), $scripts);
    check(count($scripts[1]) === 3, 'Review changed dynamic script loaders.');
    foreach ($scripts[1] as $url) {
        check(permits($directives, 'script-src', $url), 'Dynamic script not covered: ' . $url);
    }

    $negativeCases = [
        fn () => parsePolicy('default-src'),
        fn () => parsePolicy("default-src 'self'; default-src 'none'"),
        fn () => parsePolicy("default-src https:"),
        fn () => parsePolicy("script-src 'unsafe-eval'"),
        fn () => parsePolicy("default-src *"),
        fn () => parsePolicy("default-src 'self'; report-uri https://example.test"),
        fn () => parsePolicy("default-src 'self'; report-to invented"),
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
    echo 'PASS: 8 rendered PHP pages, 3 static documents, 3 dynamic loaders, '
        . count($negativeCases) . ' negative fixtures; no CSP activated.' . PHP_EOL;
} catch (Throwable $error) {
    fwrite(STDERR, 'FAIL: ' . $error->getMessage() . PHP_EOL);
    exit(1);
}
