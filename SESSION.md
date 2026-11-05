# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #34)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `a20ee57`

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky → **neodstraňovať** enforced
  `'unsafe-inline'`.
- Product ship (overené, non-promo content):
  - `files/nefamb.html`: `učí`→`určí`, `seba-obsluhy`→`starostlivosti o seba`,
    `Za účelom`→`Na posúdenie`, `najoptimálnejšie`→`najlepšie`,
    `Výučba a edukácia`→`Vzdelávanie`.
  - `files/usgo.html`: `sestrička`→`sestra`.
  - `files/transplantacia.html`: `sestričky`→`sestry`,
    `umožnilo prenos`→`umožnil prenos`.
- ASN/ISN oficiálne `<title>` **bez** akronymu → polish **neshipnutý**.
- Intro Bory zostáva zakomentovaný (žiadne spekulatívne re-enable).
- Remote-only (~69) **nemažeť** bez súhlasu; GH secrets nevytvárané.
- Live blank miss = 0 (po stripnutí komentárov).
- Segment sync pre tieto stringy netreba (homepage segmenty nemajú
  zasiahnuté intro pasáže).

## Overené na produkcii

- `csp-report-summary.ps1` → smoke-only; `php tools/test-csp.php` → PASS
- Commit `a20ee57`; post-commit SFTP nahral `files/nefamb.html`,
  `files/usgo.html`, `files/transplantacia.html`; `deploy.ps1 -Apply`
  0 upload; smoke direct 200
- Clean URL smoke (MaximumRedirection 0, Chrome UA): `/` `/privacy`
  `/terms` `/nefrologia` `/nefamb` `/usgo` `/transplantacia` → 200 +
  HSTS + CSP (enforced stále s `'unsafe-inline'`)
- Produkcia `/nefamb`: `určí`, `starostlivosti o seba`, `Na posúdenie`,
  `najlepšie`, `Vzdelávanie pacientov` prítomné; staré formy absent
- Produkcia `/usgo`: `sestra` prítomné; `sestrička` absent
- Produkcia `/transplantacia`: `sestry`, `umožnil prenos` prítomné;
  `sestričky` / `umožnilo prenos` absent
- GHA Deploy `42115452187` success (rsync skip)

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
  Bory/excluded vendor logos falošne nafúknu miss count. Skip `.kilo/`
  worktrees pri repo scanoch.
- Akronymové suffixy v promo (`(SIN)`, `(WHO)`, `(ERA)`, `(ANNA)`) a short
  brand titles (`EDTNA/ERCA`) držať v súlade s oficiálnym `<title>` cieľa.
- KDIGO oficiálne používa en dash (`&#8211;` / U+2013), nie ASCII `-`.
- `/kontakt` a `/o-nas` nie sú v sitemap/odkazoch (404 bez interných
  referencií); nie je to broken-link defect.
- `topic-teaser.php` extrahuje `<img>` z `files/*.html` (už majú `alt`);
  false positive „missing alt“ na regex v teaser helperi nie je defect.
- `ipvrm.htm` je standalone Word HTML (iframe + priama URL): nemá
  `blocks/styles.css.php` ani `scripts.sk.php` blank helper → `.sr-only`
  a new-window hint treba vložiť lokálne do dokumentu.
- ASN/ISN oficiálne `<title>` = plný názov **bez** `(ASN)`/`(ISN)` →
  nepridávať akronym spekulatívne.
- Excluded vendor logos v HTML komentároch (`bbraun`/`baxter`/…) môžu
  404-ovať ako asset path, ale nie sú live `<img>` (strip comments).
- Pri grammar scane synchronizovať `files/*.html` aj zodpovedajúci
  `segments/*.html` (homepage include), inak topic page a homepage
  divergujú; ak segment pasáž neobsahuje, sync netreba.
- `Zahrňuje`/`detekovať` sú bohemizmy/kalky; preferovať `Zahŕňa`/`odhaliť`
  v pacientskom texte. `v svojom` → `vo svojom`; `zo` len pred s/z/š/ž +
  spoluhláska (`zo rôznych` je chyba).
- `Za účelom` je úradnícky kalk → `Na` + substantívum; `najoptimálnejšie`
  je pleonazmus → `najlepšie`; deminutívum `sestrička` v odbornom texte
  → `sestra`; zhoda rodu: `umožnil prenos` (nie `umožnilo`).

## Ďalší fokus (loop #35)

1. Zbieraj RO telemetriu; drop `'unsafe-inline'` len so strong evidence +
   Clarity/GTM consent paths.
2. Schválený cleanup remote-only (A–C; keep `reports.jsonl`).
3. Voliteľne GH `DEPLOY_*` secrets (mimo repo) alebo ponechať len lokálny deploy.
4. Bug/a11y/content/tooling ship, ak telemetria stále smoke-only (ASN/ISN
   len s oficiálnym title dôkazom; uncommented intro Bory až po rozhodnutí
   o obsahu; ďalšie wording v `files/`/`segments/`).

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-224559-loop34-nefamb-usgo-tx-wording.md`
- Audit: `.audit.md` Beh #45

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
```
