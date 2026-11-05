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

**Autoritatívna produkčná cesta (stav 5. 11. 2026):** lokálny
`tools/deploy.ps1 -Apply` a post-commit SFTP hook cez SSH alias `websupport`.
GitHub Actions workflow `Deploy to nephrosite.polascin.net` stále beží po
pushi do `main` (PHP lint + voliteľný rsync), ale **rsync sa bez nastavených
`DEPLOY_*` secrets iba preskočí** s upozornením. GHA success preto neznamená,
že sa web root aktualizoval; živé súbory idú cez lokálny deploy. Secrets
do repozitára nevkladaj; keď budú v GitHub Settings, GHA môže znova
paralelne synchronizovať. `deploy-file.py` ostáva cestou pre jeden súbor.
GitHub zostáva úložiskom a miestom review.

Opravy integrácií kontroluje aj `node tools/test-integrations.cjs`.
Test overuje inicializáciu jediného projektu Clarity `fp2sq6zahr`, načítanie
až po súhlase, odovzdanie odvolaného súhlasu, generický image fallback helper
a first-party visitor map SVG (`/pix/clustrmaps-visitor-map.svg`; bez live
načítania `clustrmaps.com`). Dva duplicitné projekty Clarity sa už nenačítavajú.
`deploy-file.py --file CESTA --expected-sha256 HASH --apply` podporuje
`blocks/scripts.sk.php`, `blocks/footer.sk.php`,
`pix/clustrmaps-visitor-map.svg` a `pix/clustrmaps-unavailable.svg`. Pre nový
súbor sa použije `missing` namiesto hash hodnoty. Nástroj neprenáša celý
pracovný strom.

GitHub Actions (`.github/workflows/deploy.yml`): po pushi do `main` (alebo
**Actions → Deploy → Run workflow**) job `validate` vždy linta PHP. Job
`deploy` bez `DEPLOY_*` secrets **nepíše na server** (notice + `configured=false`);
so secrets by rsync filtrovaný `.deployignore` synchronizoval web root bez
`--delete`. Push s `[skip deploy]` v commit message celý deploy job
preskočí. Kým secrets chýbajú, ber GHA len ako CI lint, nie ako dôkaz
produkčného syncu.

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

## Dizajnové tokeny (`css/tokens.css`)

Farby, rozstupy, zaoblenia, tiene, šírky rámov a rodiny písem sú definované
ako CSS custom properties v `css/tokens.css`; `blocks/styles.css.php` a
`files/legal.css` sa na ne odkazujú cez `var(--token, pôvodná-hodnota)`.
Súbor je **generovaný** – zdrojom pravdy je `project/tokens.json` v artefakte
Design System „NephroSite“ (<https://claude.ai/artifact/D6tcpg8QTPehYS2MrKXMVm>).

Regenerácia po zmene tokenov v artefakte:

1. Stiahnite `project/tokens.json` z artefaktu (napr. do `C:\tmp\tokens.json`).
2. Spustite z koreňa repozitára:

   ```powershell
   php tools/build-tokens.php C:\tmp\tokens.json
   ```

3. Skontrolujte `git diff css/tokens.css` a commitnite. Nový token použite
   v štýloch ako `var(--názov, záložná-hodnota)`; `css/tokens.css` neupravujte
   ručne. Súbor sa načíta cez `blocks/links.sk.php` (pred `<style>` blokom)
   a z `files/privacy.html` a `files/terms.html` (pred `legal.css`), čo vyhovuje
   CSP `style-src 'self'`.

## Autoritatívna lokálna cesta (`tools/deploy.ps1`)

Toto je **produkčný deploy** pre NephroSite, kým (a pokiaľ) GitHub
`DEPLOY_*` secrets nie sú nastavené a overené. Skript nahrádza rsync časť
workflow `.github/workflows/deploy.yml` a CSP regresiu na Windows bez WSL.
Predvolene je to **plán**: nič sa nezapíše na server bez `-Apply`.

```powershell
.\tools\deploy.ps1            # validácia + zoznam zmien
.\tools\deploy.ps1 -Apply     # upload, overenie SHA-256, smoke test
```

Postup: `php -l` na všetkých sledovaných PHP súboroch, `php tools/test-csp.php`,
zoznam súborov z gitu filtrovaný `.deployignore`, porovnanie SHA-256 s web
rootom, upload iba zmenených súborov cez tar stream po SSH alias `websupport`,
opätovné overenie hashov na serveri a smoke test kanonických ciest `/`,
`/privacy`, `/terms`, `/nefrologia` (priamy HTTP 200, bez redirect hopu).

Rozdiely voči Actions rsync:

- Nepoužíva `rsync`; práva súborov idú z tar archívu (typicky 644/755).
- Rovnako ako workflow **nepoužíva `--delete`**: remote-only súbory ostávajú
  (mazanie len po výslovnom súhlase, pozri `docs/REMOTE-ONLY-INVENTORY.md`).
- Git LFS: pred uploadom musí byť `git lfs pull`, inak by pointer prepísal
  veľký binárny súbor. Workflow to rieši `lfs: true` v checkoute.

Po commite na `main` over: (1) `deploy.ps1 -Apply` alebo post-commit SFTP,
(2) produkčný smoke, (3) GHA validate success (rsync skip je očakávaný, kým
chýbajú secrets).

## Post-commit SFTP hook

Lokálny `.git/hooks/post-commit` volá `deploy.sh`, ktorý po commite pushne vetvu
a nahraje zmenené súbory cez SFTP. Skript musí rešpektovať `.deployignore`
(rovnaký zámer ako `deploy.ps1`), inak uniknú do web rootu `tools/`, `*.md`,
`.codex/` a pod. Referenčná kópia:

```text
tools/hooks/post-commit-deploy.sh
```

Inštalácia / obnova:

```powershell
Copy-Item -Force tools\hooks\post-commit-deploy.sh .git\hooks\deploy.sh
```

Hook **nemaže** remote-only zvyšky (`.git`, staré `tools/*.phar`, encoder);
cleanup vyžaduje výslovný súhlas.
