<?php
$siteName = "NephroSite";
$siteUrl = "https://nephrosite.polascin.net/";
$pageTitle ??= "NephroSite | Nefrológia, dialýza a interná medicína";
$pageDescription ??= "Odborné stránky MUDr. Ľubomíra Polaščína venované nefrológii, dialýze, purifikácii krvi, internej medicíne a edukácii pacientov.";
$pageKeywords ??= "nefrológia, dialýza, hemodialýza, peritoneálna dialýza, transplantácia obličky, purifikácia krvi, chronická obličková choroba, glomerulonefritída, interná medicína, edukácia pacientov";
$ogImage ??= "https://polascin.net/pix/elpi.jpg";
// Kanonicka URL stranky; predvolene homepage.
$canonicalUrl ??= $siteUrl;
$publishedDate = "2024-01-01T13:08:53+01:00";
$modifiedDate = date("c", getlastmod());
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="keywords" content="<?php echo htmlspecialchars($pageKeywords, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="googlebot" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="bingbot" content="index, follow">
<meta name="author" content="MUDr. Ľubomír Polaščín">
<meta name="copyright" content="Ľubomír Polaščín">
<meta name="language" content="sk">
<meta name="geo.region" content="SK">
<meta name="theme-color" content="#ffffff">

<meta property="og:type" content="website">
<meta property="og:site_name" content="<?php echo htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:locale" content="sk_SK">
<meta property="og:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:url" content="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:image" content="<?php echo htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:image:alt" content="MUDr. Ľubomír Polaščín – NephroSite">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:image" content="<?php echo htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8'); ?>">

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [{
            "@type": "WebSite",
            "@id": "https://nephrosite.polascin.net/#website",
            "url": "https://nephrosite.polascin.net/",
            "name": "NephroSite",
            "inLanguage": "sk",
            "publisher": {
                "@id": "https://nephrosite.polascin.net/#person"
            }
        },
        {
            "@type": "WebPage",
            "@id": "<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>#webpage",
            "url": "<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>",
            "name": "<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>",
            "isPartOf": {
                "@id": "https://nephrosite.polascin.net/#website"
            },
            "description": "<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>",
            "inLanguage": "sk",
            "datePublished": "<?php echo $publishedDate; ?>",
            "dateModified": "<?php echo $modifiedDate; ?>",
            "primaryImageOfPage": {
                "@type": "ImageObject",
                "url": "https://polascin.net/pix/elpi.jpg"
            },
            "about": {
                "@id": "https://nephrosite.polascin.net/#person"
            }
        },
        {
            "@type": ["Person", "Physician"],
            "@id": "https://nephrosite.polascin.net/#person",
            "name": "MUDr. Ľubomír Polaščín",
            "url": "https://nephrosite.polascin.net/",
            "jobTitle": "Nefrológ",
            "medicalSpecialty": "Nephrologic",
            "sameAs": [
                "https://www.linkedin.com/in/lubomirpolascin/"
            ]
        }
    ]
}
</script>