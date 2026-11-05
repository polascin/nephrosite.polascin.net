# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #8)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `fa7709d` (docs/handoff commit môže nasledovať)

## Čo je hotové v tejto iterácii

- Hybrid CSP: PHP dokumenty cez `blocks/csp-bootstrap.php`; static cez
  `.htaccess` `FilesMatch`.
- Enforced: `'unsafe-inline'` ponechané, **bez** `'nonce-…'` v headeri
  (CSP3 by nonce vypol unsafe-inline).
- Report-Only na PHP: `script-src 'self' 'nonce-…'` zhodný s markup nonce.
- Static RO: `script-src 'self'` (bez request nonce).
- Entry: `index.php`, `blocks/topic-page.php` → `nephrosite_csp_send_headers()`.
- Testy/docs: `tools/test-csp.php`, `docs/CSP-REPORT-ONLY.md`.

## Overené na produkcii

- Commit `fa7709d`; post-commit SFTP; `deploy.ps1 -Apply` → 0 upload;
  `origin/main` = `fa7709d`
- `/`, `/dialyza.php`, `/nefrologia.php` 200; RO nonce = HTML nonce;
  cookie banner; HSTS; Reporting-Endpoints
- `/files/privacy.html` Apache CSP; RO bez nonce
- `POST /csp-report.php` → 204; `GET` → 405; `/blocks/csp-bootstrap.php` → 403
- `php tools/test-csp.php` → PASS; `node tools/test-integrations.cjs` → PASS

## Poznámky k toolingu

- Commit cez `git -c core.hooksPath=.git/hooks` (globálny GG); ggshield Passed.
- Remote-only ~69 (pribudol `private/csp-reports/reports.jsonl`); **nemažeť
  bez súhlasu**.
- WAF 466 pri krátkom/neúplnom User-Agent; smoke s Chrome UA.

## Ďalší fokus (loop #9)

1. RO telemetria → rozhodnúť o enforced bez `'unsafe-inline'` (len so strong
   evidence vrátane Clarity/GTM consent paths).
2. Schválený cleanup remote-only (~69).
3. Oficiálne uznať `deploy.ps1` / opraviť GH secrets.
4. Voliteľne zosúladiť hosting CSP na privacy/terms.

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-201608-loop8-csp-php-bootstrap.md`
- Audit: `.audit.md` Beh #19

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1
php tools/test-csp.php
```
