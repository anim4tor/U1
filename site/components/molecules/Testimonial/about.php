<div class="item --testimonial relative" data-scroll>
	<div class="grid gap__05 relative">	
		<div class="relative">
			<?php if ($cover = $testimonial->testimonialImage()->toFile() ?? (page('about') ? page('about')->file($testimonial->testimonialImage()->value()) : null)) : ?>
				<div class="item__figure grid img__radius"><?= snippet('atoms/Image', ['img' => $cover, 'reveal' => true, 'css' => 'vh__'.rand(8,10), 'node' => 'data-reveal-image']) ?></div>
			<?php endif ?>
		</div>
		<div class="item__meta relative flex justify__space-between align__start gap__2">
			<div class="flex gap__05 upper">
				<h3 class="font__size__4 wrap ff__heading"><?= $testimonial->testimonialQuote() ?></h3>
			</div>
			<?php if ($testimonial->testimonialPosition()->isNotEmpty()) : ?>
				<p class="font__size__small upper">(<?= $testimonial->testimonialAuthor() ?>, <?= $testimonial->testimonialPosition() ?>)</p>
			<?php endif ?>
		</div>
	</div>
</div>