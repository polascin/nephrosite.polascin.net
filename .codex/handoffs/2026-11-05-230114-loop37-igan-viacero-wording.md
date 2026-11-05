# Handoff: loop37-igan-viacero-wording

## Metadata

- Generated At: 2026-11-05T23:01:14+01:00
- Updated At: 2026-11-05T23:02:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 4f21898

## Original Goal

Loop iterácia #37: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix (IgAN `viacero`);
1 product + 1 docs commit; commit/push/deploy/smoke; SESSION + handoff.

## Current State

Iterácia #37 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: IgAN register + verb agreement
(`segments/igan.html` + `IgAN.sk.html`). Product SHA `4f21898` (docs tip
nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped.
- Verified live path: `blocks/nephrology.sk.php` includes
  `segments/igan.html` (homepage).
- Patched `segments/igan.html` + `segments/IgAN.sk.html`:
  `Prebieha viacero klinických skúšaní`→`Prebiehajú viaceré klinické skúšania`.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `4f21898`; post-commit SFTP uploaded both IgAN segments;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42117700083` success (rsync skipped)
- Command: production Chrome UA `/` → fixed string present; old form
  absent; `viacero` count 0; `/` `/privacy` `/terms` `/nefrologia`
  `/dialyza` `/nefamb` `/usgo` `/transplantacia` → 200 + HSTS + CSP
  still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: further brand polish only if official `<title>` includes
  the acronym (ASN/ISN currently do not).

## Remaining Work

- [ ] Loop #38: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; next verified wording/a11y outside
      already-fixed register candidates).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship IgAN `viacero` this tick (including verb plural).
- Reason: Verified register defect; medical facts unchanged; deferred
  from loop #36.
- Decision: Patch both `igan.html` and `IgAN.sk.html`.
- Reason: Live include uses `igan.html`; sibling variant kept in sync.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `segments/igan.html`, `segments/IgAN.sk.html`
- `blocks/nephrology.sk.php` (include)
- `SESSION.md`, `.audit.md` (Beh #48)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 4f21898 Fix Slovak wording on IgAN clinical-trials sentence.
- 755d261 Document loop #36 CAPD/transplantacia wording and keep unsafe-inline after smoke-only CSP telemetry.
- 41be8c0 Fix Slovak wording on dialyza CAPD and transplantacia pages.
- 1ffd310 Document loop #35 dialyza/nefrologia wording and keep unsafe-inline after smoke-only CSP telemetry.
- 380ec5a Fix Slovak wording on dialyza and nefrologia pages.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #48)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-230114-loop37-igan-viacero-wording.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-230114-loop37-igan-viacero-wording.md.
Pokračuj loop #38 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu).
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
