# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #6)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `7d79a8c` (docs/handoff commit môže nasledovať)

## Čo je hotové v tejto iterácii

- ClustrMaps: live `map_v2.png` nahradené first-party SVG
  `/pix/clustrmaps-visitor-map.svg` (vendor connection refused; PNG snapshot
  nedostupný).
- Päta: odkaz na `clustrmaps.com/site/1ak7d` ostáva (user-initiated navigácia);
  žiadne live image/script načítanie, žiadne `data-fallback-src` na mape.
- Enforced aj Report-Only CSP: `clustrmaps.com` odstránené z `img-src`.
- Cookie banner nezmenený (ClustrMaps nikdy nebol consent-gated; first-party
  SVG je lepšie pre súkromie).
- `tools/test-csp.php` + `tools/test-integrations.cjs` + docs aktualizované.

## Overené na produkcii

- Commit `7d79a8c`; post-commit SFTP (`.htaccess`, footer, scripts, SVG);
  `deploy.ps1 -Apply` → 0 upload; `origin/main` = `7d79a8c`
- `/`, `/dialyza.php`, `/nefrologia.php` 200; HTML má SVG, site link;
  bez `clustrmaps.com/map`
- `/pix/clustrmaps-visitor-map.svg` 200 `image/svg+xml`
- Enforced + RO: bez `clustrmaps.com`; HSTS OK
- `php tools/test-csp.php` → PASS; `node tools/test-integrations.cjs` → PASS

## Poznámky k toolingu

- Commit cez `git -c core.hooksPath=.git/hooks` (globálny GG); ggshield Passed.
- Remote-only junk (~68) ostáva; **nemažeť bez súhlasu**.
- `/privacy.php` hosting CSP stále spomína Google Fonts (mimo nášho `.htaccess`).

## Ďalší fokus (loop #7)

1. Schválený cleanup remote-only zvyškov (68), alebo `report-to` endpoint.
2. Oficiálne uznať `deploy.ps1` / opraviť GH secrets.
3. CSP nonces/hashes → cesta k enforcement bez `'unsafe-inline'`.
4. Voliteľne zosúladiť hosting CSP na `/privacy.php`/`/files/*.html`.

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-200227-loop6-clustrmaps-svg-csp.md`
- Audit: `.audit.md` Beh #17

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1
php tools/test-csp.php
```
