# Handoff: loop45-dialyza-chorobnost

## Metadata

- Generated At: 2026-11-05T23:37:07+01:00
- Updated At: 2026-11-05T23:38:00+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: d28f514

## Original Goal

Loop iterácia #45: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; preferovať NON-promo product fix (kandidáti:
nefamb `ako aj`, dialýza `z hľadiska znižovania chorobnosti`);
1 product + 1 docs commit; commit/push/deploy/smoke; SESSION + handoff.

## Current State

Iterácia #45 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: dialýza HDF wording bez úradníckeho
`z hľadiska znižovania chorobnosti` v `files/dialyza.html` +
`segments/dialyza.html`. Product SHA `d28f514` (docs tip nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Kept enforced `'unsafe-inline'`; remote-only untouched; no GH secrets;
  intro Bory left commented; ASN/ISN polish skipped; nefamb `ako aj`
  left (not all occurrences are defects; dialýza calque was stronger).
- Patched `files/dialyza.html` + `segments/dialyza.html`:
  `kvôli jej lepším výsledkom z hľadiska znižovania chorobnosti
  (morbidity) a úmrtnosti (mortality) v prevažnej väčšine dialyzovaných
  pacientov` →
  `pretože v prevažnej väčšine dialyzovaných pacientov lepšie znižuje
  chorobnosť (morbidity) a úmrtnosť (mortality)`.
- Left untouched: nefamb `ako aj`; IgAN `v dôsledku zníženej schopnosti`;
  `hyponatriémia`; `kosáčikovitá anémia`; legal `poskytovateľ…`;
  Lipton literary `jedinec`/`jedincov`.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `d28f514`; post-commit SFTP uploaded both dialýza
  files; `deploy.ps1 -Apply` → 0 upload; smoke direct 200
- Command: GHA Deploy `42122830597` success (rsync skipped)
- Command: production Chrome UA `/` + `/dialyza` → new strings present;
  old `z hľadiska znižovania chorobnosti` absent; `/` `/privacy`
  `/terms` `/nefrologia` `/dialyza` `/nefamb` `/usgo` `/transplantacia`
  `/purifikacia` → 200 + HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.

## Remaining Work

- [ ] Loop #46: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content/a11y/
      tooling; ASN/ISN only with official title evidence; intro Bory
      only after content decision; candidate: nefamb `ako aj` tightening
      after verifying specific occurrences; not Lipton `jedinec`).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship dialýza HDF chorobnosť/úmrtnosť wording (not nefamb).
- Reason: Stronger verified bureaucratic calque; medical facts unchanged
  (HDF better morbidity/mortality vs HD). Sync files + segments.
- Decision: Leave nefamb `ako aj` for a later pass.
- Reason: Multiple occurrences; not every `ako aj` is a defect.
- Decision: ASN/ISN still no acronym polish; remote-only not deleted;
  no GH secrets; intro Bory stays commented.
- Reason: Same standing constraints as prior loops.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `files/dialyza.html`, `segments/dialyza.html`
- `SESSION.md`, `.audit.md` (Beh #56)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- d28f514 Fix dialýza patient wording for HDF morbidity and mortality outcomes.
- 72d4d65 Document loop #44 transplant sledovanie and keep unsafe-inline after smoke-only CSP telemetry.
- 8bab3f9 Fix transplant patient wording for sledovanie and follow-up care.
- cd55e53 Document loop #43 IgAN ludia/vyrovnat and keep unsafe-inline after smoke-only CSP telemetry.
- 4bebd4c Fix IgAN patient wording for ludia and side-effect phrasing.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #56)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-233707-loop45-dialyza-chorobnost.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-233707-loop45-dialyza-chorobnost.md.
Pokračuj loop #46 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value non-promo ship (content/a11y/tooling) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu; ASN/ISN len s oficiálnym title dôkazom (aktuálne title bez akronymu). Kandidát: nefamb ako aj (overiť konkrétne výskyty); nie Lipton jedinec.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
