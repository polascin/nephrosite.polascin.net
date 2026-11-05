# Handoff: loop30-lipton-tx-blank-hints

## Metadata

- Generated At: 2026-11-05T22:22:09+01:00
- Updated At: 2026-11-05T22:23:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: d485beb

## Original Goal

Loop iterácia #30: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix (broken links,
a11y beyond titles, security/perf, content bugs, tooling); ASN/ISN
polish len ak nie je silnejší overený defect; 1 product + 1 docs commit;
commit/push/deploy/smoke; SESSION + handoff.

## Current State

Iterácia #30 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: `files/lipton-tx.html` Martinus a
eugenika.sk `_blank` odkazy dostali sr-only „(otvorí sa v novom okne)“.
Repo na `main` @ `d485beb` (product `0a40236` + docs).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Site-wide live blank-miss scan (HTML comments stripped, `.kilo` skipped)
  → iba 2 miss: Martinus + eugenika v `files/lipton-tx.html`.
- Added matching sr-only hints; post-fix scan → 0 live blank miss.
- Left intro Bory commented; remote-only not deleted; no GH secrets;
  no speculative ASN/ISN acronym polish.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `0a40236`; post-commit SFTP uploaded `lipton-tx.html`;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200 on `/` `/privacy`
  `/terms` `/nefrologia`
- Command: GHA Deploy `42111877183` success (rsync skipped)
- Command: production Chrome UA `/lipton-tx` → Martinus + eugenika
  anchors each have sr-only; page blank miss = 0; `/` `/privacy`
  `/terms` `/nefrologia` `/lipton-tx` → 200 + HSTS + CSP still with
  enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: further brand polish (ASN/ISN etc.) only if official
  `<title>` actually includes the acronym.

## Remaining Work

- [ ] Loop #31: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
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
- Decision: Ship lipton-tx blank-hint a11y this tick (not ASN/ISN promo).
- Reason: Site-wide scan found only these 2 live blank misses; stronger
  verified non-promo defect than speculative acronym polish.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.
- Decision: Do not invent ASN/ISN `(ASN)`/`(ISN)` without title evidence.
- Reason: Prior loops already verified titles lack acronym suffix.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `files/lipton-tx.html`
- `SESSION.md`, `.audit.md` (Beh #41)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 0a40236 Add new-window hints to lipton-tx external links.
- 088d9b8 Document loop #29 ANNA/KDIGO title polish and keep unsafe-inline after smoke-only CSP telemetry.
- a0534dc Align ANNA and KDIGO promo titles with official branding.
- e7a33a9 Document loop #28 ERA/EDTNA title polish and keep unsafe-inline after smoke-only CSP telemetry.
- 27bcd26 Align ERA and EDTNA/ERCA promo titles with official branding.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #41)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-222209-loop30-lipton-tx-blank-hints.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-222209-loop30-lipton-tx-blank-hints.md.
Pokračuj loop #31 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
