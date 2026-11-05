# Handoff: loop11-local-deploy-authority

## Metadata

- Generated At: 2026-11-05T20:35:04+01:00
- Updated At: 2026-11-05T20:36:00+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 77f109e (docs/handoff commit môže nasledovať)

## Original Goal

Loop iterácia #11: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
shipnúť high-value overený fix (uznanie lokálneho deploy.ps1 ako
autoritatívnej cesty); commit/push/deploy/smoke; SESSION + handoff.

## Current State

Iterácia #11 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: dokumentácia + tooling jasne hovoria, že
`tools/deploy.ps1` / post-commit SFTP je produkčný sync, kým chýbajú
`DEPLOY_*` secrets; GHA rsync skip notice to potvrdzuje. Repo na `main` @
`77f109e`.

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- `DEPLOY.md`, `.doaudit.md`, `.cursor/rules/commit-push-deploy.mdc` (vetva
  `main`): lokálny deploy je autoritatívny.
- GHA notice pri chýbajúcich secrets odkazuje na `deploy.ps1` / SFTP.
- `deploy.ps1`: banner authority + smoke priamy HTTP 200 (no redirect) na
  `/`, `/privacy`, `/terms`, `/nefrologia`.
- Remote-only (~69) nemazané.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `77f109e`; post-commit push; `deploy.ps1 -Apply` → 0
  upload (docs/tools v `.deployignore`); smoke direct 200 on clean URLs
- Command: GHA Deploy `42095182321` success; annotation: rsync skipped,
  local deploy remains production path
- Command: produkcia Chrome UA: `/` `/privacy` `/terms` `/nefrologia` →
  200 + HSTS + CSP (enforced stále s `'unsafe-inline'`)
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not deleted;
  GH secrets still unset (by design this tick).

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: operator may later add DEPLOY_* secrets outside the repo;
  until then do not treat GHA rsync as live sync.

## Remaining Work

- [ ] Loop #12: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'` only
      with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: bug/a11y/topic/cookie coherent ship.

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Officially recognize `deploy.ps1` as authoritative production path.
- Reason: GHA rsync has been skipping without secrets; old docs wrongly
  preferred Actions over the already-working local path.
- Decision: Smoke requires direct 200 (MaximumRedirection 0).
- Reason: Clean canonical URLs from loop #10 must not hide behind a hop.
- Decision: Remote-only still not deleted.
- Reason: Explicit user approval still missing.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.

## Critical Files

- `DEPLOY.md`
- `tools/deploy.ps1`
- `.github/workflows/deploy.yml`
- `.cursor/rules/commit-push-deploy.mdc`
- `.doaudit.md`, `.audit.md` (Beh #22), `SESSION.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Recent Commits

- 77f109e Recognize local deploy.ps1 as the authoritative production path.
- b0f549d Document loop #10 clean canonical URL ship.
- 434f939 Fix privacy/terms rewrite loop after clean-URL ship.
- 53bf64b Canonicalize clean topic and legal URLs.
- 6ec2e0f Document loop #9 CSP telemetry review and font cache ship.

## Modified Files

- Po docs/handoff commite: SESSION.md, handoff path nižšie

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #22)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-203504-loop11-local-deploy-authority.md`
- `DEPLOY.md`, `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-203504-loop11-local-deploy-authority.md.
Pokračuj loop #12 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value ship (a11y/links/topic/cookie) ak telemetria ostáva smoke-only.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
