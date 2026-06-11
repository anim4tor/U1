<li class="event__item --small">
	<a href="<?= $event->url() ?>" class="grid inner-y__1 border__bottom">
		<div class="grid__5 mobile:gap__1 relative">
			<div class="event__figure grid inner-r__2 mobile:inner-r__0 mobile:span__5">
				<?php if ($cover = $event->cover()->toFile()) : ?>
					<figure class="grid"><?= snippet('atoms/Image', [ 'img' => $cover ]) ?></figure>
				<?php endif ?>
			</div>
			<div class="event__body inner-r__3 span__3 mobile:span__5 grid gap__05 mobile:gap__1 place__center-start">
				<h3 class="s mobile:df"><?= $event->title() ?></h2>
				<p class="flex gap__02 align__center s mobile:df">
					<span><?= $event->limit()->toBool() ? $event->seats() . ' tickets left' : 'Unlimited entry' ?></span>
					<span class="xs">•</span> 
					<span><?= !$event->free()->toBool() ? $event->price() . ',- Kč' : 'Free of charge' ?></span>
				</p>
				<p class="event__excerpt mobile:m"><?= $event->excerpt() ?></p>
			</div>
			<div class="event__meta grid mobile:span__5 place__start-start">
				<p class="upper xs mobile:df bolder"><span class="icon --circle wrap-b__01 wrap-r__01"></span><?= $event->date()->toDate('F d, Y') ?></p>
				<div class="icon absolute inset__top-right mobile:inset__bottom-right"><?= svg('public/assets/images/ui/ui_arrow-top-right.svg') ?></div>
			</div>
		</div>
	</a>
</li>