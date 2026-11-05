# Handoff: loop17-pdf-open-download

## Metadata

- Generated At: 2026-11-05T21:06:05+01:00
- Updated At: 2026-11-05T21:07:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 8c6871a

## Original Goal

Loop iterácia #17: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; ak smoke-only, ship coherent product fix
(same-origin PDF `_blank` policy / a11y); commit/push/deploy/smoke;
SESSION + handoff.

## Current State

Iterácia #17 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: same-origin PDF open vs download
policy (view `_blank` + sr-only; download-labeled → `download`). Repo na
`main` @ `068d217`.

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Verified production PDF headers: `application/pdf`, empty
  `Content-Disposition` (inline, not forced download).
- Lecture “na stiahnutie” links: `download` attribute, no `_blank`.
- View PDF links (lecture titles, MEL, KTx/CRRT, regcitra, ipvrm): keep
  `_blank` + `noopener noreferrer` + sr-only new-window hint.
- Remote-only (~69) not deleted; no GH secrets created.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: HEAD `/docs/fosdl.pdf` `/docs/mel.pdf` `/docs/ipvrm.pdf` →
  CT=application/pdf, CD empty
- Command: commit `068d217`; post-commit SFTP; `deploy.ps1 -Apply` →
  0 upload; smoke direct 200 on `/` `/privacy` `/terms` `/nefrologia`
- Command: GHA Deploy `42099959216` success (rsync skipped)
- Command: production Chrome UA homepage → download=6, sr-only PDF
  hint=11, blank-pdf view=11; HSTS + CSP still with enforced
  `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: browser `download` attribute behavior is consistent enough
  for same-origin PDF; no forced Content-Disposition on server.

## Remaining Work

- [ ] Loop #18: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (external link
      hygiene, content/segment consistency, a11y).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Keep `_blank` for same-origin PDF *view* links.
- Reason: Preserves lecture/page context; intentional document UX, not
  the same defect as same-origin HTML legal links.
- Decision: Use `download` on links that claim “na stiahnutie”.
- Reason: Verified false claim: PDFs are served inline without
  Content-Disposition.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.

## Critical Files

- `blocks/lectures.sk.php`, `blocks/foazosszu.sk.php`, `blocks/info.sk.php`,
  `blocks/regcitra.sk.php`
- `SESSION.md`, `.audit.md` (Beh #28)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- 8c6871a Document loop #17 PDF open/download ship.
- 068d217 Clarify same-origin PDF open vs download behavior.
- 87ba2e5 Point loop #16 handoff HEAD to docs commit.
- eeeedab Document loop #16 cookie-banner same-origin link ship.
- f67b9df Drop noopener from same-origin footer legal links.
- 57b5bd7 Open same-origin privacy links from the cookie banner in the same tab.

## Modified Files

- After docs/handoff commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #28)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-210605-loop17-pdf-open-download.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-210605-loop17-pdf-open-download.md.
Pokračuj loop #18 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value ship (links/a11y/content) ak telemetria ostáva smoke-only.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
