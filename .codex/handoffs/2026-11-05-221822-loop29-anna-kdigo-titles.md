# Handoff: loop29-anna-kdigo-titles

## Metadata

- Generated At: 2026-11-05T22:18:22+01:00
- Updated At: 2026-11-05T22:19:30+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: a0534dc

## Original Goal

Loop iterácia #29: znova skontrolovať RO telemetriu; neodstraňovať
enforced `'unsafe-inline'` bez strong evidence; remote-only nemazať;
nevyvárať GH secrets; ak smoke-only, ship coherent product fix
(prefer ANNA `(ANNA)` / KDIGO encoding after verification);
commit/push/deploy/smoke; SESSION + handoff. Preferovať 1 product +
1 docs commit.

## Current State

Iterácia #29 hotová. RO telemetria stále smoke-only (2 riadky). Enforced
`'unsafe-inline'` ponechané. Ship: ANNA promo title/alt →
`American Nephrology Nurses Association (ANNA)`; KDIGO ASCII `-` →
UTF-8 en dash U+2013. Repo na `main` @ `a0534dc` (docs tip commit
nasleduje).

## Completed This Session

- Re-run `csp-report-summary.ps1` → 2 smoke markers, 0 real candidates.
- Confirmed live blank miss hints = 0 (no stronger non-promo defect).
- Verified official annanurse.org `<title>` contains `| ANNA`.
- Verified official kdigo.org `<title>` uses `&#8211;` (en dash).
- Updated `blocks/promo.sk.php` ANNA and KDIGO title + alt.
- Left intro Bory commented; remote-only not deleted; no GH secrets.

## Validated

- Command: `powershell -File .\tools\csp-report-summary.ps1` → smoke-only;
  keep unsafe-inline
- Command: `php tools/test-csp.php` → PASS
- Command: commit `a0534dc`; post-commit SFTP uploaded `promo.sk.php`;
  `deploy.ps1 -Apply` → 0 upload; smoke direct 200 on `/` `/privacy`
  `/terms` `/nefrologia`
- Command: GHA Deploy `42111216752` success (rsync skipped)
- Command: production Chrome UA `/` → ANNA `(ANNA)` title+alt (2),
  KDIGO en-dash title+alt (2), ASCII hyphen 0; live blank miss hints = 0;
  HSTS + CSP still with enforced `'unsafe-inline'`
- Risk accepted: `'unsafe-inline'` still enforced; remote-only 69 not
  deleted; GH secrets still unset; intro Bory remains commented.

## Not Yet Validated

- Assumption: real browser RO violations will appear after more traffic /
  consented Clarity/GTM loads; until then do not tighten script-src.
- Risk: remote-only junk still on server; cleanup unapproved.
- Assumption: further brand polish (ASN/ISN etc.) only if official
  `<title>` actually includes the acronym.

## Remaining Work

- [ ] Loop #30: re-run `csp-report-summary.ps1`; drop `'unsafe-inline'`
      only with strong evidence (+ Clarity/GTM consent paths).
- [ ] Approved cleanup of remote-only A–C (keep `reports.jsonl`).
- [ ] Optional: configure GH `DEPLOY_*` secrets outside repo, or keep
      local-only deploy.
- [ ] If telemetry still smoke-only: next product ship (title/content/a11y;
      intro Bory only after content decision).

## Decisions Made

- Decision: Keep enforced `'unsafe-inline'`.
- Reason: Telemetry still smoke-only; no Clarity/GTM consent-path evidence.
- Decision: Ship ANNA `(ANNA)` + KDIGO en-dash this tick (not intro Bory).
- Reason: Official `<title>` verified for both; blank-miss scan was clean;
  matches SIN/WHO/ERA acronym pattern + official dash encoding.
- Decision: Remote-only still not deleted; no GH secrets created.
- Reason: Explicit approval still missing / out of scope this tick.
- Decision: Do not invent ASN/ISN `(ASN)`/`(ISN)` without title evidence.
- Reason: Fetched ASN/ISN titles lack acronym suffix today.

## Blockers / Open Questions

- Explicit approval for remote-only cleanup (see
  `docs/REMOTE-ONLY-INVENTORY.md`) still required.
- Whether to add GitHub `DEPLOY_*` secrets (outside repo) or retire GHA
  rsync later; until then GHA remains CI lint + optional future sync.
- Whether to uncomment intro Bory content (product decision, not title).

## Critical Files

- `blocks/promo.sk.php`
- `SESSION.md`, `.audit.md` (Beh #40)
- `tools/csp-report-summary.ps1`, `tools/deploy.ps1`

## Recent Commits

- a0534dc Align ANNA and KDIGO promo titles with official branding.
- e7a33a9 Document loop #28 ERA/EDTNA title polish and keep unsafe-inline after smoke-only CSP telemetry.
- 27bcd26 Align ERA and EDTNA/ERCA promo titles with official branding.
- c34e372 Document loop #27 WHO title polish and keep unsafe-inline after smoke-only CSP telemetry.
- 8f96f4f Align WHO promo title and alt with official World Health Organization (WHO) branding.

## Modified Files

- After docs commit: SESSION.md, .audit.md, this handoff

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #40)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-221822-loop29-anna-kdigo-titles.md`
- `docs/REMOTE-ONLY-INVENTORY.md`
- `tools/csp-report-summary.ps1`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-221822-loop29-anna-kdigo-titles.md.
Pokračuj loop #30 NephroSite: znova skontroluj RO telemetriu (csp-report-summary.ps1); 'unsafe-inline' v enforced neodstraňuj bez strong evidence; remote-only A–C nemazať bez súhlasu (docs/REMOTE-ONLY-INVENTORY.md). Preferuj high-value ship (title/content/a11y) ak telemetria ostáva smoke-only; intro Bory len po rozhodnutí o obsahu.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

See `docs/REMOTE-ONLY-INVENTORY.md`. Count ~69: accidental `.git/**`, tooling,
mirrored docs/state; keep `private/csp-reports/reports.jsonl`.
