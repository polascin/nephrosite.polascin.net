# Handoff: loop60-a11y-blank-hints-cookie-footer

## Metadata

- Generated At: 2026-11-06T00:54:16+01:00
- Updated At: 2026-11-06T00:55:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 4c73a54

## Original Goal

Loop iterácia #60: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence + Clarity/GTM safety
(súčet aj rozpad); remote-only nemazať; nevyvárať GH secrets; preferovať
tooling/a11y alebo patient-copy mimo tip-SHA / IgAN / USG /
nefamb+lectures / dialyza-transplant-ipvrm-purifikacia-nefrologia /
práve-shipnutý privacy/terms churn; 1 product + 1 docs commit;
commit/push/deploy/smoke; SESSION + handoff. Nie Lipton `jedinec`.

## Current State

Iterácia #60 hotová. RO telemetria stále smoke-only (2 riadky,
0 Clarity/GTM/Fastbase hits, rozpad 0/0/0). Enforced `'unsafe-inline'`
ponechané. Ship: `tools/scan-blank-hints.ps1` + cookie banner footer
consent wording. Product SHA `4c73a54` (docs tip nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates,
  0 Clarity/GTM/Fastbase vendor hits (0/0/0).
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped (official titles still
  without acronym); Lipton `jedinec` untouched; privacy/terms + tip-path
  topics untouched.
- Added `tools/scan-blank-hints.ps1`: strip comments, full-anchor
  `_blank` hint check, download-claim without `download`, live `<img>`
  without `alt` (skip PHP regex false positives); documented in
  `tools/README.md`.
- Patched `blocks/cookie-banner.sk.php`: `pätu obsahových stránok` /
  `stránku súkromia` → `pätičku stránky` / `zásady ochrany súkromia`.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  vendor hits 0 (Clarity 0, GTM/GA 0, Fastbase 0); keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: `powershell -File .\tools\scan-blank-hints.ps1` → 0/0/0 misses
- Command: commit `4c73a54`; post-commit SFTP uploaded
  `blocks/cookie-banner.sk.php` (tools skipped by deployignore);
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42132769594` success (rsync skipped)
- Command: production Chrome UA `/` → `pätičku stránky` +
  `cez zásady ochrany súkromia`; old phrases absent;
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

- [ ] Loop #61: re-run `csp-report-summary.ps1` (+ `scan-blank-hints.ps1`);
      drop `'unsafe-inline'` only with strong evidence (+ Clarity/GTM
      consent paths; watch total and Clarity/GTM-GA/Fastbase breakdown).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; not Lipton `jedinec`). Avoid tip-SHA /
      IgAN / USG / nefamb+lectures / dialyza-transplant-ipvrm-
      purifikacia-nefrologia / práve-shipnutý privacy/terms/cookie-banner
      churn; prefer another verified patient-copy defect outside tip path
      or further tooling.

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; Clarity/GTM/Fastbase hits = 0.
- Decision: Ship blank-hint a11y scanner + cookie footer wording instead
  of tip-path / privacy/terms churn.
- Reason: Naive blank scans false-positive late `sr-only` (e.g. regcitra
  PDF card); durable tool encodes SESSION lessons. Cookie banner pointed
  to awkward „päta obsahových stránok“ / „stránka súkromia“ instead of
  footer + privacy policy names.
- Decision: Leave ASN/ISN, remote-only, GH secrets, intro Bory,
  Lipton `jedinec`, privacy/terms, tip-path topics untouched.
- Reason: Same standing constraints; ASN/ISN official titles still lack
  acronym suffixes.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `blocks/cookie-banner.sk.php`
- `tools/scan-blank-hints.ps1`, `tools/README.md`
- `SESSION.md`, `.audit.md` (Beh #71)
- `tools/deploy.ps1`, `tools/csp-report-summary.ps1`

## Recent Commits

- 4c73a54 Add blank-hint a11y scanner and clarify cookie footer consent wording.
- dcf1ec1 Document loop #59 terms GPC/DNT mirror and CSP vendor-hit breakdown after smoke-only telemetry.
- 30e8d74 Align terms with GPC/DNT necessary-only default; break out CSP vendor hit counters.
- 8ac0862 Document loop #58 privacy GPC/DNT and CSP vendor-hit tooling after smoke-only telemetry.
- f3a407e Document GPC/DNT defaults and category-gated vendors in privacy; flag Clarity/GTM hits in CSP summary.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #71)
- `.doaudit.md`
- `.codex/handoffs/2026-11-06-005416-loop60-a11y-blank-hints-cookie-footer.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`, `tools/scan-blank-hints.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-blank-hints.ps1
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-06-005416-loop60-a11y-blank-hints-cookie-footer.md.
Pokračuj loop #61 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence (+ Clarity/GTM súčet aj rozpad Clarity/GTM-GA/Fastbase); remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Nie Lipton jedinec. Vyhni sa tip-SHA / IgAN / USG / nefamb+lectures / dialyza-transplant-ipvrm-purifikacia-nefrologia / práve-shipnutý privacy/terms/cookie-banner churn. Kandidát: overený patient-copy defect mimo tip path alebo ďalší tooling.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php; powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-blank-hints.ps1
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
