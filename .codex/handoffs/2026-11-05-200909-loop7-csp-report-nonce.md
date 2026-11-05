# Handoff: loop7-csp-report-nonce

## Metadata

- Generated At: 2026-11-05T20:09:09+01:00
- Updated At: 2026-11-05T20:10:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 5eeacb7 (docs/handoff commit môže nasledovať)

## Original Goal

Loop iterácia #7: CSP Reporting API (`report-to` / `report-uri`) first-party
endpoint a/alebo nonce helper bez zlomenia Clarity/GTM/consent. Commit + push
+ `tools/deploy.ps1 -Apply` + smoke. Remote-only junk (~68) nemazať.

## Current State

Iterácia #7 dokončená a na produkcii. First-party `/csp-report.php` je
zapojený do enforced aj Report-Only CSP cez `report-uri` + `report-to` a
`Reporting-Endpoints`. PHP inline skripty majú nonce atribúty; CSP stále
používa `'unsafe-inline'` (statické `.htaccess`). Repo na `main` @ `5eeacb7`.

## Completed This Session

- `csp-report.php` + `blocks/csp-report-handler.php` (POST-only, 8 KiB,
  sanitizácia, JSONL do `private/csp-reports/`).
- `private/.htaccess` + `private/csp-reports/.htaccess` (Require all denied).
- `.htaccess`: Reporting-Endpoints + report-uri/report-to na oboch CSP.
- `blocks/csp-nonce.php`; nonce na metatags JSON-LD, consent script, current.sk.
- `tools/test-csp.php` schvaľuje len `/csp-report.php` + group `csp`;
  `tools/test-integrations.cjs` stripuje PHP nonce prologue.
- Docs: `docs/CSP-REPORT-ONLY.md`, SESSION, audit Beh #18.

## Validated

- Command: `php tools/test-csp.php` → PASS
- Command: `node tools/test-integrations.cjs` → PASS
- Command: commit `5eeacb7`; post-commit SFTP; `git push origin main` →
  HEAD = origin/main = `5eeacb7`
- Command: `tools/deploy.ps1 -Apply` → 0 upload, smoke `/` + `/privacy.php` 200
- Command: produkcia Chrome UA:
  - `/`, `/dialyza.php`, `/nefrologia.php` 200; nonces v HTML; cookie banner
  - Headers: report-uri/report-to/Reporting-Endpoints; HSTS; unsafe-inline +
    Clarity/GTM/Fastbase v enforced
  - `POST /csp-report.php` → 204; GET → 405; `/private/` → 403;
    `/blocks/csp-nonce.php` → 403
- Risk accepted: `'unsafe-inline'` ešte v enforced (nonce v CSP header
  vyžaduje PHP bootstrap); remote-only 68 neschválené na mazanie.

## Not Yet Validated

- Assumption: hosting zapisuje do `private/csp-reports/` (POST 204 overené;
  obsah logu na serveri nečítaný cez HTTP, zámerne 403).
- Risk: remote-only junk (68) stále na serveri; cleanup neschválený.
- Assumption: GH Actions deploy stále bez `DEPLOY_*` secrets.

## Remaining Work

- [ ] Loop #8: PHP bootstrap CSP s `'nonce-…'`, potom zúžiť enforced
      `script-src` (odstrániť `'unsafe-inline'` až po RO telemetrii).
- [ ] Schválený cleanup 68 remote-only.
- [ ] Oficiálne uznať `deploy.ps1` / opraviť GH secrets.
- [ ] Voliteľne zosúladiť hosting CSP na `/privacy.php`/`/files/*.html`.

## Decisions Made

- Decision: First-party report sink namiesto tretích strán.
- Reason: GDPR/minimalizmus; žiadny schválený externý collector.
- Decision: Nonce v markup teraz; `'unsafe-inline'` v CSP zatiaľ ostáva.
- Reason: `.htaccess` nevie request-scoped nonce; odstránenie unsafe-inline
  bez PHP CSP by zlomilo cookie dialóg a JSON-LD.
- Decision: Remote-only nemazať.
- Reason: Používateľ cleanup neschválil.

## Blockers / Open Questions

- Explicitný súhlas na mazanie 68 remote-only stále chýba.
- Hosting CSP na privacy/terms stále spomína Google Fonts (mimo `.htaccess`).

## Critical Files

- `.htaccess` – Reporting-Endpoints + report-uri/report-to
- `csp-report.php`, `blocks/csp-report-handler.php`
- `private/.htaccess`, `private/csp-reports/.htaccess`
- `blocks/csp-nonce.php`, `blocks/scripts.sk.php`, `blocks/metatags.sk.php`,
  `blocks/current.sk.php`
- `tools/test-csp.php`, `tools/test-integrations.cjs`
- `docs/CSP-REPORT-ONLY.md`
- `SESSION.md`, `.audit.md`

## Recent Commits

- 5eeacb7 Add first-party CSP reporting and prepare script nonces.
- 019c9cc Document loop #6 ClustrMaps first-party SVG and CSP removal.
- 7d79a8c Replace live ClustrMaps image with first-party SVG and drop clustrmaps.com from CSP.
- 1ebf0d1 Document loop #5 self-hosted fonts and Google Fonts CSP removal.
- af48e4e Serve OFL font licenses as .ofl because hosting blocks .txt.

## Modified Files

- Po docs/handoff commite: SESSION.md, .audit.md,
  `.codex/handoffs/2026-11-05-200909-loop7-csp-report-nonce.md`

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #18)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-200909-loop7-csp-report-nonce.md`
- `docs/CSP-REPORT-ONLY.md`
- `.htaccess`, `csp-report.php`, `blocks/csp-nonce.php`

## Next Command

```text
# Loop #8: PHP bootstrap CSP with nonce; then tighten enforced script-src.
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-200909-loop7-csp-report-nonce.md.
Pokračuj loop #8 NephroSite: PHP bootstrap Content-Security-Policy s 'nonce-…', potom opatrne zúži enforced script-src (RO telemetria /csp-report.php); remote-only 68 nemazať bez súhlasu.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

From `deploy.ps1 -Apply` (68): `.git/**`, `.deployignore`, `.gitignore`,
`.gitattributes`, `.audit.md`, `SESSION.md`, `.cursor/rules/…`,
`.codex/handoffs/…`, `.github/workflows/deploy.yml`, `phpstan*.neon*`,
`tools/*.phar`, `tools/encode-lecture-gifs.py`, `tools/quality.ps1`,
`tools/install-dev-tools.ps1`, `tools/README.md`, `tools/.htaccess`.
