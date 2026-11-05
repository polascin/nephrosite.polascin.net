# Handoff: loop13-topic-heading-related-nav

## Metadata

- Generated At: 2026-11-05T20:45:27+01:00
- Updated At: 2026-11-05T20:46:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: d667b45 (docs/handoff commit môže nasledovať)

## Original Goal

Loop iterácia #13: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; ak telemetria smoke-only, shipnúť high-value
product fix (topic/a11y/links); commit/push/deploy/smoke; SESSION +
handoff.

## Current State

Iterácia #13 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: oprava `/nefamb` h1 (a teaseru),
title-aware h1 promotion, related-topic nav, typo tubulointersticiálne,
zosúladenie titulkov. Repo na `main` @ `d667b45`.

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Fixed `files/nefamb.html` heading order so topic title is first `<h2>`.
- Hardened `blocks/topic-page.php` to promote `<h2>` matching
  `$topic['title']` (fallback: first `<h2>`).
- Added „Ďalšie témy“ nav + CSS (44px targets) on topic pages.
- Fixed typo `tubulointerstickálne` → `tubulointersticiálne` in
  `files/nefrologia.html` and `segments/nefrologia.html`.
- Normalized `nefrologia` / `usgo` headings to match meta titles.
- Remote-only (~69) not deleted; no GH secrets created.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `d667b45`; post-commit SFTP uploaded topic files;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200 on `/` `/privacy`
  `/terms` `/nefrologia`
- Command: GHA Deploy `42096771812` success (rsync skipped without secrets)
- Command: production Chrome UA: `/nefamb` h1 = „Nefrologická ambulancia“,
  `topic-related` present; `/nefrologia` has `tubulointersticiálne` and
  no `tubulointerstick`; HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: ClustrMaps DNS resolving to 127.0.0.1 may be local/network
  sinkhole; outbound footer link left unchanged this tick.

## Remaining Work

- [ ] Loop #14: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (external links,
      further a11y/content).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship topic heading/nav fix instead of more deploy docs.
- Reason: Verified product bug: `/nefamb` h1 and teaser mismatched title.
- Decision: Prefer title-matched `<h2>` promotion over blind first `<h2>`.
- Reason: Fragments may start with a section heading before the topic name.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.

## Critical Files

- `blocks/topic-page.php`
- `blocks/styles.css.php`
- `files/nefamb.html`, `files/nefrologia.html`, `files/usgo.html`
- `segments/nefrologia.html`
- `SESSION.md`, `.audit.md` (Beh #24)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- d667b45 Fix topic page headings and add related-topic navigation.
- e0b8410 Document loop #12 consent reset fix and handoff.
- f8409b5 Fix privacy consent reset to clear both storage and cookie.
- 83ef530 Document loop #11 local deploy authority ship.
- 77f109e Recognize local deploy.ps1 as the authoritative production path.

## Modified Files

- Po docs/handoff commite: SESSION.md, .audit.md, handoff path nižšie

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #24)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-204527-loop13-topic-heading-related-nav.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-204527-loop13-topic-heading-related-nav.md.
Pokračuj loop #14 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value ship (links/a11y/content) ak telemetria ostáva smoke-only.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
