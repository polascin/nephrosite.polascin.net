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
enforced `'unsafe-inline'`. Okrem smoke vs real candidates hlási aj počet
Clarity/GTM/Fastbase `blocked-uri` zásahov (consent-path safety).
