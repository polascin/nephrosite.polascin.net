# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #12)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `f8409b5` (docs/handoff commit môže nasledovať)

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky → **neodstraňovať** enforced
  `'unsafe-inline'`.
- Product ship: `/privacy` reset súhlasu teraz maže **localStorage aj**
  cookie `nephro_consent_v1`; sekcia `#consent-controls`; texty privacy /
  terms / cookie banneru zosúladené so skutočnými ovládacími prvkami;
  a11y (skip-link, 44px, legal-nav).
- Remote-only (~69) **nemažeť** bez súhlasu; GH secrets nevytvárané.

## Overené na produkcii

- `csp-report-summary.ps1` → smoke-only; `php tools/test-csp.php` → PASS
- Clean URL smoke (MaximumRedirection 0): `/` `/privacy` `/terms`
  `/nefrologia` → 200
- Commit `f8409b5`; post-commit SFTP; `deploy.ps1 -Apply` 0 upload; smoke
  direct 200
- Produkcia: `#consent-controls`, privacy-consent.js maže Secure cookie,
  terms odkazuje na správu súhlasu; HSTS + CSP (stále s `'unsafe-inline'`)
- GHA Deploy `42095812695` success (rsync skip)

## Poznámky k toolingu

- Commit cez `git -c core.hooksPath=.git/hooks` (globálny GG); ggshield Passed.
- Docs/tools sú v `.deployignore` → SFTP/deploy.ps1 ich na web root neposiela.
- WAF 466 pri krátkom UA; smoke s Chrome UA.
- Pri rewrite: **vždy** `THE_REQUEST` (alebo `[END]`) pre 301 zo cieľa
  interného rewrite.
- Lokálny `tools/deploy.ps1 -Apply` (+ post-commit SFTP) je autoritatívny
  sync, kým chýbajú `DEPLOY_*` secrets.

## Ďalší fokus (loop #13)

1. Zbieraj RO telemetriu; drop `'unsafe-inline'` len so strong evidence +
   Clarity/GTM consent paths.
2. Schválený cleanup remote-only (A–C; keep `reports.jsonl`).
3. Voliteľne GH `DEPLOY_*` secrets (mimo repo) alebo ponechať len lokálny deploy.
4. Bug/a11y/topic/links ship, ak telemetria stále smoke-only.

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-203923-loop12-consent-reset-fix.md`
- Audit: `.audit.md` Beh #23

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
```
