<?php

declare(strict_types=1);

/**
 * Per-request CSP nonce helpers.
 *
 * Markup emits nonce="…" on first-party inline <script> tags. The enforced CSP
 * header still uses 'unsafe-inline' (CSP3 would drop 'unsafe-inline' if a nonce
 * were listed there). Report-Only on PHP pages includes the matching 'nonce-…'
 * via blocks/csp-bootstrap.php for measurement before enforcement.
 */

/**
 * Cryptographically random base64 nonce, stable for the current request.
 */
function nephrosite_csp_nonce(): string
{
    static $nonce = null;
    if ($nonce === null) {
        $nonce = rtrim(strtr(base64_encode(random_bytes(16)), '+/', '-_'), '=');
    }

    return $nonce;
}

/**
 * HTML attribute fragment: nonce="…" (already escaped).
 */
function nephrosite_csp_nonce_attr(): string
{
    return 'nonce="' . htmlspecialchars(nephrosite_csp_nonce(), ENT_QUOTES, 'UTF-8') . '"';
}
