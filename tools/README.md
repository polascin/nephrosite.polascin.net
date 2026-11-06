# Lokálne vývojárske nástroje

Kontrola kvality PHP kódu **bez Composera** - nástroje sa sťahujú ako samostatné
PHAR súbory (sú v `.gitignore`, na server sa nedeployujú).

## Inštalácia (raz)

```powershell
.\tools\install-dev-tools.ps1
```

Stiahne `phpstan.phar` + `php-cs-fixer.phar` do `tools/` a vygeneruje
`phpstan-baseline.neon` (existujúce nálezy sa ignorujú → hlásia sa len NOVÉ chyby).

## Každodenné použitie

```powershell
.\tools\quality.ps1          # PHPStan analýza + náhľad formátovania (nič nemení)
.\tools\quality.ps1 -Fix     # aplikuje opravy formátovania (PHP-CS-Fixer)
```

## Konfigurácia

| Súbor                   | Účel                                                                 |
| ----------------------- | -------------------------------------------------------------------- |
| `phpstan.neon.dist`     | PHPStan - úroveň 4 (postupne zvyšuj k 9)                             |
| `phpstan-baseline.neon` | zoznam ignorovaných existujúcich nálezov (regeneruje install skript) |
| `.php-cs-fixer.dist.php`| PHP-CS-Fixer - konzervatívna sada nízkorizikových pravidiel          |

## Post-commit SFTP hook

Po commite sa (ak je nainštalovaný) spustí SFTP upload cez
`tools/hooks/post-commit-deploy.sh` → `.git/hooks/deploy.sh`. Skript filtruje
cesty podľa `.deployignore` a **neuploaduje** `tools/`, dokumentáciu ani
lokálne tooling. Obnova hooku:

```powershell
Copy-Item -Force tools\hooks\post-commit-deploy.sh .git\hooks\deploy.sh
```

Produkčný smoke a hash overenie stále robí `.\tools\deploy.ps1 -Apply`.

## CSP návrh a regresie

```powershell
php .\tools\test-csp.php
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
```

`test-csp.php` bez siete vykreslí verejné PHP stránky, porovná zdroje s
[Report-Only kandidátom](../docs/CSP-REPORT-ONLY.md) a overí hybrid PHP/Apache
CSP, nonces a Cache-Control pre self-host fonty. Workflow sleduje tento test
pri PR aj pushi do `main`.

`csp-report-summary.ps1` načíta `private/csp-reports/reports.jsonl` cez SSH
alias `websupport` (súkromne; HTTP 403). Použi pred rozhodnutím o dropnutí
enforced `'unsafe-inline'`. Okrem smoke vs real candidates hlási súčet
Clarity/GTM/Fastbase `blocked-uri` zásahov a rozpad Clarity / GTM-GA /
Fastbase (consent-path safety).

## A11y blank / download / alt scan

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-blank-hints.ps1
```

`scan-blank-hints.ps1` najprv odstrihne HTML komentáre (excluded vendor
logá, zakomentovaný intro Bory), potom kontroluje celé `<a target="_blank">…</a>`
kotvy na `sr-only` / „otvorí sa v novom okne“ / `aria-label` (neskoro vložený
hint v PDF karte nie je falošný miss). Ďalej hlási odkazy s textom
„na stiahnutie“/„stiahnuť“ bez `download` a live `<img>` bez `alt` (PHP
regex vzory ako v `topic-teaser.php` ignoruje). Exit code 1 pri náleze.

## Patient-copy regression scan

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-patient-copy.ps1
```

`scan-patient-copy.ps1` hľadá high-confidence SESSION wording regresie
(bohemizmy/kalky už opravené v tip-path textoch: `Zahrňuje`, `nahradzuj*`,
`Amazon-e`, `Lipton-a`, `v prevažnej väčšine`, `mŕtveho darcu`, `cycler`,
`zobrať do úvahy`, `tak isto`, `nato na`, `všeobecne medicíne`,
`prispôsobenie životného`, `pre ľudia`, `(morbidity)`, `(mortality)`,
`orgánu (rejekcia)`, `graft-versus-host disease`, `dwell time`,
nefamb synonym piles `Hypertenzia … (HT)` / `Diabetická nefropatia … (DKD)` /
`glomerulárnej (glomerulovej)` / `lupus erythematodes, erythematosus`,
`obličiek (ľadvín)` / `obličky (ľadviny)` / `KTx, RTx, NTx` /
`centre (stredisku, stacionári)` / peritoneum membrane piles /
`cykler "cyklovač"` / purifikácia `očisťovanie, čistenie` /
`brušnú membránu, pobrušnicu, peritoneum` / nefrológia
`Chronické zlyhanie …, resp. chronická` /
`Akútne zlyhanie …, resp. akútne` /
USG `Ultrazvukové (ultrasonografické)` /
`teda ultrasonografické` /
nefamb `ESKD, ESRD`, residual IgAN `(ESRD)`,
USG `Aplikácia gélu` / `aplikáciu gélu` / `sa aplikuje špeciálny gél` /
lecture `suplementá` (→ `suplementy`),
`s cieľom` (→ `aby …`),
IgAN `genetických a biomarkerov` (→ `genetiky a biomarkerov`),
`mať prospech z` (→ `prospieť` / `mať úžitok z`),
`smernice KDIGO` (→ `usmernenia KDIGO`),
`v reálnom čase` (→ `okamžite` patient USG; `priebežne` teaching ipvrm),
dialýza `takzvanej online hemodiafiltr*` (→ `online hemodiafiltrácia`),
IgAN `glomerulárn* hypotenz*` (→ `hypertenz*`; ET-1/Ang II), …).
Default Roots: `files`, `segments`, `blocks`, plus root teaching
`ipvrm.htm`. Preskakuje
privacy/terms/cookie-banner a
`.kilo/` worktrees; allowlist: literárny Lipton `jedinec`, ABPM názov,
Lipton `vizualizácie`. Exit code 1 pri náleze.
