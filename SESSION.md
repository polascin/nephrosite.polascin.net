# SESSION – NephroSite loop handoff

Aktualizované: 2026-11-05 (loop iterácia #1)
Vetva: `main` (nie `master`; premenované 21. 9. 2026)
HEAD: `9a1e296`

## Čo je hotové v tejto iterácii

- Zlúčená divergencia `main` (dizajnové tokeny + Clarity/ClustrMaps/CSP).
- Pridaná `Content-Security-Policy-Report-Only` popri vynucovanej CSP.
- Opravený nesprávny `alt` pri `vmppd.gif`; dekoratívne ikony obličiek bez anglických altov (`lectures.sk.php`, `nephrology.sk.php`).
- Nasadené `css/tokens.css` (predtým 404 na produkcii pri lokálnom odkaze).
- `.deployignore` vylučuje tooling konfigy (`.pre-commit-config.yaml` a pod.).
- Produkcia nasadená lokálne cez `tools/deploy.ps1 -Apply` (GH Actions rsync skipped kvôli chýbajúcim secrets).

## Overené na produkcii

- `https://nephrosite.polascin.net/` → 200, bezpečnostné hlavičky, CSP + CSP-Report-Only
- `/css/tokens.css` → 200
- Spot-check: tokens link, vmppd alt, aria-hidden ikony

## Grok / xAI

Žiadny NephroSite kanál. Nájdený len Grok Bot Zarábač (biznis briefing) a xAI faktúry. Todoist MCP needsAuth.

## Ďalší fokus (loop #2)

1. Prekódovať zvyšné veľké GIF slidy (3–7 MB) na MP4+poster ako `nephrogame`.
2. Vyhodnotiť Report-Only CSP (Fonts/ClustrMaps) a prípadne lokalizovať.
3. Schválený cleanup remote-only zvyškov (`.git`, `tools/*.phar` v web roote).

## Handoff súbory

- Codex: `.codex/handoffs/2026-11-05-193052-loop1-csp-report-only-alt-tokens.md`
- Audit: `.audit.md` Beh #12

## Ďalší príkaz

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1
php tools/test-csp.php
```
