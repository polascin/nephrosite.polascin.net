# Handoff: loop48-nefrologia-zlepsit-cloveka

## Metadata

- Generated At: 2026-11-05T23:50:06+01:00
- Updated At: 2026-11-05T23:51:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 80f1659

## Original Goal

Loop iterácia #48: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix (kandidát
nefrologia `jednotlivca` / `vylepšiť pochopenie`); 1 product + 1 docs
commit; commit/push/deploy/smoke; SESSION + handoff. Nie Lipton
`jedinec`.

## Current State

Iterácia #48 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: nefrologia wording (files + segments).
Product SHA `80f1659` (docs tip nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped; Lipton `jedinec`
  untouched.
- Patched `files/nefrologia.html` + `segments/nefrologia.html`:
  1. `vylepšiť pochopenie` → `zlepšiť pochopenie` (bohemizmus;
     zhoda s neskorším `zlepšovať pochopenie` v tom istom texte)
  2. `pohodu jednotlivca` → `pohodu človeka` (kalk EN *individual*;
     zhoda so SESSION pravidlom `jedinci` → `ľudia` / `človek`)

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `80f1659`; post-commit SFTP uploaded nefrologia files;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42124709480` success (rsync skipped)
- Command: production Chrome UA `/nefrologia` and `/` → `zlepšiť
  pochopenie`, `pohodu človeka` present; `vylepšiť pochopenie`,
  `jednotlivca` absent; `/` `/privacy` `/terms` `/nefrologia`
  `/dialyza` `/nefamb` `/usgo` `/transplantacia` `/purifikacia` → 200 +
  HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.

## Remaining Work

- [ ] Loop #49: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; not Lipton `jedinec`). Candidate
      scan: remaining patient calques (`riadenie chronických` /
      `manažment`-style; promo title polish only with official title).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship nefrologia `vylepšiť`→`zlepšiť` and
  `jednotlivca`→`človeka` with files+segments sync.
- Reason: Verified register defects; medical facts unchanged; nearby
  paragraph already used `zlepšovať pochopenie`.
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

- `files/nefrologia.html`, `segments/nefrologia.html`
- `SESSION.md`, `.audit.md` (Beh #59)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 80f1659 Fix nefrologia patient wording for zlepšiť pochopenie and pohoda človeka.
- 1209814 Document loop #47 transplant zosnulý and keep unsafe-inline after smoke-only CSP telemetry.
- 5fc04c1 Fix transplant patient wording for zosnulý donor register and príjemca consistency.
- d93451f Document loop #46 nefamb ako aj and keep unsafe-inline after smoke-only CSP telemetry.
- 3ead092 Fix nefamb patient wording by tightening four defective ako aj constructions.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #59)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-235006-loop48-nefrologia-zlepsit-cloveka.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-235006-loop48-nefrologia-zlepsit-cloveka.md.
Pokračuj loop #49 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Nie Lipton jedinec.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
