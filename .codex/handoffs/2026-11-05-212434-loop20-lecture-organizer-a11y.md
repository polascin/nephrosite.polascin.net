# Handoff: loop20-lecture-organizer-a11y

## Metadata

- Generated At: 2026-11-05T21:24:34+01:00
- Updated At: 2026-11-05T21:25:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 2964c02

## Original Goal

Loop iterácia #20: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; ak smoke-only, ship coherent product fix
(lecture organizer static new-window hints); commit/push/deploy/smoke;
SESSION + handoff.

## Current State

Iterácia #20 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: 32 static sr-only new-window hints
na organizer/venue/author `target="_blank"` v `blocks/lectures.sk.php`
(Martinus + OUP recommended lit ostávajú na JS helper). Repo na `main`
@ `a437631`.

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Verified defect: 65 lecture external blanks; 0 organizer links had
  static new-window hint (JS-only coverage from loop #19).
- Added 32 static `.sr-only` hints on lecture organizers, venues, author
  and footer copyright link; skipped Martinus and academic.oup.com lit.
- Remote-only (~69) not deleted; no GH secrets created.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `a437631`; post-commit SFTP uploaded
  `blocks/lectures.sk.php`; `deploy.ps1 -Apply` → 0 upload; smoke
  direct 200 on `/` `/privacy` `/terms` `/nefrologia`
- Command: GHA Deploy `42102962134` success (rsync skipped)
- Command: production Chrome UA `/` → hints=50 (was 18; +32),
  pdfHints=11, organizerAesculap=True, eszu=True, author=True,
  jsHelperMarker=True; HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; Martinus blanks still JS-only for
  no-JS users.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: Martinus recommended-lit blanks remain acceptable as
  JS-covered only; static markup for ~33 book links deferred.

## Remaining Work

- [ ] Loop #21: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content
      consistency; intro Bory static hints; Martinus no-JS hints; title
      polish).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Static new-window hints only on lecture organizers / venues /
  author / footer, not every Martinus book link.
- Reason: Coherent no-JS a11y for lecture metadata without rewriting ~33
  recommendation anchors; JS helper still covers the rest.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.

## Critical Files

- `blocks/lectures.sk.php`
- `SESSION.md`, `.audit.md` (Beh #31)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- a437631 Add static new-window hints on lecture organizers.
- 5776ddc Point loop #19 handoff HEAD to docs commit.
- 4f9991e Document loop #19 external blank-link a11y ship.
- e3c2995 Improve external blank-link accessibility.
- 860174c Point loop #18 handoff HEAD to docs commit.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #31)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-212434-loop20-lecture-organizer-a11y.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-212434-loop20-lecture-organizer-a11y.md.
Pokračuj loop #21 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value ship (content/a11y) ak telemetria ostáva smoke-only.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
