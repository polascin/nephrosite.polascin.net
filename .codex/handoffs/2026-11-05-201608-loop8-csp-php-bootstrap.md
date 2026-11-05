# Handoff: loop8-csp-php-bootstrap

## Metadata

- Generated At: 2026-11-05T20:16:08+01:00
- Updated At: 2026-11-05T20:17:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: fa7709d (docs/handoff commit môže nasledovať)

## Original Goal

Loop iterácia #8: PHP CSP bootstrap s per-request `'nonce-…'` zarovnaným na
script tagy; hybrid so static `.htaccess`; neodstraňovať enforced
`'unsafe-inline'` bez RO dôkazov. Commit + push + `deploy.ps1 -Apply` + smoke.
Remote-only junk nemazať.

## Current State

Iterácia #8 dokončená a na produkcii. PHP HTML entrypoints emitujú CSP cez
`blocks/csp-bootstrap.php`. Enforced drží `'unsafe-inline'` (bez nonce v
headeri, CSP3 by inak unsafe-inline ignorovalo). Report-Only na PHP má
`'nonce-…'` zhodný s markup. Static HTML ostáva na Apache `FilesMatch`.
Repo na `main` @ `fa7709d`.

## Completed This Session

- `blocks/csp-bootstrap.php`: `nephrosite_csp_enforced_policy()`,
  `nephrosite_csp_report_only_policy($withNonce)`, `nephrosite_csp_send_headers()`.
- Wired v `index.php` a `blocks/topic-page.php`.
- `.htaccess`: CSP len v `FilesMatch` pre static; `Reporting-Endpoints` globálne.
- Testy: `tools/test-csp.php` (hybrid sync PHP↔htaccess, RO nonce, no nonce
  in enforced); docs `CSP-REPORT-ONLY.md`.

## Validated

- Command: `php tools/test-csp.php` → PASS
- Command: `node tools/test-integrations.cjs` → PASS
- Command: commit `fa7709d`; post-commit SFTP; `git push origin main`;
  `deploy.ps1 -Apply` → 0 upload, smoke `/` + `/privacy.php` 200
- Command: produkcia Chrome UA:
  - `/`, `/dialyza.php`, `/nefrologia.php` 200; HSTS; Reporting-Endpoints
  - PHP: enforced `unsafe-inline` (bez nonce); RO `script-src 'self' 'nonce-…'`
    zhodný s `nonce="…"` v HTML
  - `/files/privacy.html`: Apache CSP; RO bez nonce (`script-src 'self'`)
  - `POST /csp-report.php` → 204; `GET` → 405; `/blocks/csp-bootstrap.php` → 403
  - cookie banner prítomný; 3 nonce attrs na homepage
- Risk accepted: `'unsafe-inline'` stále v enforced; remote-only ~69
  (pribudol `private/csp-reports/reports.jsonl`) neschválené na mazanie.

## Not Yet Validated

- Assumption: RO telemetria v `private/csp-reports/` ešte nebola čítaná
  cez SSH (HTTP 403 zámerne); rozhodnutie o drop `'unsafe-inline'` čaká.
- Risk: remote-only junk stále na serveri; cleanup neschválený.
- Assumption: GH Actions deploy stále bez `DEPLOY_*` secrets.

## Remaining Work

- [ ] Loop #9: skontrolovať RO telemetriu; drop `'unsafe-inline'` len so
      strong evidence (+ Clarity/GTM consent paths).
- [ ] Schválený cleanup remote-only (~69).
- [ ] Oficiálne uznať `deploy.ps1` / opraviť GH secrets.
- [ ] Voliteľne zosúladiť hosting CSP na `/privacy.php`/`/files/*.html`.

## Decisions Made

- Decision: Hybrid CSP (PHP documents + Apache static FilesMatch).
- Reason: Request nonce nemôže ísť zo static `.htaccess`; `Header always unset`
  na PHP by zmazalo aj PHP-set headers.
- Decision: Nonce len v Report-Only, nie v enforced.
- Reason: CSP3 ignoruje `'unsafe-inline'` ak je v policy nonce/hash; drop
  by zlomil consent-gated Clarity/GTM bez `'strict-dynamic'`.
- Decision: Remote-only nemazať.
- Reason: Používateľ cleanup neschválil.

## Blockers / Open Questions

- Explicitný súhlas na mazanie remote-only stále chýba.
- Hosting CSP na privacy/terms môže stále spomínať Google Fonts (mimo nášho
  FilesMatch overlapping hosting rules).

## Critical Files

- `blocks/csp-bootstrap.php`, `blocks/csp-nonce.php`
- `index.php`, `blocks/topic-page.php`
- `.htaccess` (FilesMatch static CSP + Reporting-Endpoints)
- `tools/test-csp.php`, `docs/CSP-REPORT-ONLY.md`
- `SESSION.md`, `.audit.md`

## Recent Commits

- fa7709d Emit hybrid PHP CSP headers with Report-Only nonce.
- 49088ac Document loop #7 CSP reporting endpoint and nonce helpers.
- 5eeacb7 Add first-party CSP reporting and prepare script nonces.
- 019c9cc Document loop #6 ClustrMaps first-party SVG and CSP removal.
- 7d79a8c Replace live ClustrMaps image with first-party SVG and drop clustrmaps.com from CSP.

## Modified Files

- Po docs/handoff commite: SESSION.md, .audit.md,
  `.codex/handoffs/2026-11-05-201608-loop8-csp-php-bootstrap.md`

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #19)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-201608-loop8-csp-php-bootstrap.md`
- `docs/CSP-REPORT-ONLY.md`
- `blocks/csp-bootstrap.php`, `.htaccess`

## Next Command

```text
# Loop #9: RO telemetry review before tightening enforced script-src.
# Optional: approved remote-only cleanup (~69). Do not drop unsafe-inline yet.
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-201608-loop8-csp-php-bootstrap.md.
Pokračuj loop #9 NephroSite: skontroluj RO telemetriu (csp-reports); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only ~69 nemazať bez súhlasu.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

From `deploy.ps1 -Apply` (~69): prior 68 plus `private/csp-reports/reports.jsonl`
(evidence that reporting writes on server). Still includes `.git/**`,
`.deployignore`, docs/tools/phpstan, `.codex/handoffs/`, etc.
