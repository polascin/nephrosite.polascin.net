# Handoff: loop40-purifikacia-mycosis-nefamb

## Metadata

- Generated At: 2026-11-05T23:15:08+01:00
- Updated At: 2026-11-05T23:16:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 4a52309

## Original Goal

Loop iterácia #40: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix; 1 product +
1 docs commit; commit/push/deploy/smoke; SESSION + handoff.

## Current State

Iterácia #40 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: purifikacia `mykózny fungoides`→
`mycosis fungoides` (files + segments); nefamb AKI `v dôsledku rôznych
príčin`→`pre rôzne príčiny`. Product SHA `4a52309` (docs tip nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped.
- Patched `files/purifikacia.html` + `segments/purifikacia.html`:
  `mykózny fungoides`→`mycosis fungoides`.
- Patched `files/nefamb.html`: `v dôsledku rôznych príčin`→
  `pre rôzne príčiny`.
- Left untouched: `hyponatriémia`, `kosáčikovitá anémia`, IgAN
  `v dôsledku zníženej schopnosti`.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `4a52309`; post-commit SFTP uploaded three files;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42119769238` success (rsync skipped)
- Command: production Chrome UA `/purifikacia` + `/` → `mycosis fungoides`
  present, `mykózny fungoides` absent; `/nefamb` → `pre rôzne príčiny`
  present, old form absent; `/` `/privacy` `/terms` `/nefrologia`
  `/dialyza` `/nefamb` `/usgo` `/transplantacia` `/purifikacia` → 200 +
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

- [ ] Loop #41: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship `mycosis fungoides` this tick.
- Reason: Established disease name; `mykózny fungoides` is a mangled
  adjective form, not a medical fact change.
- Decision: Ship nefamb `pre rôzne príčiny`.
- Reason: Same register cleanup as `z dôvodu`→`pre`; medical facts
  unchanged. IgAN `v dôsledku zníženej schopnosti` left as natural.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `files/purifikacia.html`, `segments/purifikacia.html`, `files/nefamb.html`
- `SESSION.md`, `.audit.md` (Beh #51)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 4a52309 Fix mycosis fungoides term and nefamb cause wording.
- 99d75dc Document loop #39 ipvrm/nefamb wording and keep unsafe-inline after smoke-only CSP telemetry.
- c62b1b6 Fix Slovak wording on ipvrm and nefamb pages.
- aceeeb3 Document loop #38 nahradz wording and keep unsafe-inline after smoke-only CSP telemetry.
- dd2a73d Fix Slovak nahradz* wording on dialyza and CRRT title.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #51)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-231508-loop40-purifikacia-mycosis-nefamb.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-231508-loop40-purifikacia-mycosis-nefamb.md.
Pokračuj loop #41 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu).
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
