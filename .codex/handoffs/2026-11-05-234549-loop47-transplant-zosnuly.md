# Handoff: loop47-transplant-zosnuly

## Metadata

- Generated At: 2026-11-05T23:45:49+01:00
- Updated At: 2026-11-05T23:47:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 5fc04c1

## Original Goal

Loop iterácia #47: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix; 1 product +
1 docs commit; commit/push/deploy/smoke; SESSION + handoff. Nie Lipton
`jedinec`.

## Current State

Iterácia #47 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: transplantácia wording (files +
segments). Product SHA `5fc04c1` (docs tip nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped; Lipton `jedinec`
  untouched.
- Patched `files/transplantacia.html` + `segments/transplantacia.html`:
  1. `ako aj` → `a`; removed moralizing gratitude sentence (files only)
  2. `mŕtveho` → `zosnulého` (match intro + meta)
  3. segments `do pacienta` → `na pacienta`
  4. drop `(akceptora)`; unify `prijímateľa` → `príjemcu`

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `5fc04c1`; post-commit SFTP uploaded transplant files;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42124122112` success (rsync skipped)
- Command: production Chrome UA `/transplantacia` → `zosnulého`,
  `cievy príjemcu`, `a alternatívne` present; `mŕtveho`, `ako aj`,
  `vďačný`, `akceptor` absent; `/` `/privacy` `/terms` `/nefrologia`
  `/dialyza` `/nefamb` `/usgo` `/transplantacia` `/purifikacia` → 200 +
  HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.

## Remaining Work

- [ ] Loop #48: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; candidate: nefrologia `jednotlivca` /
      `vylepšiť pochopenie`; not Lipton `jedinec`).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship transplant zosnulý / príjemca / ako aj fixes with
  files+segments sync.
- Reason: Verified register/consistency defects; medical facts unchanged;
  meta description already used zosnulého.
- Decision: ASN/ISN still no acronym polish; remote-only not deleted;
  no GH secrets; intro Bory stays commented; Lipton `jedinec` untouched.
- Reason: Same standing constraints as prior loops.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `files/transplantacia.html`, `segments/transplantacia.html`
- `SESSION.md`, `.audit.md` (Beh #58)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 5fc04c1 Fix transplant patient wording for zosnulý donor register and príjemca consistency.
- d93451f Document loop #46 nefamb ako aj and keep unsafe-inline after smoke-only CSP telemetry.
- 3ead092 Fix nefamb patient wording by tightening four defective ako aj constructions.
- 7301a6b Document loop #45 dialýza chorobnosť and keep unsafe-inline after smoke-only CSP telemetry.
- d28f514 Fix dialýza patient wording for HDF morbidity and mortality outcomes.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #58)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-234549-loop47-transplant-zosnuly.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-234549-loop47-transplant-zosnuly.md.
Pokračuj loop #48 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Kandidát: nefrologia jednotlivca/vylepšiť pochopenie. Nie Lipton jedinec.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
