# NephroSite: CSP Report-Only

Aktualizácia 5. 11. 2026 (loop #4): Report-Only sprísnený podľa merania
markup/hostov. Vynucovaná CSP ostáva nezmenená.

## Aktívny stav

V `.htaccess` sú súčasne:

1. **Vynucovaná CSP** – povoľuje súhlasom riadenú analytiku (Clarity, GTM,
   Fastbase), Google Fonts, ClustrMaps a pozorované GA/Clarity connect/img hosty.
   Inline skripty/štýly vyžadujú `'unsafe-inline'`.
2. **Report-Only CSP** – nič neblokuje; meria prísnejšiu cestu:
   - `script-src 'self'` (bez `'unsafe-inline'`, Clarity, GTM, Fastbase)
   - `connect-src 'self'`
   - Google Fonts + ClustrMaps stále povolené, kým ich nelokalizujeme
   - `media-src 'self'`, `frame-src 'self'` (aktuálne videá/iframe sú same-origin)
   - bez `data:` v `img-src` (v markup nie sú `data:` obrázky)

Regresia: `php tools/test-csp.php` (enforced + Report-Only + font audit).

**Nepovýšiť Report-Only do vynucovanej CSP** bez samostatného schválenia:
zlomilo by to inline skripty (cookie dialóg, JSON-LD) a analytiku po súhlase.

## Meranie 5. 11. 2026

| Zdroj | Dôkaz | Záver |
| --- | --- | --- |
| Google Fonts | `css/tokens.css` + `styles.css.php` používajú len Blinker, Blaka, Fenix | 9 nepoužitých `<link>` odstránených; 1 combined stylesheet |
| Font files | Blinker CSS ťahá WOFF2 z `fonts.gstatic.com` | RO/enforced `font-src` ostáva |
| ClustrMaps | `footer.sk.php` → `https://clustrmaps.com/map_v2.png…` + SVG fallback | Host ostáva v RO/enforced; vendor často nedostupný (http 000/fallback) |
| Iframe | `/docs/*.pdf`, `/ipvrm.htm` only | RO `frame-src 'self'`; `sk.polascin.net` v enforced zatiaľ ponechané |
| Media | `/docs/*.mp4` + postery same-origin | RO `media-src 'self'` |
| `data:` obrázky | 0 v 8 PHP stránkach + legal/ipvrm | RO `data:` odstránené |
| Clarity/GTM/Fastbase | `blocks/scripts.sk.php` loadScript ×3 po súhlase | Zámerne mimo RO allowlistu (merateľné) |
| report-uri | žiadny schválený endpoint | Len DevTools/console; bez centrálnej telemetrie |

Produkčné hlavičky (Chrome UA): `/` 200, enforced CSP + CSP-Report-Only + HSTS.
`/files/privacy.html` má hostingovú vynucovanú CSP; naše Report-Only ostáva.

## Historický kandidát (11. 10. 2026)

Nasledujúci riadok bol prednasadzovací návrh (už neplatí ako aktívna politika):

```text
Content-Security-Policy-Report-Only: default-src 'self'; base-uri 'self'; object-src 'none'; frame-ancestors 'self'; form-action 'self'; script-src 'self' 'unsafe-inline' https://www.googletagmanager.com https://www.clarity.ms https://fastbase.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' https://polascin.net https://clustrmaps.com https://www.google.sk; frame-src 'self' https://sk.polascin.net; media-src 'self'; connect-src 'self' https://region1.analytics.google.com https://stats.g.doubleclick.net
```

## Ďalšie kroky

1. Self-host Blinker/Blaka/Fenix (WOFF2 + lokálne CSS) → potom odstrániť
   `fonts.googleapis.com` / `fonts.gstatic.com` z RO aj enforced.
2. ClustrMaps: buď statický snapshot, alebo len SVG/odkaz (vendor nestabilný).
3. Schválený `report-to` endpoint pred ďalším sprísnením.
4. Enforcement `script-src` bez `'unsafe-inline'` až po nonces/hashoch pre
   cookie dialóg a JSON-LD.
