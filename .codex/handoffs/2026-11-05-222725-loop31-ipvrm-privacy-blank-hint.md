# Handoff: loop31-ipvrm-privacy-blank-hint

## Metadata

- Generated At: 2026-11-05T22:27:25+01:00
- Updated At: 2026-11-05T22:28:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 450901b

## Original Goal

Loop iterácia #31: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix (broken links,
a11y, security/perf, content); 1 product + 1 docs commit;
commit/push/deploy/smoke; SESSION + handoff.

## Current State

Iterácia #31 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: `ipvrm.htm` privacy notice `_blank`
dostal lokalne `.sr-only` CSS + hint „(otvorí sa v novom okne)“ a
kanonický `href="/privacy"` (namiesto 301 `/files/privacy.html`).
Repo na `main` @ `450901b` (product; docs tip nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Site-wide live blank-miss scan (comments stripped, `.kilo`/tools skip)
  → 1 miss: `ipvrm.htm` privacy banner.
- Patched privacy notice: `/privacy` + sr-only hint + local `.sr-only`
  CSS (standalone Word HTML nemá site CSS ani scripts.sk.php helper).
- Left intro Bory commented; remote-only not deleted; no GH secrets;
  no speculative ASN/ISN acronym polish.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: post-scan live blank miss = 0
- Command: commit `450901b`; post-commit SFTP uploaded `ipvrm.htm`;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200 on `/` `/privacy`
  `/terms` `/nefrologia`
- Command: GHA Deploy `42112671817` success (rsync skipped)
- Command: production Chrome UA `/ipvrm.htm` → `/privacy` + sr-only hint
  + `.sr-only` CSS present; `/files/privacy.html` absent; `/` `/privacy`
  `/terms` `/nefrologia` `/ipvrm.htm` → 200 + HSTS + CSP still with
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

- [ ] Loop #32: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
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
- Decision: Ship ipvrm privacy blank-hint a11y this tick (not ASN/ISN promo).
- Reason: Only remaining live blank miss site-wide; stronger verified
  non-promo defect than speculative acronym polish.
- Decision: Add local `.sr-only` CSS inside the privacy notice block.
- Reason: `ipvrm.htm` is standalone Word HTML (iframe + direct URL) and
  does not load `blocks/styles.css.php` or the scripts.sk.php blank helper.
- Decision: Point privacy href to `/privacy` instead of `/files/privacy.html`.
- Reason: Production returns 301 from the files path; avoid extra hop
  when opening in a new tab.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `ipvrm.htm`
- `SESSION.md`, `.audit.md` (Beh #42)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 450901b Add new-window hint to ipvrm privacy notice.
- 4da4b23 Point SESSION and loop30 handoff HEAD to docs tip.
- d485beb Document loop #30 lipton-tx blank hints and keep unsafe-inline after smoke-only CSP telemetry.
- 0a40236 Add new-window hints to lipton-tx external links.
- 088d9b8 Document loop #29 ANNA/KDIGO title polish and keep unsafe-inline after smoke-only CSP telemetry.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #42)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-222725-loop31-ipvrm-privacy-blank-hint.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-222725-loop31-ipvrm-privacy-blank-hint.md.
Pokračuj loop #32 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
