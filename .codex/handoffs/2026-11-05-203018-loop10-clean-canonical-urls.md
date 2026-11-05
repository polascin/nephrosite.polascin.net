# Handoff: loop10-clean-canonical-urls

## Metadata

- Generated At: 2026-11-05T20:30:18+01:00
- Updated At: 2026-11-05T20:31:00+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 434f939 (docs/handoff commit môže nasledovať)

## Original Goal

Loop iterácia #10: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
shipnúť jeden high-value overený fix; commit/push/deploy/smoke; SESSION +
handoff.

## Current State

Iterácia #10 hotová na produkcii. RO telemetria stále smoke-only (2 riadky).
Enforced `'unsafe-inline'` ponechané. Ship: kanonické čisté URL pre právne
stránky a témy (`/privacy`, `/terms`, `/nefrologia`, …) s 301 zo starých
ciest. Repo na `main` @ `434f939`.

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Clean URL rewrite: internal serve + THE_REQUEST-guarded 301s from
  `.php` / `/files/*.html`.
- Sitemap, canonicals, teasers, permalinks, deploy smoke paths updated.
- Fixed rewrite loop (internal `/files/privacy.html` was re-triggering 301).

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commits `53bf64b` + `434f939`; post-commit SFTP; `deploy.ps1 -Apply`
  → 0 upload after hook; smoke `/` `/privacy` `/terms` `/nefrologia` = 200
- Command: GHA Deploy `42094343098` success (rsync skipped: missing GH
  secrets; local SFTP is live path)
- Command: produkcia Chrome UA:
  - `/privacy`, `/terms`, `/nefrologia`, `/dialyza`, `/lipton-tx` → 200
  - `/privacy.php`, `/nefrologia.php`, `/files/privacy.html`,
    `/files/nefrologia.html` → 301 → clean URLs
  - canonical `https://nephrosite.polascin.net/privacy` and `/nefrologia`
  - homepage teasers link to clean paths; sitemap locs clean
  - HSTS + CSP present
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not deleted.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: GH Actions deploy still lacks usable DEPLOY_* secrets
  (local `deploy.ps1` / post-commit SFTP is the live path).

## Remaining Work

- [ ] Loop #11: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'` only
      with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Officially recognize `deploy.ps1` / fix GH secrets.

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship clean canonical URLs instead of CSP tightening.
- Reason: `/nefrologia` etc. 404'd; `/privacy` did an extra 301 hop; SEO and
  cookie-banner anchors benefit from 200 at the public URL.
- Decision: Guard legacy `/files/*.html` 301s with `THE_REQUEST`.
- Reason: First ship looped: internal rewrite to HTML re-matched the 301 rule.
- Decision: Remote-only still not deleted.
- Reason: Explicit user approval still missing.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- GHA Deploy validates PHP but skips rsync without secrets; do not treat GHA
  rsync as production deploy until secrets exist or workflow is retired.

## Critical Files

- `.htaccess` (clean URL rewrites + THE_REQUEST guards)
- `privacy.php`, `terms.php`, topic `*.php` slugs
- `files/privacy.html`, `files/terms.html` (canonical)
- `blocks/info.sk.php`, `blocks/foazosszu.sk.php`, `sitemap.xml`
- `tools/deploy.ps1`, `.github/workflows/deploy.yml`
- `SESSION.md`, `.audit.md`

## Recent Commits

- 434f939 Fix privacy/terms rewrite loop after clean-URL ship.
- 53bf64b Canonicalize clean topic and legal URLs.
- 6ec2e0f Document loop #9 CSP telemetry review and font cache ship.
- 888ab28 Cache self-hosted fonts and document CSP telemetry.
- 2e7cc73 Document loop #8 hybrid PHP CSP bootstrap and Report-Only nonce.

## Modified Files

- Po docs/handoff commite: SESSION.md, .audit.md,
  `.codex/handoffs/2026-11-05-203018-loop10-clean-canonical-urls.md`

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #21)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-203018-loop10-clean-canonical-urls.md`
- `.htaccess`, `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
# Loop #11: re-check RO telemetry; cleanup remote-only only if approved.
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-203018-loop10-clean-canonical-urls.md.
Pokračuj loop #11 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md).
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
