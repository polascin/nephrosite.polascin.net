# Handoff: loop96-homepage-synonym-piles

## Metadata

- Generated At: 2026-11-06T03:56:00+01:00
- Updated At: 2026-11-06T03:56:00+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: b3d3746 (docs tip follows)

## Original Goal

Loop iterácia #96: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence + Clarity/GTM safety
(súčet aj rozpad); remote-only nemazať; nevyvárať GH secrets; preferovať
verified non-tip-path patient-copy/a11y/tooling mimo tip-SHA / privacy /
terms / cookie / intro-Amazon / Lipton / homepage-dative /
piles #65–#95; soft kandidáti: homepage blocks, purifikácia beyond
GvHD/membrane, blank-hints/tooling, dialýza/lectures beyond prior piles.
1 product + 1 docs commit; commit/push/deploy/smoke; SESSION + handoff.
Nie Lipton `jedinec`. Grok: ak nie je NephroSite kanál, len krátko
poznamenať.

## Current State

Iterácia #96 hotová. RO telemetria stále smoke-only (2 riadky,
0 Clarity/GTM/Fastbase hits, rozpad 0/0/0). Enforced `'unsafe-inline'`
ponechané. Ship: homepage synonym piles —
`metódam purifikácie (očisťovania) krvi` → `metódam purifikácie krvi`;
`internej medicíne (vnútornému lekárstvu)` → `internej medicíne`
(v `blocks/ns.sk.php`; #92 tieto piles zámerne nechalo; #71 čistilo
iba files/segments purifikácia). Meta `purifikacia.php` description
rovnaký očisťovania pile. Product SHA `b3d3746` (docs tip nasleduje).
Grok/XAI MCP kanál pre NephroSite neexistuje; žiadna inventovaná Grok
analýza.

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates,
  0 Clarity/GTM/Fastbase vendor hits (0/0/0).
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped; Lipton /
  homepage-dative / privacy/cookie/Amazon / synonym piles #65–#95
  untouched.
- Preferred ship: homepage ns-panel + purifikacia meta synonym residual.
- `blocks/ns.sk.php`: drop `(očisťovania)` and `(vnútornému lekárstvu)`.
- `purifikacia.php`: meta description `purifikácie (očisťovania)` →
  `purifikácie`.
- Tooling: `scan-patient-copy.ps1` 2 rules; README.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  vendor hits 0 (Clarity 0, GTM/GA 0, Fastbase 0); keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: `powershell -File .\tools\scan-blank-hints.ps1` → 0/0/0
- Command: `powershell -File .\tools\scan-patient-copy.ps1` → 0 hits
- Command: commit `b3d3746`; post-commit SFTP uploaded
  `blocks/ns.sk.php`, `purifikacia.php` (tools skipped by deployignore);
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: production Chrome UA `/` → old synonym piles 0;
  `metódam purifikácie krvi` ×1; subtitle match OK;
  `/purifikacia` meta `Metódy purifikácie krvi` present, old pile 0;
  `/` `/ipvrm.htm` `/dialyza` `/nefamb` `/nefrologia` `/usgo`
  `/transplantacia` `/privacy` `/terms` `/purifikacia` → 200 + HSTS +
  CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.

## Remaining Work

- [ ] Loop #97: re-run `csp-report-summary.ps1` (+ blank-hints +
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
      piles #65–#95 /
      práve-shipnutý homepage synonym piles (#96);
      soft kandidáti: iný verified patient-copy/a11y/tooling mimo churn
      listu (lectures beyond #77/#95, napr. author-list commas /
      `HorkýTran` typo; dialyza beyond #65/#67/#70/#82/#94;
      purifikácia cell-gloss residual beyond #71/#96; blank-hints,
      tooling).
      Spustiť `scan-blank-hints.ps1` aj `scan-patient-copy.ps1`.

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; Clarity/GTM/Fastbase hits = 0.
- Decision: Ship homepage ns-panel synonym residual as preferred soft
  candidate (plus matching purifikacia meta).
- Reason: Explicit soft preference for homepage blocks; #92 left
  `internej medicíne (vnútornému lekárstvu)` untouched; #71 cleaned
  files/segments only; coherent outside tip-path churn.
- Decision: Keep primary terms `purifikácie` and `internej medicíne`
  (homepage already uses interná medicína as primary; SESSION keeps
  standalone dative `internej medicíne`).
- Decision: Leave ASN/ISN, remote-only, GH secrets, intro Bory, Lipton,
  privacy/terms/cookie, Amazon, homepage dative, piles #65–#95
  untouched.
- Reason: Avoid tip and just-shipped path churn; keep one coherent ship.
- Decision: No Grok collaboration text.
- Reason: No NephroSite Grok/XAI channel/tools available; do not invent.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `blocks/ns.sk.php`, `purifikacia.php`
- `tools/scan-patient-copy.ps1`, `tools/README.md`
- `tools/scan-blank-hints.ps1`
- `SESSION.md`, `.audit.md`
- `tools/deploy.ps1`, `tools/csp-report-summary.ps1`

## Recent Commits

- b3d3746 Drop homepage synonym piles for purifikácia and interná medicína.
- b1b0f6d Document loop #95 lecture spol. s r.o. cleanup after smoke-only CSP telemetry.
- 7c8018e Correct lecture company form to standard Slovak spol. s r.o.
- 7cfd1a0 Document loop #94 dialýza residual cleanup after smoke-only CSP telemetry.
- 0ecf980 Tighten dialýza residual wording to clearer patient Slovak.

## Modified Files

- After docs commit: SESSION.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md`
- `.doaudit.md`
- `.codex/handoffs/2026-11-06-035600-loop96-homepage-synonym-piles.md`
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
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-06-035600-loop96-homepage-synonym-piles.md.
Pokračuj loop #97 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence (+ Clarity/GTM súčet aj rozpad Clarity/GTM-GA/Fastbase); remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Nie Lipton jedinec. Vyhni sa tip-SHA / privacy/terms/cookie/intro-Amazon/Lipton/homepage-dative/piles #65–#95/práve-shipnutý homepage synonym piles (#96) churn. Soft kandidáti: lectures beyond #77/#95 (author-list commas / HorkýTran typo); dialyza beyond #65/#67/#70/#82/#94; purifikácia cell-gloss residual beyond #71/#96; blank-hints, tooling. Spustiť aj scan-blank-hints.ps1 a scan-patient-copy.ps1.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php; powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-blank-hints.ps1; powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-patient-copy.ps1
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
