<style>

body {
	font-family: var(--font-sans, system-ui);
	text-align: center;
	color: var(--maroon, #800000);
	background-color: var(--white, #ffffff);
	max-width: var(--page-max, 1024px);
	margin-left: auto;
	margin-right: auto;
	overflow-x: hidden;
}

a, a:link, a:visited {
	color: var(--maroon, #800000);
	text-decoration: none;
}

a:hover {
	color: var(--olive, #808000);
}

a:active {
	color: var(--maroon, #800000);
}

a:focus-visible,
button:focus-visible,
summary:focus-visible,
input:focus-visible,
select:focus-visible,
textarea:focus-visible {
	outline: var(--focus-width, 2px) solid var(--focus-ring, #3d6d7a);
	outline-offset: var(--focus-offset, 2px);
}

table.lecture {
	max-width: var(--page-max, 1024px);
	margin-left: auto;
	margin-right: auto;
	width: var(--page-width, 96%);
	background-color: var(--snow, #fffafa);
	text-align: left;
	border-style: solid;
	border-width: var(--border-medium, 3px);
	border-spacing: var(--table-spacing, 2em);
	font-family: var(--font-blinker, 'Blinker');
}

table.lecture th {
  text-align: right;
	border-style: none;
	border-width: var(--border-thin, 1px);
  padding: var(--cell-pad-sm, 1em);
  font-family: var(--font-blaka, 'Blaka');
}

table.lecture td {
  padding: var(--cell-pad, 2em);
	border-style: dotted;
	border-width: var(--border-medium, 3px);
	border-color: var(--darksalmon, #e9967a);
	background-color: var(--floralwhite, #fffaf0);
}

table.lecture img.slide,
table.lecture video.slide {
	border-style: solid;
	border-width: var(--border-thin, 1px);
	width: 100%;
}

table.lecture video.slide {
	height: auto;
	background-color: var(--black, #000000);
}

table.lecture caption {
	color: var(--indigo, #4b0082);
	font-size: 3em;
	font-variant: small-caps;
	font-weight: bold;
	text-align: left;
	font-family: var(--font-blinker, 'Blinker');
}

table.lecture thead {
	background-color: var(--cornsilk, #fff8dc);
}

table.lecture tfoot td {
  padding: var(--cell-pad-foot, 0.5em);
  text-align: center;
  border-style: none;
	background-color: var(--cornsilk, #fff8dc);
}

table.lecture iframe {
  width: 100%;
  background-color: var(--ghostwhite, #f8f8ff);
}

table.nephrology {
	max-width: var(--page-max, 1024px);
	margin-left: auto;
	margin-right: auto;
	width: var(--page-width, 96%);
	background-color: var(--honeydew, #f0fff0);
	text-align: left;
	border-style: solid;
	border-width: var(--border-medium, 3px);
	border-spacing: var(--table-spacing, 2em);
	font-family: var(--font-fenix, 'Fenix');
}

table.nephrology h1,h2,h3 {
     font-variant: small-caps;
     color: var(--green, #008000);
}

table.nephrology caption {
	color: var(--darkcyan, #008b8b);
	font-size: 3em;
	font-variant: small-caps;
	font-weight: bold;
	text-align: left;
	font-family: var(--font-blinker, 'Blinker');
}

table.nephrology th {
  text-align: right;
  padding: var(--cell-pad-sm, 1em);
  font-family: var(--font-blaka, 'Blaka');
  background-color: var(--azure, #f0ffff);
}

table.nephrology td {
	text-align: justify;
	border-style: solid;
	border-width: var(--border-thin, 1px);
	padding: var(--cell-pad-sm, 1em);
	background-color: var(--mintcream, #f5fffa);
}

table.nephrology tfoot td {
  padding: var(--cell-pad-foot, 0.5em);
  text-align: center;
  border-style: none;
  background-color: var(--azure, #f0ffff);
}

table.promo {
	max-width: var(--page-max, 1024px);
	margin-left: auto;
	margin-right: auto;
	width: var(--page-width, 96%);
	background-color: transparent;
	text-align: center;
	border-style: solid;
	border-width: var(--border-thin, 1px);
}

img.reference {
  height: 5em;
  border-style: solid;
  border-width: var(--border-thin, 1px);
}

img.halfslide,
video.halfslide {
	width: var(--halfslide-width, 450px);
	max-width: 100%;
	border-style: solid;
	border-width: var(--border-medium, 3px);
	border-color: var(--green, #008000);
}

video.halfslide {
	height: auto;
	background-color: var(--black, #000000);
	vertical-align: middle;
}

img.imgpromo {
	height: 3em;
	margin: 0.3em;
	border-style: none;
}

hr.copyright {
  width: var(--copyright-rule, 40em);
  border-style: dotted;
  border-width: var(--border-thin, 1px);
}

hr.promohr {
	border-style: dotted;
	border-width: var(--border-thin, 1px);
	color: var(--silver, #c0c0c0);
	margin-top: 0em;
	margin-bottom: 0em;
}

.promosection {
	margin-top: 1.6em;
	font-style: italic;
	font-size: small;
}

.clearfix::after {
  content: "";
  clear: both;
  display: table;
}

.presentation {
  font-variant: small-caps;
  font-size: 2em;
}

.recommended {
  font-style: italic;
  font-size: small;
  text-decoration-line: underline;
  color: var(--darksalmon, #e9967a);
  padding-bottom: 0.25em;
}

.info {
	font-family: var(--font-serif, serif);
	display: inline-table;
	max-width: var(--page-max, 1024px);
	margin-left: auto;
	margin-right: auto;
	width: var(--page-width, 96%);
	background-color: var(--mintcream, #f5fffa);
	text-align: left;
	border-style: solid;
	border-width: var(--border-thin, 1px);
	border-spacing: var(--info-spacing, 1em);
}

.nspanel {
	display: inline-table;
	border-top: var(--border-thin, 1px) solid var(--gray, #808080);
	border-bottom: var(--border-thin, 1px) solid var(--gray, #808080);
	padding-top: 1em;
	padding-bottom: 1em;
	margin-top: 1em;
}

.lectureframe {
	border-width: var(--border-thin, 1px);
	border-style: solid;
	border-color: var(--gray, #808080);
	width: var(--halfslide-width, 450px);
	height: 30em;
	max-width: 100%;
}

.ns-panel-image {
	width: var(--page-max, 1024px);
	max-width: 100%;
}

.ns-panel-subtitle {
	color: var(--green, #008000);
	font-size: small;
	font-style: italic;
}

.intro-wrap {
	padding-left: var(--intro-pad, 2em);
	padding-right: var(--intro-pad, 2em);
}

.intro-left {
	display: inline-table;
	float: left;
	text-align: center;
	vertical-align: middle;
}

.intro-right {
	display: inline-table;
	float: right;
}

.title-sc {
	font-variant: small-caps;
	/* Demotované z h1 na h2 (jediný h1 na stránke) – vizuál zachovaný. */
	font-size: 2em;
	margin: 0.67em 0;
}

.title-lg {
	font-size: 2em;
	margin: 0.67em 0;
}

.intro-portrait {
	border: 0;
	width: var(--portrait-width, 500px);
	max-width: 100%;
}

.age-main {
	font-weight: bold;
	font-size: 2.5em;
}

.top-gap {
	margin-top: 5em;
}

.linkedin-logo {
	height: 3em;
}

.doctor-card {
	background-color: var(--mintcream, #f5fffa);
	border-color: var(--black, #000000);
	border-style: solid;
	border-width: var(--border-thin, 1px);
	display: inline-table;
	padding: var(--cell-pad-foot, 0.5em);
}

.amazon-box {
	border-block-end-color: var(--gray, #808080);
	border-style: solid;
	border-width: var(--border-thin, 1px);
	background-color: var(--ghostwhite, #f8f8ff);
}

.footer-rule {
	width: var(--page-width, 96%);
}

.copyright-name {
	font-variant: small-caps;
	font-size: 1.6em;
}

.centered {
	text-align: center;
}

.visitor-map {
	margin: 1em auto;
	max-width: 300px;
}

.visitor-map figcaption {
	margin-top: 0.4em;
	line-height: 1.35;
}

.meta-muted {
	color: var(--gray, #808080);
	font-size: smaller;
}

.meta-light {
	color: var(--silver, #c0c0c0);
	font-size: small;
	font-style: italic;
}

.tools-muted {
	color: var(--gray, #808080);
}

.inline-table-box {
	display: inline-table;
	border-width: var(--border-thin, 1px);
	border-style: solid;
}

.w3-logo {
	height: 5em;
}

.thanks-box {
	display: inline-table;
	border: var(--border-thin, 1px) solid var(--silver, #c0c0c0);
	padding: var(--cell-pad-sm, 1em);
	background-color: var(--whitesmoke, #f5f5f5);
}

.dw-banner {
	width: 300px;
	max-width: 50%;
}

.lipton-portrait {
	float: right;
	width: 30%;
	margin-left: 2em;
	margin-bottom: 1em;
}

.martinus-link-box {
	text-align: center;
	margin: 1.5em 0;
}

.martinus-link {
	font-weight: bold;
	text-decoration: underline;
}

.text-sc-bold {
	font-variant: small-caps;
	font-weight: bolder;
}

.info-justify {
	text-align: justify;
}

.bg-ivory {
	background-color: var(--ivory, #fffff0);
}

.bg-honeydew {
	background-color: var(--honeydew, #f0fff0);
}

.bg-lavenderblush {
	background-color: var(--lavenderblush, #fff0f5);
}

.bg-seashell {
	background-color: var(--seashell, #fff5ee);
}

.bg-ghostwhite {
	background-color: var(--ghostwhite, #f8f8ff);
}

.inline-table {
	display: inline-table;
}

.info-title {
	font-size: 3em;
	font-variant: small-caps;
	text-align: center;
}

.teal-frame {
	border: var(--frame-width, 3px) solid var(--teal, #008080);
}

.frame-mel {
	width: 100%;
	height: 50em;
}

.kidney-icon {
	vertical-align: middle;
	height: 3vw;
}

.text-right {
	text-align: right;
}

main#content > section {
	margin-top: var(--section-gap, 1.5rem);
}

main#content > section.section-lg {
	margin-top: var(--section-gap-lg, 3rem);
}

main#content > section.section-xl {
	margin-top: var(--section-gap-xl, 4.5rem);
}

main#content > section:first-child {
	margin-top: 0;
}

.archive-notice {
	max-width: var(--page-max, 1024px);
	margin-left: auto;
	margin-right: auto;
	width: var(--page-width, 96%);
	box-sizing: border-box;
	padding: var(--notice-pad-y, 1em) var(--notice-pad-x, 2em);
	background-color: var(--cornsilk, #fff8dc);
	border: var(--border-medium, 3px) solid var(--darkgoldenrod, #b8860b);
}

.archive-notice h2 {
	margin: 0.2em 0;
	color: var(--sienna, #a0522d);
	font-variant: small-caps;
}

.archive-notice p {
	margin: 0.5em 0;
}

.privacy-links {
	color: var(--legal-meta, #666666);
	font-size: 0.95rem;
}

nav.privacy-links {
	margin: 1em 0;
}

.cookie-settings-button {
	font: inherit;
	color: var(--maroon, #800000);
	background: var(--white, #ffffff);
	border: var(--border-thin, 1px) solid var(--control-border, #8b7d7d);
	padding: var(--settings-btn-pad-y, 0.25rem) var(--settings-btn-pad-x, 0.6rem);
	cursor: pointer;
}

.cookie-settings-button:hover,
.cookie-settings-button:focus-visible {
	background: var(--control-hover-bg, #fff4f4);
	outline: var(--focus-width, 2px) solid var(--focus-ring, #3d6d7a);
	outline-offset: var(--focus-offset, 2px);
}


.sr-only {
	position: absolute;
	width: 1px;
	height: 1px;
	padding: 0;
	margin: -1px;
	overflow: hidden;
	clip: rect(0, 0, 0, 0);
	white-space: nowrap;
	border: 0;
}

.cookie-banner[hidden],
.cookie-modal-backdrop[hidden] {
	display: none !important;
}

.cookie-banner {
	position: fixed;
	left: var(--banner-inset, 1rem);
	right: var(--banner-inset, 1rem);
	bottom: var(--banner-inset, 1rem);
	max-width: var(--banner-max, 76rem);
	margin: 0 auto;
	border-radius: var(--radius-lg, 1.1rem);
	background: linear-gradient(135deg, var(--cookie-banner-bg-1, #fffef8) 0%, var(--cookie-banner-bg-2, #fff6ea) 50%, var(--cookie-banner-bg-3, #f6efe5) 100%);
	border: var(--border-thin, 1px) solid var(--cookie-banner-border, #8f7f6c);
	box-shadow: var(--shadow-banner, 0 22px 55px rgba(55, 34, 12, 0.24));
	padding: var(--banner-pad, 1.25rem);
	z-index: 9998;
	text-align: left;
	backdrop-filter: blur(10px);
}

.cookie-banner-shell {
	display: grid;
	gap: var(--banner-gap, 1rem);
}

.cookie-banner-grid {
	display: grid;
	grid-template-columns: minmax(0, 1.7fr) minmax(18rem, 1fr);
	gap: var(--banner-gap, 1rem);
	align-items: start;
}

.cookie-banner-copy,
.cookie-banner-side {
	min-width: 0;
}

.cookie-eyebrow {
	margin: 0 0 0.45rem 0;
	font-size: 0.76rem;
	line-height: 1.2;
	text-transform: uppercase;
	letter-spacing: 0.16em;
	font-weight: 700;
	color: var(--cookie-eyebrow, #7d5122);
}

.cookie-title {
	margin: 0 0 0.55rem 0;
	font-size: clamp(1.3rem, 1rem + 0.9vw, 1.9rem);
	line-height: 1.15;
	color: var(--cookie-title, #4e1700);
}

.cookie-text {
	margin: 0;
	color: var(--cookie-text, #2d2d2d);
	max-width: var(--text-max, 52rem);
}

.cookie-points {
	margin: 0.9rem 0 0 1.2rem;
	padding: 0;
	color: var(--cookie-points, #5d4e3f);
	font-size: 0.95rem;
	line-height: 1.45;
}

.cookie-points li {
	margin: 0.22rem 0;
}

.cookie-pill-list {
	display: flex;
	flex-wrap: wrap;
	gap: var(--pill-gap, 0.45rem);
	margin-bottom: 0.8rem;
}

.cookie-pill {
	display: inline-flex;
	align-items: center;
	padding: var(--pill-pad-y, 0.35rem) var(--pill-pad-x, 0.65rem);
	border-radius: var(--radius-pill, 999px);
	background: var(--cookie-pill-bg, rgba(123, 89, 46, 0.12));
	border: var(--border-thin, 1px) solid var(--cookie-pill-border, rgba(123, 89, 46, 0.22));
	color: var(--cookie-pill-text, #69431d);
	font-size: 0.82rem;
	font-weight: 600;
	line-height: 1.2;
}

.cookie-disclaimer {
	margin: 0;
	padding: var(--disclaimer-pad-y, 0.85rem) var(--disclaimer-pad-x, 0.95rem);
	border-radius: var(--radius-sm, 0.85rem);
	background: var(--cookie-disclaimer-bg, rgba(255, 255, 255, 0.78));
	border: var(--border-thin, 1px) solid var(--cookie-disclaimer-border, rgba(125, 81, 34, 0.18));
	color: var(--cookie-disclaimer-text, #463528);
	font-size: 0.92rem;
	line-height: 1.5;
}

.cookie-status {
	margin: 0;
	font-size: 0.94rem;
	color: var(--cookie-status, #4f3f2f);
	min-height: 1.2rem;
	font-weight: 600;
}

.cookie-status-saved {
	animation: cookieSavedPulse 1.1s ease-out;
}

@keyframes cookieSavedPulse {
	0% {
		background-color: var(--cookie-saved-pulse, rgba(91, 143, 107, 0.25));
		color: var(--cookie-saved-text, #214a2f);
	}
	70% {
		background-color: rgba(91, 143, 107, 0.08);
		color: #2d5538;
	}
	100% {
		background-color: transparent;
		color: var(--cookie-status, #4f3f2f);
	}
}

.cookie-actions {
	display: flex;
	flex-wrap: wrap;
	gap: var(--actions-gap, 0.6rem);
}

.cookie-actions-primary {
	justify-content: flex-end;
	align-items: center;
}

.cookie-actions-modal {
	justify-content: flex-end;
	padding-top: 0.5rem;
	border-top: var(--border-thin, 1px) solid var(--cookie-divider, #e6dbce);
}

.cookie-btn {
	font: inherit;
	padding: var(--btn-pad-y, 0.6rem) var(--btn-pad-x, 0.95rem);
	min-height: var(--touch-min, 44px);
	border: var(--border-thin, 1px) solid var(--cookie-btn-border, #7a6d5d);
	cursor: pointer;
	border-radius: var(--radius-pill, 999px);
	font-weight: 600;
	transition: background-color 120ms ease, color 120ms ease, border-color 120ms ease, transform 80ms ease, box-shadow 120ms ease;
}

.cookie-btn-primary {
	background: var(--cookie-primary, #5f1b1b);
	color: var(--white, #ffffff);
	border-color: var(--cookie-primary, #5f1b1b);
	box-shadow: var(--shadow-primary-btn, 0 10px 24px rgba(95, 27, 27, 0.2));
}

.cookie-btn-secondary {
	background: var(--cookie-secondary-bg, rgba(255, 255, 255, 0.96));
	color: var(--cookie-primary, #5f1b1b);
}

.cookie-btn-ghost {
	background: var(--cookie-ghost-bg, #efe3d3);
	color: var(--cookie-ghost-text, #4b3d31);
}

.cookie-btn:hover,
.cookie-btn:focus-visible {
	outline: var(--focus-width, 2px) solid var(--focus-ring, #3d6d7a);
	outline-offset: var(--focus-offset, 2px);
}

.cookie-btn:active {
	transform: translateY(1px);
}

.cookie-icon-button {
	appearance: none;
	border: var(--border-thin, 1px) solid var(--cookie-icon-border, #d4c3af);
	background: var(--white, #ffffff);
	color: var(--cookie-icon-text, #4b2b18);
	width: var(--icon-button-size, 2.75rem);
	height: var(--icon-button-size, 2.75rem);
	border-radius: var(--radius-pill, 999px);
	font-size: 1.3rem;
	line-height: 1;
	cursor: pointer;
	box-shadow: var(--shadow-icon-btn, 0 8px 20px rgba(77, 53, 28, 0.12));
}

.cookie-icon-button:hover,
.cookie-icon-button:focus-visible {
	outline: var(--focus-width, 2px) solid var(--focus-ring, #3d6d7a);
	outline-offset: var(--focus-offset, 2px);
}

.cookie-modal-backdrop {
	position: fixed;
	inset: 0;
	background: var(--cookie-backdrop, rgba(34, 20, 7, 0.52));
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 1rem;
	z-index: 9999;
}

.cookie-modal {
	background: linear-gradient(180deg, var(--cookie-modal-bg-1, #fffdf9) 0%, var(--white, #ffffff) 100%);
	border: var(--border-thin, 1px) solid var(--cookie-modal-border, #8b7d6d);
	border-radius: var(--radius-md, 1rem);
	max-width: var(--modal-max, 56rem);
	width: 100%;
	padding: var(--banner-pad, 1.25rem);
	max-height: 90vh;
	overflow: auto;
	text-align: left;
	box-shadow: var(--shadow-modal, 0 28px 60px rgba(35, 20, 3, 0.28));
}

.cookie-modal-header {
	display: flex;
	justify-content: space-between;
	align-items: flex-start;
	gap: var(--banner-gap, 1rem);
}

.cookie-modal h2 {
	margin: 0;
	color: var(--cookie-title, #4e1700);
	font-size: clamp(1.35rem, 1rem + 0.7vw, 1.8rem);
}

.cookie-modal-lead {
	margin: 1rem 0 0 0;
	color: var(--cookie-modal-lead, #3c342e);
}

.cookie-disclaimer-modal {
	margin-top: 0.95rem;
}

.cookie-card-list {
	display: grid;
	gap: var(--card-gap, 0.85rem);
	margin: 1.1rem 0;
}

.cookie-row {
	display: flex;
	justify-content: space-between;
	align-items: center;
	gap: var(--banner-gap, 1rem);
	padding: var(--row-pad, 1rem);
	border: var(--border-thin, 1px) solid var(--cookie-row-border, #e2d7cb);
	border-radius: var(--radius-sm, 0.85rem);
	background: var(--cookie-row-bg, #fffdfb);
}

.cookie-row h3 {
	margin: 0 0 0.2rem 0;
	font-size: 1rem;
	color: var(--legal-status, #4b1f1f);
}

.cookie-row p {
	margin: 0;
	color: var(--cookie-row-text, #444444);
	font-size: 0.95rem;
}

.cookie-row-copy {
	flex: 1;
}

.cookie-row-meta {
	margin-top: 0.35rem !important;
	font-size: 0.84rem !important;
	color: var(--cookie-row-meta, #73563e) !important;
}

.cookie-row-locked {
	background: var(--cookie-row-locked-bg, #f8f3ec);
}

.cookie-toggle {
	white-space: nowrap;
	display: flex;
	align-items: center;
	gap: 0.55rem;
	font-weight: 600;
	color: var(--cookie-toggle-text, #3f3f3f);
	padding: var(--toggle-pad-y, 0.7rem) var(--toggle-pad-x, 0.9rem);
	border-radius: var(--radius-pill, 999px);
	background: var(--cookie-toggle-bg, #f8f2e8);
	border: var(--border-thin, 1px) solid var(--cookie-toggle-border, #e2d0b7);
}

.cookie-toggle input {
	inline-size: var(--checkbox-size, 1.1rem);
	block-size: var(--checkbox-size, 1.1rem);
}

.cookie-noscript {
	border: var(--border-thin, 1px) solid var(--cookie-noscript-border, #a27f5f);
	background: var(--cookie-noscript-bg, #fff8ef);
	padding: 0.75rem;
	margin: 1rem;
	text-align: left;
}

body.cookie-modal-open {
	overflow: hidden;
}

@media (max-width: 700px) {
	.cookie-banner {
		left: 0.5rem;
		right: 0.5rem;
		bottom: 0.5rem;
		padding: 0.95rem;
		max-height: 75vh;
		overflow-y: auto;
	}

	.cookie-banner-grid {
		grid-template-columns: 1fr;
	}

	.cookie-row {
		flex-direction: column;
		align-items: flex-start;
	}

	.cookie-toggle {
		width: 100%;
		justify-content: center;
	}

	.cookie-actions {
		flex-direction: column;
	}

	.cookie-btn {
		width: 100%;
	}

	.cookie-icon-button {
		flex: 0 0 auto;
	}
}

@media (prefers-reduced-motion: reduce) {
	.cookie-status-saved,
	.cookie-btn,
	.cookie-icon-button {
		animation: none !important;
		transition: none !important;
	}
}

/* Skip-link – presunuty z inline stylu v index.php, aby ho mali aj tematicke stranky. */
.skip-link {
	position: absolute;
	left: -9999px;
	top: auto;
	width: 1px;
	height: 1px;
	overflow: hidden;
}

.skip-link:focus {
	left: 1rem;
	top: 1rem;
	width: auto;
	height: auto;
	padding: var(--skip-pad-y, 0.6rem) var(--skip-pad-x, 0.8rem);
	background: var(--white, #ffffff);
	border: var(--border-thin, 1px) solid var(--skip-border, #333333);
	z-index: 1000;
}

/* Samostatne tematicke stranky (blocks/topic-page.php). */
.topic-breadcrumb {
	margin: 1rem 0;
	font-size: 0.95rem;
}

.topic-breadcrumb span {
	margin: 0 0.35rem;
}

.topic-article {
	max-width: var(--article-max, 70rem);
	margin: 0 auto;
}

.topic-back {
	margin: 2rem 0 1rem;
}

.topic-related {
	margin: 2.5rem 0 0;
	padding-top: 1.25rem;
	border-top: 1px solid var(--rule, #d0d7de);
	max-width: var(--article-max, 70rem);
	margin-left: auto;
	margin-right: auto;
}

.topic-related-title {
	margin: 0 0 0.75rem;
	font-size: 1.15rem;
	font-weight: 600;
}

.topic-related-list {
	display: flex;
	flex-wrap: wrap;
	gap: 0.55rem 1.25rem;
	margin: 0;
	padding: 0;
	list-style: none;
}

.topic-related-list a {
	display: inline-flex;
	align-items: center;
	min-height: 44px;
	padding: 0.25rem 0;
}

.topic-permalink {
	margin: 1.2rem 0 0;
	font-weight: 600;
}

/* Perex témy na hlavnej stránke (blocks/topic-teaser.php). */
.topic-teaser {
	margin-bottom: 0.5rem;
}

.topic-more {
	clear: both;
	margin: 1.2rem 0 0;
	font-weight: 600;
	text-align: left;
}

</style>
