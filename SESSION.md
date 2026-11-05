# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #4)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `59fdc4c` (docs/handoff commit môže nasledovať)

## Čo je hotové v tejto iterácii

- CSP Report-Only sprísnený podľa auditu markup/hostov:
  - `media-src 'self'`, `frame-src 'self'`
  - bez `data:` v `img-src`
  - `script-src 'self'` (bez Clarity/GTM/Fastbase/`unsafe-inline`)
  - Google Fonts + ClustrMaps stále v RO, kým ich nelokalizujeme
- Vynucovaná CSP **nezmenená** (súhlasová analytika ostáva funkčná).
- Google Fonts: 12 stylesheetov → 1 (`Blinker|Blaka|Fenix&display=swap`);
  9 nepoužitých rodín odstránených (CSS audit: tokens/styles).
- `tools/test-csp.php` + `docs/CSP-REPORT-ONLY.md` aktualizované.

## Overené na produkcii

- `tools/deploy.ps1 -Apply` → 0 upload (post-commit SFTP už nahral `.htaccess` +
  `links.sk.php`), smoke `/` a `/privacy.php` 200
- `/` Chrome UA: 200; enforced CSP + nový Report-Only; HSTS
- Homepage HTML: 1× Google Fonts CSS, 0 Archivo/Babylonica/…; ClustrMaps URL prítomná
- `/docs/mel.pdf` 200 `application/pdf`
- `php tools/test-csp.php` → PASS

## Poznámky k toolingu

- Commit cez `git -c core.hooksPath=.git/hooks` (globálny GG); tento commit
  `ggshield` Passed.
- Remote-only junk (~68) ostáva; **nemažeť bez súhlasu** (inventarizované v handoffe).
- Obnova hooku: `Copy-Item -Force tools\hooks\post-commit-deploy.sh .git\hooks\deploy.sh`

## Ďalší fokus (loop #5)

1. Self-host Blinker/Blaka/Fenix → drop `fonts.googleapis.com` / `fonts.gstatic.com`
   z RO aj enforced.
2. ClustrMaps: snapshot alebo len SVG (vendor nestabilný).
3. Schválený cleanup remote-only zvyškov (68).
4. Oficiálne uznať `deploy.ps1` / opraviť GH secrets.
5. CSP `report-to` + neskôr nonces pre enforcement bez `'unsafe-inline'`.

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-195059-loop4-csp-report-only-fonts.md`
- Audit: `.audit.md` Beh #15

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1
php tools/test-csp.php
```
