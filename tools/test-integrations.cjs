// Exercise the real integration code without sending analytics or contacting vendors.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');
const root = path.resolve(__dirname, '..');
let source = fs.readFileSync(path.join(root, 'blocks/scripts.sk.php'), 'utf8');
source = source.replace(/^<script>\s*/, '').replace(/<\/script>\s*$/, '');
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
function image(complete, naturalWidth) {
  let fallback = '/pix/clustrmaps-unavailable.svg';
  const handlers = {};
  return {
    complete, naturalWidth, src: 'https://clustrmaps.com/map_v2.png',
    getAttribute: () => fallback,
    removeAttribute: () => { fallback = null; },
    addEventListener: (event, callback) => { handlers[event] = callback; },
    fail: () => handlers.error()
  };
}
images = [image(true, 0), image(false, 0), image(true, 300)];
initImageFallbacks();
assert.equal(images[0].src, '/pix/clustrmaps-unavailable.svg', 'Cached failure uses fallback');
assert.equal(images[1].src, 'https://clustrmaps.com/map_v2.png');
images[1].fail();
assert.equal(images[1].src, '/pix/clustrmaps-unavailable.svg', 'Later failure uses fallback');
images[1].fail();
assert.equal(images[1].src, '/pix/clustrmaps-unavailable.svg', 'No recursive retries');
assert.equal(images[2].src, 'https://clustrmaps.com/map_v2.png', 'Successful map is retained');
assert.ok(fs.existsSync(path.join(root, images[0].src)));
console.log('PASS: consent gating, one initialized Clarity tag, revocation, and map fallback paths.');
