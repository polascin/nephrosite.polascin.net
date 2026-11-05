# Handoff: loop26-union-medupdate-nephrology-a11y

## Metadata

- Generated At: 2026-11-05T22:05:57+01:00
- Updated At: 2026-11-05T22:07:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 9a153dd

## Original Goal

Loop iterácia #26: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; ak smoke-only, ship coherent product fix
(title/a11y/content; nie spekulatívne intro Bory); commit/push/
deploy/smoke; SESSION + handoff. Vyhnúť sa endless tip-SHA churn.

## Current State

Iterácia #26 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: nephrology copyright static new-window
hint + Union/medupdate promo title/alt alignment. Repo na `main` @
`9a153dd` (docs tip commit nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Verified live `_blank` miss (after HTML-comment strip): only
  `blocks/nephrology.sk.php` copyright → `polascin.net`.
- Verified brand drift via official `<title>` / `og:site_name`:
  Union poisťovňa; medupdate europe.
- Left intro Bory commented; remote-only not deleted; no GH secrets;
  skipped commented NephroCare (no prod effect).

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `9a153dd`; post-commit SFTP uploaded
  `nephrology.sk.php` + `promo.sk.php`; `deploy.ps1 -Apply` → 0 upload;
  smoke direct 200 on `/` `/privacy` `/terms` `/nefrologia`
- Command: GHA Deploy `42109361935` success (rsync skipped)
- Command: production Chrome UA `/` → Union/medupdate new titles present,
  old variants 0; nephrology hint True; live blank miss hints = 0;
  HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: WHO `(WHO)` suffix and other minor brand polish remain
  optional; commented NephroCare casing not worth a prod ship alone.

## Remaining Work

- [ ] Loop #27: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (WHO title polish;
      content consistency; intro Bory only after content decision).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship nephrology a11y + Union/medupdate titles this tick
  (not intro Bory; not commented NephroCare).
- Reason: Live verified miss hint + two official-brand mismatches;
  coherent a11y/title ship without content-policy change.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `blocks/nephrology.sk.php`
- `blocks/promo.sk.php`
- `SESSION.md`, `.audit.md` (Beh #37)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 9a153dd Align Union/medupdate promo titles and add nephrology copyright new-window hint.
- 481ccf7 Record loop #25 tip SHA in SESSION handoff.
- c7d4643 Point loop #25 handoff HEAD to docs tip.
- 4cf0f43 Record loop #25 tip SHA in SESSION handoff.
- 5a86011 Align loop #25 SESSION HEAD with tip commit.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #37)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-220557-loop26-union-medupdate-nephrology-a11y.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-220557-loop26-union-medupdate-nephrology-a11y.md.
Pokračuj loop #27 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value ship (title/content/a11y) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
