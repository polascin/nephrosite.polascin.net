# NephroSite: CSP Report-Only

Aktualizácia 5. 11. 2026 (loop #6): ClustrMaps lokalizované na first-party SVG;
`clustrmaps.com` odstránené z RO aj enforced CSP. Google Fonts self-hosted
(loop #5).

## Aktívny stav

V `.htaccess` sú súčasne:

1. **Vynucovaná CSP** – povoľuje súhlasom riadenú analytiku (Clarity, GTM,
   Fastbase) a pozorované GA/Clarity connect/img hosty.
   Fonty: `font-src 'self'` (lokálne WOFF2). Mapa návštev: same-origin SVG.
   Inline skripty/štýly vyžadujú `'unsafe-inline'`.
2. **Report-Only CSP** – nič neblokuje; meria prísnejšiu cestu:
   - `script-src 'self'` (bez `'unsafe-inline'`, Clarity, GTM, Fastbase)
   - `connect-src 'self'`
   - `style-src 'self' 'unsafe-inline'`, `font-src 'self'` (bez Google Fonts)
   - `img-src 'self' https://polascin.net` (bez clustrmaps.com)
   - `media-src 'self'`, `frame-src 'self'` (aktuálne videá/iframe sú same-origin)
   - bez `data:` v `img-src` (v markup nie sú `data:` obrázky)

Regresia: `php tools/test-csp.php` (enforced + Report-Only + font/map audit).

**Nepovýšiť Report-Only do vynucovanej CSP** bez samostatného schválenia:
zlomilo by to inline skripty (cookie dialóg, JSON-LD) a analytiku po súhlase.

## Meranie 5. 11. 2026 (loop #6)

| Zdroj | Dôkaz | Záver |
| --- | --- | --- |
| Google Fonts | `css/fonts.css` + `/fonts/*.woff2` (latin/latin-ext), SIL OFL | Hosty odstránené z RO aj enforced |
| Font files | Blinker 400/600/700, Blaka 400, Fenix 400 | `font-src 'self'` stačí |
| ClustrMaps | `footer.sk.php` → `/pix/clustrmaps-visitor-map.svg` + odkaz na site | Host odstránený; vendor connection refused; PNG snapshot nedostupný |
| Iframe | `/docs/*.pdf`, `/ipvrm.htm` only | RO `frame-src 'self'`; `sk.polascin.net` v enforced zatiaľ ponechané |
| Media | `/docs/*.mp4` + postery same-origin | RO `media-src 'self'` |
| `data:` obrázky | 0 v 8 PHP stránkach + legal/ipvrm | RO `data:` odstránené |
| Clarity/GTM/Fastbase | `blocks/scripts.sk.php` loadScript ×3 po súhlase | Zámerne mimo RO allowlistu (merateľné) |
| report-uri | žiadny schválený endpoint | Len DevTools/console; bez centrálnej telemetrie |

## Ďalšie kroky

1. Schválený `report-to` endpoint pred ďalším sprísnením.
2. Enforcement `script-src` bez `'unsafe-inline'` až po nonces/hashoch pre
   cookie dialóg a JSON-LD.
3. Po schválení: cleanup remote-only zvyškov (~68).
