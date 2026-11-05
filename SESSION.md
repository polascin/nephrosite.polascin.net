# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #10)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `434f939` (docs/handoff commit môže nasledovať)

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky → **neodstraňovať** enforced
  `'unsafe-inline'`.
- Kanonické čisté URL: `/privacy`, `/terms`, `/nefrologia`, `/dialyza`, …
  servírujú **200** (interný rewrite); staré `.php` a `/files/*.html` → **301**.
- Oprava slučky: 301 z `/files/*.html` len cez `THE_REQUEST` (inak interný
  rewrite spätne 301-oval).
- Sitemap, canonical, teasery, deploy smoke (`/`, `/privacy`, `/terms`,
  `/nefrologia`) aktualizované.

## Overené na produkcii

- Commits `53bf64b` → `434f939`; post-commit SFTP; `deploy.ps1 -Apply` smoke OK
- GHA Deploy `42094343098` success (rsync skip: chýbajú DEPLOY_* secrets)
- `/privacy` `/terms` `/nefrologia` `/dialyza` `/lipton-tx` → 200 + HSTS + CSP
- Legacy 301 → clean; canonical a sitemap na čistých URL
- Homepage odkazy na čisté cesty; `csp-report-summary.ps1` → keep unsafe-inline

## Poznámky k toolingu

- Commit cez `git -c core.hooksPath=.git/hooks` (globálny GG); ggshield Passed.
- Remote-only ~69; **nemažeť bez súhlasu**.
- WAF 466 pri krátkom UA; smoke s Chrome UA.
- Pri rewrite: **vždy** `THE_REQUEST` (alebo `[END]`) pre 301 zo cieľa
  interného rewrite, inak 301/200 slučka.

## Ďalší fokus (loop #11)

1. Zbieraj RO telemetriu (`csp-report-summary.ps1`); drop `'unsafe-inline'`
   len so strong evidence + Clarity/GTM consent paths.
2. Schválený cleanup remote-only (A–C v inventári; keep `reports.jsonl`).
3. Oficiálne uznať `deploy.ps1` / opraviť GH secrets.

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-203018-loop10-clean-canonical-urls.md`
- Audit: `.audit.md` Beh #21

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
```
