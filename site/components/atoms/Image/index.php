<?php
    // Parameter Sanitizations & Fallbacks
    $img             = (!isset($img) || $img === '') ? null : $img;
    $url             = (!isset($url) || trim($url) === '') ? null : $url;
    $css             = (!isset($css) || trim($css) === '') ? '' : $css;
    $node             = (!isset($node) || trim($node) === '') ? '' : $node;
    $nodeTag         = (!isset($nodeTag) || trim($nodeTag) === '') ? 'figure' : $nodeTag;
    $nodeHref        = (!isset($nodeHref) || trim($nodeHref) === '') ? false : $nodeHref;

    // Animation Properties Sanitizations (Parallax strictly false by default)
    $parallax        = (!isset($parallax) || $parallax === false || $parallax === 'false' || trim((string)$parallax) === '') ? false : $parallax;
    $reveal          = (isset($reveal) && ($reveal === 'true' || $reveal === true)) ? true : false;
    $revealDirection = (!isset($revealDirection) || $revealDirection === false || trim($revealDirection) === '') ? 'left' : $revealDirection;

    // Extract Alternative Text
    $altText = 'Image';
    if ($img) {
        $altText = $img->alt()->isNotEmpty() ? $img->alt()->esc() : $img->filename();
    }
?>

<?php if ($nodeHref): ?>
    <a href="<?= $nodeHref ?>" class="figure__link" style="display: block; text-decoration: none; color: inherit;">
<?php endif ?>

	<figure 
		<?= $reveal || $parallax !== false ? 'data-scroll' : '' ?>
		<?= $revealDirection !== false ? 'data-reveal-image="' . esc($revealDirection) . '"' : '' ?>
		<?= $parallax !== false ? 'data-scroll-progress data-parallax style="--speed: ' . esc($parallax) . '"' : '' ?>
		class="img__radius <?= esc($css) ?>"
		<?= esc($node) ?>
	>
		<?php if ($img) : ?>
			<img 
				loading="lazy" 
				src="<?= $img->url() ?>" 
				alt="<?= $altText ?>"
			>
		<?php elseif ($url): ?>
			<img 
				loading="lazy" 
				src="<?= asset('public/assets/images/' . $url)->url() ?>" 
				alt="<?= $altText ?>"
			>
		<?php endif ?>
	</figure>

<?php if ($nodeHref): ?>
    </a>
<?php endif ?>