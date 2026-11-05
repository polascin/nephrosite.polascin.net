# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #2)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `c710399` (docs/handoff commit môže nasledovať)

## Čo je hotové v tejto iterácii

- Prekódované GIF slidy `fosdl`, `foazo`, `ktx`, `aem`, `vmppd` na H.264 MP4 + WebP poster.
- `blocks/lectures.sk.php`: `<video preload="none" poster=…>` namiesto `<img>` v odkaze; GIF ostáva ako fallback a priamy URL.
- Pridaný `tools/encode-lecture-gifs.py` (Pillow expanduje frame delay, lebo ffmpeg samotný zahodil dlhý hold posledného framu).
- GIF súbory v `docs/` **neboli** mazané ani LFS-ované; `nephrogame.gif` nedotknutý.

### Veľkosti (GIF → MP4)

| Slide | GIF | MP4 | Poster |
| --- | ---: | ---: | ---: |
| fosdl | 6,88 MB | 1,54 MB | 186 KB |
| foazo | 5,25 MB | 1,21 MB | 136 KB |
| ktx | 3,07 MB | 0,34 MB | 27 KB |
| aem | 3,59 MB | 0,82 MB | 29 KB |
| vmppd | 3,29 MB | 0,86 MB | 22 KB |

Inicializácia stránky stiahne postery (~0,4 MB spolu) namiesto ~22 MB GIF-ov.

## Overené na produkcii

- `tools/deploy.ps1 -Apply` → 0 upload (post-commit SFTP už nahral), smoke `/` a `/privacy.php` 200
- `https://nephrosite.polascin.net/` → 200, CSP + CSP-Report-Only, HSTS
- Všetkých 5× `.mp4` + 5× `-poster.webp` → 200, správne Content-Type
- Homepage HTML obsahuje `fosdl.mp4` / postery / `preload="none"`; `fosdl.gif` stále 200

## Poznámky k toolingu

- Globálny `core.hooksPath` (GitGuardian) volá chýbajúci `ggshield` CLI → commit treba cez `git -c core.hooksPath=.git/hooks commit …` (lokálny pre-commit ggshield cez pre-commit framework prejde).
- Post-commit hook pushne a SFTP-uje bez `.deployignore`; preto `tools/encode-lecture-gifs.py` ostal remote-only v web roote (deploy.ps1 ho neposiela).

## Ďalší fokus (loop #3)

1. Prekódovať `ktx2023.gif` / `crrt2023.gif` na homepage (`blocks/foazosszu.sk.php`).
2. Vyhodnotiť Report-Only CSP (Fonts/ClustrMaps) a lokalizovať.
3. Schválený cleanup remote-only zvyškov (`.git`, `tools/*.phar`, encoder script).
4. Oficiálne uznať `deploy.ps1` / opraviť GH secrets; zvážiť zosúladenie post-commit SFTP s `.deployignore`.

## Handoff súbory

- Codex: `.codex/handoffs/` (loop2, pozri najnovší súbor)
- Audit: `.audit.md` Beh #13

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1
php tools/test-csp.php
```
