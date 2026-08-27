<!DOCTYPE html>

<html lang="sk">

<head>

  <meta charset="UTF-8">
  <meta name="date" content="2024-01-01T13:08:53+0100" >

  <?php include "./blocks/metatags.sk.php"; ?>
  <?php include "./blocks/links.sk.php"; ?>
  <?php include "./blocks/styles.css.php"; ?>
  <?php // require "./blocks/scripts.sk.php"; ?>

  <?php $documentTitle = isset($pageTitle) ? $pageTitle : "NephroSite"; ?>

  <title><?php echo htmlspecialchars($documentTitle, ENT_QUOTES, "UTF-8"); ?></title>

</head>

<body>

  <a class="skip-link" href="#content">Preskočiť na hlavný obsah</a>

  <header>
    <?php include "./blocks/ns.sk.php"; ?>
  </header>

  <main id="content">

	<section>
	  <?php require "./blocks/current.sk.php"; ?>
	  <hr>
	</section>

	<section>
	  <?php include "./blocks/archive-notice.sk.php"; ?>
	  <hr>
	</section>

	<section>
	  <?php include "./blocks/foazosszu.sk.php"; ?>
	  <hr>
	</section>

  <section class="section-lg">
    <?php include "./blocks/intro.sk.php"; ?>
  </section>

  <section class="section-lg">
    <?php include "./blocks/info.sk.php"; ?>
  </section>

  <section class="section-xl">
    <?php include "./blocks/lectures.sk.php"; ?>
  </section>

  <section class="section-xl">
    <?php include "./blocks/promo.sk.php"; ?>
  </section>

  <section class="section-xl">
    <?php include "./blocks/nephrology.sk.php"; ?>
  </section>

  </main>

  <footer>
    <?php include "./blocks/footer.sk.php"; ?>
  </footer>

  <?php include "./blocks/cookie-banner.sk.php"; ?>
  <?php require "./blocks/scripts.sk.php"; ?>

</body>

</html>