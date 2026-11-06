# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-06 (loop iterácia #68)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `ae3863f` (docs tip nasleduje)

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky, **0** Clarity/GTM/Fastbase
  vendor hits (rozpad 0/0/0) → **neodstraňovať** enforced `'unsafe-inline'`.
- Product ship (nefamb synonym piles; mimo tip-SHA
  privacy/terms/cookie/intro-Amazon/Lipton/homepage-dative/
  dialyza-transplant EN gloss #65 / purifikacia-GvHD #66 /
  dialyza dwell-time #67):
  - `files/nefamb.html`: `Hypertenzia … (HT)` → bez `(HT)`;
    `Diabetická nefropatia … (DKD)` → bez `(DKD)`;
    `glomerulárnej (glomerulovej) … čiže … (GF)` →
    `glomerulovej filtračnej rýchlosti (GFR)`;
    `lupus erythematodes, erythematosus` → `lupus erythematosus`
  - `tools/scan-patient-copy.ps1`: štyri pravidlá na tieto piles; README
- Grok/XAI: žiadny NephroSite kanál/tooling; žiadna inventovaná analýza.
- Overené a **nechane**:
  - Lipton literárny `jedinec`/`jedincov` (literárny preklad)
  - Lipton genitív `Liptona` a literary wording (`vziať`/`takisto`/`na to`)
  - Homepage dative `všeobecnej medicíne`
  - ASN/ISN oficiálne `<title>` stále bez akronymu → polish **neshipnutý**
  - Intro Bory zostáva zakomentovaný
  - privacy / terms / cookie / intro Amazon / IgAN / USG /
    lectures / ipvrm / transplantacia / nefrologia / dialyza /
    purifikacia GvHD / dialyza dwell time
- Remote-only (~69) **nemažeť** bez súhlasu; GH secrets nevytvárané.
- Medicínsky obsah (diagnózy, GFR význam) **nezmenený**; odstránené
  len redundantné synonym/akronym piles.

## Overené na produkcii

- `csp-report-summary.ps1` → smoke-only + vendor hits 0 (Clarity 0,
  GTM/GA 0, Fastbase 0); `php tools/test-csp.php` → PASS;
  `scan-blank-hints.ps1` → 0/0/0; `scan-patient-copy.ps1` → 0 hits
- Commit `ae3863f`; post-commit SFTP nahral `files/nefamb.html`
  (tools v deployignore); `deploy.ps1 -Apply` 0 upload; smoke direct 200
- Clean URL smoke (Chrome UA): `/` `/nefamb` `/privacy` `/terms`
  `/nefrologia` → 200 + HSTS + CSP (enforced stále s `'unsafe-inline'`)
- Produkcia `/nefamb`: nové wording OK; `(HT):` / `(DKD)` /
  `glomerulárnej (glomerulovej)` / `erythematodes` neprítomné
- GHA Deploy `42138325192` success (rsync skip)

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
- `Za účelom` je úradnícky kalk → `Na` + substantívum; `najoptimálnejšie`
  je pleonazmus → `najlepšie`; deminutívum `sestrička`/`sestričiek` v
  odbornom texte → `sestra`/`sester`; zhoda rodu: `umožnil prenos`
  (nie `umožnilo`); `vzorka` je ženský rod → `malej vzorky` + `ktorá`;
  predložka `pochádzajúcimi z` (nie `s`) vedeckého skúmania;
  `detekciu` → `odhalenie` v pacientskom texte.
- Číselná frekvencia: `4-5 krát` → `4-5-krát` (spojovník pred `krát`);
  `viacero` + genitív → `viaceré` + nominatív plurálu (+ plurál slovesa);
  `z dôvodu` → `pre` + akuzatív v pacientskom texte;
  podobne redundantné `v dôsledku rôznych príčin` → `pre rôzne príčiny`
  (nie však každá väzba `v dôsledku` + genitív je defect).
- IgAN je na homepage cez `segments/igan.html`; `IgAN.sk.html` je paralelný
  variant (opraviť oba pri wording fixoch). IgAN nemá `files/` mirror.
- Preferovať `nahrádza`/`náhradná liečba` pred `nahradzuje`/`nahradzujúca`
  (zhoda s footer/cookie/terms); blank-hint scan môže dať false positive,
  keď je `<span class="sr-only">` až za PHP blokom vnútri `<a>`.
- `hyponatriémia` a `kosáčikovitá anémia` sú zavedené SK/MKCH/ICD tvary;
  nemeniť bez dôkazu. `dysbalancie` je anglicizmus vedľa `nerovnováhy`.
- Latinské/medzinárodné názvy chorôb (`mycosis fungoides`) nemenit́ na
  skomolené adjektíva (`mykózny fungoides`).
- Pacientsky text: `jedinci` (kalk z EN *individuals*) → `ľudia`;
  `jednotlivec`/`jednotlivca` → `človek`/`človeka`; nadpis `manažment` →
  `zvládanie`; `glomerulárnej nefritídy` → `glomerulonefritídy`
  (zavedený termín). `vylepšiť` je bohemizmus → `zlepšiť`/`zlepšovať`.
  Rovnaký rad: `riadenie chronických ochorení` → `zvládanie chronických
  ochorení` (zhoda s IgAN).
- Pacientsky IgAN: EN *healthcare provider* → `lekár` (nie úradnícky
  `poskytovateľ zdravotnej starostlivosti`; legal stránky ponechať);
  *environmental factors* → `faktorov prostredia`; vetné `Taktiež` →
  `Musia tiež` / `Tiež`; `v rámci glomerulov` → `v glomeruloch`
  (úradnícky kalk; zhoda so zvyškom odseku);
  `Pravidelné monitorovanie` → `Pravidelné sledovanie` (anglicizmus;
  ABPM názov v nefamb ponechať);
  `Propagácia` → `Osveta` (marketingový nádych vs zdravotná osveta);
  `platformu` → `priestor` (anglicizmus);
  `asymptomatické` → `bez príznakov` (pacientsky register + chybný
  neutrálny rod pri ženskom `nefropatia`);
  EN *policy changes* → `zmien v zdravotnej politike` (nie `politických
  zmien`, čo v SK znamená stranícku politiku).
- Po `pre` je genitív: `pre ľudí s` (nie nominatív `pre ľudia s`);
  EN *balance side effects* → `vyrovnať sa s vedľajšími účinkami` (nie
  `zosúladiť vedľajšie účinky`); `osoby, ktoré majú` nie je to isté ako
  `osoby s` a nemusí sa meniť.
- Pacientsky transplant: `Monitorovanie` → `Sledovanie` (zhoda s
  `sledovanie` v texte); `zo strany lekárov` je úradnícky kalk → vypustiť
  `zo strany`; `aby sa zabezpečilo správne fungovanie… a monitorovali sa`
  → priame `aby transplantovaná oblička správne fungovala a aby sa včas
  zachytili…`; `prispôsobenie životného štýlu` → `úpravu životného štýlu`;
  `prispôsobeniu liekov` → `úprave liekov`; `darcu (donora)` → `darcu`
  (EN gloss zbytočný vedľa SK `darcu`);
  `zabezpečenie hygieny potravín` → `hygiena pri potravinách`.
  Literárny Lipton `jedinec` nemeniť ako pacientsky kalk.
- Sync `files/transplantacia.html` aj `segments/transplantacia.html`.
- Pacientsky dialýza/HDF: `z hľadiska znižovania chorobnosti…` je
  úradnícky kalk → priame `pretože … lepšie znižuje chorobnosť …
  a úmrtnosť …`; predložka pri väčšine pacientov: `u prevažnej väčšiny`
  (nie `v prevažnej väčšine`); segments sync EN `cycler` → SK `cykler`
  (zhoda s `files/`). Medicínske fakty (HDF vs HD, morbidity/mortality)
  nemenit́. Sync `files/dialyza.html` aj `segments/dialyza.html`.
- Pacientsky `ako aj`: overiť každý výskyt. Defecty typicky: (a) redundantné
  po už spojenej vymenovávačke, (b) visiaci genitív po inštrumentáli
  (`dávkovaním ako aj vitamínov`), (c) chýbajúca pádová zhoda
  (`vizualizáciu A, ako aj prítomnosť` → `… a prítomnosti`), (d) zmiešané
  predložky (`v závislosti od X ako aj podľa Y`). `nefamb` nemá
  `segments/` mirror.
- Transplantácia: preferovať `zosnulý`/`zosnulého darcu` pred `mŕtvy`/
  `mŕtveho` (zhoda s meta description); `prenáša na pacienta` nie `do`;
  `príjemca` jednotne (nie `akceptor` / striedanie s `prijímateľ`);
  moralizujúce „byť vďačný darcom“ nie je pacientsky content.
- Sync `files/nefrologia.html` aj `segments/nefrologia.html`.
- Pacientsky USG: `zodpovedá na` (zodpovednosť) ≠ `odpovedá na` (odpoveď
  na otázku); EN *share* → `odovzdajú`/`pošlú` + datív
  (`ošetrujúcemu lekárovi`), nie `zdieľajú s` + inštrumentál.
  Sync `files/usgo.html` aj `segments/usgo.html` (úvodný odsek
  `odpovedá` je len vo `files/`).
- Pacientsky/UI: EN *visualization* → `zobrazenie` (nie `vizualizáciu`);
  `adekvátneho odberu` → `správneho odberu` (v pacientskom texte;
  odbornú „adekvátnosť dialýzy" nemenit́ bez dôvodu).
  Úradnícky `V rámci kurzu/zasadnutia` → `V kurze` / `Na zasadnutí`;
  rovnako ipvrm `V rámci inovatívneho vzdelávania` →
  `V inovatívnom vzdelávaní`; `platformu na zdieľanie` →
  `priestor na výmenu`.
  `nefamb` nemá `segments/` mirror; lectures sú len v `blocks/`.
- Purifikácia: `Medzi niektoré z bežných metód` → `Medzi bežné metódy`;
  `prevedie cez adsorbent` → `vedie cez adsorbent`; photosensitizing
  agent = `fotosenzibilizujúcej látky` (nie `fotosenzitívnej`);
  GvHD = `chronická reakcia štepu proti hostiteľovi` (nie
  `chronická choroba reakcie štepu voči hostiteľovi`);
  po SK termíne stačí `(GvHD)`, nie EN full name
  `graft-versus-host disease`.
  Sync `files/purifikacia.html` aj `segments/purifikacia.html`.
- Nefrológia: vypustiť filler `Ako sme už predtým spomínali`;
  proces = `diagnostikou` (nie `diagnózou`) vedľa `liečbou a prevenciou`.
- Privacy legal: cookie banner GPC/DNT claim musí byť aj v zásadách;
  vendor list uvádzať podľa kategórií súhlasu (analytics vs marketing);
  static consent status zhodný s `privacy-consent.js` (`neuložený`).
- Terms legal: sekcia cookies má zrkadliť rovnaký GPC/DNT predvolený
  režim (signál + žiadna uložená voľba → len nevyhnutné).
- `csp-report-summary.ps1` hlási súčet Clarity/GTM/Fastbase vendor hits
  a rozpad Clarity / GTM-GA / Fastbase; drop `'unsafe-inline'` len so
  strong evidence **a** consent-path vendor signalom.
- Cookie banner UI: odkazovať na `pätičku stránky` a `zásady ochrany
  súkromia` (zhoda s footer legal názvami), nie na „pätu obsahových
  stránok" / „stránku súkromia".
- Intro Amazon: lokatív `Amazone` (nie hyphenované `Amazon-e`).
- Lipton UI: genitív `Liptona` (nie hyphenované `Lipton-a`); literárny
  `jedinec` nemeniť; literárny wording: `vziať do úvahy` (nie `zobrať`),
  `takisto` (nie `tak isto`), `na to` (nie jednoslovné `nato` pred `na`).
- Homepage UI (`blocks/ns.sk.php`): datívna zhoda `všeobecnej medicíne`
  (nie príslovka `všeobecne medicíne`; paralelné s `internej medicíne`).
- Pacientsky EN gloss: zbytočné `(morbidity)` / `(mortality)` vedľa
  `chorobnosť` / `úmrtnosť` a `(rejekcia)` vedľa `odmietnutie orgánu`
  (rovnaká trieda ako `darcu (donora)` → `darcu`); aj
  `graft-versus-host disease` vedľa už SK `chronická reakcia štepu proti
  hostiteľovi` (+ akronym GvHD); aj CAPD `"dwell time"` teda
  `čas pôsobenia` → len `čas pôsobenia`. Medicínsky obsah nezmeniť.
- Nefamb synonym piles: nepoužívať `(HT)` za už glossovanú hypertenziu;
  `(DKD)` za SK `diabetická obličková choroba`; dual
  `glomerulárnej (glomerulovej) … čiže … (GF)` → jedna forma
  `glomerulovej filtračnej rýchlosti (GFR)`; dual Latin
  `lupus erythematodes, erythematosus` → `lupus erythematosus`.
  `nefamb` nemá `segments/` mirror.
- Patient-copy regressie: `tools/scan-patient-copy.ps1` (high-confidence
  SESSION patterns; skip legal/cookie; Lipton/ABPM allowlist).

## Ďalší fokus (loop #69)

1. Zbieraj RO telemetriu; drop `'unsafe-inline'` len so strong evidence +
   Clarity/GTM consent paths (sleduj súčet aj rozpad vendor hits).
2. Schválený cleanup remote-only (A–C; keep `reports.jsonl`).
3. Voliteľne GH `DEPLOY_*` secrets (mimo repo) alebo ponechať len lokálny deploy.
4. Bug/a11y/content/tooling ship, ak telemetria stále smoke-only (ASN/ISN
   len s oficiálnym title dôkazom; uncommented intro Bory až po rozhodnutí
   o obsahu). Nie Lipton `jedinec`. Preferovať overený non-promo /
   non-tip-path ship mimo tip-SHA privacy/terms/cookie/intro-Amazon/
   Lipton/homepage-dative/EN-gloss dialyza-transplant/purifikacia-GvHD/
   dialyza dwell-time/práve-shipnutý nefamb synonym piles; ďalší verified
   patient-copy/a11y/tooling. Spustiť `scan-blank-hints.ps1` aj
   `scan-patient-copy.ps1`.

## Handoff súbory

- Codex: `.codex/handoffs/` (loop #68 nefamb synonym piles)
- Audit: `.audit.md` Beh #79

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-blank-hints.ps1
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-patient-copy.ps1
```
