# Handoff: loop27-who-title-polish

## Metadata

- Generated At: 2026-11-05T22:09:40+01:00
- Updated At: 2026-11-05T22:10:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 8f96f4f

## Original Goal

Loop iterácia #27: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; ak smoke-only, ship coherent product fix
(prefer WHO `(WHO)` title polish); commit/push/deploy/smoke;
SESSION + handoff. Preferovať 1 product + 1 docs commit.

## Current State

Iterácia #27 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: WHO promo title/alt →
`World Health Organization (WHO)` podľa oficiálneho `<title>` who.int.
Repo na `main` @ `8f96f4f` (docs tip commit nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Verified official who.int `<title>` = `World Health Organization (WHO)`.
- Updated `blocks/promo.sk.php` title + alt to match (SIN-style acronym).
- Left intro Bory commented; remote-only not deleted; no GH secrets.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `8f96f4f`; post-commit SFTP uploaded `promo.sk.php`;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200 on `/` `/privacy`
  `/terms` `/nefrologia`
- Command: GHA Deploy `42109953338` success (rsync skipped)
- Command: production Chrome UA `/` → WHO `(WHO)` title+alt present (2),
  old without-suffix live attrs 0; live blank miss hints = 0;
  HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: next brand polish candidates (e.g. EDTNA/ERCA short official
  title vs long descriptive label) need separate verification.

## Remaining Work

- [ ] Loop #28: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (EDTNA/ERA acronym
      consistency; content; intro Bory only after content decision).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship WHO `(WHO)` title/alt this tick (not intro Bory).
- Reason: Official who.int `<title>` verified; matches existing SIN
  `(SIN)` promo pattern; coherent single brand polish.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `blocks/promo.sk.php`
- `SESSION.md`, `.audit.md` (Beh #38)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 8f96f4f Align WHO promo title and alt with official World Health Organization (WHO) branding.
- 0d0cae0 Document loop #26 Union/medupdate and nephrology a11y ship.
- 9a153dd Align Union/medupdate promo titles and add nephrology copyright new-window hint.
- 481ccf7 Record loop #25 tip SHA in SESSION handoff.
- c7d4643 Point loop #25 handoff HEAD to docs tip.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #38)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-220940-loop27-who-title-polish.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-220940-loop27-who-title-polish.md.
Pokračuj loop #28 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value ship (title/content/a11y) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
