# Handoff: loop4-csp-report-only-fonts

## Metadata

- Generated At: 2026-11-05T19:50:59+01:00
- Updated At: 2026-11-05T19:52:00+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: 59fdc4c (docs/handoff commit môže nasledovať)

## Original Goal

Loop iterácia #4: vyhodnotiť CSP Report-Only voči live potrebám (Fonts,
ClustrMaps/Clarity), sprísniť Report-Only len s dôkazom; neblind-promote do
enforced CSP. Commit + push + `tools/deploy.ps1 -Apply` + smoke.

## Current State

Iterácia #4 dokončená a na produkcii. Report-Only sprísnený (media/frame
same-origin, bez `data:`, script-src stále `'self'`). Deväť nepoužitých Google
Fontov odstránených; live ostáva jeden combined stylesheet Blinker|Blaka|Fenix.
Vynucovaná CSP nezmenená. Repo na `main` @ `59fdc4c`.

## Completed This Session

- Audit enforced vs Report-Only vs markup (8 PHP stránok + legal/ipvrm).
- Report-Only: pridané `media-src 'self'`, `frame-src 'self'`; odstránené `data:`;
  Clarity/GTM/Fastbase ostávajú mimo allowlistu; Fonts + ClustrMaps ponechané.
- `blocks/links.sk.php`: 12 font linkov → 1 (`Blinker|Blaka|Fenix&display=swap`).
- `tools/test-csp.php`: prísnejšie RO + font-family assertions.
- `docs/CSP-REPORT-ONLY.md` prepis na aktuálne meranie.

## Validated

- Command: `php tools/test-csp.php` → PASS
- Command: `git -c core.hooksPath=.git/hooks commit` → `59fdc4c`; post-commit SFTP
  upload `.htaccess` + `blocks/links.sk.php`; skip docs/tools (deployignore)
- Command: `git push origin main` → HEAD = origin/main = `59fdc4c`
- Command: `tools/deploy.ps1 -Apply` → 0 upload, smoke `/` + `/privacy.php` 200
- Command: curl Chrome UA `/` → 200; enforced CSP nezmenená; RO bez `data:`,
  s `media-src`/`frame-src`, bez clarity/gtm; HTML má 1 font CSS, 0 Archivo/…
- Command: `/docs/mel.pdf` → 200 application/pdf
- Risk accepted: ClustrMaps vendor stále často nedostupný (http 000); SVG fallback

## Not Yet Validated

- Assumption: DevTools RO violations po súhlase ukážu Clarity/GTM/inline (bez
  report-uri endpointu nie je centrálna telemetria).
- Assumption: `display=swap` nemení vizuál rodín Blinker/Blaka/Fenix.
- Risk: remote-only junk (68) stále na serveri; cleanup neschválený.
- Assumption: GH Actions deploy stále bez `DEPLOY_*` secrets.

## Remaining Work

- [ ] Loop #5: self-host Blinker/Blaka/Fenix (WOFF2 + lokálne CSS) → odstrániť
      `fonts.googleapis.com` / `fonts.gstatic.com` z RO aj enforced.
- [ ] ClustrMaps: statický snapshot alebo len SVG/odkaz (vendor nestabilný).
- [ ] Po schválení: cleanup 68 remote-only (`.git`, `tools/*.phar`, encoder,
      SESSION.md, `.cursor`, …) — zoznam z `deploy.ps1`.
- [ ] Schválený `report-to` pred ďalším sprísnením script-src.
- [ ] Enforcement bez `'unsafe-inline'` až po nonces/hashoch.
- [ ] Oficiálne uznať `deploy.ps1` / opraviť GH secrets.
- [ ] Globálny GitGuardian hooksPath / `ggshield` CLI (tento commit prešiel
      ggshield Passed; workaround `hooksPath=.git/hooks` stále dokumentovaný).

## Decisions Made

- Decision: Nepovýšiť RO `script-src 'self'` do enforced.
- Reason: Zlomilo by inline cookie dialóg/JSON-LD a consent-gated analytiku.
- Decision: Odstrániť 9 nepoužitých Google Fontov namiesto plnej lokalizácie teraz.
- Reason: CSS audit: tokens/styles používajú len Blinker, Blaka, Fenix; rýchly
  perf/CSP win bez font file licensing kroku.
- Decision: RO `frame-src 'self'` bez `sk.polascin.net`.
- Reason: Aktuálne iframe sú len same-origin PDF/ipvrm; sk.polascin ostáva v
  enforced pre prípadné budúce embedy.
- Decision: Remote-only nemazať.
- Reason: Používateľ v tejto konverzácii cleanup neschválil.

## Blockers / Open Questions

- Explicitný súhlas na mazanie 68 remote-only stále chýba.
- Žiadny schválený CSP report endpoint.
- Grok NephroSite kanál stále neexistuje (z loop #1).

## Critical Files

- `.htaccess` – enforced + Report-Only CSP
- `blocks/links.sk.php` – Google Fonts (3 families)
- `tools/test-csp.php` – RO + font regressie
- `docs/CSP-REPORT-ONLY.md` – meranie a ďalšie kroky
- `SESSION.md`, `.audit.md`

## Recent Commits

- 59fdc4c Tighten CSP Report-Only and drop nine unused Google Fonts.
- fd6bd8d Document loop #3 foazosszu MP4 delivery and deployignore hook handoff.
- 1a2f1c2 Honor .deployignore in post-commit SFTP so tooling never uploads to web root.
- 0def63b Serve foazosszu 2023 slides as MP4 with posters instead of multi-megabyte GIFs.
- 64d84c2 Document loop #2 GIF-to-MP4 delivery and hand off to loop #3.

## Modified Files

- Po docs/handoff commite: SESSION.md, .audit.md,
  `.codex/handoffs/2026-11-05-195059-loop4-csp-report-only-fonts.md`

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #15)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-195059-loop4-csp-report-only-fonts.md`
- `docs/CSP-REPORT-ONLY.md`
- `.htaccess`

## Next Command

```text
# Loop #5: self-host Blinker/Blaka/Fenix, then drop Google Fonts from CSP.
# Or, after explicit user approval, clean remote-only junk listed by deploy.ps1.
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1
php tools\test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-195059-loop4-csp-report-only-fonts.md.
Pokračuj loop #5 NephroSite: self-host Blinker/Blaka/Fenix a odstráň Google Fonts z RO+enforced CSP, alebo po výslovnom súhlase uprac 68 remote-only súborov.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1; php tools\test-csp.php
Commituj cez: git -c core.hooksPath=.git/hooks commit …
```

## Remote-only inventory (awaiting approval; do NOT delete)

From `deploy.ps1 -Apply` (68): `.git/**`, `.deployignore`, `.gitignore`,
`.gitattributes`, `.audit.md`, `SESSION.md`, `.cursor/rules/…`,
`.codex/handoffs/…`, `.github/workflows/deploy.yml`, `phpstan*.neon*`,
`tools/*.phar`, `tools/encode-lecture-gifs.py`, `tools/quality.ps1`,
`tools/install-dev-tools.ps1`, `tools/README.md`, `tools/.htaccess`.
