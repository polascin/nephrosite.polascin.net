// Exercise the real integration code without sending analytics or contacting vendors.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');
const root = path.resolve(__dirname, '..');
let source = fs.readFileSync(path.join(root, 'files/consent-manager.js'), 'utf8');
assert.match(source, /^\(function \(\) \{/, 'Expected consent IIFE');
const boot = source.lastIndexOf('  if (document.readyState === "loading")');
assert.ok(boot > 0, 'Expected consent boot entry point');
source = source.slice(0, boot) +
  'window.testIntegration = {applyConsent, initImageFallbacks, readStoredConsent};\n})();';
const scripts = [];
let images = [];
let storedConsent = null;
const localStorage = {
  getItem: () => storedConsent,
  removeItem() { storedConsent = null; }
};
const document = {
  cookie: '',
  head: {appendChild: script => scripts.push(script)},
  documentElement: {setAttribute() {}},
  querySelector: selector => scripts.find(script => selector.includes(script.src)) || null,
  querySelectorAll: () => images,
  createElement: () => ({setAttribute() {}})
};
const window = {location: {search: ''}};
vm.runInNewContext(source, {window, document, localStorage, setTimeout() {}, clearTimeout() {}});
const {applyConsent, initImageFallbacks, readStoredConsent} = window.testIntegration;
const privacyScript = fs.readFileSync(path.join(root, 'files/privacy-consent.js'), 'utf8');
const summary = {};
const privacyDocument = {
  getElementById: id => id === 'consent-summary' ? summary : {addEventListener() {}}
};
const choices = {analytics: true};
for (const [expiresAt, expected, status] of [
  ['invalid', false, 'neplatný záznam'],
  [new Date(Date.now() - 86400000).toISOString(), false, 'platnosť vypršala'],
  [new Date(Date.now() + 86400000).toISOString(), true, 'analytické=áno']
]) {
  storedConsent = JSON.stringify({version: 2, expiresAt, choices});
  vm.runInNewContext(privacyScript, {document: privacyDocument, localStorage});
  assert.ok(summary.textContent.includes(status));
  assert.equal(readStoredConsent()?.choices.analytics ?? false, expected);
  assert.equal(storedConsent !== null, expected);
}
applyConsent({analytics: false, marketing: false, preferences: false});
assert.equal(scripts.length, 0, 'No vendor scripts before consent');
assert.equal(window.clarity, undefined);
applyConsent({analytics: true, marketing: false, preferences: false});
assert.equal(scripts.filter(s => s.src.includes('clarity.ms/tag/')).length, 1);
assert.equal(typeof window.clarity, 'function', 'Queue exists before the tag runs');
let consent = window.clarity.q.at(-1);
assert.equal(consent[0], 'consentv2');
assert.equal(consent[1].analytics_Storage, 'granted');
assert.equal(consent[1].ad_Storage, 'denied');
applyConsent({analytics: true, marketing: false, preferences: false});
assert.equal(scripts.length, 2, 'Repeated consent must not duplicate Clarity or Google');
applyConsent({analytics: false, marketing: false, preferences: false});
consent = window.clarity.q.at(-1);
assert.equal(consent[1].analytics_Storage, 'denied', 'Revocation reaches Clarity');
assert.equal(consent[1].ad_Storage, 'denied');

// Generic image fallback helper (visitor map is now a first-party SVG; no live clustrmaps.com load).
function image(complete, naturalWidth, src) {
  let fallback = '/pix/clustrmaps-unavailable.svg';
  const handlers = {};
  return {
    complete, naturalWidth, src,
    getAttribute: () => fallback,
    removeAttribute: () => { fallback = null; },
    addEventListener: (event, callback) => { handlers[event] = callback; },
    fail: () => handlers.error()
  };
}
images = [
  image(true, 0, '/pix/broken-primary.png'),
  image(false, 0, '/pix/broken-primary.png'),
  image(true, 300, '/pix/clustrmaps-visitor-map.svg')
];
initImageFallbacks();
assert.equal(images[0].src, '/pix/clustrmaps-unavailable.svg', 'Cached failure uses fallback');
assert.equal(images[1].src, '/pix/broken-primary.png');
images[1].fail();
assert.equal(images[1].src, '/pix/clustrmaps-unavailable.svg', 'Later failure uses fallback');
images[1].fail();
assert.equal(images[1].src, '/pix/clustrmaps-unavailable.svg', 'No recursive retries');
assert.equal(images[2].src, '/pix/clustrmaps-visitor-map.svg', 'Successful local map is retained');
assert.ok(fs.existsSync(path.join(root, images[0].src)));
assert.ok(fs.existsSync(path.join(root, images[2].src)));

const footer = fs.readFileSync(path.join(root, 'blocks/footer.sk.php'), 'utf8');
assert.match(footer, /src="\/pix\/clustrmaps-visitor-map\.svg"/, 'Footer uses first-party visitor map SVG');
assert.doesNotMatch(footer, /clustrmaps\.com\/map/, 'Footer must not load live ClustrMaps image');
assert.doesNotMatch(footer, /data-fallback-src/, 'First-party map needs no remote fallback');

const clockScript = fs.readFileSync(path.join(root, 'files/current-time.js'), 'utf8');
const fields = new Map();
let updateClock;
let instant;
class ClockDate extends Date {
  constructor(...args) {
    super(...(args.length ? args : [instant]));
  }
}
const previousTimeZone = process.env.TZ;
try {
  process.env.TZ = 'Europe/Bratislava';
  instant = '2026-06-28T21:59:59Z';
  vm.runInNewContext(clockScript, {
    Date: ClockDate,
    document: {
      querySelector(selector) {
        if (!fields.has(selector)) fields.set(selector, {});
        return fields.get(selector);
      }
    },
    setInterval(callback) { updateClock = callback; }
  });
  updateClock();
  assert.equal(fields.get('#weeknumber').textContent, 26);
  instant = '2026-06-28T22:00:00Z';
  updateClock();
  assert.equal(fields.get('#daynumber').textContent, 180, 'Local midnight during summer time starts a new day');
  assert.equal(fields.get('#weeknumber').textContent, 27, 'Local Monday starts a new ISO week');
  assert.equal(fields.get('#internettime').textContent, '@958', 'Internet Time uses UTC+1 year-round');
  instant = '2026-12-31T23:30:00Z';
  updateClock();
  assert.equal(fields.get('#daynumber').textContent, 1);
  assert.equal(fields.get('#weeknumber').textContent, 53);
  assert.equal(fields.get('#yearnumber').textContent, 2027);
  assert.equal(fields.get('#internettime').textContent, '@020');
} finally {
  if (previousTimeZone === undefined) delete process.env.TZ;
  else process.env.TZ = previousTimeZone;
}

console.log('PASS: consent gating, Clarity tag, revocation, image fallback, visitor map and clock.');
