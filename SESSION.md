# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #17)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `068d217`

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky → **neodstraňovať** enforced
  `'unsafe-inline'`.
- Product ship: same-origin PDF policy. Overené, že PDF idú
  `application/pdf` bez `Content-Disposition` (inline, nie download).
  - View odkazy (nadpis prednášky, MEL, KTx/CRRT, regcitra, ipvrm):
    ponechané `target="_blank"` + `rel="noopener noreferrer"` +
    `sr-only` "(PDF, otvorí sa v novom okne)".
  - Odkazy s textom „na stiahnutie“: atribút `download`, bez `_blank`
    (skutočné sťahovanie namiesto falošného open-in-new-tab).
- Remote-only (~69) **nemažeť** bez súhlasu; GH secrets nevytvárané.

## Overené na produkcii

- `csp-report-summary.ps1` → smoke-only; `php tools/test-csp.php` → PASS
- Commit `068d217`; post-commit SFTP; `deploy.ps1 -Apply` 0 upload;
  smoke direct 200
- Clean URL smoke (MaximumRedirection 0, Chrome UA): `/` `/privacy`
  `/terms` `/nefrologia` `/transplantacia` → 200 + HSTS + CSP (enforced
  stále s `'unsafe-inline'`)
- Produkcia `/`: `download=` 6, sr-only PDF hint 11, blank-pdf view 11;
  KTx 2023 (PDF) prítomný
- GHA Deploy `42099959216` success (rsync skip)

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
- Same-origin PDF `_blank` nie je defect pre view; defect bol „na stiahnutie“
  bez `download` (súbory sú inline).

## Ďalší fokus (loop #18)

1. Zbieraj RO telemetriu; drop `'unsafe-inline'` len so strong evidence +
   Clarity/GTM consent paths.
2. Schválený cleanup remote-only (A–C; keep `reports.jsonl`).
3. Voliteľne GH `DEPLOY_*` secrets (mimo repo) alebo ponechať len lokálny deploy.
4. Bug/a11y/links/content ship, ak telemetria stále smoke-only (napr.
   remaining external link hygiene; content/segment consistency;
   GIF fallback size labels).

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-210605-loop17-pdf-open-download.md`
- Audit: `.audit.md` Beh #28

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
```
