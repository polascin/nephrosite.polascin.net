# Handoff: loop14-topic-titles-clustrmaps

## Metadata

- Generated At: 2026-11-05T20:50:24+01:00
- Updated At: 2026-11-05T20:51:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: ca9387f (docs/handoff commit môže nasledovať)

## Original Goal

Loop iterácia #14: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; ak telemetria smoke-only, shipnúť high-value
product fix (links/a11y/content/topic); commit/push/deploy/smoke;
SESSION + handoff.

## Current State

Iterácia #14 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: topic title alignment + markup typos +
dead ClustrMaps outbound removal + title-aware teaser. Repo na `main`
@ `ca9387f`.

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Aligned fragment h2 with `$topic['title']` for purifikacia,
  transplantacia, lipton-tx.
- Fixed markup typos `R<em>iziká` / `K<strong>omplikácie` in
  `files/transplantacia.html`.
- Hardened `topic-teaser.php` to prefer title-matched `<h2>`.
- Removed outbound `clustrmaps.com/site/1ak7d` (DNS A=`127.0.0.1` via
  8.8.8.8 and 1.1.1.1); kept first-party SVG + figcaption.
- Removed duplicate Fedora footer badge.
- Remote-only (~69) not deleted; no GH secrets created.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `ca9387f`; post-commit SFTP uploaded product files;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200 on `/` `/privacy`
  `/terms` `/nefrologia`
- Command: GHA Deploy `42097461973` success (rsync skipped without secrets)
- Command: production Chrome UA: h1 match for `/purifikacia`
  `/transplantacia` `/lipton-tx`; homepage has `visitor-map` +
  „nie je momentálne dostupná“; no `clustrmaps.com/site`; no
  `R<em>izik` / `K<strong>omplik`; HSTS + CSP still with enforced
  `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; ClustrMaps outbound stays off until
  vendor DNS recovers.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: some footer third-party hosts returned 403 to automation
  (validator.w3.org, mxlinux, fedora, distrowatch, time.is, OUP); may be
  bot filtering rather than true user breakage; verify in browser before
  removing.

## Remaining Work

- [ ] Loop #15: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (footer 403
      triage, segments vs files title drift on transplantácia).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship topic title / ClustrMaps / markup fix instead of CSP
  tightening or remote cleanup.
- Reason: Verified product defects with production proof; CSP and
  remote-only remain blocked by policy/evidence.
- Decision: Remove ClustrMaps outbound link, keep first-party SVG.
- Reason: Vendor A record is `127.0.0.1` on public resolvers; link is
  broken for users, not only local sinkhole.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether ClustrMaps will recover; re-check DNS before restoring outbound
  link.

## Critical Files

- `files/purifikacia.html`, `files/transplantacia.html`, `files/lipton-tx.html`
- `blocks/topic-teaser.php`, `blocks/footer.sk.php`, `blocks/styles.css.php`
- `SESSION.md`, `.audit.md` (Beh #25)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- ca9387f Align topic headings with titles and drop dead ClustrMaps link.
- 2b22582 Document loop #13 topic heading and related-nav ship.
- d667b45 Fix topic page headings and add related-topic navigation.
- e0b8410 Document loop #12 consent reset fix and handoff.
- f8409b5 Fix privacy consent reset to clear both storage and cookie.

## Modified Files

- Po docs/handoff commite: SESSION.md, .audit.md, handoff path nižšie

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #25)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-205024-loop14-topic-titles-clustrmaps.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-205024-loop14-topic-titles-clustrmaps.md.
Pokračuj loop #15 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value ship (links/a11y/content) ak telemetria ostáva smoke-only.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
