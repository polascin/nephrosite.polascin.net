<?php

/**
 * Prehľad tém na hlavnej stránke.
 *
 * Sekcie zobrazujú iba perex (úvodný obrázok, nadpis a prvý odstavec)
 * s odkazom na samostatnú tematickú stránku, kde je celé znenie.
 * Perex generuje blocks/topic-teaser.php priamo z fragmentu v files/.
 */

?>
<div class="info info-justify bg-ivory">
	<?php $teaser = ["file" => "nefrologia.html", "title" => "Klinická nefrológia", "slug" => "nefrologia.php"]; ?>
	<?php include __DIR__ . "/topic-teaser.php"; ?>
</div>

<br><br><br>

<div class="info info-justify bg-honeydew">
	<?php $teaser = ["file" => "dialyza.html", "title" => "Dialýza", "slug" => "dialyza.php"]; ?>
	<?php include __DIR__ . "/topic-teaser.php"; ?>
</div>

<br><br><br>

<div class="info info-justify bg-lavenderblush">
	<?php $teaser = ["file" => "purifikacia.html", "title" => "Purifikácia krvi", "slug" => "purifikacia.php"]; ?>
	<?php include __DIR__ . "/topic-teaser.php"; ?>
</div>

<br><br><br>

<div class="info info-justify bg-seashell">
	<?php $teaser = ["file" => "transplantacia.html", "title" => "Transplantácia obličky", "slug" => "transplantacia.php"]; ?>
	<?php include __DIR__ . "/topic-teaser.php"; ?>
</div>

<br><br><br>

<div class="info info-justify bg-ghostwhite">
	<?php $teaser = ["file" => "usgo.html", "title" => "Ultrazvukové vyšetrenie obličiek", "slug" => "usgo.php"]; ?>
	<?php include __DIR__ . "/topic-teaser.php"; ?>
</div>

<br><br><br>

<div class="info info-justify">
	<?php $teaser = ["file" => "nefamb.html", "title" => "Nefrologická ambulancia", "slug" => "nefamb.php"]; ?>
	<?php include __DIR__ . "/topic-teaser.php"; ?>
</div>

<br><br><br>

<div class="info bg-honeydew inline-table">
	<div class="info-title">
		<a href="https://sk.polascin.net/docs/mel.pdf" target="_blank" rel="noopener noreferrer">
			Mimotelová eliminačná liečba. &copy; 2009.
		</a>
	</div>
	<br>
	<iframe src="https://sk.polascin.net/docs/mel.pdf" class="teal-frame frame-mel" title="Mimotelová eliminačná liečba. &copy; 2009"></iframe>
</div>
