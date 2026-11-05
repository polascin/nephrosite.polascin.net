# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #15)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `7da9a51` (docs/handoff commit môže nasledovať)

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky → **neodstraňovať** enforced
  `'unsafe-inline'`.
- Product ship: `segments/transplantacia.html` h2 zosúladený s
  `$topic['title']` („Transplantácia obličky“); odstránený duplicitný
  `require` segmentu po teaseri v `foazosszu.sk.php`; footer `mailto:` bez
  `target="_blank"` / `rel="noopener noreferrer"`.
- Footer 403 triage: validator.w3.org, mxlinux.org, fedoraproject.org,
  distrowatch.com vracajú 403 aj na GET s Chrome UA (bot filtering /
  WAF). Badge odkazy **ponechané**; nie je dôkaz user-facing broken link
  v bežnom prehliadači.
- Remote-only (~69) **nemažeť** bez súhlasu; GH secrets nevytvárané.

## Overené na produkcii

- `csp-report-summary.ps1` → smoke-only; `php tools/test-csp.php` → PASS
- Clean URL smoke (MaximumRedirection 0): `/` `/privacy` `/terms`
  `/nefrologia` `/transplantacia` `/purifikacia` `/lipton-tx` `/nefamb`
  → 200 + HSTS + CSP (enforced stále s `'unsafe-inline'`)
- Commit `7da9a51`; post-commit SFTP; `deploy.ps1 -Apply` 0 upload; smoke
  direct 200
- Produkcia: homepage h2 plural „Transplantácie obličiek“ = 0; singular
  „Transplantácia obličky“ = 3; mailto bez `target=`; medzi teaserom a
  `/lipton-tx` už nie je druhý h2 zo segmentu
- GHA Deploy `42098259437` success (rsync skip)

## Poznámky k toolingu

- Commit cez `git -c core.hooksPath=.git/hooks` (globálny GG); ggshield Passed.
- Docs/tools sú v `.deployignore` → SFTP/deploy.ps1 ich na web root neposiela.
- WAF 466 pri krátkom UA; smoke s Chrome UA.
- Pri rewrite: **vždy** `THE_REQUEST` (alebo `[END]`) pre 301 zo cieľa
  interného rewrite.
- Lokálny `tools/deploy.ps1 -Apply` (+ post-commit SFTP) je autoritatívny
  sync, kým chýbajú `DEPLOY_*` secrets.
- ClustrMaps A záznam aj cez 8.8.8.8 / 1.1.1.1 → `127.0.0.1` (nie len lokálny
  sinkhole); outbound link zostáva vypnutý, kým vendor neodžije.
- PowerShell: `$HOME` je rezervované; na HTML response použiť iný názov.

## Ďalší fokus (loop #16)

1. Zbieraj RO telemetriu; drop `'unsafe-inline'` len so strong evidence +
   Clarity/GTM consent paths.
2. Schválený cleanup remote-only (A–C; keep `reports.jsonl`).
3. Voliteľne GH `DEPLOY_*` secrets (mimo repo) alebo ponechať len lokálny deploy.
4. Bug/a11y/links/content ship, ak telemetria stále smoke-only (napr.
   browser verify footer badge 403s; ďalšie segments vs files title
   konzistencie; cookie-banner `target="_blank"` na same-origin privacy).

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-205519-loop15-transplant-segment-mailto.md`
- Audit: `.audit.md` Beh #26

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
```
