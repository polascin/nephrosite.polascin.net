# NephroSite: CSP Report-Only

Aktualizácia 5. 11. 2026 (loop #5): Blinker/Blaka/Fenix self-hosted; Google
Fonts hosty odstránené z RO aj enforced CSP. ClustrMaps ostáva.

## Aktívny stav

V `.htaccess` sú súčasne:

1. **Vynucovaná CSP** – povoľuje súhlasom riadenú analytiku (Clarity, GTM,
   Fastbase), ClustrMaps a pozorované GA/Clarity connect/img hosty.
   Fonty: `font-src 'self'` (lokálne WOFF2). Inline skripty/štýly vyžadujú
   `'unsafe-inline'`.
2. **Report-Only CSP** – nič neblokuje; meria prísnejšiu cestu:
   - `script-src 'self'` (bez `'unsafe-inline'`, Clarity, GTM, Fastbase)
   - `connect-src 'self'`
   - `style-src 'self' 'unsafe-inline'`, `font-src 'self'` (bez Google Fonts)
   - ClustrMaps stále povolené, kým ich nelokalizujeme
   - `media-src 'self'`, `frame-src 'self'` (aktuálne videá/iframe sú same-origin)
   - bez `data:` v `img-src` (v markup nie sú `data:` obrázky)

Regresia: `php tools/test-csp.php` (enforced + Report-Only + font audit).

**Nepovýšiť Report-Only do vynucovanej CSP** bez samostatného schválenia:
zlomilo by to inline skripty (cookie dialóg, JSON-LD) a analytiku po súhlase.

## Meranie 5. 11. 2026 (loop #5)

| Zdroj | Dôkaz | Záver |
| --- | --- | --- |
| Google Fonts | `css/fonts.css` + `/fonts/*.woff2` (latin/latin-ext), SIL OFL | Hosty odstránené z RO aj enforced |
| Font files | Blinker 400/600/700, Blaka 400, Fenix 400 | `font-src 'self'` stačí |
| ClustrMaps | `footer.sk.php` → `https://clustrmaps.com/map_v2.png…` + SVG fallback | Host ostáva v RO/enforced; vendor často nedostupný |
| Iframe | `/docs/*.pdf`, `/ipvrm.htm` only | RO `frame-src 'self'`; `sk.polascin.net` v enforced zatiaľ ponechané |
| Media | `/docs/*.mp4` + postery same-origin | RO `media-src 'self'` |
| `data:` obrázky | 0 v 8 PHP stránkach + legal/ipvrm | RO `data:` odstránené |
| Clarity/GTM/Fastbase | `blocks/scripts.sk.php` loadScript ×3 po súhlase | Zámerne mimo RO allowlistu (merateľné) |
| report-uri | žiadny schválený endpoint | Len DevTools/console; bez centrálnej telemetrie |

## Ďalšie kroky

1. ClustrMaps: buď statický snapshot, alebo len SVG/odkaz (vendor nestabilný).
2. Schválený `report-to` endpoint pred ďalším sprísnením.
3. Enforcement `script-src` bez `'unsafe-inline'` až po nonces/hashoch pre
   cookie dialóg a JSON-LD.
