# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #19)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `e3c2995`

## Čo je hotové v tejto iterácii

- RO telemetria: stále **2 smoke/test** riadky → **neodstraňovať** enforced
  `'unsafe-inline'`.
- Product ship: a11y pre externé `target="_blank"` odkazy.
  Overené: na `/` 155× `_blank`, z toho 11 PDF so sr-only hintom a
  **144 externých bez** „otvorí sa v novom okne“.
  - `ensureExternalBlankLinksAreSafe()`: dopĺňa
    `.sr-only.sr-only-new-window` ak hint chýba (noopener ostáva).
  - Statické hinty: archive-notice, intro (vek/LinkedIn/Amazon),
    current (beat/čas), `terms.html` (+ `.sr-only` v `files/legal.css`).
  - Promo logo `alt`: skratky → plné názvy z `title`; druhé logo
    dekoratívne `alt=""`; ISN „Nephrology“; NKF title.
- Externé URL spot-check (GET/Chrome UA): Martinus 33 OK; 403/405/999
  (LinkedIn, time.is HEAD, OUP) = bot/method noise, nie dead link.
- Remote-only (~69) **nemažeť** bez súhlasu; GH secrets nevytvárané.

## Overené na produkcii

- `csp-report-summary.ps1` → smoke-only; `php tools/test-csp.php` → PASS
- Commit `e3c2995`; post-commit SFTP; `deploy.ps1 -Apply` 0 upload;
  smoke direct 200
- Clean URL smoke (MaximumRedirection 0, Chrome UA): `/` `/privacy`
  `/terms` `/nefrologia` `/transplantacia` → 200 + HSTS + CSP (enforced
  stále s `'unsafe-inline'`)
- Produkcia `/`: staticHintMentions=18, pdfHints=11,
  jsHelperMarker=True, promoFullAlt=True, oldSnesAlt=False,
  linkedinAlt=True; `/terms` hints=2
- GHA Deploy `42102196491` success (rsync skip)

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
  bez `download` (súbory sú inline). To isté platí pre GIF fallbacky.
- Martinus HEAD 404 / soft „nenájden“ v HTML môže byť falošný; overiť
  `<title>` produktovej stránky cez GET.

## Ďalší fokus (loop #20)

1. Zbieraj RO telemetriu; drop `'unsafe-inline'` len so strong evidence +
   Clarity/GTM consent paths.
2. Schválený cleanup remote-only (A–C; keep `reports.jsonl`).
3. Voliteľne GH `DEPLOY_*` secrets (mimo repo) alebo ponechať len lokálny deploy.
4. Bug/a11y/content ship, ak telemetria stále smoke-only (napr. content
   consistency; static new-window hinty v lectures bez JS; title polish).

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-211946-loop19-external-blank-a11y.md`
- Audit: `.audit.md` Beh #30

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\csp-report-summary.ps1
php tools/test-csp.php
```
