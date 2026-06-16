<section class="featured">	
	<div class="grid relative">
		<?php if ($cover = $featured->cover()->toFile()) : ?>
			<div class="absolute inset__stretch grid " >
				<?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'css' => 'overlay__bottom' ]) ?>
			</div>
		<?php endif ?>
		<div class="relative grid gap__07 place__end-center h__100v wrap-x__10 inner-y__2 mobile:wrap-x__1 text__center color__invert">
			<h3 class="l lighter"><span class="icon --circle wrap-r__03 wrap-b__03"></span><?= $featured->title() ?></h3>
			<p class="m"><?= $featured->excerpt() ?></p>
			<div class="flex gap__05 align__center">
				<p class="flex gap__02 align__center s">
					<span><?= $featured->limit()->toBool() ? $featured->seats() . ' tickets left' : 'Unlimited entry' ?></span>
					<span class="xs">•</span> 
					<span><?= !$featured->free()->toBool() ? $featured->price() . ',- Kč' : 'Free of charge' ?></span>
				</p>
				<?= snippet('atoms/Button', ['url' => '', 'label' => 'Get your tickets', 'theme' => 'invert']) ?>
			</div>
		</div>
	</div>
</section>