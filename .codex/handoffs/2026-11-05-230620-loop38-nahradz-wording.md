# Handoff: loop38-nahradz-wording

## Metadata

- Generated At: 2026-11-05T23:06:20+01:00
- Updated At: 2026-11-05T23:07:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: dd2a73d

## Original Goal

Loop iterácia #38: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix (`nahradz*`);
1 product + 1 docs commit; commit/push/deploy/smoke; SESSION + handoff.

## Current State

Iterácia #38 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: dialyza `nahradzuje`/`vykonávaná` +
CRRT title `nahradzujúcej`→`náhradnej`. Product SHA `dd2a73d` (docs tip
nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped.
- Patched `files/dialyza.html`: `nahradzuje`→`nahrádza`;
  `je zvyčajne vykonávaná`→`sa zvyčajne vykonáva`.
- Patched `blocks/regcitra.sk.php`: `nahradzujúcej liečby`→`náhradnej liečby`.
- Confirmed `segments/dialyza.html` lacks that intro sentence → no sync.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `dd2a73d`; post-commit SFTP uploaded both files;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42118482430` success (rsync skipped)
- Command: production Chrome UA `/` → `náhradnej liečby` present,
  `nahradzujúcej` absent; `/dialyza` → `nahrádza` +
  `sa zvyčajne vykonáva` present; old forms absent; `/` `/privacy`
  `/terms` `/nefrologia` `/dialyza` `/nefamb` `/usgo` `/transplantacia`
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

- [ ] Loop #39: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; candidates: ipvrm `viacero výhod`,
      nefamb `dysbalancie`/`hyponatriémia`, purifikacia `kosáčikovitá`).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship `nahradz*` register alignment this tick.
- Reason: Verified defect vs site convention (`nahrádza`/`náhradná` in
  footer, cookie banner, terms, purifikacia); medical facts unchanged.
- Decision: Also rewrite passive `je vykonávaná`→`sa vykonáva` in the
  same dialyza intro sentence.
- Reason: Clearer Slovak; same meaning; no medical change.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `files/dialyza.html`, `blocks/regcitra.sk.php`
- `SESSION.md`, `.audit.md` (Beh #49)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- dd2a73d Fix Slovak nahradz* wording on dialyza and CRRT title.
- 950f5ca Document loop #37 IgAN wording and keep unsafe-inline after smoke-only CSP telemetry.
- 4f21898 Fix Slovak wording on IgAN clinical-trials sentence.
- 755d261 Document loop #36 CAPD/transplantacia wording and keep unsafe-inline after smoke-only CSP telemetry.
- 41be8c0 Fix Slovak wording on dialyza CAPD and transplantacia pages.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #49)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-230620-loop38-nahradz-wording.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-230620-loop38-nahradz-wording.md.
Pokračuj loop #39 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Kandidáti: ipvrm viacero výhod; nefamb dysbalancie/hyponatriémia; purifikacia kosáčikovitá.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
