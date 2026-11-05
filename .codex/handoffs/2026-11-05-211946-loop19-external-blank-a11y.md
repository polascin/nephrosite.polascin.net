# Handoff: loop19-external-blank-a11y

## Metadata

- Generated At: 2026-11-05T21:19:46+01:00
- Updated At: 2026-11-05T21:20:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 4f9991e

## Original Goal

Loop iterácia #19: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; ak smoke-only, ship coherent product fix
(a11y / external links); commit/push/deploy/smoke; SESSION + handoff.

## Current State

Iterácia #19 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: sr-only new-window hints pre
`target="_blank"` (JS helper + above-the-fold static) a promo logo
`alt` z plných názvov. Repo na `main` @ `e3c2995`.

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Verified defect: 155 `_blank` on `/`, 11 with PDF hint, 144 external
  without new-window sr-only text.
- Spot-checked external URLs (GET/Chrome UA): Martinus 33 OK (false
  404/HEAD noise); LinkedIn/time.is/OUP bot/method noise, not dead.
- Extended `ensureExternalBlankLinksAreSafe()` to inject
  `.sr-only.sr-only-new-window` when hint missing.
- Static hints: archive-notice, intro (age/LinkedIn/Amazon), current
  (beat/time), terms.html (+ `.sr-only` in `files/legal.css`).
- Promo logos: short abbreviation alts → full `title` names; duplicate
  second images decorative `alt=""`; ISN spelling Nephrology; NKF title.
- Remote-only (~69) not deleted; no GH secrets created.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `e3c2995`; post-commit SFTP; `deploy.ps1 -Apply` →
  0 upload; smoke direct 200 on `/` `/privacy` `/terms` `/nefrologia`
- Command: GHA Deploy `42102196491` success (rsync skipped)
- Command: production Chrome UA `/` → staticHintMentions=18,
  pdfHints=11, jsHelperMarker=True, promoFullAlt=True, oldSnesAlt=False,
  linkedinAlt=True; `/terms` hints=2; HSTS + CSP still with enforced
  `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: JS-injected hints cover lecture/promo/footer blanks for
  users with JS; no-JS relies on static above-the-fold + PDF hints.

## Remaining Work

- [ ] Loop #20: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (content
      consistency, remaining logo/title polish, lecture organizer
      static hints without relying on JS).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Inject new-window sr-only via existing blank-link JS helper,
  plus static hints on above-the-fold / legal pages.
- Reason: 144 external blanks lacked hints; one coherent WCAG warning
  without rewriting ~100 Martinus/organizer markup lines.
- Decision: Expand promo `alt` to full organization names from `title`.
- Reason: Screen readers announce `alt`, not `title`; abbreviations
  (SNeS, NTO, …) were opaque accessible names.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.

## Critical Files

- `blocks/scripts.sk.php`, `blocks/promo.sk.php`, `blocks/intro.sk.php`,
  `blocks/current.sk.php`, `blocks/archive-notice.sk.php`
- `files/terms.html`, `files/legal.css`
- `SESSION.md`, `.audit.md` (Beh #30)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- e3c2995 Improve external blank-link accessibility.
- 860174c Point loop #18 handoff HEAD to docs commit.
- ce862ed Document loop #18 GIF download fallback ship.
- ee82d0b Mark GIF video fallbacks as real downloads.
- 88b7658 Point loop #17 handoff HEAD to docs commit.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #30)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-211946-loop19-external-blank-a11y.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-211946-loop19-external-blank-a11y.md.
Pokračuj loop #20 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value ship (content/a11y) ak telemetria ostáva smoke-only.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
