(function () {
  var key = "nephro_consent_v1";
  var summary = document.getElementById("consent-summary");
  var reset = document.getElementById("reset-consent");

  if (!summary || !reset) {
    return;
  }

  function render() {
    var raw = localStorage.getItem(key);
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
    localStorage.removeItem(key);
    render();
  });

  render();
})();
