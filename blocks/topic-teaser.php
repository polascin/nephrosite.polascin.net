<?php

/**
 * Perex (upútavka) témy pre hlavnú stránku.
 *
 * Z fragmentu v `files/` vyberie úvodný obrázok, prvý nadpis a prvý odstavec
 * a doplní odkaz „Čítať ďalej“ na samostatnú stránku témy. Obsah tak zostáva
 * na jedinom mieste – v fragmente – a nemôže sa medzi hlavnou stránkou
 * a tematickou stránkou rozísť.
 *
 * Volajúci blok musí pred vložením nastaviť pole $teaser:
 *   file  – názov fragmentu v adresári files/
 *   title – názov témy (do textu odkazu)
 *   slug  – čistá kanonická cesta bez .php (napr. dialyza)
 */
if (!isset($teaser) || !is_array($teaser)) {
    return;
}

$teaserPath = __DIR__ . '/../files/' . basename((string) $teaser['file']);

if (!is_file($teaserPath)) {
    return;
}

ob_start();
require $teaserPath;
$teaserHtml = (string) ob_get_clean();

preg_match('#<img\b[^>]*>#i', $teaserHtml, $teaserImage);
preg_match('#<p\b[^>]*>.*?</p>#is', $teaserHtml, $teaserLead);

$teaserSlug = basename((string) $teaser['slug']);
$teaserTitle = (string) $teaser['title'];
$teaserTitlePlain = trim($teaserTitle);
$teaserHeadingHtml = '';

if (preg_match_all('#<h2\b([^>]*)>(.*?)</h2>#is', $teaserHtml, $headingMatches, PREG_SET_ORDER)) {
    foreach ($headingMatches as $headingMatch) {
        $plain = trim(html_entity_decode(strip_tags($headingMatch[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        if (strcasecmp($plain, $teaserTitlePlain) === 0) {
            $teaserHeadingHtml = $headingMatch[0];
            break;
        }
    }
    if ($teaserHeadingHtml === '') {
        $teaserHeadingHtml = $headingMatches[0][0];
    }
}

?>
<div class="topic-teaser clearfix">
	<?php echo $teaserImage[0] ?? ''; ?>
	<?php echo $teaserHeadingHtml; ?>
	<?php echo $teaserLead[0] ?? ''; ?>
	<p class="topic-more">
		<a href="/<?php echo htmlspecialchars($teaserSlug, ENT_QUOTES, 'UTF-8'); ?>">Čítať ďalej: <?php echo htmlspecialchars($teaserTitle, ENT_QUOTES, 'UTF-8'); ?> &rarr;</a>
	</p>
</div>
