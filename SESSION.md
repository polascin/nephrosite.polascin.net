# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-06 (loop iterácia #93)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `5f2b369` (docs tip nasleduje)

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky, **0** Clarity/GTM/Fastbase
  vendor hits (rozpad 0/0/0) → **neodstraňovať** enforced `'unsafe-inline'`.
- Product ship (nefrologia residual; mimo tip-SHA privacy/terms/cookie/
  intro-Amazon/Lipton/homepage-dative/
  dialyza-transplant EN gloss #65 / purifikacia-GvHD #66 /
  dialyza dwell-time #67 / nefamb synonym piles #68 /
  ľadvina+KTx piles #69 / dialyza centre/membrane/cykler #70 /
  purifikácia očisťovanie/membrane #71 / nefrologia CKD/AKI #72 /
  USG ultrasonografické #73 / nefamb ESKD dual acronym #74 /
  IgAN residual ESRD→ESKD #75 / USG gel aplikácia→nanášanie #76 /
  lecture suplementá→suplementy #77 / nefamb/IgAN s cieľom→aby #78 /
  IgAN genetiky/prospieť #79 / IgAN smernice→usmernenia #80 /
  USG v reálnom čase→okamžite #81 / dialýza online HDF #82 /
  ipvrm priebežne #83 / IgAN glomerular hypertenzia #84 /
  IgAN kaukazský→európsky pôvod #85 /
  IgAN paradigme→modeli liečby #86 /
  IgAN ET-1 regulácia→zvýšená tvorba #87 /
  transplant dobu dožitia→dlhšie prežívanie #88 /
  transplant preferovanou→uprednostňovanou #89 /
  IgAN špecifickej populácii #90 /
  nefamb obličkových/cievny #91 /
  nefamb brušnú/močovým/vnútornom #92):
  - `files/nefrologia.html` + `segments/nefrologia.html`:
    `starajú sa o dlhodobú starostlivosť o transplantačný orgán` →
    `zabezpečujú dlhodobú starostlivosť o transplantovaný orgán`;
    `systémovým lupusom erythematosus (SLE)` →
    `systémovým lupus erythematosus (SLE)`;
    `celkové zdravie a pohodu človeka` → `celkové zdravie človeka`
  - Dôvod: redundantné „starajú sa o … starostlivosť“; nesprávny
    adjektív `transplantačný` (má byť `transplantovaný`); zmiešaný
    skloňovaný lupus + latinské erythematosus; EN well-being kalk
    `pohodu`
  - Sync files + segments (homepage include)
  - `tools/scan-patient-copy.ps1`: 4 pravidlá; README
- Grok/XAI: žiadny NephroSite kanál/tooling; žiadna inventovaná analýza.
- Overené a **nechane**:
  - Lipton literárny `jedinec`/`jedincov` (literárny preklad)
  - Lipton genitív `Liptona` a literary wording (`vziať`/`takisto`/`na to`)
  - Homepage dative `všeobecnej medicíne`
  - ASN/ISN oficiálne `<title>` stále bez akronymu → polish **neshipnutý**
  - Intro Bory zostáva zakomentovaný
  - privacy / terms / cookie / intro Amazon / dialyza synonym piles /
    nefamb synonym piles (#65–#92) /
    USG okamžite (#81) / ipvrm priebežne (#83) /
    IgAN piles (#84–#90) /
    transplant `dlhšie prežívanie` (#88) /
    transplant `uprednostňovanou` (#89) /
    nefrologia CKD/AKI `resp.` piles (#72; distinct od tohto residual)
  - Intro dialýzy `brušnú membránu (pobrušnicu), ktorá sa nazýva
    peritoneum` ponechané (edukačný gloss, nie trojitý pile)
  - HD `umelú membránu (dialyzátor)` ponechané (prístroj, nie synonym pile)
  - Lecture PDF branding `KTx 2023` v `foazosszu.sk.php` ponechané
  - nefamb `Katetrizácia (zavedenie dialyzačného katétra)` ponechané
  - Meta/homepage standalone `internej medicíne` ponechané
- Remote-only (~69) **nemažeť** bez súhlasu; GH secrets nevytvárané.
- Medicínsky obsah: wording residual len; bez zmeny klinického významu.

## Overené na produkcii

- `csp-report-summary.ps1` → smoke-only + vendor hits 0 (Clarity 0,
  GTM/GA 0, Fastbase 0); `php tools/test-csp.php` → PASS;
  `scan-blank-hints.ps1` → 0/0/0; `scan-patient-copy.ps1` → 0 hits
- Commit `5f2b369`; post-commit SFTP nahral `files/nefrologia.html` +
  `segments/nefrologia.html` (tools v deployignore); `deploy.ps1 -Apply`
  0 upload; smoke direct 200
- Clean URL smoke (Chrome UA): `/` `/ipvrm.htm` `/dialyza` `/nefamb`
  `/nefrologia` `/usgo` `/transplantacia` `/privacy` `/terms`
  `/purifikacia` → 200 + HSTS + CSP (enforced stále s `'unsafe-inline'`)
- Produkcia `/nefrologia`: `zabezpečujú dlhodobú starostlivosť o
  transplantovaný orgán` ×1; residual `starajú sa o dlhodobú
  starostlivosť` 0; residual `transplantačný orgán` 0;
  `systémovým lupus erythematosus` ×1; residual `lupusom erythematosus` 0;
  `celkové zdravie človeka` ×1; residual `zdravie a pohodu` 0
- GHA Deploy `42151698978` success (rsync skip)

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
  worktrees pri repo scanoch. Kontrolovať **celú** `<a>…</a>` kotvu
  (neskorý `sr-only` v PDF karte, napr. regcitra, nie je miss) —
  `tools/scan-blank-hints.ps1`.
- Akronymové suffixy v promo (`(SIN)`, `(WHO)`, `(ERA)`, `(ANNA)`) a short
  brand titles (`EDTNA/ERCA`) držať v súlade s oficiálnym `<title>` cieľa.
- KDIGO oficiálne používa en dash (`&#8211;` / U+2013), nie ASCII `-`.
- `/kontakt` a `/o-nas` nie sú v sitemap/odkazoch (404 bez interných
  referencií); nie je to broken-link defect.
- `topic-teaser.php` extrahuje `<img>` z `files/*.html` (už majú `alt`);
  false positive „missing alt“ na regex v teaser helperi nie je defect
  (`scan-blank-hints.ps1` ho filtruje).
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
- `Za účelom` → `Na` + N; `s cieľom` → `aby` + veta (úradnícky kalk).
- KDIGO guidelines v pacientskom SK: držať `usmernenia` (nie striedať so
  `smernice` v tom istom odseku).
- USG `v reálnom čase` = EN *in real time* → `okamžite` (loop #81;
  zobrazenie na monitore). Výučba ipvrm: to isté EN kalk → `priebežne`
  (sledovanie/hodnotenie pokroku; loop #83); scanner Roots zahŕňa
  `ipvrm.htm`.
- Dialýza HDF: `vo forme takzvanej online hemodiafiltrácie` →
  `online hemodiafiltrácia` (ol-HDF; „takzvanej“ zbytočné; loop #82).
- IgAN research: neúplné NP `genetických a biomarkerov` → `genetiky a
  biomarkerov`; kalk `mať prospech z` → `prospieť` + nominatív.
- IgAN patofyziológia ET-1/Ang II: `glomerulárn* hypotenz*` →
  `hypertenz*` (intraglomerulárna hypertenzia; loop #84). Sync
  `segments/igan.html` + `segments/IgAN.sk.html` (live include
  `igan.html`; žiadny `files/` mirror).
- IgAN ethnonym: `kaukazský pôvod` → `európsky pôvod` (EN Caucasian
  calque; loop #85). Sync oba IgAN segmenty.
- IgAN liečba: `V súčasnej paradigme liečby` → `V súčasnom modeli liečby`
  (EN paradigm calque; loop #86). Sync oba IgAN segmenty; treatment
  section (mimo pathophysiology odsek #84/#ET-1).
- IgAN ET-1: `regulácia endotelínu-1` → `zvýšená tvorba endotelínu-1`
  (EN upregulation; loop #87). Sync oba IgAN segmenty; cascade
  `regulácii … kaskády` → `aktivácii … kaskády a endotelínových
  receptorov`; `lokálne reguluje` → `lokálne zvyšuje aj tvorba`.
- Transplantácia výhody: `dlhšiu dobu dožitia` → `dlhšie prežívanie`
  (loop #88; zhoda s nadpisom „Dlhšie prežívanie“; demografia vs
  survival). Sync `files/transplantacia.html` +
  `segments/transplantacia.html`.
- Transplantácia úvod: `preferovanou možnosťou liečby` →
  `uprednostňovanou možnosťou liečby` (loop #89; EN preferred calque).
  Sync `files/transplantacia.html` + `segments/transplantacia.html`.
  Záver stránky `najlepšou možnosťou liečby` ponechať (iný register).
- IgAN liečba (SGLT2): `v tejto populácii špecifickej populácie IgA
  nefropatie alebo populácie glomerulonefritídy` →
  `v tejto špecifickej populácii IgA nefropatie alebo
  glomerulonefritídy` (loop #90; garbled doubled NP). Sync
  `segments/igan.html` + `segments/IgAN.sk.html` (žiadny `files/`
  mirror; `/igan` 404).
- Pacientsky nefamb synonym piles (loop #91): `renálnych (obličkových)` →
  `obličkových`; `cievny (vaskulárny)` → `cievny`. Sync len
  `files/nefamb.html` (žiadny segments mirror). Distinct od #68 CKD dual.
- Pacientsky nefamb synonym piles (loop #92):
  `močovým systémom (uropoetickým aparátom)` → `močovým systémom`;
  `vnútornom lekárstve (internej medicíne)` → `vnútornom lekárstve`;
  `brušnú (peritoneálnu) membránu` → `brušnú membránu`. Sync len
  `files/nefamb.html`.
- Pacientsky nefrologia residual (loop #93):
  `starajú sa o dlhodobú starostlivosť o transplantačný orgán` →
  `zabezpečujú dlhodobú starostlivosť o transplantovaný orgán`;
  `lupusom erythematosus` → `lupus erythematosus` (Latin undeclined);
  `zdravie a pohodu` → `zdravie` (EN well-being calque). Sync
  `files/nefrologia.html` + `segments/nefrologia.html`. Distinct od
  #72 CKD/AKI `resp.` piles.
- Pacientsky dialýza-transplant EN gloss piles: `ekvilibrácia (vyrovnanie
  koncentrácií)` → `ekvilibrácia`; `ultrafiltrácia (odstránenie vody)` →
  `ultrafiltrácia` (vysvetlenie už v okolí); `glomerulárna filtrácia
  (GFR)` ponechať akronym kde je diagnostický.
- Pacientsky purifikácia GvHD: `ochorenie štepu verzus hostiteľ (GvHD)`
  → `ochorenie štepu proti hostiteľovi (GvHD)` (štandardný SK).
- Pacientsky dialýza dwell time: EN gloss `"dwell time"` pred už SK
  `čas pôsobenia` → len `čas pôsobenia` (loop #67; scanner label).
- Pacientsky nefamb synonym piles: `chronické ochorenie obličiek (CKD,
  chronická renálna insuficiencia)` → `chronické ochorenie obličiek
  (CKD)`; podobne AKI/ESKD dual-acronym piles.
- Pacientsky ľadvina+KTx piles: `ľadvina` synonym pile; `KTx` dual.
- Pacientsky dialýza centre/membrane/cykler: `dialyzačnom stredisku
  (dialyzačnom centre, dialyzačnom stacionári)` → `dialyzačnom centre`;
  `peritoneálna membrána - peritoneum` (brušná membrána, pobrušnica) →
  `peritoneálna membrána` (pobrušnica); `cykler` (…, "cyklovač") →
  `cykler` (APD odsek už popisuje automatizáciu). Sync `files/dialyza.html`
  + `segments/dialyza.html`. Intro `pobrušnicu, ktorá sa nazýva
  peritoneum` nie je ten istý pile.
- Pacientsky purifikácia synonym piles: `Purifikácia (očisťovanie,
  čistenie) krvi, teda …` → `Purifikácia krvi, teda …` (vysvetlenie už
  v `teda`); `peritoneálnu membránu (brušnú membránu, pobrušnicu,
  peritoneum)` → `peritoneálnu membránu (pobrušnicu)` (zhoda s dialýzou).
  Sync `files/purifikacia.html` + `segments/purifikacia.html`.
  `umelú membránu (dialyzátor)` nie je synonym pile (prístroj).
- Patient-copy regressie: `tools/scan-patient-copy.ps1` (high-confidence
  SESSION patterns; skip legal/cookie; Lipton/ABPM allowlist; Roots
  vrátane root `ipvrm.htm`).

## Ďalší fokus (loop #94)

1. Zbieraj RO telemetriu; drop `'unsafe-inline'` len so strong evidence +
   Clarity/GTM consent paths (sleduj súčet aj rozpad vendor hits).
2. Schválený cleanup remote-only (A–C; keep `reports.jsonl`).
3. Voliteľne GH `DEPLOY_*` secrets (mimo repo) alebo ponechať len lokálny deploy.
4. Bug/a11y/content/tooling ship, ak telemetria stále smoke-only (ASN/ISN
   len s oficiálnym title dôkazom; uncommented intro Bory až po rozhodnutí
   o obsahu). Nie Lipton `jedinec`. Preferovať overený non-promo /
   non-tip-path ship mimo tip-SHA privacy/terms/cookie/intro-Amazon/
   Lipton/homepage-dative/EN-gloss dialyza-transplant/purifikacia-GvHD/
   dialyza dwell-time/nefamb synonym piles/ľadvina+KTx piles/
   dialyza centre/membrane/cykler piles/
   purifikácia očisťovanie/membrane piles/
   nefrologia CKD/AKI `resp.` piles/
   USG ultrasonografické piles/
   nefamb ESKD dual acronym (#74)/
   IgAN residual ESRD→ESKD (#75)/
   USG gel aplikácia→nanášanie (#76)/
   lecture `suplementá`→`suplementy` (#77)/
   nefamb/IgAN `s cieľom`→`aby …` (#78)/
   IgAN genetiky/prospieť (#79)/
   IgAN `smernice`→`usmernenia` (#80)/
   USG `v reálnom čase`→`okamžite` (#81)/
   dialýza `takzvanej online HDF`→`online hemodiafiltrácia` (#82)/
   ipvrm `v reálnom čase`→`priebežne` (#83)/
   IgAN glomerular hypotenzi→hypertenzi (#84)/
   IgAN `kaukazský`→`európsky pôvod` (#85)/
   IgAN `paradigme`→`modeli liečby` (#86)/
   IgAN ET-1 `regulácia`→`zvýšená tvorba` (#87)/
   transplant `dobu dožitia`→`dlhšie prežívanie` (#88)/
   transplant `preferovanou`→`uprednostňovanou` (#89)/
   IgAN garbled NP (#90)/
   nefamb `obličkových`/`cievny` (#91)/
   nefamb `brušnú membránu` / `močovým systémom` /
   `vnútornom lekárstve` (#92)/
   práve-shipnutý nefrologia residual transplant/SLE/pohodu (#93);
   soft kandidáti: iný verified patient-copy/a11y/tooling mimo churn
   listu (dialyza beyond prior piles, lectures, homepage blocks,
   purifikácia, blank-hints, tooling).
   Spustiť `scan-blank-hints.ps1` aj `scan-patient-copy.ps1`.

## Handoff súbory

- Codex: `.codex/handoffs/` (loop #93 nefrologia residual)
- Audit: `.audit.md` Beh #100

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-blank-hints.ps1
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-patient-copy.ps1
```
