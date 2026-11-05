# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #13)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `d667b45` (docs/handoff commit môže nasledovať)

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky → **neodstraňovať** enforced
  `'unsafe-inline'`.
- Product ship: `/nefamb` h1 teraz zodpovedá názvu témy; `topic-page.php`
  preferuje `<h2>` zhodný s `$topic['title']`; navigácia „Ďalšie témy“;
  typo tubulointersticiálne; titulky nefrologia/usgo zosúladené.
- Remote-only (~69) **nemažeť** bez súhlasu; GH secrets nevytvárané.

## Overené na produkcii

- `csp-report-summary.ps1` → smoke-only; `php tools/test-csp.php` → PASS
- Clean URL smoke (MaximumRedirection 0): `/` `/privacy` `/terms`
  `/nefrologia` `/nefamb` `/usgo` → 200 + HSTS + CSP
- Commit `d667b45`; post-commit SFTP; `deploy.ps1 -Apply` 0 upload; smoke
  direct 200
- Produkcia: `/nefamb` h1 = „Nefrologická ambulancia“, `topic-related`,
  `/nefrologia` bez `tubulointerstick`; CSP stále s `'unsafe-inline'`
- GHA Deploy `42096771812` success (rsync skip)

## Poznámky k toolingu

- Commit cez `git -c core.hooksPath=.git/hooks` (globálny GG); ggshield Passed.
- Docs/tools sú v `.deployignore` → SFTP/deploy.ps1 ich na web root neposiela.
- WAF 466 pri krátkom UA; smoke s Chrome UA.
- Pri rewrite: **vždy** `THE_REQUEST` (alebo `[END]`) pre 301 zo cieľa
  interného rewrite.
- Lokálny `tools/deploy.ps1 -Apply` (+ post-commit SFTP) je autoritatívny
  sync, kým chýbajú `DEPLOY_*` secrets.

## Ďalší fokus (loop #14)

1. Zbieraj RO telemetriu; drop `'unsafe-inline'` len so strong evidence +
   Clarity/GTM consent paths.
2. Schválený cleanup remote-only (A–C; keep `reports.jsonl`).
3. Voliteľne GH `DEPLOY_*` secrets (mimo repo) alebo ponechať len lokálny deploy.
4. Bug/a11y/links/content ship, ak telemetria stále smoke-only.

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-204527-loop13-topic-heading-related-nav.md`
- Audit: `.audit.md` Beh #24

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
```
