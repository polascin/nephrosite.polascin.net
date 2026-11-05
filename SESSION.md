# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #16)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `f67b9df` (docs/handoff commit môže nasledovať)

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky → **neodstraňovať** enforced
  `'unsafe-inline'`.
- Footer badge browser verify: validator.w3.org a mxlinux.org ukazujú
  Cloudflare challenge („Verification successful…“); fedoraproject.org a
  distrowatch.com načítajú plný obsah. Badge odkazy **ponechané** (nie
  dead links; automation 403 = WAF/bot filtering).
- Product ship: cookie-banner same-origin `/privacy` odkazy bez
  `target="_blank"` / `rel`; footer legal odkazy (`/privacy`, `/terms`,
  `#legal-disclaimer`) bez zbytočného `rel="noopener noreferrer"`.
- Remote-only (~69) **nemažeť** bez súhlasu; GH secrets nevytvárané.

## Overené na produkcii

- `csp-report-summary.ps1` → smoke-only; `php tools/test-csp.php` → PASS
- Clean URL smoke (MaximumRedirection 0, Chrome UA): `/` `/privacy`
  `/terms` `/nefrologia` `/transplantacia` → 200 + HSTS + CSP (enforced
  stále s `'unsafe-inline'`)
- Commits `57b5bd7` + `f67b9df`; post-commit SFTP; `deploy.ps1 -Apply`
  0 upload; smoke direct 200
- Produkcia: `/privacy` a `/terms` anchory bez `target="_blank"` a bez
  `rel="noopener noreferrer"` v cookie-banneri aj v päte legal nav
- GHA Deploy `42098848473` + `42099000099` success (rsync skip)

## Poznámky k toolingu

- Commit cez `git -c core.hooksPath=.git/hooks` (globálny GG); ggshield Passed.
- Docs/tools sú v `.deployignore` → SFTP/deploy.ps1 ich na web root neposiela.
- WAF 466 pri krátkom UA; smoke s Chrome UA.
- Pri rewrite: **vždy** `THE_REQUEST` (alebo `[END]`) pre 301 zo cieľa
  interného rewrite.
- Lokálny `tools/deploy.ps1 -Apply` (+ post-commit SFTP) je autoritatívny
  sync, kým chýbajú `DEPLOY_*` secrets.
- ClustrMaps A záznam aj cez 8.8.8.8 / 1.1.1.1 → `127.0.0.1` (nie len lokálny
  sinkhole); outbound link zostáva vypnutý, kým vendor neodžije.
- PowerShell: `$HOME` je rezervované; na HTML response použiť iný názov.
- Externý 403 pri curl/Invoke-WebRequest nie je dôkaz dead linku: overiť
  v reálnom prehliadači (Cloudflare challenge vs 404).

## Ďalší fokus (loop #17)

1. Zbieraj RO telemetriu; drop `'unsafe-inline'` len so strong evidence +
   Clarity/GTM consent paths.
2. Schválený cleanup remote-only (A–C; keep `reports.jsonl`).
3. Voliteľne GH `DEPLOY_*` secrets (mimo repo) alebo ponechať len lokálny deploy.
4. Bug/a11y/links/content ship, ak telemetria stále smoke-only (napr.
   same-origin PDF `target="_blank"` review; remaining external link
   hygiene; content/segment consistency).

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-205907-loop16-cookie-banner-same-origin.md`
- Audit: `.audit.md` Beh #27

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
```
