# Handoff: loop50-igan-v-glomeruloch

## Metadata

- Generated At: 2026-11-05T23:58:25+01:00
- Updated At: 2026-11-05T23:59:10+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: e64f6d0

## Original Goal

Loop iterácia #50: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix (kandidát IgAN
`v rámci glomerulov` → `v glomeruloch`, sync `igan.html` + `IgAN.sk.html`);
1 product + 1 docs commit; commit/push/deploy/smoke; SESSION + handoff.
Nie Lipton `jedinec`.

## Current State

Iterácia #50 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: IgAN `v glomeruloch` (segments sync).
Product SHA `e64f6d0` (docs tip nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped; Lipton `jedinec`
  untouched.
- Patched `segments/igan.html` + `segments/IgAN.sk.html`:
  `v rámci glomerulov` → `v glomeruloch`.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `e64f6d0`; post-commit SFTP uploaded both IgAN segments;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42125735925` success (rsync skipped)
- Command: production Chrome UA `/` → `v glomeruloch lokálne reguluje`
  present; `v rámci glomerulov` absent; `/` `/privacy` `/terms`
  `/nefrologia` `/dialyza` `/nefamb` `/usgo` `/transplantacia`
  `/purifikacia` → 200 + HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.

## Remaining Work

- [ ] Loop #51: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; not Lipton `jedinec`). Avoid tip-SHA
      churn.

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship IgAN `v rámci glomerulov` → `v glomeruloch` with
  `igan.html` + `IgAN.sk.html` sync (no `files/` mirror).
- Reason: Verified bureaucratic calque; same paragraph already uses
  `v glomeruloch`; medical facts unchanged.
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

- `segments/igan.html`, `segments/IgAN.sk.html`
- `blocks/nephrology.sk.php` (homepage include)
- `SESSION.md`, `.audit.md` (Beh #61)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- e64f6d0 Fix IgAN patient wording: v glomeruloch instead of v rámci glomerulov.
- 7e4a672 Document loop #49 zvládanie/príjemcu and keep unsafe-inline after smoke-only CSP telemetry.
- 0e6a9c5 Fix patient wording: zvládanie chronických ochorení and leftover príjemcu.
- c32c5a1 Document loop #48 nefrologia wording and keep unsafe-inline after smoke-only CSP telemetry.
- 80f1659 Fix nefrologia patient wording for zlepšiť pochopenie and pohoda človeka.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #61)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-235825-loop50-igan-v-glomeruloch.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-235825-loop50-igan-v-glomeruloch.md.
Pokračuj loop #51 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Nie Lipton jedinec. Vyhni sa tip-SHA churn.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
