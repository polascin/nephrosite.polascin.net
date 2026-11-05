# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #28)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `27bcd26`

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky → **neodstraňovať** enforced
  `'unsafe-inline'`.
- Product ship (overené):
  - `blocks/promo.sk.php`: ERA title/alt
    `European Renal Association` → `European Renal Association (ERA)`
    (oficiálny `<title>` obsahuje `| ERA`; vzor ako SIN/WHO).
  - EDTNA title/alt dlhý deskriptívny label → `EDTNA/ERCA`
    podľa oficiálneho `<title>` na edtnaerca.org.
- Intro Bory zostáva zakomentovaný (žiadne spekulatívne re-enable).
- Remote-only (~69) **nemažeť** bez súhlasu; GH secrets nevytvárané.

## Overené na produkcii

- `csp-report-summary.ps1` → smoke-only; `php tools/test-csp.php` → PASS
- Commit `27bcd26`; post-commit SFTP nahral `promo.sk.php`;
  `deploy.ps1 -Apply` 0 upload; smoke direct 200
- Clean URL smoke (MaximumRedirection 0, Chrome UA): `/` `/privacy`
  `/terms` `/nefrologia` → 200 + HSTS + CSP (enforced stále s
  `'unsafe-inline'`)
- Produkcia `/`: ERA `(ERA)` title+alt OK (2); EDTNA/ERCA title+alt OK
  (2); staré labely 0; live blank miss hints = 0
- GHA Deploy `42110567136` success (rsync skip)

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
- Inline Python cez PowerShell láme úvodzovky v title atribútoch; temp
  `.py` súbor + `Path.write_text` je spoľahlivejší.
- Pri scane `_blank` bez hintu **najprv strip HTML komentáre**, inak
  Bory/excluded vendor logos falošne nafúknu miss count.
- Akronymové suffixy v promo (`(SIN)`, `(WHO)`, `(ERA)`) a short brand
  titles (`EDTNA/ERCA`) držať v súlade s oficiálnym `<title>` cieľa.
- `/kontakt` a `/o-nas` nie sú v sitemap/odkazoch (404 bez interných
  referencií); nie je to broken-link defect.

## Ďalší fokus (loop #29)

1. Zbieraj RO telemetriu; drop `'unsafe-inline'` len so strong evidence +
   Clarity/GTM consent paths.
2. Schválený cleanup remote-only (A–C; keep `reports.jsonl`).
3. Voliteľne GH `DEPLOY_*` secrets (mimo repo) alebo ponechať len lokálny deploy.
4. Bug/a11y/content ship, ak telemetria stále smoke-only (ďalší title
   polish napr. ANNA `(ANNA)` / KDIGO title encoding; content consistency;
   uncommented intro Bory až po rozhodnutí o obsahu).

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-221345-loop28-era-edtna-titles.md`
- Audit: `.audit.md` Beh #39

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
```
