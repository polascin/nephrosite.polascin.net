# Handoff: loop41-igan-jedinci-glomerulonefritida

## Metadata

- Generated At: 2026-11-05T23:19:35+01:00
- Updated At: 2026-11-05T23:20:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 8b9127d

## Original Goal

Loop iterácia #41: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix; 1 product +
1 docs commit; commit/push/deploy/smoke; SESSION + handoff.

## Current State

Iterácia #41 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: IgAN `jedinci`→`ľudia`,
`manažment`→`zvládanie`, `glomerulárnej nefritídy`→`glomerulonefritídy`
v `segments/igan.html` + `IgAN.sk.html`. Product SHA `8b9127d` (docs tip
nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped.
- Patched `segments/igan.html` + `segments/IgAN.sk.html`:
  `jedinci`→`ľudia` (3×); `Liečba a manažment`→`Liečba a zvládanie`;
  `glomerulárnej nefritídy`→`glomerulonefritídy` (2×).
- Left untouched: IgAN `v dôsledku zníženej schopnosti`;
  `hyponatriémia`; `kosáčikovitá anémia`.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `8b9127d`; post-commit SFTP uploaded both IgAN segments;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42120391913` success (rsync skipped)
- Command: production Chrome UA `/` → new IgAN strings present;
  `jedinci`, `Liečba a manažment`, `glomerulárnej nefritídy` absent;
  `/` `/privacy` `/terms` `/nefrologia` `/dialyza` `/nefamb` `/usgo`
  `/transplantacia` `/purifikacia` → 200 + HSTS + CSP still with
  enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: further IgAN calques (`poskytovateľ zdravotnej starostlivosti`,
  `environmentálnych faktorov`, `Taktiež`) can wait for a later tick.

## Remaining Work

- [ ] Loop #42: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; optional IgAN calque cleanup).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship IgAN `ľudia` / `zvládanie` / `glomerulonefritídy`.
- Reason: Patient-register calques and nonstandard disease term; medical
  facts unchanged. Sync both IgAN segment variants.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `segments/igan.html`, `segments/IgAN.sk.html`
- `SESSION.md`, `.audit.md` (Beh #52)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 8b9127d Fix IgAN patient wording and glomerulonephritis term.
- d11dc62 Document loop #40 purifikacia/nefamb wording and keep unsafe-inline after smoke-only CSP telemetry.
- 4a52309 Fix mycosis fungoides term and nefamb cause wording.
- 99d75dc Document loop #39 ipvrm/nefamb wording and keep unsafe-inline after smoke-only CSP telemetry.
- c62b1b6 Fix Slovak wording on ipvrm and nefamb pages.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #52)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-231935-loop41-igan-jedinci-glomerulonefritida.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-231935-loop41-igan-jedinci-glomerulonefritida.md.
Pokračuj loop #42 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu); voliteľne IgAN calques (poskytovateľ zdravotnej starostlivosti / environmentálnych faktorov / Taktiež).
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
