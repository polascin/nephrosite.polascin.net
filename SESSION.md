# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #9)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `888ab28` (docs/handoff commit môže nasledovať)

## Čo je hotové v tejto iterácii

- RO telemetria cez SSH: **2 riadky**, oba smoke/test
  (`evil.example`, `inline` bez sample) → **neodstraňovať** enforced
  `'unsafe-inline'`.
- `tools/csp-report-summary.ps1` (súkromný SSH súhrn; HTTP 403 na log).
- Cache-Control: `woff2`/`ofl` 1y immutable; `fonts.css`/`tokens.css`/
  `legal.css`/`privacy-consent.js`/ClustrMaps SVG 7d.
- Privacy/terms: dátum 05.11.2026; interné odkazy na `/privacy`/`/terms`.
- `sitemap.xml` lastmod 2026-11-05.
- Inventár remote-only 69: `docs/REMOTE-ONLY-INVENTORY.md` (bez mazania).

## Overené na produkcii

- Commit `888ab28`; post-commit SFTP; `deploy.ps1 -Apply` → 0 upload;
  GHA Deploy `42093214113` success; CSP regression success
- `/` 200; HSTS; Reporting-Endpoints; enforced stále `unsafe-inline`
- Fonty: `Cache-Control: public, max-age=31536000, immutable` (po cache-bust /
  nový súbor); CSS/legal 604800
- `/privacy` → 05.11.2026 + odkaz `/terms`; sitemap lastmod 2026-11-05
- `php tools/test-csp.php` → PASS; `csp-report-summary.ps1` → smoke-only verdict

## Poznámky k toolingu

- Commit cez `git -c core.hooksPath=.git/hooks` (globálny GG); ggshield Passed.
- Remote-only ~69; **nemažeť bez súhlasu** (pozri inventár).
- WAF 466 pri krátkom UA; smoke s Chrome UA.
- Edge môže krátko držať staré odpovede bez Cache-Control; overiť `?v=`
  alebo iný ešte necachovaný asset.

## Ďalší fokus (loop #10)

1. Zbieraj RO telemetriu (`csp-report-summary.ps1`); drop `'unsafe-inline'`
   len so strong evidence + Clarity/GTM consent paths.
2. Schválený cleanup remote-only (A–C v inventári; keep `reports.jsonl`).
3. Oficiálne uznať `deploy.ps1` / opraviť GH secrets.

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-202343-loop9-csp-telemetry-font-cache.md`
- Audit: `.audit.md` Beh #20

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
```
