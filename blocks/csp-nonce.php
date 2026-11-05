<?php

declare(strict_types=1);

/**
 * Per-request CSP nonce helpers.
 *
 * Markup may already carry nonce="…" on inline <script> tags. The CSP header
 * still uses 'unsafe-inline' until PHP emits Content-Security-Policy with
 * 'nonce-…' (static .htaccess cannot inject a request-scoped nonce). Including
 * this helper now keeps all PHP layouts on one generator for that migration.
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
