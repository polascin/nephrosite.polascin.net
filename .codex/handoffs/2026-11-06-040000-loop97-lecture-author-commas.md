# Handoff: loop97-lecture-author-commas

## Metadata

- Generated At: 2026-11-06T04:00:00+01:00
- Updated At: 2026-11-06T04:00:00+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: b2898ab (docs tip follows)

## Original Goal

Loop iterácia #97: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence + Clarity/GTM safety
(súčet aj rozpad); remote-only nemazať; nevyvárať GH secrets; preferovať
verified non-tip-path patient-copy/a11y/tooling mimo tip-SHA / privacy /
terms / cookie / intro-Amazon / Lipton / homepage-dative /
piles #65–#96; soft kandidát: lectures author-list commas / `HorkýTran`.
1 product + 1 docs commit; commit/push/deploy/smoke; SESSION + handoff.
Nie Lipton `jedinec`. Grok: ak nie je NephroSite kanál, len krátko
poznamenať.

## Current State

Iterácia #97 hotová. RO telemetria stále smoke-only (2 riadky,
0 Clarity/GTM/Fastbase hits, rozpad 0/0/0). Enforced `'unsafe-inline'`
ponechané. Ship: lecture author-list punctuation —
`Karel HorkýTran` → `Karel Horký` (Martinus uItem=111412 schema.org:
autori Widimský, Widimský jr., Horký, Monhart; `Tran` nie je autor);
commas medzi menami vo všetkých `Autori:` zoznamoch; `X kolektív` →
`X a kolektív` / `A, B a kolektív` v `blocks/lectures.sk.php`.
Product SHA `b2898ab` (docs tip nasleduje).
Grok/XAI MCP kanál pre NephroSite neexistuje; žiadna inventovaná Grok
analýza.

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates,
  0 Clarity/GTM/Fastbase vendor hits (0/0/0).
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped; Lipton /
  homepage-dative / privacy/cookie/Amazon / synonym piles #65–#96
  untouched.
- Preferred ship: lecture author-list formatting (HorkýTran + commas).
- `blocks/lectures.sk.php`: fix glued surname; add commas across Autori
  lists; normalize kolektív phrasing.
- Tooling: `scan-patient-copy.ps1` 1 rule `HorkýTran`; README.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  vendor hits 0 (Clarity 0, GTM/GA 0, Fastbase 0); keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: `powershell -File .\tools\scan-blank-hints.ps1` → 0/0/0
- Command: `powershell -File .\tools\scan-patient-copy.ps1` → 0 hits
- Command: Martinus GET uItem=111412 → schema.org authors confirm
  Horký (no Tran)
- Command: commit `b2898ab`; post-commit SFTP uploaded
  `blocks/lectures.sk.php` (tools skipped by deployignore);
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: production Chrome UA `/` → `HorkýTran` 0;
  `Václav Monhart, Jiří Widimský, Jiří Widimský jr., Karel Horký` ×1;
  `Teplan a kolektív` ×2; old space-only Monhart list 0;
  `/` `/ipvrm.htm` `/dialyza` `/nefamb` `/nefrologia` `/usgo`
  `/transplantacia` `/privacy` `/terms` `/purifikacia` → 200 + HSTS +
  CSP still with enforced `'unsafe-inline'`
- Command: GHA Deploy `42153684072` success (rsync skip expected)
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.

## Remaining Work

- [ ] Loop #98: re-run `csp-report-summary.ps1` (+ blank-hints +
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
      piles #65–#96 /
      práve-shipnutý lecture author commas / `HorkýTran` (#97);
      soft kandidáti: iný verified patient-copy/a11y/tooling mimo churn
      listu (dialyza beyond #65/#67/#70/#82/#94; purifikácia cell-gloss
      residual beyond #71/#96; lectures beyond #77/#95/#97; blank-hints,
      tooling).
      Spustiť `scan-blank-hints.ps1` aj `scan-patient-copy.ps1`.

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; Clarity/GTM/Fastbase hits = 0.
- Decision: Ship lecture author-list commas + Horký glue typo as
  preferred soft candidate.
- Reason: Explicit soft preference for #97; Martinus confirms authors;
  coherent outside tip-path churn; lectures already touched in #77/#95
  for other issues.
- Decision: Drop `Tran` entirely (not a missing fifth author).
- Reason: Martinus schema.org + product page list four authors only.
- Decision: Normalize all Autori lists with commas / `a kolektív` in the
  same ship.
- Reason: Same formatting defect across the lectures block; one coherent
  punctuation pass.
- Decision: Leave ASN/ISN, remote-only, GH secrets, intro Bory, Lipton,
  privacy/terms/cookie, Amazon, homepage dative, piles #65–#96
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

- `blocks/lectures.sk.php`
- `tools/scan-patient-copy.ps1`, `tools/README.md`
- `tools/scan-blank-hints.ps1`
- `SESSION.md`, `.audit.md`
- `tools/deploy.ps1`, `tools/csp-report-summary.ps1`

## Recent Commits

- b2898ab Fix lecture author lists: commas and Horký glue typo.
- 4df9847 Document loop #96 homepage synonym cleanup after smoke-only CSP telemetry.
- b3d3746 Drop homepage synonym piles for purifikácia and interná medicína.
- b1b0f6d Document loop #95 lecture spol. s r.o. cleanup after smoke-only CSP telemetry.
- 7c8018e Correct lecture company form to standard Slovak spol. s r.o.

## Modified Files

- After docs commit: SESSION.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md`
- `.doaudit.md`
- `.codex/handoffs/2026-11-06-040000-loop97-lecture-author-commas.md`
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
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-06-040000-loop97-lecture-author-commas.md.
Pokračuj loop #98 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence (+ Clarity/GTM súčet aj rozpad Clarity/GTM-GA/Fastbase); remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Nie Lipton jedinec. Vyhni sa tip-SHA / privacy/terms/cookie/intro-Amazon/Lipton/homepage-dative/piles #65–#96/práve-shipnutý lecture author commas / HorkýTran (#97) churn. Soft kandidáti: dialyza beyond #65/#67/#70/#82/#94; purifikácia cell-gloss residual beyond #71/#96; lectures beyond #77/#95/#97; blank-hints, tooling. Spustiť aj scan-blank-hints.ps1 a scan-patient-copy.ps1.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php; powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-blank-hints.ps1; powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-patient-copy.ps1
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
