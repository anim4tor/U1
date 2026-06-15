<?php
	$img ??= null;
	$parallax ??= false;
	$url ??= null;
	$css ??= false;
	$reveal ??= true;
	$alt = $img ? $img->alt()->esc() : 'Image';
?>
<figure data-scroll 
    <?= $reveal ? 'data-reveal-image' : null ?>
	<?= $parallax ? 'data-scroll-progress data-parallax style="--speed: '.$parallax.'"' : null ?>
	class="<?= $css ?>"
>
	<?php if ($img) : ?>
		<img 
			loading="auto" 
			src="<?= $img->url() ?>" 
			alt="<?= $alt ?>"
		>
	<?php else: ?>
		<img 
			loading="auto" 
			src="<?= asset('public/assets/images/'.$url)->url() ?>" 
			alt="<?= $alt ?>"
		>
	<?php endif ?>
</figure>