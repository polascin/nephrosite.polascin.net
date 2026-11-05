# Handoff: loop55-nefamb-lectures-zobrazenie

## Metadata

- Generated At: 2026-11-06T00:21:41+01:00
- Updated At: 2026-11-06T00:22:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: dd33d8e

## Original Goal

Loop iterácia #55: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-IgAN/USG product fix (wording/
tooling mimo tip churn); 1 product + 1 docs commit; commit/push/deploy/
smoke; SESSION + handoff. Nie Lipton `jedinec`.

## Current State

Iterácia #55 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. a11y blank scan 0 misses. Ship: nefamb
`zobrazenie` / `správneho odberu` / čiarka pred `patria` + lectures
`V kurze` / `Na zasadnutí`. Product SHA `dd33d8e` (docs tip nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped; Lipton `jedinec`
  untouched; IgAN/USG tip path untouched; nefamb ABPM untouched.
- a11y `_blank`/sr-only scan after strip comments → 0 misses.
- Patched `files/nefamb.html`: comma before `patria`; `vizualizáciu` →
  `zobrazenie`; `adekvátneho odberu` → `správneho odberu`.
- Patched `blocks/lectures.sk.php`: `V rámci kurzu` → `V kurze` (4×);
  `V rámci zasadnutia` → `Na zasadnutí`.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `dd33d8e`; post-commit SFTP uploaded nefamb + lectures;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42128845409` success (rsync skipped)
- Command: production Chrome UA `/nefamb` → new wording present, old
  forms absent; `/` → `V kurze` ×4 + `Na zasadnutí` present;
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

- [ ] Loop #56: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; not Lipton `jedinec`). Avoid tip-SHA
      / IgAN / USG / nefamb+lectures churn; prefer dialyza/transplant/
      purifikacia/ipvrm/legal/tooling.

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship nefamb grammar/anglicisms + lectures `V rámci` fixes
  instead of a11y (scan clean) or IgAN/USG tip polish.
- Reason: Clear verified Slovak defects outside churn paths; medical
  facts unchanged; ABPM name left intact.
- Decision: Leave ASN/ISN, remote-only, GH secrets, intro Bory,
  Lipton `jedinec`, IgAN/USG untouched.
- Reason: Same standing constraints as prior loops.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `files/nefamb.html`, `blocks/lectures.sk.php`
- `SESSION.md`, `.audit.md` (Beh #66)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- dd33d8e Fix nefamb and lectures wording: zobrazenie, spravny odber, V kurze.
- e1dee07 Document loop #54 USG odpoveda/odovzdaju and keep unsafe-inline after smoke-only CSP telemetry.
- 8d8e2be Fix USG patient wording: odpoveda and odovzdaju instead of zodpoveda/zdielaju.
- 9d34cba Document loop #53 IgAN zdravotnej politike and keep unsafe-inline after smoke-only CSP telemetry.
- 08338a1 Fix IgAN patient wording: zdravotnej politike instead of politickych zmien.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #66)
- `.doaudit.md`
- `.codex/handoffs/2026-11-06-002141-loop55-nefamb-lectures-zobrazenie.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-06-002141-loop55-nefamb-lectures-zobrazenie.md.
Pokračuj loop #56 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Nie Lipton jedinec. Vyhni sa tip-SHA / IgAN / USG / nefamb+lectures churn. Kandidát: dialyza/transplant/purifikacia/ipvrm/legal/tooling.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
