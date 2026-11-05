# Handoff: loop44-transplant-sledovanie

## Metadata

- Generated At: 2026-11-05T23:32:57+01:00
- Updated At: 2026-11-05T23:34:00+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 8bab3f9

## Original Goal

Loop iterácia #44: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix mimo IgAN
micro-polish ak existuje silnejší defect; 1 product + 1 docs commit;
commit/push/deploy/smoke; SESSION + handoff.

## Current State

Iterácia #44 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: transplant `Sledovanie`, bez `zo
strany lekárov`, priame aby-vetý, `úpravu životného štýlu`, `hygiena
pri potravinách` v `files/transplantacia.html` +
`segments/transplantacia.html`. Product SHA `8bab3f9` (docs tip
nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped (official titles
  still without acronym).
- Patched `files/transplantacia.html` + `segments/transplantacia.html`:
  `Monitorovanie`→`Sledovanie`;
  `starostlivosť zo strany lekárov`→`starostlivosť lekárov`;
  `aby sa zabezpečilo správne fungovanie… a monitorovali sa…`→
  `aby transplantovaná oblička správne fungovala a aby sa včas
  zachytili…`;
  `prispôsobenie životného štýlu, ako napríklad zmena`→
  `úpravu životného štýlu, napríklad zmenu`;
  `zabezpečenie hygieny potravín`→`hygiena pri potravinách`.
- Left untouched: IgAN `v dôsledku zníženej schopnosti`;
  `hyponatriémia`; `kosáčikovitá anémia`; legal `poskytovateľ…`;
  Lipton literary `jedinec`/`jedincov`.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `8bab3f9`; post-commit SFTP uploaded both transplant
  files; `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42122220816` success (rsync skipped)
- Command: production Chrome UA `/` + `/transplantacia` → new strings
  present; old calques absent; `/` `/privacy` `/terms` `/nefrologia`
  `/dialyza` `/nefamb` `/usgo` `/transplantacia` `/purifikacia` → 200 +
  HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.

## Remaining Work

- [ ] Loop #45: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; candidates: nefamb `ako aj`, dialýza
      `z hľadiska znižovania chorobnosti`; not Lipton `jedinec`).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship transplant sledovanie / follow-up wording (not IgAN).
- Reason: Stronger verified non-promo defect outside IgAN micro-polish;
  bureaucratic/EN calques → natural patient Slovak; medical facts
  unchanged. Sync files + segments. Leave literary Lipton `jedinec`.
- Decision: ASN/ISN still no acronym polish.
- Reason: Official titles still `American Society of Nephrology` /
  `International Society of Nephrology` without acronym.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `files/transplantacia.html`, `segments/transplantacia.html`
- `SESSION.md`, `.audit.md` (Beh #55)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 8bab3f9 Fix transplant patient wording for sledovanie and follow-up care.
- cd55e53 Document loop #43 IgAN ludia/vyrovnat and keep unsafe-inline after smoke-only CSP telemetry.
- 4bebd4c Fix IgAN patient wording for ludia and side-effect phrasing.
- e906961 Document loop #42 IgAN calques and keep unsafe-inline after smoke-only CSP telemetry.
- 2ce776e Fix IgAN patient calques for provider, environment, and tiež.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #55)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-233257-loop44-transplant-sledovanie.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-233257-loop44-transplant-sledovanie.md.
Pokračuj loop #45 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Kandidáti: nefamb ako aj; dialýza z hľadiska znižovania chorobnosti; nie Lipton jedinec.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
