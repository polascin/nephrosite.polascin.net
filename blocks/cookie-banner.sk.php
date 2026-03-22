<section id="cookie-banner" class="cookie-banner" role="dialog" aria-labelledby="cookie-banner-title"
    aria-describedby="cookie-banner-desc cookie-banner-disclaimer cookie-consent-status" hidden>
    <div class="cookie-banner-shell">
        <p class="cookie-eyebrow">Privacy center</p>
        <div class="cookie-banner-grid">
            <div class="cookie-banner-copy">
                <h2 id="cookie-banner-title" class="cookie-title">Cookies iba pod vasou kontrolou</h2>
                <p id="cookie-banner-desc" class="cookie-text">
                    Nevyhnutne cookies pouzivame pre bezpecnost a funkcnost webu. Preferencie, analyticke a marketingove
                    uloziska su standardne vypnute a aktivuju sa az po vasom vyslovnom suhlase.
                </p>
                <ul class="cookie-points" aria-label="Zakladne pravidla suhlasu">
                    <li>rovnako jednoduche prijatie aj odmietnutie</li>
                    <li>moznost vybrat jednotlive kategorie</li>
                    <li>zmena suhlasu kedykolvek cez patu webu</li>
                </ul>
            </div>

            <aside class="cookie-banner-side" aria-label="Zhrnutie ochrany sukromia">
                <div class="cookie-pill-list" aria-hidden="true">
                    <span class="cookie-pill">defaultne vypnute</span>
                    <span class="cookie-pill">platnost 180 dni</span>
                    <span class="cookie-pill">GPC a DNT respektujeme</span>
                </div>
                <p id="cookie-banner-disclaimer" class="cookie-disclaimer">
                    Dolezite upozornenie: obsah webu sluzi na informacne a edukacne ucely a nenahradza odborne lekarske,
                    pravne ani ine profesionalne poradenstvo. Precitajte si aj
                    <a href="/files/privacy.html#legal-disclaimer" target="_blank" rel="noopener noreferrer">disclaimer</a>
                    a
                    <a href="/files/privacy.html" target="_blank" rel="noopener noreferrer">zasady ochrany sukromia</a>.
                </p>
            </aside>
        </div>

        <p id="cookie-consent-status" class="cookie-status" role="status" aria-live="polite"></p>

        <div class="cookie-actions cookie-actions-primary">
            <button type="button" id="cookie-reject-all" class="cookie-btn cookie-btn-secondary">Len nevyhnutne</button>
            <button type="button" id="cookie-customize" class="cookie-btn cookie-btn-ghost" aria-haspopup="dialog"
                aria-controls="cookie-modal" aria-expanded="false">Vybrat kategorie</button>
            <button type="button" id="cookie-accept-all" class="cookie-btn cookie-btn-primary">Prijat vsetko</button>
        </div>
    </div>
</section>

<div id="cookie-modal-backdrop" class="cookie-modal-backdrop" hidden>
    <section id="cookie-modal" class="cookie-modal" role="dialog" aria-modal="true" aria-labelledby="cookie-modal-title"
        aria-describedby="cookie-modal-desc cookie-modal-disclaimer" tabindex="-1">
        <div class="cookie-modal-header">
            <div>
                <p class="cookie-eyebrow">Preference center</p>
                <h2 id="cookie-modal-title">Podrobne nastavenie cookies</h2>
            </div>
            <button type="button" id="cookie-modal-close" class="cookie-icon-button" aria-label="Zavriet nastavenie cookies">×</button>
        </div>

        <p id="cookie-modal-desc" class="cookie-modal-lead">
            Vyberte, ktore nepovinne uloziska mozeme aktivovat. Nevyhnutne uloziska zostavaju zapnute stale, ostatne len po suhlase.
        </p>

        <p id="cookie-modal-disclaimer" class="cookie-disclaimer cookie-disclaimer-modal">
            Upozornenie: informacie na tomto webe nenahradzaju odbornu zdravotnu starostlivost ani ine profesionalne odporucania.
            Podrobnosti najdete v
            <a href="/files/privacy.html#legal-disclaimer" target="_blank" rel="noopener noreferrer">disclaimere</a>.
        </p>

        <div class="cookie-card-list" role="group" aria-label="Kategorie cookies">
            <div class="cookie-row cookie-row-locked">
                <div class="cookie-row-copy">
                    <h3>Nevyhnutne</h3>
                    <p>Bezpecnost, navigacia, zakladna dostupnost webu a ulozenie vasej volby suhlasu.</p>
                    <p class="cookie-row-meta">Pravny zaklad: opravneny zaujem.</p>
                </div>
                <label class="cookie-toggle">
                    <input type="checkbox" checked disabled aria-describedby="cookie-necessary-state">
                    <span id="cookie-necessary-state">Vzdy aktivne</span>
                </label>
            </div>

            <div class="cookie-row">
                <div class="cookie-row-copy">
                    <h3>Preferencie</h3>
                    <p>Zapamataju lokalne volby rozhrania a znizuju pocet opakovanych vyziev.</p>
                    <p class="cookie-row-meta">Aktivuju sa iba po suhlase.</p>
                </div>
                <label class="cookie-toggle" for="cookie-pref-preferences">
                    <input type="checkbox" id="cookie-pref-preferences" aria-describedby="cookie-pref-preferences-hint">
                    <span>Povolit</span>
                </label>
                <span id="cookie-pref-preferences-hint" class="sr-only">Povolit preferencne cookies.</span>
            </div>

            <div class="cookie-row">
                <div class="cookie-row-copy">
                    <h3>Analyticke</h3>
                    <p>Pomahaju nam rozumiet navstevnosti a pouzivaniu obsahu bez priamej identifikacie navstevnika.</p>
                    <p class="cookie-row-meta">Nastroje: Piwik PRO, Microsoft Clarity, Google Analytics.</p>
                </div>
                <label class="cookie-toggle" for="cookie-pref-analytics">
                    <input type="checkbox" id="cookie-pref-analytics" aria-describedby="cookie-pref-analytics-hint">
                    <span>Povolit</span>
                </label>
                <span id="cookie-pref-analytics-hint" class="sr-only">Povolit analyticke cookies.</span>
            </div>

            <div class="cookie-row">
                <div class="cookie-row-copy">
                    <h3>Marketingove</h3>
                    <p>Umoznuju meranie kampani a marketingove spracovanie po vasom samostatnom suhlase.</p>
                    <p class="cookie-row-meta">Nastroj: Fastbase.</p>
                </div>
                <label class="cookie-toggle" for="cookie-pref-marketing">
                    <input type="checkbox" id="cookie-pref-marketing" aria-describedby="cookie-pref-marketing-hint">
                    <span>Povolit</span>
                </label>
                <span id="cookie-pref-marketing-hint" class="sr-only">Povolit marketingove cookies.</span>
            </div>
        </div>

        <div class="cookie-actions cookie-actions-modal">
            <button type="button" id="cookie-modal-reject" class="cookie-btn cookie-btn-secondary">Len nevyhnutne</button>
            <button type="button" id="cookie-save-preferences" class="cookie-btn cookie-btn-ghost">Ulozit vyber</button>
            <button type="button" id="cookie-modal-accept" class="cookie-btn cookie-btn-primary">Prijat vsetko</button>
        </div>
    </section>
</div>

<noscript>
    <div class="cookie-noscript">
        JavaScript je vypnuty. Na tomto webe sa pouzivaju iba nevyhnutne cookies.
        Detaily su uvedene v <a href="/files/privacy.html" target="_blank" rel="noopener noreferrer">zasadach ochrany
            sukromia</a> a v <a href="/files/privacy.html#legal-disclaimer" target="_blank" rel="noopener noreferrer">disclaimere</a>.
    </div>
</noscript>