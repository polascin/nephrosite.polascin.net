# NephroSite: CSP Report-Only

Aktualizácia 5. 11. 2026 (loop #7): first-party CSP reporting
(`/csp-report.php`, `report-uri` + `report-to` / `Reporting-Endpoints`) a
nonce helper na PHP stránkach. Loop #6: ClustrMaps first-party SVG.
Loop #5: Google Fonts self-hosted.

## Aktívny stav

V `.htaccess` sú súčasne:

1. **Vynucovaná CSP** – povoľuje súhlasom riadenú analytiku (Clarity, GTM,
   Fastbase) a pozorované GA/Clarity connect/img hosty.
   Fonty: `font-src 'self'` (lokálne WOFF2). Mapa návštev: same-origin SVG.
   Inline skripty/štýly vyžadujú `'unsafe-inline'`.
   Reporting: `report-uri /csp-report.php; report-to csp`.
2. **Report-Only CSP** – nič neblokuje; meria prísnejšiu cestu:
   - `script-src 'self'` (bez `'unsafe-inline'`, Clarity, GTM, Fastbase)
   - `connect-src 'self'`
   - `style-src 'self' 'unsafe-inline'`, `font-src 'self'` (bez Google Fonts)
   - `img-src 'self' https://polascin.net` (bez clustrmaps.com)
   - `media-src 'self'`, `frame-src 'self'` (aktuálne videá/iframe sú same-origin)
   - bez `data:` v `img-src` (v markup nie sú `data:` obrázky)
   - rovnaký reporting endpoint ako enforced
3. **Reporting-Endpoints** – `csp="/csp-report.php"` (Chromium Reporting API).
4. **Endpoint** – `csp-report.php` (POST, max 8 KiB, sanitizovaný JSONL do
   `private/csp-reports/`, HTTP prístup do `private/` zakázaný).

Regresia: `php tools/test-csp.php` (enforced + Report-Only + reporting +
nonce helper + font/map audit).

**Nepovýšiť Report-Only do vynucovanej CSP** bez samostatného schválenia:
zlomilo by to inline skripty (cookie dialóg, JSON-LD) a analytiku po súhlase.

## Nonce príprava (loop #7)

- `blocks/csp-nonce.php` generuje jeden nonce na request.
- Inline `<script>` v `metatags.sk.php`, `scripts.sk.php`, `current.sk.php`
  už emitú `nonce="…"`.
- CSP header stále používa `'unsafe-inline'`: statické `.htaccess` nevie
  vložiť request-scoped nonce. Ďalší krok: bootstrap PHP, ktorý pošle
  `Content-Security-Policy` s `'nonce-…'` pred výstupom HTML, a až potom
  odstrániť `'unsafe-inline'` zo `script-src`.

## Meranie 5. 11. 2026

| Zdroj | Dôkaz | Záver |
| --- | --- | --- |
| Google Fonts | `css/fonts.css` + `/fonts/*.woff2` (latin/latin-ext), SIL OFL | Hosty odstránené z RO aj enforced |
| Font files | Blinker 400/600/700, Blaka 400, Fenix 400 | `font-src 'self'` stačí |
| ClustrMaps | `footer.sk.php` → `/pix/clustrmaps-visitor-map.svg` + odkaz na site | Host odstránený; vendor connection refused; PNG snapshot nedostupný |
| Iframe | `/docs/*.pdf`, `/ipvrm.htm` only | RO `frame-src 'self'`; `sk.polascin.net` v enforced zatiaľ ponechané |
| Media | `/docs/*.mp4` + postery same-origin | RO `media-src 'self'` |
| `data:` obrázky | 0 v 8 PHP stránkach + legal/ipvrm | RO `data:` odstránené |
| Clarity/GTM/Fastbase | `blocks/scripts.sk.php` loadScript ×3 po súhlase | Zámerne mimo RO allowlistu (merateľné) |
| report-uri / report-to | `/csp-report.php` + group `csp` | First-party sink; log v `private/csp-reports/` |

## Ďalšie kroky

1. PHP bootstrap: emitovať CSP s `'nonce-…'`, potom zúžiť enforced
   `script-src` (odstrániť `'unsafe-inline'` len keď RO telemetria potvrdí
   čistotu).
2. Po schválení: cleanup remote-only zvyškov (~68).
3. Oficiálne uznať `deploy.ps1` / opraviť GH secrets.
4. Voliteľne zosúladiť hosting CSP na `/privacy.php`/`/files/*.html`.
