<style>

body {
	font-family: system-ui;
	text-align: center;
	color: maroon;
	background-color: white;
	max-width: 1024px;
	margin-left: auto;
	margin-right: auto;
}

a, a:link, a:visited {
	color: maroon;
	text-decoration: none;
}

a:hover {
	color: olive;
}

a:active {
	color: maroon;
}

table.lecture {
	max-width: 1024px;
	margin-left: auto;
	margin-right: auto;
	width: 96%;
	background-color: snow;
	text-align: left;
	border-style: solid;
	border-width: medium;
	border-spacing: 2em;
	font-family: 'Blinker';
}

table.lecture th {
  text-align: right;
	border-style: none;
	border-width: thin;
  padding: 1em;
  font-family: 'Blaka';
}

table.lecture td {
  padding: 2em;
	border-style: dotted;
	border-width: medium;
	border-color: darksalmon;
	background-color: floralwhite;
}

table.lecture img.slide {
	border-style: solid;
	border-width: thin;
	width: 100%;
}

table.lecture caption {
	color: indigo;
	font-size: 3em;
	font-variant: small-caps;
	font-weight: bold;
	text-align: left;
	font-family: 'Blinker';
}

table.lecture thead {
	background-color: cornsilk;
}

table.lecture tfoot td {
  padding: 0.5em;
  text-align: center;
  border-style: none;
	background-color: cornsilk;
}

table.lecture iframe {
  width: 100%;
  background-color: ghostwhite;
}

table.nephrology {
	max-width: 1024px;
	margin-left: auto;
	margin-right: auto;
	width: 96%;
	background-color: honeydew;
	text-align: left;
	border-style: solid;
	border-width: medium;
	border-spacing: 2em;
	font-family: 'Fenix';
}

table.nephrology h1,h2,h3 {
     font-variant: small-caps;
     color: green;
}

table.nephrology caption {
	color: darkcyan;
	font-size: 3em;
	font-variant: small-caps;
	font-weight: bold;
	text-align: left;
	font-family: 'Blinker';
}

table.nephrology th {
  text-align: right;
  padding: 1em;
  font-family: 'Blaka';
  background-color: azure;
}

table.nephrology td {
	text-align: justify;
	border-style: solid;
	border-width: thin;
	padding: 1em;
	background-color: mintcream;
}

table.nephrology tfoot td {
  padding: 0.5em;
  text-align: center;
  border-style: none;
  background-color: azure;
}

table.promo {
	max-width: 1024px;
	margin-left: auto;
	margin-right: auto;
	width: 96%;
	background-color: transparent;
	text-align: center;
	border-style: solid;
	border-width: thin;
}

img.reference {
  height: 5em;
  border-style: solid;
  border-width: thin;
}

img.halfslide {
	width: 450px;
	max-width: 100%;
	border-style: solid;
	border-width: medium;
	border-color: green;
}

img.imgpromo {
	height: 3em;
	margin: 0.3em;
	border-style: none;
}

hr.copyright {
  width: 40em;
  border-style: dotted;
  border-width: thin;
}

hr.promohr {
	border-style: dotted;
	border-width: thin;
	color: silver;
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
  color: darksalmon;
  padding-bottom: 0.25em;
}

.info {
	font-family: serif;
	display: inline-table;
	max-width: 1024px;
	margin-left: auto;
	margin-right: auto;
	width: 96%;
	background-color: mintcream;
	text-align: left;
	border-style: solid;
	border-width: thin;
	border-spacing: 1em;
}

.nspanel {
	display: inline-table;
	border-top: thin solid gray;
	border-bottom: thin solid gray;
	padding-top: 1em;
	padding-bottom: 1em;
	margin-top: 1em;
}

.lectureframe {
	border-width: thin;
	border-style: solid;
	border-color: gray;
	width: 450px;
	height: 30em;
	max-width: 100%;
}

.ns-panel-image {
	width: 1024px;
	max-width: 100%;
}

.ns-panel-subtitle {
	color: green;
	font-size: small;
	font-style: italic;
}

.intro-wrap {
	padding-left: 2em;
	padding-right: 2em;
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
}

.intro-portrait {
	border: 0;
	width: 500px;
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
	background-color: mintcream;
	border-color: black;
	border-style: solid;
	border-width: thin;
	display: inline-table;
	padding: 0.5em;
}

.amazon-box {
	border-block-end-color: gray;
	border-style: solid;
	border-width: thin;
	background-color: ghostwhite;
}

.footer-rule {
	width: 96%;
}

.copyright-name {
	font-variant: small-caps;
	font-size: 1.6em;
}

.centered {
	text-align: center;
}

.meta-muted {
	color: gray;
	font-size: smaller;
}

.meta-light {
	color: silver;
	font-size: small;
	font-style: italic;
}

.tools-muted {
	color: gray;
}

.inline-table-box {
	display: inline-table;
	border-width: thin;
	border-style: solid;
}

.w3-logo {
	height: 5em;
}

.thanks-box {
	display: inline-table;
	border: thin solid silver;
	padding: 1em;
	background-color: whitesmoke;
}

.dw-banner {
	width: 300px;
	max-width: 50%;
}

.info-justify {
	text-align: justify;
}

.bg-ivory {
	background-color: ivory;
}

.bg-honeydew {
	background-color: honeydew;
}

.bg-lavenderblush {
	background-color: lavenderblush;
}

.bg-seashell {
	background-color: seashell;
}

.bg-ghostwhite {
	background-color: ghostwhite;
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
	border: 3px solid teal;
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
	margin-top: 1.5rem;
}

main#content > section.section-lg {
	margin-top: 3rem;
}

main#content > section.section-xl {
	margin-top: 4.5rem;
}

main#content > section:first-child {
	margin-top: 0;
}

.privacy-links {
	color: #666666;
	font-size: 0.95rem;
}

.cookie-settings-button {
	font: inherit;
	color: maroon;
	background: #ffffff;
	border: 1px solid #8b7d7d;
	padding: 0.25rem 0.6rem;
	cursor: pointer;
}

.cookie-settings-button:hover,
.cookie-settings-button:focus-visible {
	background: #fff4f4;
	outline: 2px solid #3d6d7a;
	outline-offset: 2px;
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

.cookie-banner {
	position: fixed;
	left: 1rem;
	right: 1rem;
	bottom: 1rem;
	max-width: 76rem;
	margin: 0 auto;
	border-radius: 1.1rem;
	background: linear-gradient(135deg, #fffef8 0%, #fff6ea 50%, #f6efe5 100%);
	border: 1px solid #8f7f6c;
	box-shadow: 0 22px 55px rgba(55, 34, 12, 0.24);
	padding: 1.25rem;
	z-index: 9998;
	text-align: left;
	backdrop-filter: blur(10px);
}

.cookie-banner-shell {
	display: grid;
	gap: 1rem;
}

.cookie-banner-grid {
	display: grid;
	grid-template-columns: minmax(0, 1.7fr) minmax(18rem, 1fr);
	gap: 1rem;
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
	color: #7d5122;
}

.cookie-title {
	margin: 0 0 0.55rem 0;
	font-size: clamp(1.3rem, 1rem + 0.9vw, 1.9rem);
	line-height: 1.15;
	color: #4e1700;
}

.cookie-text {
	margin: 0;
	color: #2d2d2d;
	max-width: 52rem;
}

.cookie-points {
	margin: 0.9rem 0 0 1.2rem;
	padding: 0;
	color: #5d4e3f;
	font-size: 0.95rem;
	line-height: 1.45;
}

.cookie-points li {
	margin: 0.22rem 0;
}

.cookie-pill-list {
	display: flex;
	flex-wrap: wrap;
	gap: 0.45rem;
	margin-bottom: 0.8rem;
}

.cookie-pill {
	display: inline-flex;
	align-items: center;
	padding: 0.35rem 0.65rem;
	border-radius: 999px;
	background: rgba(123, 89, 46, 0.12);
	border: 1px solid rgba(123, 89, 46, 0.22);
	color: #69431d;
	font-size: 0.82rem;
	font-weight: 600;
	line-height: 1.2;
}

.cookie-disclaimer {
	margin: 0;
	padding: 0.85rem 0.95rem;
	border-radius: 0.85rem;
	background: rgba(255, 255, 255, 0.78);
	border: 1px solid rgba(125, 81, 34, 0.18);
	color: #463528;
	font-size: 0.92rem;
	line-height: 1.5;
}

.cookie-status {
	margin: 0;
	font-size: 0.94rem;
	color: #4f3f2f;
	min-height: 1.2rem;
	font-weight: 600;
}

.cookie-status-saved {
	animation: cookieSavedPulse 1.1s ease-out;
}

@keyframes cookieSavedPulse {
	0% {
		background-color: rgba(91, 143, 107, 0.25);
		color: #214a2f;
	}
	70% {
		background-color: rgba(91, 143, 107, 0.08);
		color: #2d5538;
	}
	100% {
		background-color: transparent;
		color: #4f3f2f;
	}
}

.cookie-actions {
	display: flex;
	flex-wrap: wrap;
	gap: 0.6rem;
}

.cookie-actions-primary {
	justify-content: flex-end;
	align-items: center;
}

.cookie-actions-modal {
	justify-content: flex-end;
	padding-top: 0.5rem;
	border-top: 1px solid #e6dbce;
}

.cookie-btn {
	font: inherit;
	padding: 0.6rem 0.95rem;
	border: 1px solid #7a6d5d;
	cursor: pointer;
	border-radius: 999px;
	font-weight: 600;
	transition: background-color 120ms ease, color 120ms ease, border-color 120ms ease, transform 80ms ease, box-shadow 120ms ease;
}

.cookie-btn-primary {
	background: #5f1b1b;
	color: #ffffff;
	border-color: #5f1b1b;
	box-shadow: 0 10px 24px rgba(95, 27, 27, 0.2);
}

.cookie-btn-secondary {
	background: rgba(255, 255, 255, 0.96);
	color: #5f1b1b;
}

.cookie-btn-ghost {
	background: #efe3d3;
	color: #4b3d31;
}

.cookie-btn:hover,
.cookie-btn:focus-visible {
	outline: 2px solid #3d6d7a;
	outline-offset: 2px;
}

.cookie-btn:active {
	transform: translateY(1px);
}

.cookie-icon-button {
	appearance: none;
	border: 1px solid #d4c3af;
	background: #ffffff;
	color: #4b2b18;
	width: 2.4rem;
	height: 2.4rem;
	border-radius: 999px;
	font-size: 1.3rem;
	line-height: 1;
	cursor: pointer;
	box-shadow: 0 8px 20px rgba(77, 53, 28, 0.12);
}

.cookie-icon-button:hover,
.cookie-icon-button:focus-visible {
	outline: 2px solid #3d6d7a;
	outline-offset: 2px;
}

.cookie-modal-backdrop {
	position: fixed;
	inset: 0;
	background: rgba(34, 20, 7, 0.52);
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 1rem;
	z-index: 9999;
}

.cookie-modal {
	background: linear-gradient(180deg, #fffdf9 0%, #ffffff 100%);
	border: 1px solid #8b7d6d;
	border-radius: 1rem;
	max-width: 56rem;
	width: 100%;
	padding: 1.25rem;
	max-height: 90vh;
	overflow: auto;
	text-align: left;
	box-shadow: 0 28px 60px rgba(35, 20, 3, 0.28);
}

.cookie-modal-header {
	display: flex;
	justify-content: space-between;
	align-items: flex-start;
	gap: 1rem;
}

.cookie-modal h2 {
	margin: 0;
	color: #4e1700;
	font-size: clamp(1.35rem, 1rem + 0.7vw, 1.8rem);
}

.cookie-modal-lead {
	margin: 1rem 0 0 0;
	color: #3c342e;
}

.cookie-disclaimer-modal {
	margin-top: 0.95rem;
}

.cookie-card-list {
	display: grid;
	gap: 0.85rem;
	margin: 1.1rem 0;
}

.cookie-row {
	display: flex;
	justify-content: space-between;
	align-items: center;
	gap: 1rem;
	padding: 1rem;
	border: 1px solid #e2d7cb;
	border-radius: 0.85rem;
	background: #fffdfb;
}

.cookie-row h3 {
	margin: 0 0 0.2rem 0;
	font-size: 1rem;
	color: #4b1f1f;
}

.cookie-row p {
	margin: 0;
	color: #444444;
	font-size: 0.95rem;
}

.cookie-row-copy {
	flex: 1;
}

.cookie-row-meta {
	margin-top: 0.35rem !important;
	font-size: 0.84rem !important;
	color: #73563e !important;
}

.cookie-row-locked {
	background: #f8f3ec;
}

.cookie-toggle {
	white-space: nowrap;
	display: flex;
	align-items: center;
	gap: 0.55rem;
	font-weight: 600;
	color: #3f3f3f;
	padding: 0.7rem 0.9rem;
	border-radius: 999px;
	background: #f8f2e8;
	border: 1px solid #e2d0b7;
}

.cookie-toggle input {
	inline-size: 1.1rem;
	block-size: 1.1rem;
}

.cookie-noscript {
	border: 1px solid #a27f5f;
	background: #fff8ef;
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

</style>
