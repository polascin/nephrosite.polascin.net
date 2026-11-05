# Remote-only inventory (awaiting explicit cleanup approval)

Snapshot from `tools/deploy.ps1` dry-run on 2026-11-05 (loop #9).
Count: **69** remote-only paths under the NephroSite web root.
**Do not delete** without explicit user approval in the current session.

## Categories

### A. Accidental `.git` tree on production (~50)

Hooks, objects, refs, LFS objects, `packed-refs`, `ORIG_HEAD`, `FETCH_HEAD`,
sample hooks. Leftover from an earlier on-server clone or rsync that included
`.git`. Safe to remove **after** approval (site does not need a git checkout).

### B. Dev / CI tooling that should not be public (~10)

- `.github/workflows/deploy.yml`
- `.deployignore`, `.gitattributes`, `.gitignore`
- `phpstan.neon.dist`, `phpstan-baseline.neon`
- `tools/README.md`, `tools/quality.ps1`, `tools/install-dev-tools.ps1`
- `tools/phpstan.phar`, `tools/php-cs-fixer.phar`
- `tools/encode-lecture-gifs.py`, `tools/.htaccess`
- `.cursor/rules/commit-push-deploy.mdc`

Already blocked or unused by visitors; cleanup reduces attack/noise surface.

### C. Local state / docs mirrored to server (~6)

- `SESSION.md`, `.audit.md`
- `.codex/handoffs/2026-11-05-193949-loop2-lecture-gif-to-mp4.md`

HTTP for `*.md` is denied by `.htaccess`; still better not to host them.

### D. Runtime evidence (keep)

- `private/csp-reports/reports.jsonl` — CSP Report-Only / report-uri sink.
  Keep; review via `tools/csp-report-summary.ps1` over SSH only.

## Proposed cleanup (when approved)

1. Remove categories A–C only (leave `private/csp-reports/`).
2. Re-run `deploy.ps1` (plan) and confirm remote-only ≈ 1 (`reports.jsonl`).
3. Smoke `/` + `/privacy` + `POST /csp-report.php`.

## Command sketch (do not run until approved)

```powershell
# After explicit approval only — list candidates, then delete via SSH.
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1
# ssh websupport "cd …/nephrosite && …"  # curated rm of A–C paths
```
