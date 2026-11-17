# Handoff: loop23-footer-tooling-a11y

## Metadata

- Generated At: 2026-11-05T21:42:14+01:00
- Updated At: 2026-11-05T21:43:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 690bac9

## Original Goal

Loop iterácia #23: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; ak smoke-only, ship coherent product fix
(DistroWatch/W3C image hints / title polish); commit/push/deploy/smoke;
SESSION + handoff.

## Current State

Iterácia #23 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: 4 static sr-only new-window hints na
footer tooling image blanks (Bluefish, W3 Schools, W3C, DistroWatch) +
WHO alt Organisation → Organization. Prod hints 140 → 144. Repo na
`main` @ `690bac9` (product `4f352b3`, docs `9b237fe`).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Verified defect: 4 footer image blanks without static hint
  (Bluefish, W3 Schools, W3C validator, DistroWatch); WHO alt mismatch.
- Added 4 static `.sr-only` hints in `blocks/footer.sk.php`.
- Aligned WHO `alt` to `World Health Organization` in `blocks/promo.sk.php`.
- Cleaned temp `tools/_tmp-loop23-hints.py` (not committed).
- Remote-only (~69) not deleted; no GH secrets created.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `4f352b3`; post-commit SFTP uploaded `footer.sk.php`
  and `promo.sk.php`; `deploy.ps1 -Apply` → 0 upload; smoke direct 200
  on `/` `/privacy` `/terms` `/nefrologia`
- Command: GHA Deploy `42105696759` success (rsync skipped)
- Command: production Chrome UA `/` → hints=144 (was 140; +4),
  pdfHints=11; DistroWatch/W3C/Bluefish/W3 Schools static hints true;
  WHO Organization alt; HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: remaining title/content polish candidates are smaller than
  the footer tooling a11y gap just closed.

## Remaining Work

- [ ] Loop #24: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (further title /
      content consistency; intro Bory only after content decision).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship footer tooling image static hints + WHO alt this tick.
- Reason: Completes DistroWatch/W3C (and sibling tooling) no-JS coverage
  left from loop #22; coherent 4-anchor ship plus one verified title polish.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not a11y).

## Critical Files

- `blocks/footer.sk.php`, `blocks/promo.sk.php`
- `SESSION.md`, `.audit.md` (Beh #34)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 4f352b3 Add static new-window hints on footer tooling logos.
- e1c5562 Point loop #22 handoff HEAD to docs commit.
- 075085c Document loop #22 promo and footer a11y ship.
- 083167f Add static new-window hints on footer FOSS logos.
- 61c5de9 Add static new-window hints on promo logos.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #34)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-214214-loop23-footer-tooling-a11y.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-214214-loop23-footer-tooling-a11y.md.
Pokračuj loop #24 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value ship (title/content consistency) ak telemetria ostáva smoke-only.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.

## Opakované overenie 2026-11-16

- Oprava v commite `4f352b3` je súčasťou `origin/main`. Opakovaná kontrola prebehla na revízii `217f7f3`. DistroWatch aj validátor W3C majú po jednom statickom upozornení na otvorenie v novom okne, overenom v produkčnom HTML bez JavaScriptu.
- `csp-report-summary.ps1` načítal 8 riadkov. Dva sú testovacie značky, ďalším šiestim v súhrne chýba `blocked-uri`, direktíva aj `document-uri`. Bez záznamov pre Clarity, GTM/GA a Fastbase. Ponechané `'unsafe-inline'` v `script-src`. Pred sprísnením politiky overiť správanie Clarity a GTM po udelení súhlasu.
- `php tools/test-csp.php` prešiel. Lokálny plán nasadenia porovnal 246 súborov a našiel 0 na nahratie. Priame požiadavky na `/`, `/privacy`, `/terms`, `/nefrologia` a `/transplantacia` vrátili HTTP 200, HSTS a obe hlavičky CSP. Produkčná hlavička CSP obsahovala `'unsafe-inline'` v `script-src`.

## CSP a súhlas s analytikou 2026-11-16

- Pôvodných šesť nezaradených riadkov obsahovalo iba polia `referrer` a `disposition`, po tri s hodnotami `report` a `enforce`. Chýba blokovaný zdroj aj direktíva. Z riadkov sa preto nedá určiť, čo bolo blokované. Prijímač spracuje obálku Reporting API, ale jeho filter ponecháva iba staršie názvy polí. Lokálny test potvrdil, že zahodí `documentURL`, `effectiveDirective` a `blockedURL`.
- Produkčná titulná stránka v čistom profile Chrome. Pred voľbou a po odmietnutí neboli zaznamenané žiadne požiadavky na Clarity ani na Google Tag Manager alebo Google Analytics. Po povolení všetkých kategórií cez nastavenia sa hlavné skripty Clarity a Google `gtag.js` načítali s HTTP 200. Požiadavky Clarity na `r.clarity.ms/collect` vrátili HTTP 204. Dve ďalšie požiadavky na `gtag.js` Chrome ukončil chybou `ERR_BLOCKED_BY_ORB`. Úspešné doručenie udalosti do Google Analytics sa nepotvrdilo.
- Chrome zaznamenal 17 udalostí CSP, všetky s dispozíciou `report`. Týkali sa skriptov Clarity, Google a Fastbase, sieťových spojení a obrázkov. Po teste bolo v serverovom súhrne 9 riadkov, o jeden viac než pred ním. Posledný mal opäť iba `referrer` a `disposition` a súhrn stále uvádzal nula zásahov dodávateľov. Záznam nemožno jednoznačne priradiť k testu.
- Ponechané `'unsafe-inline'`. Politika Report-Only sa líši aj povolenými zdrojmi. Tento test preto neizoluje vplyv odstránenia `'unsafe-inline'`. Pred sprísnením treba zachovať polia Reporting API a overiť politiku, ktorá sa od vynucovanej líši iba odstránením `'unsafe-inline'`.

## Oprava prijímača CSP a opakovaný test súhlasu 2026-11-16

- Prijímač mapuje polia Reporting API na existujúce kľúče protokolu, napríklad `documentURL` na `document-uri`, `effectiveDirective` na `effective-directive` a `blockedURL` na `blocked-uri`. Naďalej platí zoznam povolených polí aj limity dĺžky. Regresný test s formátom z prehliadača pred opravou zlyhal a po nej prešiel. Prešiel aj lokálny test integrácií.
- Lokálne nasadenie cez WebSupport nahralo iba `blocks/csp-report-handler.php` a overilo SHA-256. Priame požiadavky na `/`, `/privacy`, `/terms` a `/nefrologia` vrátili HTTP 200. Produkčný `script-src` stále obsahuje `'unsafe-inline'`.
- V novom profile Chrome neboli pred voľbou ani po odmietnutí zaznamenané požiadavky na Clarity, Google Tag Manager alebo Google Analytics. Po povolení všetkých kategórií hlavné skripty vrátili HTTP 200 a zberné koncové body Clarity aj Google Analytics HTTP 204. Dve ďalšie požiadavky na `gtag.js` Chrome ukončil chybou `ERR_BLOCKED_BY_ORB`.
- Chrome zaznamenal 18 udalostí CSP, všetky typu Report-Only. V súkromnom serverovom protokole bolo 10 riadkov jednoznačne priraditeľných k testu podľa adresy testovacej stránky. Obsahovali adresu stránky, direktívu aj blokovaný zdroj vrátane skriptov Clarity a Google a spojení na zberné koncové body oboch služieb.

## Izolovaný test Report-Only 2026-11-16

- V čistom profile Chrome sa na produkčnej titulnej stránke lokálne nahradila iba hlavička Report-Only. Testovacia politika vznikla z aktuálnej vynucovanej politiky odobratím jediného tokenu `'unsafe-inline'` z `script-src`. Zhoda oboch hlavičiek s očakávanými hodnotami sa overila v prehliadači. Produkčná konfigurácia sa nemenila a samostatná požiadavka potvrdila HTTP 200 a `'unsafe-inline'` vo vynucovanom `script-src`.
- Už pred voľbou Chrome zaznamenal dve hlásenia testovacej politiky `script-src-elem` pre inline skripty. Prvé smerovalo na blok s funkciou `getDayOfYear` (riadok 1142 produkčného HTML), druhé na správu súhlasu (`nephro_consent_v1`, riadok 2789). Po odmietnutí a následnom povolení nepribudli ďalšie hlásenia. Každé hlásenie sa priradilo k testovacej politike podľa `originalPolicy`.
- Pred voľbou a po odmietnutí neboli zaznamenané požiadavky na Clarity ani Google tagging. Po povolení cez nastavenia sa hlavné skripty načítali s HTTP 200 a zberné koncové body oboch služieb odpovedali HTTP 204. Dve ďalšie požiadavky na `gtag.js` skončili s `ERR_BLOCKED_BY_ORB`, bez zodpovedajúcej udalosti CSP.
- Odstránenie `'unsafe-inline'` by pri vynútení zablokovalo aj správu súhlasu. Pred sprísnením treba oba inline bloky presunúť do externých skriptov alebo ich povoliť pomocou nonce či hashov a test zopakovať. Výsledok sa týka jednej návštevy titulnej stránky v Chrome.

## Presun inline skriptov do súborov 2026-11-16

- Hodiny a správa súhlasu sa načítavajú z `/files/current-time.js` a `/files/consent-manager.js`. Obe značky zostali na pôvodných miestach v HTML. Lokálne prešli kontrola syntaxe, regresný test CSP aj test integrácií. Regresný test teraz overuje externé načítanie a neprítomnosť vykonateľných inline skriptov na ôsmich renderovaných stránkach.
- Pri lokálnom nasadení cez WebSupport sa oba súbory JavaScriptu nahrali a overili pomocou SHA-256 pred nasadením šablón. Priame požiadavky na `/`, `/privacy`, `/terms` a `/nefrologia` vrátili HTTP 200.
- V čistom profile Chrome sa na produkčnej titulnej stránke lokálne nasadila politika Report-Only zhodná s vynucovanou politikou po odobratí jediného tokenu `'unsafe-inline'` z `script-src`. Obe hlavičky sa overili v prehliadači. Externé skripty vrátili HTTP 200, hodiny vyplnili všetky polia a Chrome nezaznamenal žiadne hlásenie CSP ani výnimku JavaScriptu.
- Pred voľbou a po odmietnutí neboli zaznamenané požiadavky na Clarity, Google Tag Manager ani Google Analytics. Po povolení cez nastavenia vrátili hlavné skripty HTTP 200 a zberné koncové body Clarity a Google Analytics HTTP 204. Pri prvom pokuse odpoveď Clarity neprišla v časovom limite testu. Opakovaný test s dlhším čakaním ju zachytil. Dve ďalšie požiadavky na `gtag.js` skončili s `ERR_BLOCKED_BY_ORB`, bez udalosti CSP.
- Vynucovaná produkčná politika stále obsahuje `'unsafe-inline'` v `script-src`. Výsledok testovacej politiky sa vzťahuje na titulnú stránku v Chrome.

## Sprísnenie vynucovanej CSP 2026-11-16

- V čistých profiloch Chrome prešla politika Report-Only zhodná s dovtedajšou vynucovanou politikou po odobratí jediného tokenu `'unsafe-inline'` z `script-src`. Bez udalostí CSP a výnimiek JavaScriptu na `/`, `/nefrologia`, `/dialyza`, `/transplantacia`, `/nefamb`, `/usgo`, `/lipton-tx`, `/purifikacia`, `/privacy`, `/terms` a `/ipvrm.htm`. Na ôsmich stránkach so správou súhlasu sa Clarity ani Google tag neozvali pred voľbou ani po odmietnutí. Po povolení hlavné skripty vrátili HTTP 200 a zberné koncové body oboch služieb HTTP 204.
- Po zálohe konfigurácie na WebSupport v `codex-deploy-backups/20261116-235418/nephrosite/` sa `'unsafe-inline'` odstránilo z vynucovanej direktívy `script-src` v `.htaccess` aj `blocks/csp-bootstrap.php`. Ostatné direktívy a existujúca politika Report-Only zostali bez zmeny. Prešli regresný test CSP, test integrácií a lokálne nasadenie s kontrolou SHA-256.
- Po nasadení všetkých 11 adries vrátilo priamo HTTP 200, presnú očakávanú vynucovanú hlavičku CSP, hlavičku Report-Only aj HSTS. Opakovaný test skutočnej vynucovanej politiky na `/` a `/nefrologia` potvrdil rovnaké správanie súhlasu, HTTP 200 pre hlavné skripty, HTTP 204 pri zbere a žiadne vynútené blokovanie ani výnimku JavaScriptu. Dve vedľajšie požiadavky na Google tag na každej stránke naďalej končili s `ERR_BLOCKED_BY_ORB`. Po súhlase zaznamenala existujúca užšia politika Report-Only 19 udalostí na titulnej stránke a 16 na `/nefrologia`.

## Kontrola súhrnu CSP 2026-11-17

- Súhrn zahŕňa aj regionálne koncové body `analytics.google.com`, dodávateľa určuje podľa hostiteľa a v tabuľkách vynecháva parametre a fragmenty HTTP adries. Neúplné hlásenia vykazuje samostatne a rozlišuje úplné hlásenia vynucovanej politiky.
- Overené na 23 produkčných záznamoch. Dve testovacie značky, sedem neúplných riadkov, 14 úplných netestovacích záznamov, z toho nula z vynucovanej politiky. Rozpoznaných 11 hlásení dodávateľov (Clarity 7, GTM/GA 2, Fastbase 2).
- Regresný test CSP prešiel. Produkčné adresy `/`, `/nefrologia`, `/privacy` a `/terms` vrátili HTTP 200 a vynucovaný `script-src` bez `'unsafe-inline'`.

## Overenie expirácie súhlasu 2026-11-17

- Commit `46c3e18` odmieta neplatný dátum expirácie pri obnove súhlasu, rozlišuje neplatný a vypršaný záznam na stránke ochrany súkromia a odstraňuje nadbytočnú kontrolu typu v prijímači CSP. Prešli regresné testy CSP, test integrácií aj PHPStan.
- Lokálne nasadenie cez WebSupport. Po nahratí cez post-commit hook potvrdil `deploy.ps1 -Apply` zhodu všetkých 248 nasadzovaných súborov. Priame požiadavky na `/`, `/privacy`, `/terms` a `/nefrologia` vrátili HTTP 200.
- Produkčný Chrome s izolovaným profilom a vypnutou vyrovnávacou pamäťou. Stránka `/privacy` správne označila neplatný aj vypršaný záznam. Titulná stránka v oboch prípadoch vymazala záznam z lokálneho úložiska aj zo súboru cookie, zobrazila voľbu súhlasu a neodoslala žiadnu požiadavku sledovaným dodávateľom.
- Odmietnutie nevyvolalo požiadavky na analytické služby. Po povolení sa uložil nový súhlas s budúcim dátumom expirácie. Hlavné skripty Clarity a Google vrátili HTTP 200 a oba zberné koncové body HTTP 204. Bez porušenia vynucovanej politiky CSP v tomto teste.
