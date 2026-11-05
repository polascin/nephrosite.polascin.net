<?php $canonicalUrl ??= "https://nephrosite.polascin.net/"; $canonicalEsc = htmlspecialchars($canonicalUrl, ENT_QUOTES, "UTF-8"); ?>
<link rel="canonical" href="<?php echo $canonicalEsc; ?>">
<link rel="alternate" href="<?php echo $canonicalEsc; ?>" hreflang="sk">
<link rel="alternate" href="<?php echo $canonicalEsc; ?>" hreflang="x-default">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://polascin.net" crossorigin>
<link rel="preload" as="image" href="/pix/elpi.jpg">
<link href="/apple-touch-icon.png" rel="apple-touch-icon"  sizes="180x180">
<link href="/favicon-32x32.png" type="image/png" rel="icon"  sizes="32x32">
<link href="/favicon-16x16.png" type="image/png" rel="icon"  sizes="16x16">
<link href="/site.webmanifest" rel="manifest">
<?php
// Only families referenced by css/tokens.css + blocks/styles.css.php.
// Nine unused Google Font stylesheet links removed 2026-11-05 after CSS audit.
?>
<link href="https://fonts.googleapis.com/css?family=Blinker|Blaka|Fenix&display=swap" rel="stylesheet">
<?php /* Dizajnové tokeny (css/tokens.css, generované z tokens.json – pozri DEPLOY.md); musia byť načítané pred blocks/styles.css.php. */ ?>
<link rel="stylesheet" href="/css/tokens.css">
