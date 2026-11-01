# Deploy - nephrosite.polascin.net

## Cielené lokálne nasadenie od 1. 11. 2026

Aktívna CSP je v `.htaccess`. `php tools/test-csp.php` overuje nasadzovanú
politiku, osem vykreslených PHP stránok, tri statické dokumenty a dynamické
skripty. Dokument `docs/CSP-REPORT-ONLY.md` opisuje historický návrh.

Pre samostatnú opravu `.htaccess` slúži `python tools/deploy-file.py
--expected-sha256 HASH`, následne rovnaký príkaz s `--apply`. Voliteľné
`--source CESTA` umožní nasadiť skontrolovaný súbor zostavený z produkčného
základu bez iných rozpracovaných zmien. Pred nasadením vždy porovnať jeho diff.

Nástroj používa SSH alias `websupport`, kontroluje pôvodný SHA-256, vytvorí
zálohu mimo web rootu v `codex-deploy-backups/CAS/nephrosite/`, nahrá dočasný
súbor a atómovo ho premenuje. Overí SHA-256 a HTTP 200; pri zlyhaní následnej
kontroly obnoví zálohu. Výsledok a cesta zálohy sú v štandardnom výstupe.
Spúšťanie je ručné, pri schválenom nasadení, bez plánovanej úlohy.

Existujúce Actions reagujú na push do main alebo workflow_dispatch, validujú
PHP a cez rsync/SSH nahrávajú obsah filtrovaný `.deployignore` bez mazania.
Vstupy tvoria checkout, LFS a DEPLOY_* secrets, výstupom je zmenený web root
a smoke test. `deploy-file.py` je overená lokálna cesta pre jeden súbor, nie
náhrada synchronizácie celého webu ani všetkých CI kontrol. Existujúce
workflow zostávajú zachované. GitHub zostáva aj úložiskom a miestom review.
Pri lokálnej práci sa nasadzuje miestnymi nástrojmi.

Opravy integrácií z 1. 11. 2026 kontroluje aj `node tools/test-integrations.cjs`.
Test overuje inicializáciu jediného projektu Clarity `fp2sq6zahr`, načítanie
až po súhlase, odovzdanie odvolaného súhlasu a náhradný obrázok pri výpadku
ClustrMaps. Dva duplicitné projekty Clarity sa už nenačítavajú.
`deploy-file.py --file CESTA --expected-sha256 HASH --apply` podporuje
`blocks/scripts.sk.php`, `blocks/footer.sk.php` a
`pix/clustrmaps-unavailable.svg`. Pre nový súbor sa použije `missing`
namiesto hash hodnoty. Najprv sa nahrá obrázok, potom skripty a päta.
Nástroj neprenáša celý pracovný strom.

Automatické nasadenie cez GitHub Actions (`.github/workflows/deploy.yml`):
po každom pushi do `main` (alebo manuálne cez **Actions → Deploy → Run
workflow**) sa repozitár zosynchronizuje rsyncom do web rootu na WebSupport.
Súbory vylúčené v `.deployignore` sa nenasadzujú; `--delete` sa nepoužíva,
takže serverové súbory mimo repozitára zostávajú nedotknuté. Push s
`[skip deploy]` v commit message deploy preskočí.

Kým secrets nie sú nastavené, deploy job sa iba preskočí s upozornením
(workflow nezlyhá).

## GitHub Secrets (Settings → Secrets and variables → Actions)

| Secret               | Popis                                                                                                                |
| -------------------- | -------------------------------------------------------------------------------------------------------------------- |
| `DEPLOY_HOST`        | SSH host, napr. `shell.r1.websupport.sk`                                                                             |
| `DEPLOY_USER`        | SSH používateľ, napr. `uid58858`                                                                                     |
| `DEPLOY_PORT`        | SSH port (WebSupport shell používa `26650`; predvolené `22`)                                                         |
| `DEPLOY_SSH_KEY`     | Celý obsah privátneho SSH kľúča                                                                                      |
| `DEPLOY_KNOWN_HOSTS` | Host key servera (`ssh-keyscan -p <port> <host>`), formát `[host]:port`                                              |
| `DEPLOY_REMOTE_PATH` | Absolútna cesta k web rootu subdomény (pravdepodobne `.../polascin.net/sub/nephrosite`, overte vo WebSupport paneli) |

Workflow pred rsyncom overí, že vzdialený adresár existuje: pri zlej ceste
bezpečne zlyhá bez zápisu.
