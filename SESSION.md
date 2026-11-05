# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #18)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `ce862ed`

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky → **neodstraňovať** enforced
  `'unsafe-inline'`.
- Product ship: GIF video fallback odkazy.
  Overené: produkčné GIF sú `image/gif` bez `Content-Disposition`
  (inline open). Veľké súbory (3 až 168 MB) sa tak zobrazovali v
  prehliadači namiesto sťahovania.
  - 8 fallback odkazov (`lectures.sk.php` + `foazosszu.sk.php`):
    atribút `download`, text „na stiahnutie“, overené size labely
    (7 / 5 / 3 / 4 / 3 / 168 / 7 / 7 MB).
  - CRRT 2023: zjednotené „Akútne eliminačné metódy“ (aria-label,
    title PDF, iframe; predtým „metodiky“ vs „metódy“).
- Remote-only (~69) **nemažeť** bez súhlasu; GH secrets nevytvárané.

## Overené na produkcii

- `csp-report-summary.ps1` → smoke-only; `php tools/test-csp.php` → PASS
- Commit `ee82d0b`; post-commit SFTP; `deploy.ps1 -Apply` 0 upload;
  smoke direct 200
- Clean URL smoke (MaximumRedirection 0, Chrome UA): `/` `/privacy`
  `/terms` `/nefrologia` `/transplantacia` → 200 + HSTS + CSP (enforced
  stále s `'unsafe-inline'`)
- Produkcia `/`: gif-download=8, gif-label=8, old-gif-label=0,
  pdf-download=6, metody-crrt=3; zostávajúce „metodiky“ = legitímny
  názov prednášky „Voľba metodiky…“
- GHA Deploy `42100877653` success (rsync skip)

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
- Externý 403 pri curl/Invoke-WebRequest nie je dôkaz dead linku: overiť
  v reálnom prehliadači (Cloudflare challenge vs 404).
- Same-origin PDF `_blank` nie je defect pre view; defect bol „na stiahnutie“
  bez `download` (súbory sú inline). To isté platí pre GIF fallbacky.

## Ďalší fokus (loop #19)

1. Zbieraj RO telemetriu; drop `'unsafe-inline'` len so strong evidence +
   Clarity/GTM consent paths.
2. Schválený cleanup remote-only (A–C; keep `reports.jsonl`).
3. Voliteľne GH `DEPLOY_*` secrets (mimo repo) alebo ponechať len lokálny deploy.
4. Bug/a11y/links/content ship, ak telemetria stále smoke-only (napr.
   remaining external link hygiene; sr-only new-window hints na
   externých odkazoch; content consistency).

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-211202-loop18-gif-download-fallbacks.md`
- Audit: `.audit.md` Beh #29

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
```
