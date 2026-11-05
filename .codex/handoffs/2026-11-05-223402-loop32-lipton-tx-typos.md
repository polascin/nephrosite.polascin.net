# Handoff: loop32-lipton-tx-typos

## Metadata

- Generated At: 2026-11-05T22:34:02+01:00
- Updated At: 2026-11-05T22:35:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: fe4df5c

## Original Goal

Loop iterácia #32: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix; 1 product + 1
docs commit; commit/push/deploy/smoke; SESSION + handoff.

## Current State

Iterácia #32 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: oprava prepisových chýb v
`files/lipton-tx.html` (citát kapitoly). Repo na `main` @ `fe4df5c`
(product; docs tip nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Verified ASN/ISN official `<title>` lacks acronym → no promo polish.
- Site-wide live blank-miss = 0; missing-alt false positive only in
  `topic-teaser.php` regex.
- Patched `files/lipton-tx.html` transcription typos (`má`, `však`,
  `systémom`, `tento`, `"antény"`, `začalo`; Heart book titles).
- Left intro Bory commented; remote-only not deleted; no GH secrets.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `fe4df5c`; post-commit SFTP uploaded
  `files/lipton-tx.html`; `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42113695661` success (rsync skipped)
- Command: production Chrome UA `/lipton-tx` → fixed strings present;
  old typos absent; `/` `/privacy` `/terms` `/nefrologia` `/lipton-tx`
  → 200 + HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: further brand polish only if official `<title>` includes
  the acronym (ASN/ISN currently do not).

## Remaining Work

- [ ] Loop #33: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
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
- Decision: Ship lipton-tx transcription/grammar fixes this tick (not
  ASN/ISN promo).
- Reason: Blank-miss = 0; ASN/ISN official titles lack acronym; content
  typos were a stronger verified non-promo defect.
- Decision: Correct English book titles Hearth → Heart.
- Reason: Claire Sylvia *A Change of Heart*; Pearsall *The Heart's Code*
  (factual title correction, not medical invention).
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `files/lipton-tx.html`
- `SESSION.md`, `.audit.md` (Beh #43)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- fe4df5c Fix transcription typos in lipton-tx excerpt.
- c2ab52d Document loop #31 ipvrm privacy blank hint and keep unsafe-inline after smoke-only CSP telemetry.
- 450901b Add new-window hint to ipvrm privacy notice.
- 4da4b23 Point SESSION and loop30 handoff HEAD to docs tip.
- d485beb Document loop #30 lipton-tx blank hints and keep unsafe-inline after smoke-only CSP telemetry.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #43)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-223402-loop32-lipton-tx-typos.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-223402-loop32-lipton-tx-typos.md.
Pokračuj loop #33 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu).
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
