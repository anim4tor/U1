<a data-async-tab="detail" href="<?= BASE_PROJECT_PATH ?>/booking/events/<?= $event->slug() ?>" class="inner-y__05 inner-x__2 grid place__center-stretch border__top">	
	<div class="grid__4 gap__05 align__stretch relative">
		<?php if ($cover = $event->cover()->toFile()) : ?>
			<div class="grid"><?= snippet('atoms/Image', [ 'img' => $cover]) ?></div>
		<?php endif ?>
		<div class="span__3 inner-r__2 grid gap__2">
			<div class="grid gap__02">
				<p class="font__size__small upper"><span class="icon --circle wrap-b__01 wrap-r__01"></span><?= $event->date()->toDate('F d, Y') ?></p>
				<h4 class=""><?= $event->title() ?></h2>
			</div>
			<p class="flex gap__02 align__center xs">
				<span><?= $event->limit()->toBool() ? $event->seats() . ' tickets left' : 'Unlimited entry' ?></span>
				<span class="xs">•</span> 
				<span><?= !$event->free()->toBool() ? $event->price() . ',- Kč' : 'Free of charge' ?></span>
			</p>
		</div>
		<div class="absolute inset__top-right icon --open"><?= svg('public/assets/images/ui/ui_arrow-top-right.svg') ?></div>
	</div>
</a>