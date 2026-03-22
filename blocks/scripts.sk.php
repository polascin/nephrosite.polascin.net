<script>
(function () {
  var STORAGE_KEY = "nephro_consent_v1";
  var CONSENT_TTL_DAYS = 180;
  var VERSION = 2;

  var defaultChoices = {
    necessary: true,
    preferences: false,
    analytics: false,
    marketing: false
  };

  var consentRecord = null;
  var listeners = [];
  var loaded = {
    analytics: false,
    marketing: false
  };
  var debugUnsubscribe = null;
  var statusFlashTimer = null;
  var googleTagReady = false;
  var googleAnalyticsConfigured = false;
  var GA_MEASUREMENT_IDS = ["G-QRSPED10HK", "G-E5ZP1RCYNE", "G-KQK88SFRVE"];
  var previouslyFocused = null;

  function setStatusText(text) {
    var status = document.getElementById("cookie-consent-status");
    if (status) {
      status.textContent = text || "";
    }
  }

  function flashSavedStatus() {
    var status = document.getElementById("cookie-consent-status");
    if (!status) {
      return;
    }

    status.classList.remove("cookie-status-saved");
    void status.offsetWidth;
    status.classList.add("cookie-status-saved");

    if (statusFlashTimer) {
      clearTimeout(statusFlashTimer);
    }

    statusFlashTimer = setTimeout(function () {
      status.classList.remove("cookie-status-saved");
      statusFlashTimer = null;
    }, 1200);
  }

  function isObject(value) {
    return value && typeof value === "object";
  }

  function dntOrGpcEnabled() {
    return navigator.globalPrivacyControl === true ||
      navigator.doNotTrack === "1" ||
      window.doNotTrack === "1";
  }

  function getExpiryDate() {
    var date = new Date();
    date.setDate(date.getDate() + CONSENT_TTL_DAYS);
    return date.toISOString();
  }

  function normalizeChoices(choices) {
    var safe = isObject(choices) ? choices : {};
    return {
      necessary: true,
      preferences: Boolean(safe.preferences),
      analytics: Boolean(safe.analytics),
      marketing: Boolean(safe.marketing)
    };
  }

  function readStoredConsent() {
    try {
      var raw = localStorage.getItem(STORAGE_KEY);
      if (!raw) {
        return null;
      }

      var parsed = JSON.parse(raw);
      if (!isObject(parsed) || parsed.version !== VERSION || !parsed.expiresAt) {
        localStorage.removeItem(STORAGE_KEY);
        return null;
      }

      if (new Date(parsed.expiresAt).getTime() <= Date.now()) {
        localStorage.removeItem(STORAGE_KEY);
        return null;
      }

      parsed.choices = normalizeChoices(parsed.choices);
      return parsed;
    } catch (err) {
      localStorage.removeItem(STORAGE_KEY);
      return null;
    }
  }

  function saveConsent(choices, source) {
    consentRecord = {
      version: VERSION,
      updatedAt: new Date().toISOString(),
      expiresAt: getExpiryDate(),
      source: source || "banner",
      choices: normalizeChoices(choices)
    };

    localStorage.setItem(STORAGE_KEY, JSON.stringify(consentRecord));
    applyConsent(consentRecord.choices);
    fireConsentChange();

    setStatusText(
      "Volba ulozena: preferencie " + (consentRecord.choices.preferences ? "povolene" : "zakazane") +
      ", analyticke " + (consentRecord.choices.analytics ? "povolene" : "zakazane") +
      ", marketingove " + (consentRecord.choices.marketing ? "povolene" : "zakazane") + "."
    );

    flashSavedStatus();
  }

  function ensureExternalBlankLinksAreSafe() {
    var links = document.querySelectorAll('a[target="_blank"]');
    links.forEach(function (link) {
      var rel = (link.getAttribute("rel") || "").toLowerCase();
      if (rel.indexOf("noopener") === -1 || rel.indexOf("noreferrer") === -1) {
        link.setAttribute("rel", "noopener noreferrer");
      }
    });
  }

  function loadScript(src, attrs) {
    if (document.querySelector('script[data-src="' + src + '"]')) {
      return;
    }

    var script = document.createElement("script");
    script.src = src;
    script.setAttribute("data-src", src);

    if (attrs && isObject(attrs)) {
      Object.keys(attrs).forEach(function (key) {
        var value = attrs[key];
        if (value === true) {
          script.setAttribute(key, "");
        } else if (value !== false && value != null) {
          script.setAttribute(key, String(value));
        }
      });
    }

    document.head.appendChild(script);
  }

  function ensureGoogleTagBridge() {
    window.dataLayer = window.dataLayer || [];
    if (typeof window.gtag !== "function") {
      window.gtag = function () {
        window.dataLayer.push(arguments);
      };
    }

    if (!googleTagReady) {
      window.gtag("js", new Date());
      window.gtag("consent", "default", {
        analytics_storage: "denied",
        ad_storage: "denied",
        ad_user_data: "denied",
        ad_personalization: "denied",
        functionality_storage: "granted",
        security_storage: "granted",
        personalization_storage: "denied",
        wait_for_update: 500
      });
      googleTagReady = true;
    }
  }

  function updateGoogleConsent(choices) {
    ensureGoogleTagBridge();

    var analyticsGranted = choices.analytics ? "granted" : "denied";
    var marketingGranted = choices.marketing ? "granted" : "denied";
    var preferencesGranted = choices.preferences ? "granted" : "denied";

    window.gtag("consent", "update", {
      analytics_storage: analyticsGranted,
      ad_storage: marketingGranted,
      ad_user_data: marketingGranted,
      ad_personalization: marketingGranted,
      functionality_storage: preferencesGranted,
      personalization_storage: preferencesGranted,
      security_storage: "granted"
    });
  }

  function updateGoogleDisableFlags(choices) {
    var disableTracking = !choices.analytics;
    GA_MEASUREMENT_IDS.forEach(function (id) {
      window["ga-disable-" + id] = disableTracking;
    });
  }

  function configureGoogleAnalytics() {
    if (googleAnalyticsConfigured) {
      return;
    }

    googleAnalyticsConfigured = true;
    GA_MEASUREMENT_IDS.forEach(function (id) {
      window.gtag("config", id, { anonymize_ip: true });
    });
  }

  function loadAnalyticsScripts() {
    if (loaded.analytics) {
      return;
    }

    loaded.analytics = true;

    ensureGoogleTagBridge();

    loadScript("https://nephrosite.containers.piwik.pro/1d43d282-1703-4cb7-9d66-91c82decad1a.sync.js", { async: true });

    ["fp2sq6zahr", "fp3d1xd7wp", "fp3f40q535"].forEach(function (clarityId) {
      loadScript("https://www.clarity.ms/tag/" + clarityId, { async: true });
    });

    loadScript("https://www.googletagmanager.com/gtag/js?id=G-QRSPED10HK", { async: true });
    configureGoogleAnalytics();
  }

  function loadMarketingScripts() {
    if (loaded.marketing) {
      return;
    }

    loaded.marketing = true;
    loadScript("https://fastbase.com/fscript.js", {
      async: true,
      id: "2IFrUz1eKQ"
    });
  }

  function applyConsent(choices) {
    var normalized = normalizeChoices(choices);

    updateGoogleDisableFlags(normalized);
    updateGoogleConsent(normalized);

    document.documentElement.setAttribute("data-consent-preferences", normalized.preferences ? "granted" : "denied");
    document.documentElement.setAttribute("data-consent-analytics", normalized.analytics ? "granted" : "denied");
    document.documentElement.setAttribute("data-consent-marketing", normalized.marketing ? "granted" : "denied");

    if (normalized.analytics) {
      loadAnalyticsScripts();
    }

    if (normalized.marketing) {
      loadMarketingScripts();
    }
  }

  function fireConsentChange() {
    listeners.forEach(function (listener) {
      try {
        listener(getConsent());
      } catch (err) {
      }
    });
  }

  function getConsent() {
    if (consentRecord) {
      return consentRecord;
    }

    return {
      version: VERSION,
      updatedAt: null,
      expiresAt: null,
      source: "default",
      choices: normalizeChoices(defaultChoices)
    };
  }

  function shouldShowBanner() {
    return !consentRecord;
  }

  function getCurrentDataLayerSize() {
    return Array.isArray(window.dataLayer) ? window.dataLayer.length : 0;
  }

  function getDebugReport() {
    var consent = getConsent();
    var flags = {};

    GA_MEASUREMENT_IDS.forEach(function (id) {
      flags[id] = Boolean(window["ga-disable-" + id]);
    });

    return {
      consent: consent,
      dataAttributes: {
        preferences: document.documentElement.getAttribute("data-consent-preferences"),
        analytics: document.documentElement.getAttribute("data-consent-analytics"),
        marketing: document.documentElement.getAttribute("data-consent-marketing")
      },
      trackersLoaded: {
        analytics: loaded.analytics,
        marketing: loaded.marketing
      },
      google: {
        tagReady: googleTagReady,
        analyticsConfigured: googleAnalyticsConfigured,
        dataLayerSize: getCurrentDataLayerSize(),
        disableFlags: flags
      }
    };
  }

  function debugLog(prefix, payload) {
    if (window.console && typeof window.console.log === "function") {
      window.console.log("[NephroConsent] " + prefix, payload);
    }
  }

  function getChoiceSummary(choices) {
    return "preferencie " + (choices.preferences ? "povolene" : "zakazane") +
      ", analyticke " + (choices.analytics ? "povolene" : "zakazane") +
      ", marketingove " + (choices.marketing ? "povolene" : "zakazane") + ".";
  }

  function setCustomizeExpanded(expanded) {
    var customize = document.getElementById("cookie-customize");
    if (customize) {
      customize.setAttribute("aria-expanded", expanded ? "true" : "false");
    }
  }

  function syncPreferenceInputs(choices) {
    var current = normalizeChoices(choices || defaultChoices);
    var pref = document.getElementById("cookie-pref-preferences");
    var analytics = document.getElementById("cookie-pref-analytics");
    var marketing = document.getElementById("cookie-pref-marketing");

    if (pref) {
      pref.checked = current.preferences;
    }
    if (analytics) {
      analytics.checked = current.analytics;
    }
    if (marketing) {
      marketing.checked = current.marketing;
    }
  }

  function updateUiSummary(choices, hasSavedConsent) {
    var summary = hasSavedConsent
      ? "Aktualna volba: " + getChoiceSummary(choices)
      : "Bez vasej volby zostavaju aktivne iba nevyhnutne cookies.";

    setStatusText(summary);
    syncPreferenceInputs(choices);
  }

  function setBannerVisible(visible) {
    var banner = document.getElementById("cookie-banner");
    if (!banner) {
      return;
    }

    if (visible) {
      banner.removeAttribute("hidden");
      var firstAction = banner.querySelector("button");
      if (firstAction && typeof firstAction.focus === "function") {
        firstAction.focus();
      }
    } else {
      banner.setAttribute("hidden", "");
    }
  }

  function openModal() {
    var backdrop = document.getElementById("cookie-modal-backdrop");
    var modal = document.getElementById("cookie-modal");
    if (!backdrop || !modal) {
      return;
    }

    previouslyFocused = document.activeElement;
    backdrop.removeAttribute("hidden");
    backdrop.setAttribute("aria-hidden", "false");
    document.body.classList.add("cookie-modal-open");

    syncPreferenceInputs((consentRecord && consentRecord.choices) ? consentRecord.choices : defaultChoices);
    setCustomizeExpanded(true);

    var firstFocusable = modal.querySelector("button, input, a, [tabindex]:not([tabindex='-1'])");
    if (firstFocusable) {
      firstFocusable.focus();
    } else {
      modal.focus();
    }
  }

  function closeModal() {
    var backdrop = document.getElementById("cookie-modal-backdrop");
    if (backdrop) {
      backdrop.setAttribute("hidden", "");
      backdrop.setAttribute("aria-hidden", "true");
    }

    document.body.classList.remove("cookie-modal-open");
    setCustomizeExpanded(false);

    if (previouslyFocused && typeof previouslyFocused.focus === "function") {
      previouslyFocused.focus();
    }
  }

  function trapModalFocus(event) {
    var backdrop = document.getElementById("cookie-modal-backdrop");
    var modal = document.getElementById("cookie-modal");

    if (!backdrop || !modal || backdrop.hasAttribute("hidden")) {
      return;
    }

    if (event.key === "Escape") {
      closeModal();
      return;
    }

    if (event.key !== "Tab") {
      return;
    }

    var focusable = modal.querySelectorAll("button, [href], input, select, textarea, [tabindex]:not([tabindex='-1'])");
    if (!focusable.length) {
      return;
    }

    var first = focusable[0];
    var last = focusable[focusable.length - 1];

    if (event.shiftKey && document.activeElement === first) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault();
      first.focus();
    }
  }

  function wireUiEvents() {
    var acceptAll = document.getElementById("cookie-accept-all");
    var rejectAll = document.getElementById("cookie-reject-all");
    var customize = document.getElementById("cookie-customize");
    var savePrefs = document.getElementById("cookie-save-preferences");
    var modalReject = document.getElementById("cookie-modal-reject");
    var modalAccept = document.getElementById("cookie-modal-accept");
    var modalClose = document.getElementById("cookie-modal-close");
    var openSettings = document.getElementById("open-cookie-settings");
    var backdrop = document.getElementById("cookie-modal-backdrop");

    if (acceptAll) {
      acceptAll.addEventListener("click", function () {
        saveConsent({ preferences: true, analytics: true, marketing: true }, "accept_all");
        setBannerVisible(false);
      });
    }

    if (rejectAll) {
      rejectAll.addEventListener("click", function () {
        saveConsent({ preferences: false, analytics: false, marketing: false }, "reject_all");
        setBannerVisible(false);
      });
    }

    if (customize) {
      customize.addEventListener("click", openModal);
    }

    if (savePrefs) {
      savePrefs.addEventListener("click", function () {
        var preferences = document.getElementById("cookie-pref-preferences");
        var analytics = document.getElementById("cookie-pref-analytics");
        var marketing = document.getElementById("cookie-pref-marketing");

        saveConsent({
          preferences: preferences ? preferences.checked : false,
          analytics: analytics ? analytics.checked : false,
          marketing: marketing ? marketing.checked : false
        }, "custom");

        setBannerVisible(false);
        closeModal();
      });
    }

    if (modalAccept) {
      modalAccept.addEventListener("click", function () {
        saveConsent({ preferences: true, analytics: true, marketing: true }, "modal_accept_all");
        setBannerVisible(false);
        closeModal();
      });
    }

    if (modalReject) {
      modalReject.addEventListener("click", function () {
        saveConsent({ preferences: false, analytics: false, marketing: false }, "modal_reject");
        setBannerVisible(false);
        closeModal();
      });
    }

    if (modalClose) {
      modalClose.addEventListener("click", closeModal);
    }

    if (openSettings) {
      openSettings.addEventListener("click", openModal);
    }

    if (backdrop) {
      backdrop.addEventListener("click", function (event) {
        if (event.target === backdrop) {
          closeModal();
        }
      });
    }

    document.addEventListener("keydown", trapModalFocus);
  }

  function initConsent() {
    consentRecord = readStoredConsent();

    if (!consentRecord) {
      var privacyByDefault = dntOrGpcEnabled();
      if (privacyByDefault) {
        saveConsent({ preferences: false, analytics: false, marketing: false }, "gpc_dnt");
      }
    }

    if (consentRecord) {
      applyConsent(consentRecord.choices);
      updateUiSummary(consentRecord.choices, true);
    } else {
      updateUiSummary(defaultChoices, false);
    }

    wireUiEvents();
    setBannerVisible(shouldShowBanner());
    ensureExternalBlankLinksAreSafe();
  }

  window.NephroConsent = {
    getConsent: getConsent,
    openPreferences: openModal,
    reset: function () {
      localStorage.removeItem(STORAGE_KEY);
      consentRecord = null;
      updateUiSummary(defaultChoices, false);
      setBannerVisible(true);
    },
    onChange: function (callback) {
      if (typeof callback === "function") {
        listeners.push(callback);
      }
    },
    debug: function () {
      var report = getDebugReport();
      debugLog("state", report);
      return report;
    },
    debugWatch: function () {
      if (debugUnsubscribe) {
        debugLog("watch", "already enabled");
        return;
      }

      var watcher = function (consent) {
        debugLog("consent changed", {
          consent: consent,
          report: getDebugReport()
        });
      };

      listeners.push(watcher);
      debugUnsubscribe = function () {
        listeners = listeners.filter(function (listener) {
          return listener !== watcher;
        });
        debugUnsubscribe = null;
      };

      debugLog("watch", "enabled");
    },
    debugUnwatch: function () {
      if (debugUnsubscribe) {
        debugUnsubscribe();
        debugLog("watch", "disabled");
      } else {
        debugLog("watch", "not enabled");
      }
    }
  };

  if (/([?&])cookie_debug=1(?:[&#]|$)/.test(window.location.search)) {
    setTimeout(function () {
      debugLog("auto", window.NephroConsent.debug());
    }, 0);
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initConsent);
  } else {
    initConsent();
  }
})();
</script>
