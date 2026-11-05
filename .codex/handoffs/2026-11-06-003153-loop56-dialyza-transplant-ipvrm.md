# Handoff: loop56-dialyza-transplant-ipvrm

## Metadata

- Generated At: 2026-11-06T00:31:53+01:00
- Updated At: 2026-11-06T00:33:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: a15c074

## Original Goal

Loop iterácia #56: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať dialyza/transplant/purifikacia/ipvrm/
legal/tooling (vyhnúť sa tip-SHA / IgAN / USG / nefamb+lectures churn);
1 product + 1 docs commit; commit/push/deploy/smoke; SESSION + handoff.
Nie Lipton `jedinec`.

## Current State

Iterácia #56 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: dialyza `u prevažnej väčšiny` + segments
`cykler` sync; transplant `úprave liekov` + drop `(donora)`; ipvrm
`V inovatívnom` / `priestor na výmenu`. Product SHA `a15c074` (docs tip
nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped; Lipton `jedinec`
  untouched; IgAN/USG/nefamb/lectures untouched.
- Patched `files/dialyza.html` + `segments/dialyza.html`:
  `v prevažnej väčšine` → `u prevažnej väčšiny`; segments `cycler` →
  `cykler`; `8 - 10` → `8-10`.
- Patched `files/transplantacia.html` + `segments/transplantacia.html`:
  `prispôsobeniu liekov` → `úprave liekov`; `darcu (donora)` → `darcu`.
- Patched `ipvrm.htm`: `V rámci inovatívneho` → `V inovatívnom`;
  `platformu na zdieľanie` → `priestor na výmenu`.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `a15c074`; post-commit SFTP uploaded dialyza/transplant/
  ipvrm + segments; `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42129925838` success (rsync skipped)
- Command: production Chrome UA `/dialyza` + `/` → `u prevažnej väčšiny`
  + `cykler`; `/transplantacia` + `/` → `úprave liekov`, no `(donora)`;
  `/ipvrm.htm` → `V inovatívnom` + `priestor na výmenu`;
  `/` `/privacy` `/terms` `/nefrologia` `/dialyza` `/nefamb` `/usgo`
  `/transplantacia` `/purifikacia` → 200 + HSTS + CSP still with
  enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.

## Remaining Work

- [ ] Loop #57: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; not Lipton `jedinec`). Avoid tip-SHA
      / IgAN / USG / nefamb+lectures / just-shipped dialyza-transplant-
      ipvrm churn; prefer purifikacia/legal/tooling/nefrologia.

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship dialyza/transplant/ipvrm wording instead of IgAN/USG/
  nefamb/lectures tip churn or a11y (prior scans clean).
- Reason: Clear verified Slovak defects in preferred domains; medical
  facts (HDF vs HD) unchanged; segments synced with files.
- Decision: Leave ASN/ISN, remote-only, GH secrets, intro Bory,
  Lipton `jedinec`, IgAN/USG/nefamb/lectures untouched.
- Reason: Same standing constraints as prior loops.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `files/dialyza.html`, `segments/dialyza.html`
- `files/transplantacia.html`, `segments/transplantacia.html`
- `ipvrm.htm`
- `SESSION.md`, `.audit.md` (Beh #67)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- a15c074 Fix dialyza, transplant and ipvrm wording: u vacsiny, uprava liekov, cykler, priestor.
- 5b6c954 Document loop #55 audit Beh #66 and handoff after nefamb/lectures wording ship.
- f43ff08 Document loop #55 nefamb/lectures wording and keep unsafe-inline after smoke-only CSP telemetry.
- dd33d8e Fix nefamb and lectures wording: zobrazenie, spravny odber, V kurze.
- e1dee07 Document loop #54 USG odpoveda/odovzdaju and keep unsafe-inline after smoke-only CSP telemetry.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #67)
- `.doaudit.md`
- `.codex/handoffs/2026-11-06-003153-loop56-dialyza-transplant-ipvrm.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-06-003153-loop56-dialyza-transplant-ipvrm.md.
Pokračuj loop #57 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Nie Lipton jedinec. Vyhni sa tip-SHA / IgAN / USG / nefamb+lectures / dialyza-transplant-ipvrm churn. Kandidát: purifikacia/legal/tooling/nefrologia.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
