# Handoff: loop34-nefamb-usgo-tx-wording

## Metadata

- Generated At: 2026-11-05T22:45:59+01:00
- Updated At: 2026-11-05T22:47:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: a20ee57

## Original Goal

Loop iterácia #34: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix; 1 product + 1
docs commit; commit/push/deploy/smoke; SESSION + handoff.

## Current State

Iterácia #34 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: Slovak wording fixes in nefamb, usgo,
transplantacia (`files/`). Repo na `main` @ `a20ee57` (product; docs tip
nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Site-wide live blank-miss = 0; ASN/ISN polish skipped; intro Bory left
  commented.
- Patched `files/nefamb.html`: `učí`→`určí`, `seba-obsluhy`→
  `starostlivosti o seba`, `Za účelom`→`Na posúdenie`,
  `najoptimálnejšie`→`najlepšie`, `Výučba a edukácia`→`Vzdelávanie`.
- Patched `files/usgo.html`: `sestrička`→`sestra`.
- Patched `files/transplantacia.html`: `sestričky`→`sestry`,
  `umožnilo prenos`→`umožnil prenos`.
- Left remote-only untouched; no GH secrets.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `a20ee57`; post-commit SFTP uploaded nefamb/usgo/
  transplantacia; `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42115452187` success (rsync skipped)
- Command: production Chrome UA `/nefamb` `/usgo` `/transplantacia` →
  fixed strings present; old forms absent; `/` `/privacy` `/terms`
  `/nefrologia` `/nefamb` `/usgo` `/transplantacia` → 200 + HSTS + CSP
  still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: further brand polish only if official `<title>` includes
  the acronym (ASN/ISN currently do not).

## Remaining Work

- [ ] Loop #35: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; further `files/`/`segments/` wording).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship nefamb typo/register/calque fixes plus usgo/tx register
  and agreement this tick (not ASN/ISN promo).
- Reason: Blank-miss = 0; `učí`→`určí` was a clear meaning defect;
  verified wording defects beat speculative promo polish.
- Decision: No `segments/` sync needed for these strings (no matching
  segment copy for the patched passages).
- Reason: Homepage usgo/transplantacia segments omit the intro lines
  that contained `sestrička` / agreement defects.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `files/nefamb.html`, `files/usgo.html`, `files/transplantacia.html`
- `SESSION.md`, `.audit.md` (Beh #45)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- a20ee57 Fix Slovak wording on nefamb, usgo, and transplantacia pages.
- 71b4c20 Document loop #33 nefamb/usgo grammar and keep unsafe-inline after smoke-only CSP telemetry.
- ba62522 Fix Slovak grammar in nefamb and usgo pages.
- 9bbb5c9 Document loop #32 lipton-tx typo fixes and keep unsafe-inline after smoke-only CSP telemetry.
- fe4df5c Fix transcription typos in lipton-tx excerpt.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #45)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-224559-loop34-nefamb-usgo-tx-wording.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-224559-loop34-nefamb-usgo-tx-wording.md.
Pokračuj loop #35 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu).
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
