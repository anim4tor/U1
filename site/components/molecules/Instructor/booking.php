<a data-async-tab="detail" href="<?= BASE_PROJECT_PATH ?>/booking/team/<?= $instructor->slug() ?>" class="inner-y__05 inner-x__2 grid place__center-stretch border__top">	
	<div class="flex gap__05 align__center">
		<?php if ($photo = $instructor->photo()->toFile()) : ?>
			<div class="w__2 h__2 grid aspect__square"><?= snippet('atoms/Image', [ 'img' => $photo]) ?></div>
		<?php endif ?>
		<h4 class=""><?= $instructor->title() ?></h2>
		<div class="icon --open"><?= svg('public/assets/images/ui/ui_arrow-top-right.svg') ?></div>
	</div>
</a>