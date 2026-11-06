# Handoff: loop66-purifikacia-gvhd-gloss

## Metadata

- Generated At: 2026-11-06T01:30:22+01:00
- Updated At: 2026-11-06T01:31:00+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 8bf6880

## Original Goal

Loop iterácia #66: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence + Clarity/GTM safety
(súčet aj rozpad); remote-only nemazať; nevyvárať GH secrets; preferovať
verified non-tip-path patient-copy alebo tooling mimo tip-SHA / privacy /
terms / cookie / intro-Amazon / Lipton / homepage-dative / práve-shipnutý
EN-gloss dialyza-transplant churn; 1 product + 1 docs commit;
commit/push/deploy/smoke; SESSION + handoff. Nie Lipton `jedinec`.
Grok: ak nie je NephroSite kanál, len krátko poznamenať.

## Current State

Iterácia #66 hotová. RO telemetria stále smoke-only (2 riadky,
0 Clarity/GTM/Fastbase hits, rozpad 0/0/0). Enforced `'unsafe-inline'`
ponechané. Ship: redundantný EN gloss `graft-versus-host disease` v
purifikácii (SK term + GvHD akronym ostávajú) + scanner rule. Product
SHA `8bf6880` (docs tip nasleduje). Grok/XAI MCP kanál pre NephroSite
neexistuje; žiadna inventovaná Grok analýza.

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates,
  0 Clarity/GTM/Fastbase vendor hits (0/0/0).
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped; Lipton /
  homepage-dative / privacy/cookie/Amazon / dialyza-transplant EN glosses
  untouched.
- Removed redundant EN full name after Slovak GvHD term in
  `files|segments/purifikacia.html`; kept `(GvHD)` and
  `mycosis fungoides`.
- Extended `tools/scan-patient-copy.ps1` with `graft-versus-host disease`;
  README note.
- Noted candidate for later: dialyza `"dwell time"` teda `čas pôsobenia`
  (same EN-gloss class; left alone to avoid dialyza tip churn).

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  vendor hits 0 (Clarity 0, GTM/GA 0, Fastbase 0); keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: `powershell -File .\tools\scan-blank-hints.ps1` → 0/0/0
- Command: `powershell -File .\tools\scan-patient-copy.ps1` → 0 hits
- Command: commit `8bf6880`; post-commit SFTP uploaded purifikacia
  files+segments (tools skipped by deployignore); `deploy.ps1 -Apply` →
  0 upload; smoke direct 200
- Command: GHA Deploy `42137216341` success (rsync skipped)
- Command: production Chrome UA `/purifikacia` and `/` →
  `chronická reakcia štepu proti hostiteľovi (GvHD)` present;
  `graft-versus-host disease` absent; `mycosis fungoides` kept;
  `/` `/privacy` `/terms` `/dialyza` `/nefrologia` → 200 + HSTS + CSP
  still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented;
  dialyza `"dwell time"` left for a later loop.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Candidate: CAPD `"dwell time"` EN gloss in dialyza files/segments.

## Remaining Work

- [ ] Loop #67: re-run `csp-report-summary.ps1` (+ blank-hints +
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
      dialyza-transplant EN gloss / práve-shipnutý purifikacia-GvHD churn;
      kandidát: dialyza `"dwell time"` → `čas pôsobenia`, or another
      verified patient-copy/tooling outside tip path.

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; Clarity/GTM/Fastbase hits = 0.
- Decision: Ship GvHD EN gloss cleanup in purifikacia + scanner rule
  (new tip path; same defect class as prior EN parentheticals).
- Reason: Slovak term already present; English full name redundant next
  to GvHD acronym; Latin `mycosis fungoides` kept per SESSION.
- Decision: Leave dialyza `"dwell time"`, ASN/ISN, remote-only, GH
  secrets, intro Bory, Lipton, privacy/terms/cookie, Amazon, homepage
  dative untouched.
- Reason: Avoid tip churn on just-shipped dialyza-transplant; dwell time
  is a good #67 candidate.
- Decision: No Grok collaboration text.
- Reason: No NephroSite Grok/XAI channel/tools available; do not invent.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `files/purifikacia.html`, `segments/purifikacia.html`
- `tools/scan-patient-copy.ps1`, `tools/README.md`
- `tools/scan-blank-hints.ps1`
- `SESSION.md`, `.audit.md` (Beh #77)
- `tools/deploy.ps1`, `tools/csp-report-summary.ps1`

## Recent Commits

- 8bf6880 Remove redundant English GvHD gloss from blood purification patient copy.
- 4201d99 Document loop #65 EN gloss cleanup and patient-copy scanner after smoke-only CSP telemetry.
- c406b84 Remove redundant English glosses from dialysis and transplant patient copy.
- 429e7d8 Document loop #64 homepage dative and patient-copy scanner after smoke-only CSP telemetry.
- 23ac8a3 Fix homepage dative agreement and extend patient-copy regression rules.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #77)
- `.doaudit.md`
- `.codex/handoffs/2026-11-06-013022-loop66-purifikacia-gvhd-gloss.md`
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
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-06-013022-loop66-purifikacia-gvhd-gloss.md.
Pokračuj loop #67 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence (+ Clarity/GTM súčet aj rozpad Clarity/GTM-GA/Fastbase); remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Nie Lipton jedinec. Vyhni sa tip-SHA / privacy/terms/cookie/intro-Amazon/Lipton/homepage-dative/dialyza-transplant EN gloss/práve-shipnutý purifikacia-GvHD churn. Kandidát: dialyza "dwell time" → čas pôsobenia (files+segments + scanner) alebo iný overený patient-copy/tooling mimo tip path. Spusti aj scan-blank-hints.ps1 a scan-patient-copy.ps1.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php; powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-blank-hints.ps1; powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\scan-patient-copy.ps1
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
