# NephroSite: kandidát CSP Report-Only

**Iba návrh, bez aktívnej hlavičky, enforcementu a produkčného deployu.**
Rozsah je `nephrosite.polascin.net`; AlphaGrab rieši samostatný PR.

## Zdrojové dôkazy

Aktuálny remote `main` a východisková vetva po `git fetch origin main`
11. 10. 2026: `e551076a27f81b4dc88957beaab810733c8b6b84`.
`AGENTS.md` sa v pracovnom strome ani v zozname koreňa GitHub `main` nenachádza.
Načítané pravidlá: `.agent.md`, `.cursor/rules/commit-push-deploy.mdc`,
`DEPLOY.md`, `.github/workflows/deploy.yml`, `.deployignore`.
Výslovný pokyn pripraviť PR bez deployu má prednosť pred starým pravidlom
o priamom pushi na `master`; aktuálny deploy workflow používa `main`.

`.htaccess` neobsahuje CSP. Šablóny nemajú meta CSP. Nejde o SPA:
homepage a sedem tematických stránok sú generované cez PHP includes.

- Inline skripty: `blocks/current.sk.php`, `blocks/scripts.sk.php`;
  štruktúrované JSON-LD: `blocks/metatags.sk.php`.
- Inline CSS: `blocks/styles.css.php`, štýlové atribúty v obsahových fragmentoch.
- Google Fonts: `blocks/links.sk.php` načítava CSS z `fonts.googleapis.com`;
  získané CSS pre Blinker odkazuje na WOFF2 na `fonts.gstatic.com`.
- Po analytickom súhlase: tri Clarity tagy na `www.clarity.ms` a Google tag
  na `www.googletagmanager.com`. Po marketingovom súhlase: `fastbase.com`.
- Obrázky: same-origin, `polascin.net`, `clustrmaps.com`.
- Iframe: same-origin PDF a `/ipvrm.htm`, PDF z `sk.polascin.net`.
  Video `/docs/nephrogame.mp4` je same-origin.
- Právne HTML používa externé same-origin CSS a JS. Nie je menené.

Externé navigačné odkazy nie sú automaticky zdrojmi pre `default-src`.
Nepovoľujeme ich všetky ani plošné `https:` či `*`.

## Produkčné dôkazy

Kontrola 11. 10. 2026 približne 16:26–16:28 UTC cez HTTP GET s plným Chrome
UA a browser canvas (Chrome/Edge 154, Windows):

- `/`, `/dialyza.php`, `/ipvrm.htm`: HTTP 200, bez CSP aj CSP-Report-Only.
- `/files/privacy.html`, `/files/terms.html`: HTTP 200, **majú vynucovanú CSP**
  od hostingu. Tá má `default-src 'self'`, explicitné Google zdroje,
  `img-src 'self' data: https:`, `object-src 'none'`, `frame-ancestors 'self'`
  a `upgrade-insecure-requests`. Nie je to jednoduchá dvojdirektívová politika
  zo staršieho záznamu v `.audit.md`; neprepisovať ani neoslabovať.
- `/privacy` a `/privacy.php`: HTTP 301 na `/files/privacy.html`.
  Meta CSP chýba v HTML homepage, dialýzy aj oboch právnych stránok.
- Homepage DOM: tri inline script elementy, 13 stylesheetov, štyri iframe.
  Čerstvý stav aj „Len nevyhnutné“: žiadne externé script elementy.
- Po „Prijať všetko“: načítavanie Clarity, Google tag a Fastbase;
  Resource Timing zaznamenal `region1.analytics.google.com` (fetch),
  `stats.g.doubleclick.net` (beacon), `www.google.sk` (img).
  Voľba bola následne vrátená na „Len nevyhnutné“.
- Právna privacy stránka v browseri: `/files/legal.css` načítané,
  `/files/privacy-consent.js` externý, bez inline štýlov; text `rgb(34, 34, 34)`
  na bielom pozadí. Existujúca CSP sa ponecháva.

Resource Timing dokazuje pokus o request, nie jeho úspešné dokončenie.
Prehliadač vykázal načítané fonty Fenix/Blinker/Blaka, ale viaceré externé
obrázky mali `naturalWidth = 0`. Nebolo to vyvolané týmto PR ani CSP na PHP.
Nie všetky Clarity/Fastbase následné requesty alebo geografické Google hosty
sa museli objaviť v krátkom meraní. Ich funkčnosť ostáva podmienkou pilotu.

**Nasadený SHA neoverený:** posledný úspešný workflow pre uvedený SHA,
[run 35640300351](https://github.com/polascin/nephrosite.polascin.net/actions/runs/35640300351),
má Prepare SSH, rsync aj smoke test **skipped**. Zelený workflow neznamená
nasadenie. Verejný release marker nebol identifikovaný; PHP generovaný čas
sa nepovažuje za obsahový ani release marker.

## Kandidát

Nasledujúci jediný riadok je vstupom regresného testu, nie konfiguráciou:

```text
Content-Security-Policy-Report-Only: default-src 'self'; base-uri 'self'; object-src 'none'; frame-ancestors 'self'; form-action 'self'; script-src 'self' 'unsafe-inline' https://www.googletagmanager.com https://www.clarity.ms https://fastbase.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' https://polascin.net https://clustrmaps.com https://www.google.sk; frame-src 'self' https://sk.polascin.net; media-src 'self'; connect-src 'self' https://region1.analytics.google.com https://stats.g.doubleclick.net
```

Bez vymysleného `report-uri` alebo `report-to`: automatický zber reportov
nie je pripravený. Bez endpointu nemožno tvrdiť, že vzniká centrálna telemetria;
lokálne DevTools/violation udalosti nie sú náhradou za reprezentatívny pilot.
Zber vyžaduje schváleného vlastníka, retenčnú politiku a kontrolu osobných údajov
v reportovaných URL. Report-only nemožno aplikovať cez meta tag.

`'unsafe-inline'` je vedomý prechodný kompromis pre existujúce inline bloky
a atribúty; kandidát nepridáva `unsafe-eval`, nonce ani neoverené hash hodnoty.
`connect-src` je úzky **pozorovaný kandidát**, nie úplný zoznam vendor hostov.
Neznáme requesty majú pri pilote vytvoriť reporty, nie viesť k plošnému povoleniu.
Žiadnu direktívu nekopírovať do vynucovanej CSP bez samostatného schválenia.

## Regresie, rollout a rollback

Lokálne spustiť `php tools\test-csp.php`; rovnaký test beží v samostatnej PR CI
bez deploy jobu. Kontroluje syntax kandidáta, explicitné zdroje v skutočne
vykreslenej homepage a všetkých siedmich PHP témach, dynamické script URL,
meta/aktívnu CSP v produkčných zdrojoch a negatívne prípady v pamäti.
Nenahrádza sieťové ani browser testy. `*.md` a `tools/` sú vylúčené z deployu.

Pred pilotom zopakovať HTTP/browser dôkazy na aktuálnom main a po schválení:

1. Na stagingu pridať iba HTTP `Content-Security-Policy-Report-Only`, zachovať
   všetky existujúce vynucované politiky a zabezpečiť schválený zber reportov.
2. V čerstvom browser kontexte overiť default, odmietnutie, analytický-only,
   marketingový-only aj plný súhlas a odvolanie. Bez súhlasu nesmú pribudnúť
   tracker skripty. Overiť cookie dialóg, čas, témy, fonty, iframe/PDF, video,
   externé obrázky a právne redirecty v porovnaní s baseline.
3. Zachytiť Network/Console a violation udalosti; potvrdiť
   `disposition = report`, rovnaké úspešné requesty ako baseline a žiadne nové
   CSP blokovanie. Zlyhané baseline obrázky nezamieňať za novú regresiu.
   WAF 403/466 nie je dôkaz výpadku; nemení sa WAF ani deploy pravidlá.
4. Produkčný report-only pilot nasadiť až samostatne schváleným postupom.
   Získať reprezentatívne reporty vrátane rôznych regiónov a vendor requestov.
   Enforcement a odstránenie inline výnimiek sú samostatné neskoršie rozhodnutia.

**Rollback pilotu:** odstrániť iba novú Report-Only hlavičku, overiť jej
neprítomnosť a nezmenené hostingové CSP. Tento PR nemení runtime a nepotrebuje
produkčný rollback; jeho CI/dokumentáciu možno revertovať bez deployu.
