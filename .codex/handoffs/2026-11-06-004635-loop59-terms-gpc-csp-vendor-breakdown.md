# Handoff: loop59-terms-gpc-csp-vendor-breakdown

## Metadata

- Generated At: 2026-11-06T00:46:35+01:00
- Updated At: 2026-11-06T00:47:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 30e8d74

## Original Goal

Loop iterácia #59: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence + Clarity/GTM safety;
remote-only nemazať; nevyvárať GH secrets; preferovať legal/tooling
(vyhnúť sa tip-SHA / IgAN / USG / nefamb+lectures /
dialyza-transplant-ipvrm-purifikacia-nefrologia / práve-shipnutý privacy
churn); 1 product + 1 docs commit; commit/push/deploy/smoke; SESSION +
handoff. Nie Lipton `jedinec`.

## Current State

Iterácia #59 hotová. RO telemetria stále smoke-only (2 riadky,
0 Clarity/GTM/Fastbase hits, rozpad 0/0/0). Enforced `'unsafe-inline'`
ponechané. Ship: terms GPC/DNT necessary-only mirror + CSP summary
vendor breakdown. Product SHA `30e8d74` (docs tip nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates,
  0 Clarity/GTM/Fastbase vendor hits.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped; Lipton `jedinec`
  untouched; privacy + tip-path topics untouched.
- Patched `files/terms.html`: section 10 mirrors privacy GPC/DNT
  necessary-only default when signal present and no stored choice;
  bump date 06.11.2026.
- Patched `tools/csp-report-summary.ps1`: print Clarity / GTM-GA /
  Fastbase breakdown under the vendor-hit total.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  vendor hits 0 (Clarity 0, GTM/GA 0, Fastbase 0); keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `30e8d74`; post-commit SFTP uploaded `files/terms.html`
  (tools skipped by deployignore); `deploy.ps1 -Apply` → 0 upload;
  smoke direct 200
- Command: GHA Deploy `42131843174` success (rsync skipped)
- Command: production Chrome UA `/terms` → `06.11.2026`,
  `Global Privacy Control`, `Do Not Track`, `nevyhnutné cookies`,
  `Nastavenie cookies`; `/` `/privacy` `/terms` `/nefrologia` `/dialyza`
  `/nefamb` `/usgo` `/transplantacia` `/purifikacia` → 200 + HSTS +
  CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.

## Remaining Work

- [ ] Loop #60: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths; watch
      total and Clarity/GTM-GA/Fastbase breakdown).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; not Lipton `jedinec`). Avoid tip-SHA /
      IgAN / USG / nefamb+lectures / dialyza-transplant-ipvrm-
      purifikacia-nefrologia / práve-shipnutý privacy/terms churn;
      prefer tooling/a11y or another verified patient-copy defect
      outside tip path.

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; Clarity/GTM/Fastbase hits = 0.
- Decision: Ship terms GPC/DNT legal mirror + CSP vendor breakdown
  instead of tip-path wording churn.
- Reason: Terms cookies section pointed to privacy but omitted the
  GPC/DNT necessary-only default already documented in privacy and
  claimed by the cookie banner; CSP tooling needed per-vendor detail.
- Decision: Leave ASN/ISN, remote-only, GH secrets, intro Bory,
  Lipton `jedinec`, privacy, tip-path topics untouched.
- Reason: Same standing constraints as prior loops; privacy was just
  shipped in #58.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `files/terms.html`
- `tools/csp-report-summary.ps1`, `tools/README.md`
- `SESSION.md`, `.audit.md` (Beh #70)
- `tools/deploy.ps1`

## Recent Commits

- 30e8d74 Align terms with GPC/DNT necessary-only default; break out CSP vendor hit counters.
- 8ac0862 Document loop #58 privacy GPC/DNT and CSP vendor-hit tooling after smoke-only telemetry.
- f3a407e Document GPC/DNT defaults and category-gated vendors in privacy; flag Clarity/GTM hits in CSP summary.
- f633d7d Document loop #57 purifikacia/nefrologia wording and keep unsafe-inline after smoke-only CSP telemetry.
- 6302a13 Fix purifikacia and nefrologia wording: fotosenzibilizujuca latka, GvHD, diagnostika.

## Modified Files

- After docs commit: SESSION.md, .audit.md, tools/README.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #70)
- `.doaudit.md`
- `.codex/handoffs/2026-11-06-004635-loop59-terms-gpc-csp-vendor-breakdown.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-06-004635-loop59-terms-gpc-csp-vendor-breakdown.md.
Pokračuj loop #60 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence (+ Clarity/GTM súčet aj rozpad Clarity/GTM-GA/Fastbase); remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Nie Lipton jedinec. Vyhni sa tip-SHA / IgAN / USG / nefamb+lectures / dialyza-transplant-ipvrm-purifikacia-nefrologia / práve-shipnutý privacy/terms churn. Kandidát: tooling/a11y alebo ďalší overený patient-copy defect mimo tip path.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
