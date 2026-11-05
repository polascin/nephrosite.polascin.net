# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #20)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `2964c02`

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky → **neodstraňovať** enforced
  `'unsafe-inline'`.
- Product ship: static a11y hinty pre lecture organizer / venue / author
  `target="_blank"` (bez JS).
  Overené: 65 externých blank v `lectures.sk.php`, organizer/venue/author
  mali 0 static hintov → doplnených **32**
  `.sr-only` „(otvorí sa v novom okne)“.
  Martinus a OUP recommended lit ostávajú na JS helper z loop #19.
- Remote-only (~69) **nemažeť** bez súhlasu; GH secrets nevytvárané.

## Overené na produkcii

- `csp-report-summary.ps1` → smoke-only; `php tools/test-csp.php` → PASS
- Commit `a437631`; post-commit SFTP (`lectures.sk.php`);
  `deploy.ps1 -Apply` 0 upload; smoke direct 200
- Clean URL smoke (MaximumRedirection 0, Chrome UA): `/` `/privacy`
  `/terms` `/nefrologia` `/transplantacia` → 200 + HSTS + CSP (enforced
  stále s `'unsafe-inline'`)
- Produkcia `/`: hints=50 (bolo 18; +32), pdfHints=11,
  organizerAesculap=True, eszu=True, author=True, jsHelperMarker=True
- GHA Deploy `42102962134` success (rsync skip)

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
- Martinus HEAD 404 / soft „nenájden“ v HTML môže byť falošný; overiť
  `<title>` produktovej stránky cez GET.

## Ďalší fokus (loop #21)

1. Zbieraj RO telemetriu; drop `'unsafe-inline'` len so strong evidence +
   Clarity/GTM consent paths.
2. Schválený cleanup remote-only (A–C; keep `reports.jsonl`).
3. Voliteľne GH `DEPLOY_*` secrets (mimo repo) alebo ponechať len lokálny deploy.
4. Bug/a11y/content ship, ak telemetria stále smoke-only (napr. content
   consistency; intro Bory static hints; Martinus no-JS; title polish).

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-212434-loop20-lecture-organizer-a11y.md`
- Audit: `.audit.md` Beh #31

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
```
