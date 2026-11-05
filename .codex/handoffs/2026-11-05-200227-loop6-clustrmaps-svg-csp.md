# Handoff: loop6-clustrmaps-svg-csp

## Metadata

- Generated At: 2026-11-05T20:02:27+01:00
- Updated At: 2026-11-05T20:03:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 7d79a8c (docs/handoff commit môže nasledovať)

## Original Goal

Loop iterácia #6: ClustrMaps snapshot alebo SVG-only, odstrániť
`clustrmaps.com` z RO aj enforced CSP po overení UX a consent správania.
Commit + push + `tools/deploy.ps1 -Apply` + smoke.

## Current State

Iterácia #6 dokončená a na produkcii. Live ClustrMaps image/script už nie je
potrebné: päta používa first-party `/pix/clustrmaps-visitor-map.svg` a odkaz
na site. `clustrmaps.com` je von z oboch CSP. Repo na `main` @ `7d79a8c`.

## Completed This Session

- Overený vendor: `clustrmaps.com:443` connection refused; PNG snapshot
  nemožný → SVG-only first-party badge.
- `pix/clustrmaps-visitor-map.svg` (lokálny náhľad mapy návštev).
- `blocks/footer.sk.php`: src same-origin SVG; odkaz na site; bez
  `data-fallback-src` / live `map_v2.png`.
- `.htaccess`: enforced + Report-Only bez `clustrmaps.com` v `img-src`.
- Generický alt vo fallback helperi; testy + docs aktualizované.
- Cookie banner nezmenený (mapa nebola consent-gated; first-party je OK).

## Validated

- Command: `php tools/test-csp.php` → PASS
- Command: `node tools/test-integrations.cjs` → PASS
- Command: commit `7d79a8c`; post-commit SFTP; `git push origin main` →
  HEAD = origin/main = `7d79a8c`
- Command: `tools/deploy.ps1 -Apply` → 0 upload, smoke `/` + `/privacy.php` 200
- Command: produkcia Chrome UA:
  - `/`, `/dialyza.php`, `/nefrologia.php` 200; SVG markup + site link;
    bez `clustrmaps.com/map`
  - `/pix/clustrmaps-visitor-map.svg` 200 `image/svg+xml`
  - enforced + RO bez `clustrmaps.com`; HSTS OK
- Risk accepted: `/privacy.php` hosting CSP stále spomína Google Fonts
  (mimo `.htaccess`); stránka mapu neťahá.

## Not Yet Validated

- Assumption: používateľ odkaz na ClustrMaps site stále chce (klik = outbound).
- Risk: remote-only junk (68) stále na serveri; cleanup neschválený.
- Assumption: GH Actions deploy stále bez `DEPLOY_*` secrets.

## Remaining Work

- [ ] Loop #7: schválený cleanup 68 remote-only, alebo `report-to` endpoint.
- [ ] Oficiálne uznať `deploy.ps1` / opraviť GH secrets.
- [ ] Enforcement bez `'unsafe-inline'` až po nonces/hashoch.
- [ ] Voliteľne zosúladiť hosting CSP na `/privacy.php`/`/files/*.html`.

## Decisions Made

- Decision: SVG-only first-party namiesto PNG snapshotu.
- Reason: Vendor connection refused; live PNG nedostupný.
- Decision: Ponechať outbound odkaz na ClustrMaps site.
- Reason: UX zachovaná; navigácia nie je CSP img/script load.
- Decision: Cookie banner copy nezmeniť.
- Reason: ClustrMaps nebol v consent modeloch; first-party SVG nevyžaduje
  nový súhlas.
- Decision: Remote-only nemazať.
- Reason: Používateľ cleanup neschválil.

## Blockers / Open Questions

- Explicitný súhlas na mazanie 68 remote-only stále chýba.
- Žiadny schválený CSP report endpoint.
- Hosting CSP na privacy/terms stále spomína Google Fonts (mimo `.htaccess`).

## Critical Files

- `.htaccess` – enforced + Report-Only CSP (bez clustrmaps.com)
- `blocks/footer.sk.php` – first-party visitor map
- `pix/clustrmaps-visitor-map.svg`
- `pix/clustrmaps-unavailable.svg` (generický fallback helper)
- `tools/test-csp.php`, `tools/test-integrations.cjs`
- `docs/CSP-REPORT-ONLY.md`
- `SESSION.md`, `.audit.md`

## Recent Commits

- 7d79a8c Replace live ClustrMaps image with first-party SVG and drop clustrmaps.com from CSP.
- 1ebf0d1 Document loop #5 self-hosted fonts and Google Fonts CSP removal.
- af48e4e Serve OFL font licenses as .ofl because hosting blocks .txt.
- 883e0e1 Self-host Blinker, Blaka, and Fenix; drop Google Fonts from CSP.
- e33d721 Document loop #4 CSP Report-Only tighten and unused Google Fonts cleanup.

## Modified Files

- Po docs/handoff commite: SESSION.md, .audit.md,
  `.codex/handoffs/2026-11-05-200227-loop6-clustrmaps-svg-csp.md`

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #17)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-200227-loop6-clustrmaps-svg-csp.md`
- `docs/CSP-REPORT-ONLY.md`
- `.htaccess`, `blocks/footer.sk.php`, `pix/clustrmaps-visitor-map.svg`

## Next Command

```text
# Loop #7: approved remote-only cleanup (68) OR CSP report-to endpoint prep.
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-200227-loop6-clustrmaps-svg-csp.md.
Pokračuj loop #7 NephroSite: po výslovnom súhlase uprac 68 remote-only súborov, alebo priprav schválený CSP report-to endpoint / nonces cestu.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

From `deploy.ps1 -Apply` (68): `.git/**`, `.deployignore`, `.gitignore`,
`.gitattributes`, `.audit.md`, `SESSION.md`, `.cursor/rules/…`,
`.codex/handoffs/…`, `.github/workflows/deploy.yml`, `phpstan*.neon*`,
`tools/*.phar`, `tools/encode-lecture-gifs.py`, `tools/quality.ps1`,
`tools/install-dev-tools.ps1`, `tools/README.md`, `tools/.htaccess`.
