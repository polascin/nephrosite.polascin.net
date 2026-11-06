# Handoff: loop70-dialyza-synonym-piles

## Metadata

- Generated At: 2026-11-06T01:51:00+01:00
- Updated At: 2026-11-06T01:51:00+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: e2b7d37 (docs tip follows)

## Original Goal

Loop iterácia #70: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence + Clarity/GTM safety
(súčet aj rozpad); remote-only nemazať; nevyvárať GH secrets; preferovať
verified non-tip-path patient-copy alebo tooling mimo tip-SHA / privacy /
terms / cookie / intro-Amazon / Lipton / homepage-dative /
dialyza-transplant EN gloss (#65) / purifikacia-GvHD (#66) /
dialyza dwell-time (#67) / nefamb synonym piles (#68) /
ľadvina+KTx piles (#69); 1 product + 1 docs commit; commit/push/deploy/
smoke; SESSION + handoff. Nie Lipton `jedinec`. Grok: ak nie je
NephroSite kanál, len krátko poznamenať.

## Current State

Iterácia #70 hotová. RO telemetria stále smoke-only (2 riadky,
0 Clarity/GTM/Fastbase hits, rozpad 0/0/0). Enforced `'unsafe-inline'`
ponechané. Ship: tighten dialysis centre / membrane / cykler synonym
piles + scanner rules. Product SHA `e2b7d37` (docs tip nasleduje).
Grok/XAI MCP kanál pre NephroSite neexistuje; žiadna inventovaná Grok
analýza.

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates,
  0 Clarity/GTM/Fastbase vendor hits (0/0/0).
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped; Lipton /
  homepage-dative / privacy/cookie/Amazon / nefamb / purifikacia GvHD /
  EN gloss / dwell-time / ľadvina+KTx untouched.
- `files/dialyza.html` + `segments/dialyza.html`:
  drop `(stredisku, stacionári)`; simplify peritoneum membrane pile to
  `peritoneálna membrána (pobrušnica)`; drop cykler `"cyklovač"` + long
  parenthetical (APD text already explains).
- Extended `tools/scan-patient-copy.ps1` with four dialyza synonym rules;
  README note. Intro `pobrušnicu, ktorá sa nazýva peritoneum` kept.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  vendor hits 0 (Clarity 0, GTM/GA 0, Fastbase 0); keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: `powershell -File .\tools\scan-blank-hints.ps1` → 0/0/0
- Command: `powershell -File .\tools\scan-patient-copy.ps1` → 0 hits
- Command: commit `e2b7d37`; post-commit SFTP uploaded dialyza
  files/segments (tools skipped by deployignore); `deploy.ps1 -Apply`
  → 0 upload; smoke direct 200
- Command: GHA Deploy `42139556740` success (rsync skipped)
- Command: production Chrome UA `/dialyza` → `stredisku, stacionári` /
  `peritoneálna membrána - peritoneum` / `cyklovač` absent; wording
  `v dialyzačnom centre` + `peritoneálna membrána` (pobrušnica) present;
  `/` `/privacy` `/terms` `/nefrologia` `/transplantacia` `/purifikacia`
  → 200 + HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.

## Remaining Work

- [ ] Loop #71: re-run `csp-report-summary.ps1` (+ blank-hints +
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
      dialyza-transplant EN gloss / purifikacia-GvHD / dialyza dwell-time /
      nefamb synonym piles / ľadvina+KTx piles / práve-shipnutý dialyza
      centre/membrane/cykler piles; pick another verified
      patient-copy/a11y/tooling (candidate: purifikácia očisťovanie /
      membrane synonym pile).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; Clarity/GTM/Fastbase hits = 0.
- Decision: Ship dialysis centre / membrane / cykler synonym-pile cleanup
  + scanner rules (`files` + `segments`).
- Reason: Same class as prior synonym piles but distinct from EN gloss /
  dwell-time / ľadvina; APD paragraph already explains cykler function.
- Decision: Leave ASN/ISN, remote-only, GH secrets, intro Bory, Lipton,
  privacy/terms/cookie, Amazon, homepage dative, nefamb, purifikacia
  očisťovanie pile, intro peritoneum educational gloss untouched.
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

- `files/dialyza.html`, `segments/dialyza.html`
- `tools/scan-patient-copy.ps1`, `tools/README.md`
- `tools/scan-blank-hints.ps1`
- `SESSION.md`, `.audit.md` (Beh #81)
- `tools/deploy.ps1`, `tools/csp-report-summary.ps1`

## Recent Commits

- e2b7d37 Tighten dialysis centre, membrane, and cykler synonym piles for clearer patient copy.
- 02e74a5 Document loop #69 ľadvina and KTx acronym-pile cleanup after smoke-only CSP telemetry.
- c757872 Drop redundant ľadvina glosses and unused KTx/RTx/NTx acronym pile from dialysis and transplant patient copy.
- 99c5be8 Document loop #68 nefamb synonym-pile cleanup after smoke-only CSP telemetry.
- ae3863f Tighten nefamb diagnosis and lab synonym piles for clearer patient copy.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #81)
- `.doaudit.md`
- `.codex/handoffs/2026-11-06-015100-loop70-dialyza-synonym-piles.md`
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
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-06-015100-loop70-dialyza-synonym-piles.md.
Pokračuj loop #71 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence (+ Clarity/GTM súčet aj rozpad Clarity/GTM-GA/Fastbase); remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Nie Lipton jedinec. Vyhni sa tip-SHA / privacy/terms/cookie/intro-Amazon/Lipton/homepage-dative/dialyza-transplant EN gloss/purifikacia-GvHD/dialyza dwell-time/nefamb synonym piles/ľadvina+KTx piles/práve-shipnutý dialyza centre-membrane-cykler piles churn. Kandidát: purifikácia očisťovanie/membrane pile. Spusti aj scan-blank-hints.ps1 a scan-patient-copy.ps1.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php; powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-blank-hints.ps1; powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-patient-copy.ps1
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
