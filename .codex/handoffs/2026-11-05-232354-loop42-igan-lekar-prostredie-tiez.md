# Handoff: loop42-igan-lekar-prostredie-tiez

## Metadata

- Generated At: 2026-11-05T23:23:54+01:00
- Updated At: 2026-11-05T23:24:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 2ce776e

## Original Goal

Loop iterácia #42: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix; 1 product +
1 docs commit; commit/push/deploy/smoke; SESSION + handoff.

## Current State

Iterácia #42 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: IgAN `faktorov prostredia`, `lekár`/
`lekárovi`, `Musia tiež` v `segments/igan.html` + `IgAN.sk.html`.
Product SHA `2ce776e` (docs tip nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped.
- Patched `segments/igan.html` + `segments/IgAN.sk.html`:
  `environmentálnych faktorov`→`faktorov prostredia`;
  `poskytovateľ zdravotnej starostlivosti`→`lekár`;
  `poskytovateľovi zdravotnej starostlivosti`→`lekárovi`;
  `Taktiež musia`→`Musia tiež`.
- Left untouched: legal `poskytovateľ…` in privacy/terms;
  IgAN `v dôsledku zníženej schopnosti`; `hyponatriémia`;
  `kosáčikovitá anémia`.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `2ce776e`; post-commit SFTP uploaded both IgAN segments;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42120965708` success (rsync skipped)
- Command: production Chrome UA `/` → new IgAN strings present;
  old calques absent; `/` `/privacy` `/terms` `/nefrologia` `/dialyza`
  `/nefamb` `/usgo` `/transplantacia` `/purifikacia` → 200 + HSTS + CSP
  still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: further IgAN wording (`zosúladiť vedľajšie účinky`,
  `osoby s IgA`→`ľudia s`) can wait for a later tick.

## Remaining Work

- [ ] Loop #43: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; optional IgAN `zosúladiť` / `osoby`).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship IgAN `lekár` / `faktorov prostredia` / `Musia tiež`.
- Reason: Patient-register calques; medical facts unchanged; keep legal
  `poskytovateľ zdravotnej starostlivosti` on privacy/terms. Sync both
  IgAN segment variants.
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
- `SESSION.md`, `.audit.md` (Beh #53)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 2ce776e Fix IgAN patient calques for provider, environment, and tiež.
- 636e550 Document loop #41 IgAN wording and keep unsafe-inline after smoke-only CSP telemetry.
- 8b9127d Fix IgAN patient wording and glomerulonephritis term.
- d11dc62 Document loop #40 purifikacia/nefamb wording and keep unsafe-inline after smoke-only CSP telemetry.
- 4a52309 Fix mycosis fungoides term and nefamb cause wording.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #53)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-232354-loop42-igan-lekar-prostredie-tiez.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-232354-loop42-igan-lekar-prostredie-tiez.md.
Pokračuj loop #43 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu); voliteľne IgAN zosúladiť vedľajšie účinky / osoby s IgA → ľudia s.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
