<?php

declare(strict_types=1);

/**
 * Public CSP reporting endpoint for NephroSite.
 * Wired from .htaccess via report-uri / report-to (Reporting-Endpoints group "csp").
 */

require __DIR__ . '/blocks/csp-report-handler.php';

nephrosite_handle_csp_report();
