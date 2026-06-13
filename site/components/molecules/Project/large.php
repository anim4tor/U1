<li class="class__item --large" data-scroll>
	<a href="<?= $lecture->url() ?>" class="grid relative">	
		<?php if ($cover = $lecture->cover()->toFile()) : ?>
			<div class="lecture__figure absolute inset__stretch grid"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 1, 'css' => 'overlay__bottom' ]) ?></div>
		<?php endif ?>
		<div class="relative color__invert grid place__space-between-start gap__05 aspect__square h__20 inner__1">
			<p class="flex align__center gap__02 font__size__small upper m"><span class="icon --circle"></span><?= $lecture->subtitle()->inline() ?></p>
			<h2 class="font__size__3 lighter"><?= $lecture->title() ?></h2>
		</div>
	</a>
</li>