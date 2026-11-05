# Handoff: loop16-cookie-banner-same-origin

## Metadata

- Generated At: 2026-11-05T20:59:07+01:00
- Updated At: 2026-11-05T21:00:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: f67b9df (docs/handoff commit môže nasledovať)

## Original Goal

Loop iterácia #16: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; browser-verify footer badges (403 vs real UA);
ak sú true dead links, fix; inak ship next a11y/content defect;
commit/push/deploy/smoke; SESSION + handoff.

## Current State

Iterácia #16 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Footer badges overené v prehliadači ako
WAF/Cloudflare, nie dead links. Ship: cookie-banner same-origin privacy
bez `_blank`; footer legal bez zbytočného `rel`. Repo na `main` @
`f67b9df`.

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Browser-verified footer badges: validator + MX = Cloudflare challenge;
  Fedora + DistroWatch = live pages. Badges kept.
- Removed `target="_blank"` / `rel` from cookie-banner same-origin
  `/privacy` links (banner, modal, noscript).
- Removed unnecessary `rel="noopener noreferrer"` from footer same-origin
  `/privacy`, `/terms`, `/privacy#legal-disclaimer`.
- Remote-only (~69) not deleted; no GH secrets created.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: browser navigate to validator.w3.org, mxlinux.org,
  fedoraproject.org, distrowatch.com → WAF challenge or live content
- Command: commits `57b5bd7` + `f67b9df`; post-commit SFTP;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200 on `/` `/privacy`
  `/terms` `/nefrologia` (+ `/transplantacia`)
- Command: GHA Deploy `42098848473` + `42099000099` success (rsync skipped)
- Command: production Chrome UA: privacy/terms anchors without
  `target="_blank"` or `rel="noopener noreferrer"`; HSTS + CSP still with
  enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; FOSS badges kept after browser proof.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: same-origin PDF `target="_blank"` may still be intentional
  (open document in new tab); review before changing.

## Remaining Work

- [ ] Loop #17: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (PDF `_blank`
      policy, external link hygiene, content/a11y).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Keep footer FOSS/validator badges.
- Reason: Browser shows Cloudflare challenges or live sites; automation
  403 is WAF/bot filtering, not user-facing breakage.
- Decision: Ship same-origin privacy/terms link hygiene instead of CSP
  tightening or remote cleanup.
- Reason: Verified a11y/UX defect; CSP and remote-only remain blocked.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.

## Critical Files

- `blocks/cookie-banner.sk.php`, `blocks/footer.sk.php`
- `SESSION.md`, `.audit.md` (Beh #27)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- f67b9df Drop noopener from same-origin footer legal links.
- 57b5bd7 Open same-origin privacy links from the cookie banner in the same tab.
- e9db1b6 Document loop #15 transplant segment and mailto ship.
- 7da9a51 Align transplant segment title and fix footer mailto UX.
- 1ba55e7 Document loop #14 topic title and ClustrMaps ship.

## Modified Files

- Po docs/handoff commite: SESSION.md, .audit.md, handoff path nižšie

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #27)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-205907-loop16-cookie-banner-same-origin.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-205907-loop16-cookie-banner-same-origin.md.
Pokračuj loop #17 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value ship (links/a11y/content) ak telemetria ostáva smoke-only.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
