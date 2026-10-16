# Deploy - nephrosite.polascin.net

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
