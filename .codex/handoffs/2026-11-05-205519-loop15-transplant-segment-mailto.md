# Handoff: loop15-transplant-segment-mailto

## Metadata

- Generated At: 2026-11-05T20:55:19+01:00
- Updated At: 2026-11-05T20:56:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 7da9a51 (docs/handoff commit môže nasledovať)

## Original Goal

Loop iterácia #15: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; ak telemetria smoke-only, shipnúť high-value
product fix (footer 403/mailto a/alebo segments title drift); verify
bug before fix; commit/push/deploy/smoke; SESSION + handoff.

## Current State

Iterácia #15 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: transplant segment title alignment +
remove foazosszu duplicate segment include + mailto without target=_blank.
Repo na `main` @ `7da9a51`.

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Aligned `segments/transplantacia.html` h2 to „Transplantácia obličky“.
- Removed redundant `require segments/transplantacia.html` after teaser
  in `blocks/foazosszu.sk.php` (kept segment use in `nephrology.sk.php`).
- Fixed footer mailto: dropped `target="_blank"` and `rel="noopener noreferrer"`.
- Triaged footer third-party 403s (validator, MX, Fedora, DistroWatch):
  403 on GET with Chrome UA → left badges in place (likely bot/WAF).
- Remote-only (~69) not deleted; no GH secrets created.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `7da9a51`; post-commit SFTP uploaded product files;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200 on `/` `/privacy`
  `/terms` `/nefrologia` (+ manual `/transplantacia` `/purifikacia`
  `/lipton-tx` `/nefamb`)
- Command: GHA Deploy `42098259437` success (rsync skipped without secrets)
- Command: production Chrome UA: homepage h2 plural = 0, singular = 3;
  mailto = `<a href="mailto:lubomir@polascin.net" title="Pošli e-mail">`;
  no second h2 between teaser and `/lipton-tx`; HSTS + CSP still with
  enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; footer badge 403s left pending browser
  confirmation.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: footer badge 403s are bot/WAF filtering, not true user
  breakage; confirm in a real browser before removing badges.
- Assumption: other segments already match `$topic['title']` (checked
  dialyza/nefrologia/purifikacia/usgo); only transplantácia drifted.

## Remaining Work

- [ ] Loop #16: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (browser-verify
      footer badges; cookie-banner same-origin `target="_blank"`;
      links/a11y/content).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship transplant segment / mailto / foazosszu dedupe instead
  of CSP tightening or remote cleanup.
- Reason: Verified product defects with production proof; CSP and
  remote-only remain blocked by policy/evidence.
- Decision: Do not remove footer FOSS/validator badges on 403 alone.
- Reason: Automation gets 403 with Chrome UA; may be IP/bot filtering;
  handoff requires browser confirmation before removal.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether footer badge hosts are reachable in a real browser session.

## Critical Files

- `segments/transplantacia.html`, `blocks/foazosszu.sk.php`,
  `blocks/footer.sk.php`
- `SESSION.md`, `.audit.md` (Beh #26)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 7da9a51 Align transplant segment title and fix footer mailto UX.
- 1ba55e7 Document loop #14 topic title and ClustrMaps ship.
- ca9387f Align topic headings with titles and drop dead ClustrMaps link.
- 2b22582 Document loop #13 topic heading and related-nav ship.
- d667b45 Fix topic page headings and add related-topic navigation.

## Modified Files

- Po docs/handoff commite: SESSION.md, .audit.md, handoff path nižšie

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #26)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-205519-loop15-transplant-segment-mailto.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-205519-loop15-transplant-segment-mailto.md.
Pokračuj loop #16 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value ship (links/a11y/content) ak telemetria ostáva smoke-only.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
