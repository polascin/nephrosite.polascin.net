# Handoff: loop5-self-host-fonts-csp

## Metadata

- Generated At: 2026-11-05T19:57:34+01:00
- Updated At: 2026-11-05T19:58:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: af48e4e (docs/handoff commit môže nasledovať)

## Original Goal

Loop iterácia #5: self-host Blinker/Blaka/Fenix (WOFF2), odstrániť
`fonts.googleapis.com` / `fonts.gstatic.com` z RO aj enforced CSP po overení
na produkcii. Commit + push + `tools/deploy.ps1 -Apply` + smoke.

## Current State

Iterácia #5 dokončená a na produkcii. Fonty sú lokálne (`/css/fonts.css` +
`/fonts/*.woff2`), SIL OFL atribúcia cez `/fonts/OFL-*.ofl` (hosting blokuje
`.txt`). Google Fonts hosty sú von z oboch CSP. Repo na `main` @ `af48e4e`.

## Completed This Session

- Stiahnuté latin + latin-ext WOFF2: Blinker 400/600/700, Blaka 400, Fenix 400.
- `css/fonts.css` s `@font-face` + `font-display: swap`.
- `blocks/links.sk.php`: preconnect/stylesheet Google Fonts odstránené;
  link na `/css/fonts.css`.
- `.htaccess`: enforced + Report-Only bez Google Fonts; `font-src 'self'`;
  `AddType font/woff2` + `AddType text/plain .ofl`.
- OFL licencie + README (`.ofl` kvôli 403 na `.txt`).
- `tools/test-csp.php` + `docs/CSP-REPORT-ONLY.md` aktualizované.

## Validated

- Command: `php tools/test-csp.php` → PASS
- Command: commits `883e0e1` + `af48e4e`; post-commit SFTP upload fonts/CSP;
  `git push origin main` → HEAD = origin/main = `af48e4e`
- Command: `tools/deploy.ps1 -Apply` → 0 upload, smoke `/` + `/privacy.php` 200
- Command: produkcia Chrome UA:
  - `/`, `/dialyza.php`, `/nefrologia.php` 200; HTML bez googleapis/gstatic;
    link `/css/fonts.css`
  - enforced + RO: `font-src 'self'`, žiadne fonts.googleapis/gstatic
  - `/css/fonts.css` 200; WOFF2 200 `font/woff2`; `/fonts/OFL-Blinker.ofl` 200
    `text/plain`
  - HSTS prítomný
- Risk accepted: `/privacy.php` má hostingovú vynucovanú CSP so starými Google
  Fonts hostmi (dokumentované už v loop #4); naše Report-Only je čisté;
  stránka neťahá naše fonty.

## Not Yet Validated

- Assumption: DevTools ukáže Blinker/Blaka/Fenix ako local fonts (nie gstatic).
- Risk: remote-only junk (68) stále na serveri; cleanup neschválený.
- Assumption: GH Actions deploy stále bez `DEPLOY_*` secrets.

## Remaining Work

- [ ] Loop #6: ClustrMaps snapshot alebo len SVG/odkaz → drop `clustrmaps.com`
      z RO/enforced ak je to možné.
- [ ] Po schválení: cleanup 68 remote-only.
- [ ] Schválený `report-to` pred ďalším sprísnením script-src.
- [ ] Enforcement bez `'unsafe-inline'` až po nonces/hashoch.
- [ ] Oficiálne uznať `deploy.ps1` / opraviť GH secrets.
- [ ] Voliteľne zosúladiť hosting CSP na `/privacy.php`/`/files/*.html`.

## Decisions Made

- Decision: Self-host len latin + latin-ext (bez Blaka arabic subset).
- Reason: Slovenský obsah; menší payload.
- Decision: Licencie ako `.ofl` namiesto `.txt`.
- Reason: WebSupport vracia 403 na `.txt`; OFL musí zostať v distribúcii a
  lepšie aj cez HTTP.
- Decision: Odstrániť Google Fonts z enforced aj RO naraz.
- Reason: Live markup už neťahá Google Fonts; `font-src 'self'` stačí.
- Decision: Remote-only nemazať.
- Reason: Používateľ cleanup neschválil.

## Blockers / Open Questions

- Explicitný súhlas na mazanie 68 remote-only stále chýba.
- Žiadny schválený CSP report endpoint.
- Hosting CSP na privacy/terms stále spomína Google Fonts (mimo `.htaccess`).

## Critical Files

- `.htaccess` – enforced + Report-Only CSP (bez Google Fonts)
- `css/fonts.css` – `@font-face` Blinker/Blaka/Fenix
- `fonts/*.woff2`, `fonts/OFL-*.ofl`
- `blocks/links.sk.php`
- `tools/test-csp.php`
- `docs/CSP-REPORT-ONLY.md`
- `SESSION.md`, `.audit.md`

## Recent Commits

- af48e4e Serve OFL font licenses as .ofl because hosting blocks .txt.
- 883e0e1 Self-host Blinker, Blaka, and Fenix; drop Google Fonts from CSP.
- e33d721 Document loop #4 CSP Report-Only tighten and unused Google Fonts cleanup.
- 59fdc4c Tighten CSP Report-Only and drop nine unused Google Fonts.
- fd6bd8d Document loop #3 foazosszu MP4 delivery and deployignore hook handoff.

## Modified Files

- Po docs/handoff commite: SESSION.md, .audit.md,
  `.codex/handoffs/2026-11-05-195734-loop5-self-host-fonts-csp.md`

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #16)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-195734-loop5-self-host-fonts-csp.md`
- `docs/CSP-REPORT-ONLY.md`
- `.htaccess`, `css/fonts.css`, `blocks/links.sk.php`

## Next Command

```text
# Loop #6: ClustrMaps snapshot or SVG-only, then drop clustrmaps.com from CSP if possible.
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-195734-loop5-self-host-fonts-csp.md.
Pokračuj loop #6 NephroSite: ClustrMaps snapshot alebo SVG-only a odstráň clustrmaps.com z CSP, alebo po výslovnom súhlase uprac 68 remote-only súborov.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

From `deploy.ps1 -Apply` (68): `.git/**`, `.deployignore`, `.gitignore`,
`.gitattributes`, `.audit.md`, `SESSION.md`, `.cursor/rules/…`,
`.codex/handoffs/…`, `.github/workflows/deploy.yml`, `phpstan*.neon*`,
`tools/*.phar`, `tools/encode-lecture-gifs.py`, `tools/quality.ps1`,
`tools/install-dev-tools.ps1`, `tools/README.md`, `tools/.htaccess`.
