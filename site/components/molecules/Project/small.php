<li class="class__item --small">
	<a href="<?= $lecture->url() ?>" class="inner-y__05 grid__2 mobile:grid__1 place__center-stretch border__bottom">	
		<div class="flex align__center">
			<?php if ($cover = $lecture->cover()->toFile()) : ?>
				<div class="lecture__figure w__2 h__2 aspect__square grid place__end-start"><?= snippet('atoms/Image', [ 'img' => $cover ]) ?></div>
			<?php endif ?>
			<h2 class="text-s"><?= $lecture->title() ?></h2>
		</div>
		<div class="flex justify__space-between align__center">
			<p class="flex align__center gap__02 font__size__small upper text-m mobile:text-df"><span class="icon --circle"></span><?= $lecture->subtitle()->inline() ?></p>
			<div class="icon --open"><?= svg('public/assets/images/ui/ui_arrow-top-right.svg') ?></div>
		</div>

	</a>
</li>