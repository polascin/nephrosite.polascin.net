# NephroSite: CSP Report-Only

Aktualizácia 5. 11. 2026 (loop #9): RO telemetria cez SSH je príliš čerstvá
(2 riadky, oba smoke/test; žiadne reálne Clarity/GTM vzorky). Enforced
`'unsafe-inline'` ostáva. Pridaný `tools/csp-report-summary.ps1`.
Loop #8: hybrid PHP/Apache CSP + Report-Only nonce. Loop #7: reporting
endpoint. Loop #6: ClustrMaps SVG. Loop #5: self-host fontov.

## Aktívny stav

1. **Vynucovaná CSP (PHP + static)** – povoľuje súhlasom riadenú analytiku
   (Clarity, GTM, Fastbase) a pozorované GA/Clarity connect/img hosty.
   Fonty: `font-src 'self'`. Mapa návštev: same-origin SVG.
   Inline skripty/štýly vyžadujú `'unsafe-inline'`.
   **Bez `'nonce-…'` v enforced** (CSP3 by pri nonci ignorovalo `'unsafe-inline'`).
   Reporting: `report-uri /csp-report.php; report-to csp`.
2. **Report-Only CSP**
   - Static (`.htaccess`): `script-src 'self'` (bez nonce, bez analytiky).
   - PHP (`csp-bootstrap.php`): `script-src 'self' 'nonce-…'` (meranie
     first-party nonced inline skriptov pred enforcement).
   - Spoločné: `connect-src 'self'`; `style-src 'self' 'unsafe-inline'`;
     `font-src 'self'`; `img-src 'self' https://polascin.net`;
     `media-src`/`frame-src 'self'`; rovnaký reporting endpoint.
3. **Reporting-Endpoints** – `csp="/csp-report.php"` (globálne v `.htaccess`).
4. **Endpoint** – `csp-report.php` (POST, max 8 KiB, JSONL v
   `private/csp-reports/`).

Hybrid: Apache CSP len pre `FilesMatch` statických prípon; PHP dokumenty
volajú `nephrosite_csp_send_headers()` z `index.php` / `topic-page.php`.

Regresia: `php tools/test-csp.php`.

**Nepovýšiť Report-Only do vynucovanej CSP** bez samostatného schválenia a
RO telemetrie: zlomilo by to analytiku po súhlase (a CSP3 + nonce by vypol
`'unsafe-inline'`).

## Nonce + bootstrap (loop #7 → #8)

- `blocks/csp-nonce.php` – jeden nonce na request; markup v metatags /
  scripts / current.sk.
- `blocks/csp-bootstrap.php` – enforced (s `'unsafe-inline'`, bez nonce) +
  Report-Only (s matching `'nonce-…'`).
- Ďalší krok: po čistej RO telemetrii zvážiť `'strict-dynamic'` / odstránenie
  `'unsafe-inline'` z enforced `script-src`.

## Meranie 5. 11. 2026

| Zdroj | Dôkaz | Záver |
| --- | --- | --- |
| Google Fonts | `css/fonts.css` + `/fonts/*.woff2` | Hosty odstránené |
| ClustrMaps | first-party SVG | Host odstránený |
| Clarity/GTM/Fastbase | `loadScript` ×3 po súhlase | Mimo RO allowlistu |
| report-uri / report-to | `/csp-report.php` + group `csp` | First-party sink |
| PHP nonce RO | `csp-bootstrap.php` | Meranie first-party inline |

## Telemetria 5. 11. 2026 (loop #9)

Čítané cez SSH z `private/csp-reports/reports.jsonl` (HTTP 403 zámerne).
Súhrn: `powershell -File .\tools\csp-report-summary.ps1`.

| ts (UTC) | blocked-uri | disposition | poznámka |
| --- | --- | --- | --- |
| 19:09:00 | `https://evil.example/x.js` | report | smoke POST z loop #7/#8 |
| 19:16:05 | `inline` | (prázdne) | bez `script-sample` / `source-file`; smoke marker |

**Záver:** žiadne reálne prehliadačové RO porušenia. **Neodstraňovať**
enforced `'unsafe-inline'` v tomto cykle. Consent Clarity/GTM cesty ostávajú
mimo RO allowlistu a ešte neboli overené živou telemetriou.

## Ďalšie kroky

1. Zbieraj RO telemetriu (`csp-report-summary.ps1`) → drop `'unsafe-inline'`
   len so strong evidence vrátane Clarity/GTM po súhlase.
2. Po schválení: cleanup remote-only (pozri `docs/REMOTE-ONLY-INVENTORY.md`).
3. Oficiálne uznať `deploy.ps1` / opraviť GH secrets.
