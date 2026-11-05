# Handoff: loop53-igan-zdravotnej-politike

## Metadata

- Generated At: 2026-11-06T00:11:20+01:00
- Updated At: 2026-11-06T00:11:53+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 08338a1

## Original Goal

Loop iterácia #53: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix (kandidát IgAN
`politických zmien` / EN *policy* po overení registra; sync
`igan.html` + `IgAN.sk.html`); 1 product + 1 docs commit;
commit/push/deploy/smoke; SESSION + handoff. Nie Lipton `jedinec`.

## Current State

Iterácia #53 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: IgAN `zmien v zdravotnej politike`
namiesto `politických zmien` (segments sync). Product SHA `08338a1`
(docs tip nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped; Lipton `jedinec`
  untouched; nefamb ABPM term untouched.
- Patched `segments/igan.html` + `segments/IgAN.sk.html`:
  `politických zmien` → `zmien v zdravotnej politike`.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `08338a1`; post-commit SFTP uploaded both IgAN segments;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42127561520` success (rsync skipped)
- Command: production Chrome UA `/` → `zmien v zdravotnej politike`
  present; `politických zmien` absent; `/` `/privacy` `/terms`
  `/nefrologia` `/dialyza` `/nefamb` `/usgo` `/transplantacia`
  `/purifikacia` → 200 + HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.

## Remaining Work

- [ ] Loop #54: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; not Lipton `jedinec`). Avoid tip-SHA
      / IgAN churn; prefer a11y scan or wording outside IgAN tip path.

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship IgAN `politických zmien` → `zmien v zdravotnej politike`
  with `igan.html` + `IgAN.sk.html` sync (no `files/` mirror).
- Reason: EN *policy changes* was calqued as party-politics
  `politických`; patient register needs healthcare-policy reading.
  Medical facts unchanged.
- Decision: Leave ASN/ISN, remote-only, GH secrets, intro Bory,
  Lipton `jedinec`, nefamb ABPM untouched.
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
- `SESSION.md`, `.audit.md` (Beh #64)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 08338a1 Fix IgAN patient wording: zdravotnej politike instead of politickych zmien.
- 0024208 Document loop #52 IgAN osveta/priestor and keep unsafe-inline after smoke-only CSP telemetry.
- cbfd38c Fix IgAN patient wording: osveta, priestor, bez príznakov.
- 177aae7 Document loop #51 IgAN sledovanie and keep unsafe-inline after smoke-only CSP telemetry.
- 04f9693 Fix IgAN patient wording: sledovanie instead of monitorovanie.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #64)
- `.doaudit.md`
- `.codex/handoffs/2026-11-06-001120-loop53-igan-zdravotnej-politike.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-06-001120-loop53-igan-zdravotnej-politike.md.
Pokračuj loop #54 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Nie Lipton jedinec. Vyhni sa tip-SHA / IgAN churn. Kandidát: a11y scan _blank/sr-only po strip komentárov, alebo overený pacientsky wording mimo IgAN tip path.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
