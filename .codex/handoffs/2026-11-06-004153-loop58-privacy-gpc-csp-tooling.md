# Handoff: loop58-privacy-gpc-csp-tooling

## Metadata

- Generated At: 2026-11-06T00:41:53+01:00
- Updated At: 2026-11-06T00:43:00+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: f3a407e

## Original Goal

Loop iterácia #58: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence + Clarity/GTM safety;
remote-only nemazať; nevyvárať GH secrets; preferovať legal/tooling
(vyhnúť sa tip-SHA / IgAN / USG / nefamb+lectures /
dialyza-transplant-ipvrm-purifikacia-nefrologia churn); 1 product +
1 docs commit; commit/push/deploy/smoke; SESSION + handoff. Nie Lipton
`jedinec`.

## Current State

Iterácia #58 hotová. RO telemetria stále smoke-only (2 riadky,
0 Clarity/GTM/vendor hits). Enforced `'unsafe-inline'` ponechané.
Ship: privacy GPC/DNT + category-gated vendors + status wording;
CSP summary Clarity/GTM vendor hit counter. Product SHA `f3a407e`
(docs tip nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates,
  0 Clarity/GTM/vendor hits.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped; Lipton `jedinec`
  untouched; tip-path topics untouched.
- Patched `files/privacy.html`: document GPC/DNT necessary-only default;
  clarify Clarity/GA = analytics and Fastbase = marketing categories;
  align static consent status `nezistený` → `neuložený`; bump date
  06.11.2026.
- Patched `tools/csp-report-summary.ps1`: count Clarity/GTM/Fastbase
  blocked-uri hits; stronger verdict when real candidates lack vendor
  evidence.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  Clarity/GTM/vendor hits 0; keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `f3a407e`; post-commit SFTP uploaded `files/privacy.html`
  (tools skipped by deployignore); `deploy.ps1 -Apply` → 0 upload;
  smoke direct 200
- Command: GHA Deploy `42131253146` success (rsync skipped)
- Command: production Chrome UA `/privacy` → `06.11.2026`,
  `Global Privacy Control`, `neuložený`, `analytické cookies`,
  `marketingové cookies`, `Bez súhlasu s danou kategóriou`;
  `nezistený` absent; `/` `/privacy` `/terms` `/nefrologia` `/dialyza`
  `/nefamb` `/usgo` `/transplantacia` `/purifikacia` → 200 + HSTS +
  CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.

## Remaining Work

- [ ] Loop #59: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths; now also
      watch vendor hit counter).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; not Lipton `jedinec`). Avoid tip-SHA /
      IgAN / USG / nefamb+lectures / dialyza-transplant-ipvrm-
      purifikacia-nefrologia / práve-shipnutý privacy churn; prefer
      another verified legal/tooling or patient-copy defect outside tip
      path.

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; Clarity/GTM/vendor hits = 0.
- Decision: Ship privacy legal transparency + CSP summary vendor counter
  instead of tip-path wording churn.
- Reason: Cookie banner already claimed GPC/DNT respect but privacy
  policy omitted it; vendor list lacked category gating; static consent
  status disagreed with JS (`nezistený` vs `neuložený`).
- Decision: Leave ASN/ISN, remote-only, GH secrets, intro Bory,
  Lipton `jedinec`, tip-path topics untouched.
- Reason: Same standing constraints as prior loops.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `files/privacy.html`
- `tools/csp-report-summary.ps1`, `tools/README.md`
- `SESSION.md`, `.audit.md` (Beh #69)
- `tools/deploy.ps1`

## Recent Commits

- f3a407e Document GPC/DNT defaults and category-gated vendors in privacy; flag Clarity/GTM hits in CSP summary.
- f633d7d Document loop #57 purifikacia/nefrologia wording and keep unsafe-inline after smoke-only CSP telemetry.
- 6302a13 Fix purifikacia and nefrologia wording: fotosenzibilizujuca latka, GvHD, diagnostika.
- 6f16c79 Document loop #56 dialyza/transplant/ipvrm wording and keep unsafe-inline after smoke-only CSP telemetry.
- a15c074 Fix dialyza, transplant and ipvrm wording: u vacsiny, uprava liekov, cykler, priestor.

## Modified Files

- After docs commit: SESSION.md, .audit.md, tools/README.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #69)
- `.doaudit.md`
- `.codex/handoffs/2026-11-06-004153-loop58-privacy-gpc-csp-tooling.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-06-004153-loop58-privacy-gpc-csp-tooling.md.
Pokračuj loop #59 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence (+ Clarity/GTM vendor hit counter); remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Nie Lipton jedinec. Vyhni sa tip-SHA / IgAN / USG / nefamb+lectures / dialyza-transplant-ipvrm-purifikacia-nefrologia / práve-shipnutý privacy churn. Kandidát: legal/tooling alebo ďalší overený patient-copy defect mimo tip path.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
