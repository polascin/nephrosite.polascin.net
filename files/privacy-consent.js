(function () {
  // Must stay aligned with blocks/scripts.sk.php (STORAGE_KEY / COOKIE_NAME).
  var key = "nephro_consent_v1";
  var summary = document.getElementById("consent-summary");
  var reset = document.getElementById("reset-consent");

  if (!summary || !reset) {
    return;
  }

  function readCookie() {
    var escaped = key.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
    var match = document.cookie.match(new RegExp("(?:^|; )" + escaped + "=([^;]*)"));
    if (!match) {
      return null;
    }

    try {
      return decodeURIComponent(match[1]);
    } catch (err) {
      return null;
    }
  }

  function readRaw() {
    try {
      var localValue = localStorage.getItem(key);
      if (localValue) {
        return localValue;
      }
    } catch (err) {
    }

    return readCookie();
  }

  function clearAll() {
    try {
      localStorage.removeItem(key);
    } catch (err) {
    }

    // Same path/SameSite/Secure as the live consent writer in scripts.sk.php.
    document.cookie =
      key + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/; SameSite=Lax; Secure";
  }

  function render() {
    var raw = readRaw();
    if (!raw) {
      summary.textContent = "Aktuálny stav súhlasu: neuložený.";
      return;
    }

    try {
      var parsed = JSON.parse(raw);
      var c = parsed.choices || {};
      summary.textContent =
        "Aktuálny stav súhlasu: preferencie=" +
        (c.preferences ? "áno" : "nie") +
        ", analytické=" +
        (c.analytics ? "áno" : "nie") +
        ", marketingové=" +
        (c.marketing ? "áno" : "nie") +
        ".";
    } catch (err) {
      summary.textContent = "Aktuálny stav súhlasu: poškodený záznam.";
    }
  }

  reset.addEventListener("click", function () {
    clearAll();
    render();
  });

  render();
})();
