<section id="cookie-banner" class="cookie-banner" role="dialog" aria-labelledby="cookie-banner-title"
    aria-describedby="cookie-banner-desc cookie-banner-disclaimer cookie-consent-status" hidden>
    <div class="cookie-banner-shell">
        <p class="cookie-eyebrow">Centrum ochrany súkromia</p>
        <div class="cookie-banner-grid">
            <div class="cookie-banner-copy">
                <h2 id="cookie-banner-title" class="cookie-title">Cookies iba pod vašou kontrolou</h2>
                <p id="cookie-banner-desc" class="cookie-text">
                    Nevyhnutné cookies používame pre bezpečnosť a funkčnosť webu. Preferencie, analytické a marketingové
                    úložiská sú štandardne vypnuté a aktivujú sa až po vašom výslovnom súhlase.
                </p>
                <ul class="cookie-points" aria-label="Základné pravidlá súhlasu">
                    <li>rovnako jednoduché prijatie aj odmietnutie</li>
                    <li>možnosť vybrať jednotlivé kategórie</li>
                    <li>zmena súhlasu kedykoľvek cez pätu webu</li>
                </ul>
            </div>

            <aside class="cookie-banner-side" aria-label="Zhrnutie ochrany súkromia">
                <div class="cookie-pill-list" aria-hidden="true">
                    <span class="cookie-pill">predvolene vypnuté</span>
                    <span class="cookie-pill">platnosť 180 dní</span>
                    <span class="cookie-pill">GPC a DNT rešpektujeme</span>
                </div>
                <p id="cookie-banner-disclaimer" class="cookie-disclaimer">
                    Dôležité upozornenie: obsah webu slúži na informačné a edukačné účely a nenahrádza odborné lekárske,
                    právne ani iné profesionálne poradenstvo. Prečítajte si aj
                    <a href="/files/privacy.html#legal-disclaimer" target="_blank" rel="noopener noreferrer">právne upozornenie</a>
                    a
                    <a href="/files/privacy.html" target="_blank" rel="noopener noreferrer">zásady ochrany súkromia</a>.
                </p>
            </aside>
        </div>

        <p id="cookie-consent-status" class="cookie-status" role="status" aria-live="polite"></p>

        <div class="cookie-actions cookie-actions-primary">
            <button type="button" id="cookie-reject-all" class="cookie-btn cookie-btn-secondary">Len nevyhnutné</button>
            <button type="button" id="cookie-customize" class="cookie-btn cookie-btn-ghost" aria-haspopup="dialog"
                aria-controls="cookie-modal" aria-expanded="false">Vybrať kategórie</button>
            <button type="button" id="cookie-accept-all" class="cookie-btn cookie-btn-primary">Prijať všetko</button>
        </div>
    </div>
</section>

<div id="cookie-modal-backdrop" class="cookie-modal-backdrop" hidden>
    <section id="cookie-modal" class="cookie-modal" role="dialog" aria-modal="true" aria-labelledby="cookie-modal-title"
        aria-describedby="cookie-modal-desc cookie-modal-disclaimer" tabindex="-1">
        <div class="cookie-modal-header">
            <div>
                <p class="cookie-eyebrow">Centrum preferencií</p>
                <h2 id="cookie-modal-title">Podrobné nastavenie cookies</h2>
            </div>
            <button type="button" id="cookie-modal-close" class="cookie-icon-button" aria-label="Zavrieť nastavenie cookies">×</button>
        </div>

        <p id="cookie-modal-desc" class="cookie-modal-lead">
            Vyberte, ktoré nepovinné úložiská môžeme aktivovať. Nevyhnutné úložiská zostávajú zapnuté stále, ostatné len po súhlase.
        </p>

        <p id="cookie-modal-disclaimer" class="cookie-disclaimer cookie-disclaimer-modal">
            Upozornenie: informácie na tomto webe nenahrádzajú odbornú zdravotnú starostlivosť ani iné profesionálne odporúčania.
            Podrobnosti nájdete v
            <a href="/files/privacy.html#legal-disclaimer" target="_blank" rel="noopener noreferrer">právnom upozornení</a>.
        </p>

        <div class="cookie-card-list" role="group" aria-label="Kategórie cookies">
            <div class="cookie-row cookie-row-locked">
                <div class="cookie-row-copy">
                    <h3>Nevyhnutné</h3>
                    <p>Bezpečnosť, navigácia, základná dostupnosť webu a uloženie vašej voľby súhlasu.</p>
                    <p class="cookie-row-meta">Právny základ: oprávnený záujem.</p>
                </div>
                <label class="cookie-toggle">
                    <input type="checkbox" checked disabled aria-describedby="cookie-necessary-state">
                    <span id="cookie-necessary-state">Vždy aktívne</span>
                </label>
            </div>

            <div class="cookie-row">
                <div class="cookie-row-copy">
                    <h3>Preferencie</h3>
                    <p>Zapamätajú lokálne voľby rozhrania a znižujú počet opakovaných výziev.</p>
                    <p class="cookie-row-meta">Aktivujú sa iba po súhlase.</p>
                </div>
                <label class="cookie-toggle" for="cookie-pref-preferences">
                    <input type="checkbox" id="cookie-pref-preferences" aria-describedby="cookie-pref-preferences-hint">
                    <span>Povoliť</span>
                </label>
                <span id="cookie-pref-preferences-hint" class="sr-only">Povoliť preferenčné cookies.</span>
            </div>

            <div class="cookie-row">
                <div class="cookie-row-copy">
                    <h3>Analytické</h3>
                    <p>Pomáhajú nám rozumieť návštevnosti a používaniu obsahu bez priamej identifikácie návštevníka.</p>
                    <p class="cookie-row-meta">Nástroje: Microsoft Clarity, Google Analytics.</p>
                </div>
                <label class="cookie-toggle" for="cookie-pref-analytics">
                    <input type="checkbox" id="cookie-pref-analytics" aria-describedby="cookie-pref-analytics-hint">
                    <span>Povoliť</span>
                </label>
                <span id="cookie-pref-analytics-hint" class="sr-only">Povoliť analytické cookies.</span>
            </div>

            <div class="cookie-row">
                <div class="cookie-row-copy">
                    <h3>Marketingové</h3>
                    <p>Umožňujú meranie kampaní a marketingové spracovanie po vašom samostatnom súhlase.</p>
                    <p class="cookie-row-meta">Nástroj: Fastbase.</p>
                </div>
                <label class="cookie-toggle" for="cookie-pref-marketing">
                    <input type="checkbox" id="cookie-pref-marketing" aria-describedby="cookie-pref-marketing-hint">
                    <span>Povoliť</span>
                </label>
                <span id="cookie-pref-marketing-hint" class="sr-only">Povoliť marketingové cookies.</span>
            </div>
        </div>

        <div class="cookie-actions cookie-actions-modal">
            <button type="button" id="cookie-modal-reject" class="cookie-btn cookie-btn-secondary">Len nevyhnutné</button>
            <button type="button" id="cookie-save-preferences" class="cookie-btn cookie-btn-ghost">Uložiť výber</button>
            <button type="button" id="cookie-modal-accept" class="cookie-btn cookie-btn-primary">Prijať všetko</button>
        </div>
    </section>
</div>

<noscript>
    <div class="cookie-noscript">
        JavaScript je vypnutý. Na tomto webe sa používajú iba nevyhnutné cookies.
        Detaily sú uvedené v <a href="/files/privacy.html" target="_blank" rel="noopener noreferrer">zásadách ochrany
            súkromia</a> a v <a href="/files/privacy.html#legal-disclaimer" target="_blank" rel="noopener noreferrer">právnom upozornení</a>.
    </div>
</noscript>
