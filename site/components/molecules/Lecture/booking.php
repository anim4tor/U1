<a data-async-tab="detail" href="<?= BASE_PROJECT_PATH ?>/booking/lectures/<?= $lecture->slug() ?>" class="inner-y__05 inner-x__2 grid place__center-stretch border__top">	
	<div class="flex gap__05 align__center">
		<?php if ($cover = $lecture->cover()->toFile()) : ?>
			<figure class="w__2 h__2 aspect__square grid place__end-start"><?= snippet('atoms/Image', [ 'img' => $cover ]) ?></figure>
		<?php endif ?>
		<h4 class=""><?= $lecture->title() ?></h2>
		<div class="icon --open"><?= svg('public/assets/images/ui/ui_arrow-top-right.svg') ?></div>
	</div>
</a>