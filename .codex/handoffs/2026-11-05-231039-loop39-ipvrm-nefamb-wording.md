# Handoff: loop39-ipvrm-nefamb-wording

## Metadata

- Generated At: 2026-11-05T23:10:39+01:00
- Updated At: 2026-11-05T23:12:00+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: c62b1b6

## Original Goal

Loop iterácia #39: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix (ipvrm/nefamb/
purifikacia kandidáti); 1 product + 1 docs commit; commit/push/deploy/smoke;
SESSION + handoff.

## Current State

Iterácia #39 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: ipvrm `viacero výhod`→`viaceré výhody`;
nefamb drop `(dysbalancie elektrolytov)`. `hyponatriémia` a
`kosáčikovitá anémia` overené a nechané. Product SHA `c62b1b6` (docs tip
nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped.
- Patched `ipvrm.htm`: `viacero <i>výhod</i>`→`viaceré <i>výhody</i>`.
- Patched `files/nefamb.html`: removed redundant anglicism
  `(dysbalancie elektrolytov)`.
- Verified and kept: `hyponatriémia` (MKCH E87.1), `kosáčikovitá anémia`
  (ICD/SK medical term).

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `c62b1b6`; post-commit SFTP uploaded both files;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42119106990` success (rsync skipped)
- Command: production Chrome UA `/ipvrm.htm` → `viaceré … výhody` present,
  `viacero … výhod` absent; `/nefamb` → `dysbalancie` absent,
  `hyponatriémia` + `Elektrolytové nerovnováhy:` present; `/` `/privacy`
  `/terms` `/nefrologia` `/dialyza` `/nefamb` `/usgo` `/transplantacia`
  `/ipvrm.htm` → 200 + HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: further brand polish only if official `<title>` includes
  the acronym (ASN/ISN currently do not).

## Remaining Work

- [ ] Loop #40: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship ipvrm `viacero`→`viaceré` this tick.
- Reason: Same verified register defect as transplantacia/IgAN; medical
  facts unchanged.
- Decision: Drop nefamb `(dysbalancie elektrolytov)` anglicism.
- Reason: Redundant beside `Elektrolytové nerovnováhy`; no medical change.
- Decision: Do not change `hyponatriémia` or `kosáčikovitá anémia`.
- Reason: MKCH E87.1 / ICD-SK established forms; not defects.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `ipvrm.htm`, `files/nefamb.html`
- `SESSION.md`, `.audit.md` (Beh #50)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- c62b1b6 Fix Slovak wording on ipvrm and nefamb pages.
- aceeeb3 Document loop #38 nahradz wording and keep unsafe-inline after smoke-only CSP telemetry.
- dd2a73d Fix Slovak nahradz* wording on dialyza and CRRT title.
- 950f5ca Document loop #37 IgAN wording and keep unsafe-inline after smoke-only CSP telemetry.
- 4f21898 Fix Slovak wording on IgAN clinical-trials sentence.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #50)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-231039-loop39-ipvrm-nefamb-wording.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-231039-loop39-ipvrm-nefamb-wording.md.
Pokračuj loop #40 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu).
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
