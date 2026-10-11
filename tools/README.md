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

## CSP návrh a regresie

```powershell
php .\tools\test-csp.php
```

Bez ďalších závislostí a siete vykreslí verejné PHP stránky, porovná ich zdroje
s dokumentovaným [Report-Only kandidátom](../docs/CSP-REPORT-ONLY.md) a overí,
že návrh neaktivuje hlavičku ani meta CSP vrátane neúvodzovkových a
zmiešaných zápisov `http-equiv`. Kontroluje aj to, že workflow sleduje tento
test pri pull requestoch aj pushi do `main`. Samostatný PR workflow nemá deploy
job. Test nemení produkčné ani právne súbory.
