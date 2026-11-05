# Handoff: loop24-promo-title-consistency

## Metadata

- Generated At: 2026-11-05T21:48:46+01:00
- Updated At: 2026-11-05T21:49:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: a516268

## Original Goal

Loop iterácia #24: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; ak smoke-only, ship coherent product fix
(title/content consistency; nie spekulatívne intro Bory); commit/push/
deploy/smoke; SESSION + handoff.

## Current State

Iterácia #24 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: 3 overené brand title/alt opravy v
`blocks/promo.sk.php` (Bory, ASN, ÖGFN). Repo na `main` @ `a516268`
(product `28bd919`, docs `a516268`).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Verified defects via official site `<title>` GET (Chrome UA):
  BORY≠Bory; ASN Of≠of; ÖGFN Nefrologie≠Nephrologie.
- Aligned title+alt in `blocks/promo.sk.php` to official names.
- Left intro Bory commented; remote-only not deleted; no GH secrets.
- Cleaned temp `_tmp-loop24-*.py` (not committed).

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `28bd919`; post-commit SFTP uploaded `promo.sk.php`;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200 on `/` `/privacy`
  `/terms` `/nefrologia`
- Command: GHA Deploy `42106647063` success (rsync skipped)
- Command: production Chrome UA `/` → Bory/ASN/ÖGFN title+alt correct
  (old variants count 0); hints=144; HSTS + CSP still with enforced
  `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: remaining title/content candidates are smaller than the
  verified promo brand drift just closed.

## Remaining Work

- [ ] Loop #25: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (further title /
      content consistency; intro Bory only after content decision).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship promo brand title/alt alignment this tick (not intro Bory).
- Reason: Three verified mismatches against official site titles; coherent
  single-file title/content consistency ship without content policy change.
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
- `SESSION.md`, `.audit.md` (Beh #35)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 28bd919 Align promo brand titles with official site names.
- dee2c20 Record loop #23 tip SHA in SESSION handoff.
- 690bac9 Align loop #23 SESSION HEAD with tip commit.
- 2aad571 Point loop #23 handoff HEAD to docs commit.
- 9b237fe Document loop #23 footer tooling a11y ship.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #35)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-214846-loop24-promo-title-consistency.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-214846-loop24-promo-title-consistency.md.
Pokračuj loop #25 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value ship (title/content consistency / a11y) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
