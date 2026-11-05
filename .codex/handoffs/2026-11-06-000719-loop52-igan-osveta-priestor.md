# Handoff: loop52-igan-osveta-priestor

## Metadata

- Generated At: 2026-11-06T00:07:19+01:00
- Updated At: 2026-11-06T00:08:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: cbfd38c

## Original Goal

Loop iterácia #52: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix (kandidát IgAN
`Propagácia`/`platformu`/`asymptomatické` po overení registra; sync
`igan.html` + `IgAN.sk.html`); 1 product + 1 docs commit;
commit/push/deploy/smoke; SESSION + handoff. Nie Lipton `jedinec`.

## Current State

Iterácia #52 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: IgAN `Osveta` / `priestor` /
`bez príznakov` (segments sync). Product SHA `cbfd38c` (docs tip nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped; Lipton `jedinec`
  untouched; nefamb ABPM term untouched; `politických zmien` left.
- Patched `segments/igan.html` + `segments/IgAN.sk.html`:
  `Propagácia` → `Osveta`; `platformu` → `priestor`;
  `asymptomatické` → `bez príznakov`.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `cbfd38c`; post-commit SFTP uploaded both IgAN segments;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42127027608` success (rsync skipped)
- Command: production Chrome UA `/` → `Osveta a vzdelávanie`,
  `priestor na výmenu`, `bez príznakov mnoho` present;
  `Propagácia a vzdelávanie`, `platformu na výmenu`, `asymptomatické`
  absent; `/` `/privacy` `/terms` `/nefrologia` `/dialyza` `/nefamb`
  `/usgo` `/transplantacia` `/purifikacia` → 200 + HSTS + CSP still with
  enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.

## Remaining Work

- [ ] Loop #53: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; not Lipton `jedinec`). Avoid tip-SHA
      churn. Possible IgAN candidate: `politických zmien` (EN *policy*;
      verify register first).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship IgAN `Propagácia`→`Osveta`, `platformu`→`priestor`,
  `asymptomatické`→`bez príznakov` with `igan.html` + `IgAN.sk.html`
  sync (no `files/` mirror).
- Reason: Patient register; `Osveta` pairs with health education heading;
  `priestor` replaces EN calque; `bez príznakov` matches earlier wording
  and avoids wrong neuter agreement with feminine `nefropatia`. Medical
  facts unchanged.
- Decision: Leave `politických zmien`, ASN/ISN, remote-only, GH secrets,
  intro Bory, Lipton `jedinec`, nefamb ABPM untouched.
- Reason: Same standing constraints as prior loops; policy calque needs
  separate register check.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `segments/igan.html`, `segments/IgAN.sk.html`
- `blocks/nephrology.sk.php` (homepage include)
- `SESSION.md`, `.audit.md` (Beh #63)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- cbfd38c Fix IgAN patient wording: osveta, priestor, bez príznakov.
- 177aae7 Document loop #51 IgAN sledovanie and keep unsafe-inline after smoke-only CSP telemetry.
- 04f9693 Fix IgAN patient wording: sledovanie instead of monitorovanie.
- 3ecf44b Document loop #50 IgAN v glomeruloch and keep unsafe-inline after smoke-only CSP telemetry.
- e64f6d0 Fix IgAN patient wording: v glomeruloch instead of v rámci glomerulov.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #63)
- `.doaudit.md`
- `.codex/handoffs/2026-11-06-000719-loop52-igan-osveta-priestor.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-06-000719-loop52-igan-osveta-priestor.md.
Pokračuj loop #53 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Nie Lipton jedinec. Vyhni sa tip-SHA churn. Kandidát: IgAN politických zmien (EN policy) overiť register.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
