# Handoff: loop65-en-gloss-removal

## Metadata

- Generated At: 2026-11-06T01:25:29+01:00
- Updated At: 2026-11-06T01:27:00+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: c406b84

## Original Goal

Loop iterácia #65: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence + Clarity/GTM safety
(súčet aj rozpad); remote-only nemazať; nevyvárať GH secrets; preferovať
verified non-tip-path patient-copy alebo tooling mimo tip-SHA / privacy /
terms / cookie / intro-Amazon / Lipton / homepage-dative churn; 1 product
+ 1 docs commit; commit/push/deploy/smoke; SESSION + handoff. Nie Lipton
`jedinec`.

## Current State

Iterácia #65 hotová. RO telemetria stále smoke-only (2 riadky,
0 Clarity/GTM/Fastbase hits, rozpad 0/0/0). Enforced `'unsafe-inline'`
ponechané. Ship: redundantné EN glossy v dialýze/transplantácii
(`(morbidity)` / `(mortality)` / `(rejekcia)`) + scanner rules. Product
SHA `c406b84` (docs tip nasleduje). Medicínske fakty nezmenené.

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates,
  0 Clarity/GTM/Fastbase vendor hits (0/0/0).
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped (official titles still
  without acronym); Lipton / homepage-dative / privacy/cookie/Amazon
  untouched.
- Removed redundant EN glosses in `files|segments/dialyza.html` and
  `files|segments/transplantacia.html` (parallel to `darcu (donora)`).
- Extended `tools/scan-patient-copy.ps1` with `(morbidity)`, `(mortality)`,
  `orgánu (rejekcia)`; README note.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  vendor hits 0 (Clarity 0, GTM/GA 0, Fastbase 0); keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: `powershell -File .\tools\scan-blank-hints.ps1` → 0/0/0
- Command: `powershell -File .\tools\scan-patient-copy.ps1` → 0 hits
- Command: commit `c406b84`; post-commit SFTP uploaded dialyza/transplant
  files+segments (tools skipped by deployignore); `deploy.ps1 -Apply` →
  0 upload; smoke direct 200
- Command: GHA Deploy `42136612798` success (rsync skipped)
- Command: production Chrome UA `/dialyza` → `chorobnosť a úmrtnosť`
  present; morbidity/mortality absent; `/transplantacia` →
  `odmietnutie orgánu,` present; rejekcia absent; `/` `/privacy` `/terms`
  `/nefrologia` `/nefamb` `/usgo` `/purifikacia` `/lipton-tx` → 200 +
  HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.

## Remaining Work

- [ ] Loop #66: re-run `csp-report-summary.ps1` (+ blank-hints +
      patient-copy scans); drop `'unsafe-inline'` only with strong
      evidence (+ Clarity/GTM consent paths; watch total and
      Clarity/GTM-GA/Fastbase breakdown).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; not Lipton `jedinec`). Avoid tip-SHA /
      privacy/terms/cookie / intro-Amazon / Lipton / homepage-dative /
      práve-shipnutý EN-gloss dialyza-transplant churn; prefer another
      verified patient-copy defect outside tip path or further tooling.

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; Clarity/GTM/Fastbase hits = 0.
- Decision: Ship EN gloss cleanup in dialyza/transplant + scanner rules
  (new defect class parallel to `darcu (donora)`, not re-polish of prior
  tip wording).
- Reason: High-confidence patient-copy defect; SK terms already present;
  EN parentheticals redundant; medical claims unchanged.
- Decision: Leave ASN/ISN, remote-only, GH secrets, intro Bory,
  Lipton `jedinec`, privacy/terms/cookie, intro Amazon, homepage dative
  untouched.
- Reason: Same standing constraints; ASN/ISN official titles still lack
  acronym suffixes.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `files/dialyza.html`, `segments/dialyza.html`
- `files/transplantacia.html`, `segments/transplantacia.html`
- `tools/scan-patient-copy.ps1`, `tools/README.md`
- `tools/scan-blank-hints.ps1`
- `SESSION.md`, `.audit.md` (Beh #76)
- `tools/deploy.ps1`, `tools/csp-report-summary.ps1`

## Recent Commits

- c406b84 Remove redundant English glosses from dialysis and transplant patient copy.
- 429e7d8 Document loop #64 homepage dative and patient-copy scanner after smoke-only CSP telemetry.
- 23ac8a3 Fix homepage dative agreement and extend patient-copy regression rules.
- d2f41ba Document loop #63 Lipton literary wording and patient-copy scanner after smoke-only CSP telemetry.
- 0b31d04 Fix Lipton literary wording and extend patient-copy regression rules.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #76)
- `.doaudit.md`
- `.codex/handoffs/2026-11-06-012529-loop65-en-gloss-removal.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`, `tools/scan-blank-hints.ps1`,
  `tools/scan-patient-copy.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-blank-hints.ps1
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-patient-copy.ps1
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-06-012529-loop65-en-gloss-removal.md.
Pokračuj loop #66 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence (+ Clarity/GTM súčet aj rozpad Clarity/GTM-GA/Fastbase); remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Nie Lipton jedinec. Vyhni sa tip-SHA / privacy/terms/cookie/intro-Amazon/Lipton/homepage-dative/práve-shipnutý EN-gloss dialyza-transplant churn. Kandidát: overený patient-copy defect mimo tip path alebo ďalší tooling. Spusti aj scan-blank-hints.ps1 a scan-patient-copy.ps1.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php; powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-blank-hints.ps1; powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-patient-copy.ps1
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
