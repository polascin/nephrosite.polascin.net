# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #7)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `5eeacb7` (docs/handoff commit môže nasledovať)

## Čo je hotové v tejto iterácii

- First-party CSP reporting: `/csp-report.php` (POST, 8 KiB cap, sanitizovaný
  JSONL do `private/csp-reports/`; GET → 405; `private/` → 403).
- `.htaccess`: `Reporting-Endpoints: csp="/csp-report.php"` +
  `report-uri /csp-report.php; report-to csp` na enforced aj Report-Only CSP.
- Nonce helper `blocks/csp-nonce.php`; inline skripty v `metatags.sk.php`,
  `scripts.sk.php`, `current.sk.php` emitú `nonce="…"`.
- `'unsafe-inline'` v enforced CSP ponechané (statické `.htaccess` nevie
  request-scoped nonce; Clarity/GTM/consent ostávajú funkčné).
- Testy/docs: `tools/test-csp.php`, `tools/test-integrations.cjs`,
  `docs/CSP-REPORT-ONLY.md`.

## Overené na produkcii

- Commit `5eeacb7`; post-commit SFTP; `deploy.ps1 -Apply` → 0 upload;
  `origin/main` = `5eeacb7`
- `/`, `/dialyza.php`, `/nefrologia.php` 200; nonces v HTML; cookie banner;
  Clarity stále len v consent `loadScript` (nie auto-load)
- Headers: `report-uri`/`report-to`/`Reporting-Endpoints`; HSTS OK;
  `'unsafe-inline'` + analytics hosty v enforced
- `POST /csp-report.php` → 204; `GET` → 405; `/private/` → 403;
  `/blocks/csp-nonce.php` → 403
- `php tools/test-csp.php` → PASS; `node tools/test-integrations.cjs` → PASS

## Poznámky k toolingu

- Commit cez `git -c core.hooksPath=.git/hooks` (globálny GG); ggshield Passed.
- Remote-only junk (~68) ostáva; **nemažeť bez súhlasu**.
- `/privacy.php` hosting CSP stále spomína Google Fonts (mimo nášho `.htaccess`).

## Ďalší fokus (loop #8)

1. PHP bootstrap: emitovať CSP s `'nonce-…'`, potom zúžiť enforced
   `script-src` (odstrániť `'unsafe-inline'` až po RO telemetrii).
2. Schválený cleanup remote-only zvyškov (68).
3. Oficiálne uznať `deploy.ps1` / opraviť GH secrets.
4. Voliteľne zosúladiť hosting CSP na `/privacy.php`/`/files/*.html`.

## Handoff súbory

- Codex: `.codex/handoffs/` (loop7-csp-report-nonce)
- Audit: `.audit.md` Beh #18

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1
php tools/test-csp.php
```
