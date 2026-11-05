# Handoff: loop35-dialyza-nefrologia-wording

## Metadata

- Generated At: 2026-11-05T22:53:40+01:00
- Updated At: 2026-11-05T22:54:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 380ec5a

## Original Goal

Loop iterácia #35: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix; 1 product + 1
docs commit; commit/push/deploy/smoke; SESSION + handoff.

## Current State

Iterácia #35 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: Slovak wording fixes in dialyza and
nefrologia (`files/` + `segments/`). Product SHA `380ec5a` (docs tip
nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped.
- Patched `files/dialyza.html`: `sestričiek`→`sester`,
  `pochádzajúcimi s vedeckého`→`z vedeckého`.
- Patched `segments/dialyza.html`: `s vedeckého`→`z vedeckého`.
- Patched `files/nefrologia.html` + `segments/nefrologia.html`:
  `detekciu abnormalít`→`odhalenie abnormalít`,
  `malého vzorku`→`malej vzorky`, relative `ktorý`→`ktorá`.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `380ec5a`; post-commit SFTP uploaded dialyza/nefrologia
  files+segments; `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42116271613` success (rsync skipped)
- Command: production Chrome UA `/dialyza` `/nefrologia` `/` → fixed
  strings present; old forms absent; `/` `/privacy` `/terms`
  `/nefrologia` `/dialyza` `/nefamb` `/usgo` `/transplantacia` → 200 +
  HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: further brand polish only if official `<title>` includes
  the acronym (ASN/ISN currently do not).

## Remaining Work

- [ ] Loop #36: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; further `files/`/`segments/` wording,
      e.g. `z dôvodu` / `viacero` register, CAPD `4-5 krát`→`4-5-krát`).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship dialyza/nefrologia grammar this tick (not ASN/ISN promo).
- Reason: Clear defects: deminutive `sestričiek`, wrong preposition
  `s vedeckého`, feminine agreement `vzorka`, calque `detekciu`.
- Decision: Sync matching `segments/` for both pages.
- Reason: Homepage includes `segments/nefrologia.html` and
  `segments/dialyza.html`.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `files/dialyza.html`, `segments/dialyza.html`
- `files/nefrologia.html`, `segments/nefrologia.html`
- `SESSION.md`, `.audit.md` (Beh #46)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 380ec5a Fix Slovak wording on dialyza and nefrologia pages.
- ba30f78 Document loop #34 wording fixes and keep unsafe-inline after smoke-only CSP telemetry.
- a20ee57 Fix Slovak wording on nefamb, usgo, and transplantacia pages.
- 71b4c20 Document loop #33 nefamb/usgo grammar and keep unsafe-inline after smoke-only CSP telemetry.
- ba62522 Fix Slovak grammar in nefamb and usgo pages.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #46)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-225340-loop35-dialyza-nefrologia-wording.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-225340-loop35-dialyza-nefrologia-wording.md.
Pokračuj loop #36 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu).
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
