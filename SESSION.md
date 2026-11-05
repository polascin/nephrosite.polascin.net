# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #5)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `af48e4e` (docs/handoff commit môže nasledovať)

## Čo je hotové v tejto iterácii

- Self-host Blinker / Blaka / Fenix (latin + latin-ext WOFF2):
  - `/css/fonts.css` s `font-display: swap`
  - `/fonts/*.woff2` + SIL OFL `/fonts/OFL-*.ofl` (`.txt` hosting blokuje 403)
- `blocks/links.sk.php`: Google Fonts preconnect/stylesheet odstránené
- Enforced aj Report-Only CSP: `font-src 'self'`, bez
  `fonts.googleapis.com` / `fonts.gstatic.com`
- `tools/test-csp.php` + `docs/CSP-REPORT-ONLY.md` aktualizované

## Overené na produkcii

- Commits `883e0e1` + `af48e4e`; post-commit SFTP; `deploy.ps1 -Apply` → 0 upload
- `/`, `/dialyza.php`, `/nefrologia.php`, `/privacy.php` 200
- HTML bez googleapis/gstatic; `/css/fonts.css` 200; WOFF2 `font/woff2` 200
- `/fonts/OFL-Blinker.ofl` 200 `text/plain`; HSTS OK
- Enforced + RO: `font-src 'self'`, žiadne Google Fonts hosty
- `php tools/test-csp.php` → PASS

## Poznámky k toolingu

- Commit cez `git -c core.hooksPath=.git/hooks` (globálny GG); ggshield Passed.
- Remote-only junk (~68) ostáva; **nemažeť bez súhlasu**.
- `/privacy.php` hosting CSP stále spomína Google Fonts (mimo nášho `.htaccess`);
  naše Report-Only je čisté.

## Ďalší fokus (loop #6)

1. ClustrMaps: snapshot alebo len SVG → drop `clustrmaps.com` z CSP ak možné.
2. Schválený cleanup remote-only zvyškov (68).
3. Oficiálne uznať `deploy.ps1` / opraviť GH secrets.
4. CSP `report-to` + neskôr nonces pre enforcement bez `'unsafe-inline'`.

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-195734-loop5-self-host-fonts-csp.md`
- Audit: `.audit.md` Beh #16

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1
php tools/test-csp.php
```
