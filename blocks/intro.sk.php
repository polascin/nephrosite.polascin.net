<div class="clearfix intro-wrap">
  <div class="intro-left">
    <div>
    	<a href="https://nephrosite.polascin.net/" target="_top" title="NephroSite - Ľubomír Polaščín">
				<h1 class="title-sc">Ľubomír Polaščín</h1>
	   		<img src="https://polascin.net/pix/elpi.jpg" alt="Ľubomír Polaščín - fotografia" class="intro-portrait">
			</a>
		</div>
    <div>
    	<a href="https://sk.wikipedia.org/wiki/Dospelos%C5%A5" target="_blank" title="Vek v rokoch">
				<?php
        	$vek = (time() - mktime(8,30,0,3,4,1971)) / (60 * 60 * 24 * 365.25) ;
				$vekCely = floor($vek);
				$vekDesatinnaCast = strstr((string) round($vek, 3), ".");
				?>
				<span class="age-main"><?php echo $vekCely; ?></span>
				<br>(<?php echo $vekCely; ?><small><?php echo ($vekDesatinnaCast !== false) ? $vekDesatinnaCast : ".0"; ?></small>)<br>
			</a>
		</div>
  </div>
	<div class="intro-right top-gap">
  	  	<a href="https://www.linkedin.com/in/lubomirpolascin/" target="_blank" title="Lubomir Polacin's LinkedIn Profile">
		<img src="https://polascin.net/weblogo/LinkedIn-logo.png" alt="LinkedIn Logo" class="linkedin-logo">
  	</a>
		<br><br><br>
    <!--<a href="https://nemocnica-bory.sk/ambulancia/nefrologicka/" target="_blank" title="Nefrologická ambulancia Nemocnice Bory">-->
	    <div class="doctor-card">
  			<strong>MUDr. Ľubomír POLAŠČÍN</strong>
				<br>
 				Nefrológ
				<br>
				<strong>A64482063</strong>
			</div>
		<!--</a>-->
		<br><br>
		<a href="https://www.amazon.com/stores/Lubomir-Polascin/author/B07PN436VJ?store_ref=ap_rdr&isDramIntegrated=true&shoppingPortalEnabled=true&linkCode=ll2&tag=mobile0f21130-20&linkId=857497f66a358285c30f667879e75f8e&language=en_US&ref_=as_li_ss_tl" target="_blank" title="Moje knihy na Amazon-e">
			<h3 class="amazon-box">
				Moje knihy na Amazon-e
			</h3>
		</a>
		<br>
		<!--<div style="border-style: solid; border-width: thin; border-color: gray; padding: 0.3em;">
			<a href="https://nemocnica-bory.sk/pacient/ambulancie/#objednanie" target="_blank" title="Nefrologická ambulancia Nemocnice Bory - OBJEDNANIE">
				<small><em>Nájdete ma v Nemocnici novej generácie Bory</em></small>
			</a>
			<br>
			<a href="https://nemocnica-bory.sk/" target="_blank" title="Nemocnica Bory - Penta Hospitals">
				<img src="https://polascin.net/weblogo/nngb-logo.svg" height="50" alt="Nemocnica Bory - Penta Hospitals">
			</a>
			<a href="https://nemocnica-bory.sk/pacient/ambulancie/#objednanie" target="_blank" title="Ako sa objednať?">
				<div style="font-weight: bold;"><hr class="promohr">0950 105 510<hr class="promohr"></div>
			</a>
			<div style="font-size: small; font-style: italic;">
				<a href="https://nemocnica-bory.sk/pracovisko/dialyza/" target="_blank" title="Dialyzačný stacionár Nemocnice Bory">
					Dialýza (Dialyzačný stacionár)
				</a>
				&nbsp;&nbsp;&nbsp;
				<a href="https://nemocnica-bory.sk/ambulancia/nefrologicka/" target="_blank" title="Nefrologická ambulancia Nemocnice Bory">
					Nefrologická ambulancia
				</a>
			</div>
			<hr class="promohr"><br>
			<div style="font-size: small;">
				Recepcia D : +421 <strong>2 5977 7118</strong> &nbsp;&nbsp;|&nbsp;&nbsp; Dialýza : +421 <strong>2 5977 7181</strong>
			</div>
		</div>-->
		<br><br><br>
	</div>
</div>
