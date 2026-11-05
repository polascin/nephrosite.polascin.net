# Handoff: loop18-gif-download-fallbacks

## Metadata

- Generated At: 2026-11-05T21:12:02+01:00
- Updated At: 2026-11-05T21:13:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: ce862ed

## Original Goal

Loop iterácia #18: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; ak smoke-only, ship coherent product fix
(GIF fallback download / a11y / content); commit/push/deploy/smoke;
SESSION + handoff.

## Current State

Iterácia #18 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: GIF video fallback `download` +
„na stiahnutie“ (8 odkazov) a CRRT „metódy“ consistency. Repo na
`main` @ `ee82d0b`.

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Verified production GIF headers: `image/gif`, empty
  `Content-Disposition` (inline, not forced download).
- Verified local sizes vs labels (7/5/3/4/3/168/7/7 MB).
- 8 GIF fallback links: `download` + „na stiahnutie“ + `&nbsp;MB`.
- CRRT 2023 aria-label/title aligned to „Akútne eliminačné metódy“.
- Remote-only (~69) not deleted; no GH secrets created.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: HEAD `/docs/fosdl.gif` `/docs/nephrogame.gif`
  `/docs/ktx2023.gif` → CT=image/gif, CD empty
- Command: commit `ee82d0b`; post-commit SFTP; `deploy.ps1 -Apply` →
  0 upload; smoke direct 200 on `/` `/privacy` `/terms` `/nefrologia`
- Command: GHA Deploy `42100877653` success (rsync skipped)
- Command: production Chrome UA homepage → gif-download=8,
  gif-label=8, old-gif-label=0, pdf-download=6, metody-crrt=3;
  HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: browser `download` on same-origin GIF is consistent enough;
  no forced Content-Disposition on server.

## Remaining Work

- [ ] Loop #19: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (external link
      hygiene, sr-only new-window hints, content/a11y).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Treat GIF video fallbacks as downloads (`download` + label).
- Reason: Served inline without Content-Disposition; 3 to 168 MB files
  must not open as browser images when video is unavailable.
- Decision: Align CRRT wording to „metódy“ (not „metodiky“).
- Reason: Matches lectures.sk.php and iframe title; removes drift.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.

## Critical Files

- `blocks/lectures.sk.php`, `blocks/foazosszu.sk.php`
- `SESSION.md`, `.audit.md` (Beh #29)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- ce862ed Document loop #18 GIF download fallback ship.
- ee82d0b Mark GIF video fallbacks as real downloads.
- 88b7658 Point loop #17 handoff HEAD to docs commit.
- 8c6871a Document loop #17 PDF open/download ship.
- 068d217 Clarify same-origin PDF open vs download behavior.

## Modified Files

- After HEAD retarget commit: SESSION.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #29)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-211202-loop18-gif-download-fallbacks.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-211202-loop18-gif-download-fallbacks.md.
Pokračuj loop #19 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value ship (links/a11y/content) ak telemetria ostáva smoke-only.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
