// Exercise the real integration code without sending analytics or contacting vendors.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');
const root = path.resolve(__dirname, '..');
let source = fs.readFileSync(path.join(root, 'blocks/scripts.sk.php'), 'utf8');
// Strip PHP (nonce helper) and the opening/closing <script> tags.
source = source
  .replace(/<\?php[\s\S]*?\?>/gu, '')
  .replace(/^\s*<script\b[^>]*>\s*/u, '')
  .replace(/<\/script>\s*$/u, '');
assert.match(source, /^\(function \(\) \{/, 'Expected consent IIFE after stripping PHP/script wrappers');
const boot = source.lastIndexOf('  if (document.readyState === "loading")');
assert.ok(boot > 0, 'Expected consent boot entry point');
source = source.slice(0, boot) +
  'window.testIntegration = {applyConsent, initImageFallbacks};\n})();';
const scripts = [];
let images = [];
const document = {
  head: {appendChild: script => scripts.push(script)},
  documentElement: {setAttribute() {}},
  querySelector: selector => scripts.find(script => selector.includes(script.src)) || null,
  querySelectorAll: () => images,
  createElement: () => ({setAttribute() {}})
};
const window = {location: {search: ''}};
vm.runInNewContext(source, {window, document, setTimeout() {}, clearTimeout() {}});
const {applyConsent, initImageFallbacks} = window.testIntegration;
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

console.log('PASS: consent gating, Clarity tag, revocation, image fallback helper, first-party visitor map.');
