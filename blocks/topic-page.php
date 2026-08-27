<?php

/**
 * Zdieľaná šablóna samostatnej tematickej stránky.
 *
 * Obsahové fragmenty v `files/` sa vkladajú aj do `index.php`, preto samy
 * neobsahujú `<head>` ani `<title>`. Táto šablóna ich obalí plnohodnotným
 * dokumentom s vlastným titulkom, popisom a kanonickou URL, takže sú
 * samostatne indexovateľné.
 *
 * Volajúci súbor musí pred vložením nastaviť pole $topic:
 *   file        – názov fragmentu v adresári files/
 *   title       – nadpis témy (bez sufixu „| NephroSite“)
 *   description – meta popis stránky
 *   slug        – názov tejto PHP stránky (kanonická URL)
 */
if (!isset($topic) || !is_array($topic)) {
    http_response_code(500);
    exit('Chýba konfigurácia tematickej stránky.');
}

// basename() zabraňuje path traversal, aj keď je zdroj vždy interný.
$fragmentPath = __DIR__ . '/../files/' . basename((string) $topic['file']);

if (!is_file($fragmentPath)) {
    http_response_code(404);
    exit('Požadovaný obsah sa nenašiel.');
}

$pageTitle = $topic['title'] . ' | NephroSite';
$pageDescription = $topic['description'];
$canonicalUrl = 'https://nephrosite.polascin.net/' . basename((string) $topic['slug']);

// Hlavným nadpisom dokumentu je názov témy, nie názov webu.
$showSiteHeading = false;

?>
<!DOCTYPE html>

<html lang="sk">

<head>

  <meta charset="UTF-8">

  <?php include __DIR__ . "/metatags.sk.php"; ?>
  <?php include __DIR__ . "/links.sk.php"; ?>
  <?php include __DIR__ . "/styles.css.php"; ?>

  <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, "UTF-8"); ?></title>

</head>

<body>

  <a class="skip-link" href="#content">Preskočiť na hlavný obsah</a>

  <header>
    <?php include __DIR__ . "/ns.sk.php"; ?>
  </header>

  <main id="content">

    <nav class="topic-breadcrumb" aria-label="Omrvinková navigácia">
      <a href="/">NephroSite</a>
      <span aria-hidden="true">&rsaquo;</span>
      <span aria-current="page"><?php echo htmlspecialchars($topic['title'], ENT_QUOTES, "UTF-8"); ?></span>
    </nav>

    <article class="topic-article">
      <?php
      // Fragment sa vykreslí do vyrovnávacej pamäte, aby sa jeho prvý nadpis
      // dal povýšiť na <h1> – na samostatnej stránke je hlavným nadpisom.
      ob_start();
      require $fragmentPath;
      $fragment = (string) ob_get_clean();
      $fragment = preg_replace('#<h2\b([^>]*)>(.*?)</h2>#s', '<h1$1>$2</h1>', $fragment, 1);
      echo $fragment;
      ?>
    </article>

    <p class="topic-back">
      <a href="/">&larr; Späť na hlavnú stránku</a>
    </p>

  </main>

  <footer>
    <?php include __DIR__ . "/footer.sk.php"; ?>
  </footer>

  <?php include __DIR__ . "/cookie-banner.sk.php"; ?>
  <?php require __DIR__ . "/scripts.sk.php"; ?>

</body>

</html>
