# Handoff: loop23-footer-tooling-a11y

## Metadata

- Generated At: 2026-11-05T21:42:14+01:00
- Updated At: 2026-11-05T21:43:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 9b237fe

## Original Goal

Loop iterácia #23: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; ak smoke-only, ship coherent product fix
(DistroWatch/W3C image hints / title polish); commit/push/deploy/smoke;
SESSION + handoff.

## Current State

Iterácia #23 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: 4 static sr-only new-window hints na
footer tooling image blanks (Bluefish, W3 Schools, W3C, DistroWatch) +
WHO alt Organisation → Organization. Prod hints 140 → 144. Repo na
`main` @ `9b237fe` (product `4f352b3`, docs `9b237fe`).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Verified defect: 4 footer image blanks without static hint
  (Bluefish, W3 Schools, W3C validator, DistroWatch); WHO alt mismatch.
- Added 4 static `.sr-only` hints in `blocks/footer.sk.php`.
- Aligned WHO `alt` to `World Health Organization` in `blocks/promo.sk.php`.
- Cleaned temp `tools/_tmp-loop23-hints.py` (not committed).
- Remote-only (~69) not deleted; no GH secrets created.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `4f352b3`; post-commit SFTP uploaded `footer.sk.php`
  and `promo.sk.php`; `deploy.ps1 -Apply` → 0 upload; smoke direct 200
  on `/` `/privacy` `/terms` `/nefrologia`
- Command: GHA Deploy `42105696759` success (rsync skipped)
- Command: production Chrome UA `/` → hints=144 (was 140; +4),
  pdfHints=11; DistroWatch/W3C/Bluefish/W3 Schools static hints true;
  WHO Organization alt; HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: remaining title/content polish candidates are smaller than
  the footer tooling a11y gap just closed.

## Remaining Work

- [ ] Loop #24: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (further title /
      content consistency; intro Bory only after content decision).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship footer tooling image static hints + WHO alt this tick.
- Reason: Completes DistroWatch/W3C (and sibling tooling) no-JS coverage
  left from loop #22; coherent 4-anchor ship plus one verified title polish.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not a11y).

## Critical Files

- `blocks/footer.sk.php`, `blocks/promo.sk.php`
- `SESSION.md`, `.audit.md` (Beh #34)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 4f352b3 Add static new-window hints on footer tooling logos.
- e1c5562 Point loop #22 handoff HEAD to docs commit.
- 075085c Document loop #22 promo and footer a11y ship.
- 083167f Add static new-window hints on footer FOSS logos.
- 61c5de9 Add static new-window hints on promo logos.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #34)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-214214-loop23-footer-tooling-a11y.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-214214-loop23-footer-tooling-a11y.md.
Pokračuj loop #24 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value ship (title/content consistency) ak telemetria ostáva smoke-only.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
