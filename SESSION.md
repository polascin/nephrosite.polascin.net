# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #11)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: (po commite tejto iterácie)

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky → **neodstraňovať** enforced
  `'unsafe-inline'`.
- Oficiálne uznanie lokálneho deployu: `tools/deploy.ps1 -Apply` + post-commit
  SFTP sú **autoritatívna** produkčná cesta, kým chýbajú `DEPLOY_*` secrets.
- `DEPLOY.md`, rule `commit-push-deploy.mdc` (vetva `main`), `.doaudit.md`,
  GHA notice pri skip rsync, banner + direct-200 smoke v `deploy.ps1`.
- Remote-only (~69) **nemažeť** bez súhlasu.

## Overené na produkcii

- `csp-report-summary.ps1` → smoke-only; `php tools/test-csp.php` → PASS
- Clean URL smoke (MaximumRedirection 0): `/` `/privacy` `/terms`
  `/nefrologia` → 200
- Po pushi: `deploy.ps1 -Apply` + GHA (rsync skip očakávaný)

## Poznámky k toolingu

- Commit cez `git -c core.hooksPath=.git/hooks` (globálny GG); ggshield Passed.
- Docs/tools sú v `.deployignore` → SFTP/deploy.ps1 ich na web root neposiela.
- WAF 466 pri krátkom UA; smoke s Chrome UA.
- Pri rewrite: **vždy** `THE_REQUEST` (alebo `[END]`) pre 301 zo cieľa
  interného rewrite.

## Ďalší fokus (loop #12)

1. Zbieraj RO telemetriu; drop `'unsafe-inline'` len so strong evidence +
   Clarity/GTM consent paths.
2. Schválený cleanup remote-only (A–C; keep `reports.jsonl`).
3. Voliteľne GH `DEPLOY_*` secrets (mimo repo) alebo ponechať len lokálny deploy.
4. Bug/a11y/topic/cookie ship, ak telemetria stále smoke-only.

## Handoff súbory

- Codex: `.codex/handoffs/` (loop11 handoff po dokončení)
- Audit: `.audit.md` Beh #22

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
```
