# Handoff: loop1-csp-report-only-alt-tokens

## Metadata

- Generated At: 2026-11-05T19:30:52+01:00
- Updated At: 2026-11-05T19:35:00+01:00
- Project Root: D:\Dev\nephrosite.polascin.net
- Git Branch: main
- Head Commit: bb935ad

## Original Goal

Loop iterácia #1: nájsť a úplne opraviť jeden vysokohodnotný defect/set na nephrosite.polascin.net, commit+push na `main`, overiť deploy, napísať handoff, skúsiť Grok spoluprácu.

## Current State

Iterácia #1 dokončená a na produkcii. Repo je na `main` (nie `master`). GH Actions workflow je zelený, ale rsync sa skipuje; skutočné nasadenie išlo cez `tools/deploy.ps1 -Apply`.

## Completed This Session

- Merge `origin/main` (Clarity consent queue, ClustrMaps fallback, vynucovaná CSP) s lokálnymi commitmi dizajnových tokenov a `deploy.ps1`.
- CSP Report-Only v `.htaccess` + regresia v `tools/test-csp.php`.
- A11y: správny `alt` pre `vmppd.gif`; dekoratívne ikony v `lectures.sk.php` a `nephrology.sk.php`.
- `.deployignore`: tooling konfigy a `.codex` mimo web rootu.
- Lokálne nasadenie 40+ súborov vrátane `css/tokens.css`.
- `SESSION.md` + tento Codex handoff.

## Validated

- Command: `php tools/test-csp.php` → PASS (enforced + Report-Only)
- Command: `node tools/test-integrations.cjs` → PASS
- Command: `gh run watch 42084626200` → success (rsync skipped)
- Command: `powershell -ExecutionPolicy Bypass -File .\tools\deploy.ps1 -Apply` → SHA-256 OK, smoke 200
- Command: `curl -sIL -A "Mozilla/5.0 …Chrome/120…" https://nephrosite.polascin.net/` → 200, CSP + CSP-Report-Only, HSTS a ostatné hlavičky
- Command: `curl -sI …/css/tokens.css` → 200, text/css, 4472 B
- Spot-check HTML: tokens link, vmppd alt, aria-hidden ikony

## Not Yet Validated

- Assumption: Report-Only CSP zachytí reálne Fonts/ClustrMaps violationy v prehliadači používateľov (zatiaľ bez report-uri endpointu, len konzola).
- Risk: bez `report-uri`/`report-to` sa meranie robí len manuálne; automatické agregovanie chýba.
- Assumption: remote-only zvyšky (`.git`, phar v `tools/`) na serveri sú staré a neškodné; cleanup nebol schválený.
- Risk: ak by niekto sprístupnil `.git`, únik histórie; `.htaccess` `.git` blokuje, ale adresár by mal zmiznúť.

## Remaining Work

- [ ] Loop #2: prekódovať zvyšné 3–7 MB GIF slidy na MP4+poster (`fosdl`, `foazo`, `ktx`, `aem`, `vmppd`).
- [ ] Vyhodnotiť Report-Only merania a lokalizovať Google Fonts / ClustrMaps.
- [ ] Po schválení: cleanup remote-only súborov v web roote.
- [ ] Doplniť DEPLOY_* secrets alebo oficiálne uznať `deploy.ps1` ako primárnu cestu.

## Decisions Made

- Decision: Default vetva je `main` (nie `master` z Cursor rule / starého promptu).
- Reason: `.doaudit.md` a GitHub `origin/HEAD` potvrdzujú premenovanie 21. 9. 2026.
- Decision: Pri skipnutom GH rsyncu nasadzovať `tools/deploy.ps1 -Apply`.
- Reason: AGENTS.md preferuje lokálne nástroje; skript bol overený na produkcii.
- Decision: Report-Only CSP nechať striktnú na `script-src 'self'` pri zachovaní Fonts/ClustrMaps v RO politike.
- Reason: Meranie pred lokalizáciou bez blokovania produkcie.

## Blockers / Open Questions

- Grok boty: žiadny NephroSite analytický kanál (len Grok Bot Zarábač / xAI billing). Nespolupracované, zdokumentované.
- Todoist MCP: `needsAuth` – neautorizované v tejto session.
- Či mazať remote `.git` / `tools/*.phar` vyžaduje výslovný súhlas (pravidlo 4 AGENTS.md).

## Critical Files

- `.htaccess` – enforced + Report-Only CSP
- `blocks/lectures.sk.php`, `blocks/nephrology.sk.php` – alt/a11y
- `css/tokens.css`, `blocks/links.sk.php`, `blocks/styles.css.php`, `files/legal.css`
- `tools/deploy.ps1`, `tools/test-csp.php`, `tools/test-integrations.cjs`
- `.deployignore`, `.audit.md`, `SESSION.md`

## Recent Commits

- 9a1e296 Mark nephrology header kidney icons as decorative and record deploy proof
- 3433ada Exclude local tooling configs from production deploy payload
- 260a254 Add CSP Report-Only, fix lecture alt texts, merge Clarity/tokens onto main
- 2abdfdd Merge origin/main: consent-gated Clarity, ClustrMaps fallback, enforced CSP
- 1cf0335 Fix consent-gated Clarity and resilient visitor map; record enforced CSP [skip deploy]

## Modified Files

- Working tree by mal byť čistý po commite handoff/SESSION; overiť `git status`.

## Context To Load

- `SESSION.md`
- `.audit.md` (Beh #12)
- `.doaudit.md`
- `.codex/handoffs/2026-11-05-193052-loop1-csp-report-only-alt-tokens.md`
- `DEPLOY.md`

## Next Command

```text
powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1
php tools/test-csp.php
```

## Resume Prompt

```text
Najprv načítaj SESSION.md, .audit.md, .doaudit.md a .codex/handoffs/2026-11-05-193052-loop1-csp-report-only-alt-tokens.md.
Pokračuj loop #2 NephroSite: prekóduj zvyšné veľké GIF slidy (fosdl/foazo/ktx/aem/vmppd) na MP4+poster podľa vzoru nephrogame, alebo vyber vyšší prioritu podľa fresh auditu.
Prvý krok: powershell -NoProfile -ExecutionPolicy Bypass -File .\tools\deploy.ps1; php tools/test-csp.php
```
