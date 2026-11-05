# Handoff: loop9-csp-telemetry-font-cache

## Metadata

- Generated At: 2026-11-05T20:23:43+01:00
- Updated At: 2026-11-05T20:25:00+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 888ab28 (docs/handoff commit môže nasledovať)

## Original Goal

Loop iterácia #9: skontrolovať CSP Report-Only telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; ak telemetria prázdna/príliš
čerstvá, shipnúť iný high-value fix; remote-only nemazať; commit/push/deploy/
smoke; SESSION + handoff.

## Current State

Iterácia #9 hotová na produkcii. RO telemetria je smoke-only (2 riadky).
Enforced `'unsafe-inline'` ponechané. Alternatívny fix: long-cache self-host
fontov + CSP summary tool + privacy/terms/sitemap/docs inventár. Repo na
`main` @ `888ab28`.

## Completed This Session

- SSH review `private/csp-reports/reports.jsonl` (HTTP 403 zámerne).
- `tools/csp-report-summary.ps1` + docs v `CSP-REPORT-ONLY.md`.
- `.htaccess` Cache-Control pre woff2/ofl (1y immutable) a CSS/legal/SVG (7d).
- Privacy/terms: dátum 05.11.2026; odkazy `/privacy`/`/terms`.
- `sitemap.xml` lastmod 2026-11-05.
- `docs/REMOTE-ONLY-INVENTORY.md` (69 paths, categories A–D; no delete).

## Validated

- Command: `php tools/test-csp.php` → PASS
- Command: `powershell -File .\tools\csp-report-summary.ps1` → 2 smoke markers,
  0 real candidates; keep unsafe-inline
- Command: commit `888ab28`; post-commit SFTP; `git push origin main`;
  `deploy.ps1 -Apply` → 0 upload; GHA Deploy `42093214113` success;
  CSP regression success
- Command: produkcia Chrome UA:
  - `/` 200; HSTS; Reporting-Endpoints; enforced `unsafe-inline`
  - `/fonts/*.woff2` Cache-Control immutable (verify with cache-bust if edge stale)
  - `/css/fonts.css`, `/files/legal.css` max-age=604800
  - `/privacy` text 05.11.2026 + `/terms`; sitemap lastmod 2026-11-05
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not deleted.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: GH Actions deploy may still lack usable DEPLOY_* secrets locally
  (local `deploy.ps1` is the live path).

## Remaining Work

- [ ] Loop #10: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'` only
      with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Officially recognize `deploy.ps1` / fix GH secrets.

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry is smoke-only; no evidence scripts are fully covered or
  that consent Clarity/GTM paths are safe under RO-equivalent policy.
- Decision: Ship font Cache-Control + summarizer + privacy/sitemap/docs instead.
- Reason: Tick required a verified high-value alternate when telemetry is fresh.
- Decision: Remote-only still not deleted.
- Reason: Explicit user approval still missing.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Edge may briefly serve pre-change responses without Cache-Control; spot-check
  with `?v=` or a previously uncached asset.

## Critical Files

- `.htaccess` (Cache-Control + hybrid CSP FilesMatch)
- `tools/csp-report-summary.ps1`, `tools/test-csp.php`
- `docs/CSP-REPORT-ONLY.md`, `docs/REMOTE-ONLY-INVENTORY.md`
- `files/privacy.html`, `files/terms.html`, `sitemap.xml`
- `SESSION.md`, `.audit.md`

## Recent Commits

- 888ab28 Cache self-hosted fonts and document CSP telemetry.
- 2e7cc73 Document loop #8 hybrid PHP CSP bootstrap and Report-Only nonce.
- fa7709d Emit hybrid PHP CSP headers with Report-Only nonce.
- 49088ac Document loop #7 CSP reporting endpoint and nonce helpers.
- 5eeacb7 Add first-party CSP reporting and prepare script nonces.

## Modified Files

- Po docs/handoff commite: SESSION.md, .audit.md,
  `.codex/handoffs/2026-11-05-202343-loop9-csp-telemetry-font-cache.md`

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #20)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-202343-loop9-csp-telemetry-font-cache.md`
- `docs/CSP-REPORT-ONLY.md`, `docs/REMOTE-ONLY-INVENTORY.md`
- `.htaccess`, `tools/csp-report-summary.ps1`

## Next Command

```text
# Loop #10: re-check RO telemetry; cleanup remote-only only if approved.
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-202343-loop9-csp-telemetry-font-cache.md.
Pokračuj loop #10 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md).
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
