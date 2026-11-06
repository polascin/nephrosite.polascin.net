# Handoff: loop64-homepage-dative-agreement

## Metadata

- Generated At: 2026-11-06T01:18:41+01:00
- Updated At: 2026-11-06T01:19:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 23ac8a3

## Original Goal

Loop iterácia #64: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence + Clarity/GTM safety
(súčet aj rozpad); remote-only nemazať; nevyvárať GH secrets; preferovať
verified non-tip-path patient-copy alebo tooling mimo tip-SHA / IgAN /
USG / nefamb+lectures / dialyza-transplant-ipvrm-purifikacia-nefrologia /
práve-shipnutý privacy/terms/cookie/intro-Amazon/Lipton-genitive /
Lipton-literary-wording churn; 1 product + 1 docs commit;
commit/push/deploy/smoke; SESSION + handoff. Nie Lipton `jedinec`.

## Current State

Iterácia #64 hotová. RO telemetria stále smoke-only (2 riadky,
0 Clarity/GTM/Fastbase hits, rozpad 0/0/0). Enforced `'unsafe-inline'`
ponechané. Ship: homepage dative agreement (`všeobecne medicíne` →
`všeobecnej medicíne`) + scanner rules for that defect and several
SESSION tip-path lessons still missing from the regression set.
Product SHA `23ac8a3` (docs tip nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates,
  0 Clarity/GTM/Fastbase vendor hits (0/0/0).
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped; Lipton `jedinec`
  and literary/genitive wording untouched; tip-path topics +
  privacy/terms/cookie/intro-Amazon untouched.
- Patched `blocks/ns.sk.php`: `všeobecne medicíne` → `všeobecnej medicíne`
  (dative adjective agreement parallel to `internej medicíne`).
- Extended `tools/scan-patient-copy.ps1` with `všeobecne medicíne` plus
  durable SESSION patterns still missing from the ruleset
  (`pochádzajúcimi s`, `prispôsobenie životného`, `prispôsobeniu liekov`,
  `zabezpečenie hygieny potravín`, `v rámci glomerul`, `pre ľudia`,
  `umožnilo prenos`); README note.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  vendor hits 0 (Clarity 0, GTM/GA 0, Fastbase 0); keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: `powershell -File .\tools\scan-blank-hints.ps1` → 0/0/0
- Command: `powershell -File .\tools\scan-patient-copy.ps1` → 0 hits
- Command: commit `23ac8a3`; post-commit SFTP uploaded `blocks/ns.sk.php`
  (tools skipped by deployignore); `deploy.ps1 -Apply` → 0 upload;
  smoke direct 200
- Command: GHA Deploy `42135777717` success (rsync skipped)
- Command: production Chrome UA `/` → `všeobecnej medicíne` present;
  old `všeobecne medicíne` absent; `/` `/privacy` `/terms` `/nefrologia`
  `/dialyza` `/nefamb` `/usgo` `/transplantacia` `/purifikacia`
  `/lipton-tx` → 200 + HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.

## Remaining Work

- [ ] Loop #65: re-run `csp-report-summary.ps1` (+ blank-hints +
      patient-copy scans); drop `'unsafe-inline'` only with strong
      evidence (+ Clarity/GTM consent paths; watch total and
      Clarity/GTM-GA/Fastbase breakdown).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; not Lipton `jedinec`). Avoid tip-SHA /
      IgAN / USG / nefamb+lectures / dialyza-transplant-ipvrm-
      purifikacia-nefrologia / práve-shipnutý privacy/terms/cookie /
      intro-Amazon / Lipton-genitive / Lipton-literary-wording /
      homepage-dative churn; prefer another verified patient-copy defect
      outside tip path or further tooling.

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; Clarity/GTM/Fastbase hits = 0.
- Decision: Ship homepage dative agreement + scanner rules instead of
  tip-path / privacy/terms/cookie / intro-Amazon / Lipton churn.
- Reason: High-confidence SK defect outside tip path (`všeobecne`
  adverb vs required dative adjective `všeobecnej` parallel to
  `internej medicíne`); scanner encodes that fix and remaining SESSION
  tip-path lessons as durable regressions.
- Decision: Leave ASN/ISN, remote-only, GH secrets, intro Bory,
  Lipton `jedinec`, tip-path topics, privacy/terms/cookie, intro Amazon,
  Lipton genitive/literary wording untouched.
- Reason: Same standing constraints; ASN/ISN official titles still lack
  acronym suffixes.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `blocks/ns.sk.php`
- `tools/scan-patient-copy.ps1`, `tools/README.md`
- `tools/scan-blank-hints.ps1`
- `SESSION.md`, `.audit.md` (Beh #75)
- `tools/deploy.ps1`, `tools/csp-report-summary.ps1`

## Recent Commits

- 23ac8a3 Fix homepage dative agreement and extend patient-copy regression rules.
- d2f41ba Document loop #63 Lipton literary wording and patient-copy scanner after smoke-only CSP telemetry.
- 0b31d04 Fix Lipton literary wording and extend patient-copy regression rules.
- 0d0a646 Document loop #62 Lipton genitive and patient-copy scanner after smoke-only CSP telemetry.
- 3f96767 Fix Lipton genitive wording and extend patient-copy regression rules.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #75)
- `.doaudit.md`
- `.codex/handoffs/2026-11-06-011841-loop64-homepage-dative-agreement.md`
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
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-06-011841-loop64-homepage-dative-agreement.md.
Pokračuj loop #65 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence (+ Clarity/GTM súčet aj rozpad Clarity/GTM-GA/Fastbase); remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Nie Lipton jedinec. Vyhni sa tip-SHA / IgAN / USG / nefamb+lectures / dialyza-transplant-ipvrm-purifikacia-nefrologia / práve-shipnutý privacy/terms/cookie/intro-Amazon/Lipton-genitive/Lipton-literary-wording/homepage-dative churn. Kandidát: overený patient-copy defect mimo tip path alebo ďalší tooling. Spusti aj scan-blank-hints.ps1 a scan-patient-copy.ps1.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php; powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-blank-hints.ps1; powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-patient-copy.ps1
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
