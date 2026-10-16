<?php

declare(strict_types=1);

/*
 * Generates css/tokens.css from the Design System artifact's project/tokens.json.
 *
 *   php tools/build-tokens.php <path-to-tokens.json> [<output.css>]
 *
 * Every colour, spacing, radius, shadow and border token becomes a custom property on
 * :root under its own name (--maroon, --section-gap, …); the font families from
 * type.families become --font-<key>. See DEPLOY.md, section "Design tokens".
 */

$args = $_SERVER['argv'] ?? [];
if (!is_array($args) || !is_string($args[1] ?? null)) {
    fwrite(STDERR, "usage: php tools/build-tokens.php <tokens.json> [<output.css>]\n");
    exit(1);
}

$source = $args[1];
$output = is_string($args[2] ?? null) ? $args[2] : dirname(__DIR__) . '/css/tokens.css';

$json = file_get_contents($source);
if ($json === false) {
    fwrite(STDERR, "cannot read {$source}\n");
    exit(1);
}
/** @var array<string, mixed> $tokens */
$tokens = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

$meta = $tokens['meta'] ?? [];
$ref = is_string($meta['ref'] ?? null) ? $meta['ref'] : 'unknown';
$synced = is_string($meta['synced'] ?? null) ? $meta['synced'] : 'unknown';

$lines = [];
$lines[] = '/* NephroSite design tokens.';
$lines[] = '   GENERATED FILE - do not edit by hand.';
$lines[] = "   Source: project/tokens.json of the NephroSite Design System artifact";
$lines[] = '           (https://claude.ai/artifact/D6tcpg8QTPehYS2MrKXMVm),';
$lines[] = "           extracted from {$ref}, synced {$synced}.";
$lines[] = '   Regenerate with: php tools/build-tokens.php <path-to-tokens.json>  (see DEPLOY.md).';
$lines[] = '   Loaded before blocks/styles.css.php and files/legal.css, which reference these as var(--name, fallback). */';
$lines[] = '';
$lines[] = ':root {';

$groups = [
    'color' => 'Colour',
    'spacing' => 'Spacing and sizes',
    'radius' => 'Radius',
    'shadow' => 'Shadow',
    'border' => 'Border widths',
];

$emitGroup = static function (string $label, array $entries) use (&$lines): void {
    $lines[] = "\t/* {$label} */";
    foreach ($entries as $name => $value) {
        $lines[] = "\t--{$name}: {$value};";
    }
    $lines[] = '';
};

foreach ($groups as $key => $label) {
    $entries = [];
    foreach ($tokens[$key]['tokens'] ?? [] as $token) {
        if (!is_array($token) || !is_string($token['name'] ?? null) || !is_scalar($token['value'] ?? null)) {
            continue;
        }
        $entries[$token['name']] = (string) $token['value'];
    }
    $emitGroup($label, $entries);

    if ($key === 'color') {
        $families = [];
        foreach ($tokens['type']['families'] ?? [] as $name => $value) {
            if (is_string($name) && is_string($value)) {
                $families['font-' . $name] = $value;
            }
        }
        $emitGroup('Type families', $families);
    }
}

array_pop($lines); // trailing blank line inside the block
$lines[] = '}';
$lines[] = '';

$css = implode("\n", $lines);
if (file_put_contents($output, $css) === false) {
    fwrite(STDERR, "cannot write {$output}\n");
    exit(1);
}
$count = count(array_filter($lines, static fn (string $l): bool => str_starts_with($l, "\t--")));
echo 'wrote ' . $output . ' (' . $count . " custom properties)\n";
