# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #24)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `e14b485`

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky → **neodstraňovať** enforced
  `'unsafe-inline'`.
- Product ship: title/content consistency v `blocks/promo.sk.php`
  (overené oproti oficiálnym `<title>` stránkam):
  - Bory: `title` BORY → Bory (zhoda s `alt` a nemocnica-bory.sk)
  - ASN: `Of` → `of` (asn-online.org)
  - ÖGFN: `Nefrologie` → `Nephrologie` (nephrologie.at)
- Intro Bory zostáva zakomentovaný (žiadne spekulatívne re-enable).
- Remote-only (~69) **nemažeť** bez súhlasu; GH secrets nevytvárané.

## Overené na produkcii

- `csp-report-summary.ps1` → smoke-only; `php tools/test-csp.php` → PASS
- Commit `28bd919`; post-commit SFTP nahral `promo.sk.php`;
  `deploy.ps1 -Apply` 0 upload; smoke direct 200
- Clean URL smoke (MaximumRedirection 0, Chrome UA): `/` `/privacy`
  `/terms` `/nefrologia` `/transplantacia` → 200 + HSTS + CSP (enforced
  stále s `'unsafe-inline'`)
- Produkcia `/`: Bory/ASN/ÖGFN title+alt zhodné s oficiálnymi názvami;
  hints=144; staré BORY / Of / Nefrologie = 0
- GHA Deploy `42106647063` success (rsync skip)

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
- Martinus HEAD 404 / text „nenájden“ v HTML môže byť falošný; overiť
  `<title>` produktovej stránky cez GET.
- Pri počítaní `imgpromo` blanks odfiltrovať HTML komentáre (excluded
  vendor logos v `promo.sk.php`); PowerShell UTF-8 skripty môžu pokaziť
  diakrítiku (`otvorí` → mojibake) — preferovať Python `Path.write_text`.
- Footer tooling logos (Bluefish/W3/W3C/DistroWatch) nie sú `imgpromo`;
  pri a11y scane ich treba brať osobitne.
- Title/alt brand polish: overovať oficiálny `<title>` cieľovej stránky
  (GET + Chrome UA), nie len vnútornú zhodu title↔alt.

## Ďalší fokus (loop #25)

1. Zbieraj RO telemetriu; drop `'unsafe-inline'` len so strong evidence +
   Clarity/GTM consent paths.
2. Schválený cleanup remote-only (A–C; keep `reports.jsonl`).
3. Voliteľne GH `DEPLOY_*` secrets (mimo repo) alebo ponechať len lokálny deploy.
4. Bug/a11y/content ship, ak telemetria stále smoke-only (ďalší title
   polish; content consistency; uncommented intro Bory až po rozhodnutí
   o obsahu).

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-214846-loop24-promo-title-consistency.md`
- Audit: `.audit.md` Beh #35

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
```
