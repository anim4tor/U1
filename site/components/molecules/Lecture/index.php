<li class="class__item --default" data-scroll>
	<a href="<?= $lecture->url() ?>" class="inner-y__1 grid__2 mobile:grid__1 mobile:gap__1 place__center-stretch border__bottom">	
		<div class="flex align__center h__3">
			<?php if ($cover = $lecture->cover()->toFile()) : ?>
				<div class="lecture__figure w__3 h__3 aspect__square grid place__end-start"><?= snippet('atoms/Image', [ 'img' => $cover ]) ?></div>
			<?php endif ?>
			<h2 class="m" data-reveal-text="lines"><?= $lecture->title() ?></h2>
		</div>
		<div class="flex justify__space-between align__center">
			<p class="flex align__center gap__02 font__size__small upper m" ><span class="icon --circle"></span><span data-reveal-text="lines"><?= $lecture->subtitle()->inline() ?></span></p>
			<div class="icon --open"><?= svg('public/assets/images/ui/ui_arrow-top-right.svg') ?></div>
		</div>

	</a>
</li>