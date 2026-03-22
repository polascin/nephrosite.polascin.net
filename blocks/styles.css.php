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

</style>
