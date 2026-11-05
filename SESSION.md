# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #39)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `c62b1b6`

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky → **neodstraňovať** enforced
  `'unsafe-inline'`.
- Product ship (overené, non-promo content):
  - `ipvrm.htm`: `viacero výhod`→`viaceré výhody` (zhoda s transplantacia/IgAN)
  - `files/nefamb.html`: odstránený anglicizmus `(dysbalancie elektrolytov)`
    pri už existujúcom `Elektrolytové nerovnováhy`
- Overené a **nechane**:
  - `hyponatriémia` (MKCH E87.1 / odborná literatúra)
  - `kosáčikovitá anémia` (ICD/SK medicínsky termín)
- ASN/ISN oficiálne `<title>` **bez** akronymu → polish **neshipnutý**.
- Intro Bory zostáva zakomentovaný (žiadne spekulatívne re-enable).
- Remote-only (~69) **nemažeť** bez súhlasu; GH secrets nevytvárané.

## Overené na produkcii

- `csp-report-summary.ps1` → smoke-only; `php tools/test-csp.php` → PASS
- Commit `c62b1b6`; post-commit SFTP nahral `ipvrm.htm` +
  `files/nefamb.html`; `deploy.ps1 -Apply` 0 upload; smoke direct 200
- Clean URL smoke (MaximumRedirection 0, Chrome UA): `/` `/privacy`
  `/terms` `/nefrologia` `/dialyza` `/nefamb` `/usgo` `/transplantacia`
  `/ipvrm.htm` → 200 + HSTS + CSP (enforced stále s `'unsafe-inline'`)
- Produkcia `/ipvrm.htm`: `viaceré … výhody` prítomné; `viacero … výhod`
  absent
- Produkcia `/nefamb`: `Elektrolytové nerovnováhy:` bez `dysbalancie`;
  `hyponatriémia` ponechaná
- GHA Deploy `42119106990` success (rsync skip)

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
  je pleonazmus → `najlepšie`; deminutívum `sestrička`/`sestričiek` v
  odbornom texte → `sestra`/`sester`; zhoda rodu: `umožnil prenos`
  (nie `umožnilo`); `vzorka` je ženský rod → `malej vzorky` + `ktorá`;
  predložka `pochádzajúcimi z` (nie `s`) vedeckého skúmania;
  `detekciu` → `odhalenie` v pacientskom texte.
- Číselná frekvencia: `4-5 krát` → `4-5-krát` (spojovník pred `krát`);
  `viacero` + genitív → `viaceré` + nominatív plurálu (+ plurál slovesa);
  `z dôvodu` → `pre` + akuzatív v pacientskom texte.
- IgAN je na homepage cez `segments/igan.html`; `IgAN.sk.html` je paralelný
  variant (opraviť oba pri wording fixoch).
- Preferovať `nahrádza`/`náhradná liečba` pred `nahradzuje`/`nahradzujúca`
  (zhoda s footer/cookie/terms); blank-hint scan môže dať false positive,
  keď je `<span class="sr-only">` až za PHP blokom vnútri `<a>`.
- `hyponatriémia` a `kosáčikovitá anémia` sú zavedené SK/MKCH/ICD tvary;
  nemenit́ bez dôkazu. `dysbalancie` je anglicizmus vedľa `nerovnováhy`.

## Ďalší fokus (loop #40)

1. Zbieraj RO telemetriu; drop `'unsafe-inline'` len so strong evidence +
   Clarity/GTM consent paths.
2. Schválený cleanup remote-only (A–C; keep `reports.jsonl`).
3. Voliteľne GH `DEPLOY_*` secrets (mimo repo) alebo ponechať len lokálny deploy.
4. Bug/a11y/content/tooling ship, ak telemetria stále smoke-only (ASN/ISN
   len s oficiálnym title dôkazom; uncommented intro Bory až po rozhodnutí
   o obsahu).

## Handoff súbory

- Codex: `.codex/handoffs/` (loop #39 ipvrm/nefamb wording)
- Audit: `.audit.md` Beh #50

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
```
