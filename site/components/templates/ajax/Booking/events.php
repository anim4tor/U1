<a data-tab="events" aria-controls="detail" tabindex="-1" aria-selected="false" role="tab" class="inner-y__05 inner-x__2 wrap-y__05 flex justify__start op__5"><div class="button upper -wrap-l__04">Back</div></a>
<div class="inner-x__2 event__item --small">
	<div class="grid inner-b__1 border__bottom">
		<div class="grid__4 gap__1 relative">
			<div class="event__figure grid">
				<?php if ($cover = $book->cover()->toFile()) : ?>
					<figure class="grid"><?= snippet('atoms/Image', [ 'img' => $cover ]) ?></figure>
				<?php endif ?>
			</div>
			<div class="event__body span__3 grid gap__05 place__center-start">
				<div class="icon absolute inset__top-right"><?= svg('public/assets/images/ui/ui_arrow-top-right.svg') ?></div>
				<p class="upper text-xs bolder"><span class="icon --circle wrap-b__01 wrap-r__01"></span><?= $book->date()->toDate('F d, Y') ?></p>
				<h3 class="text-s inner-r__2"><?= $book->title() ?></h2>
				<p class="flex gap__02 align__center text-s">
					<span><?= $book->limit()->toBool() ? $book->seats() . ' tickets left' : 'Unlimited entry' ?></span>
					<span class="text-xs">•</span> 
					<span><?= !$book->free()->toBool() ? $book->price() . ',- Kč' : 'Free of charge' ?></span>
				</p>
				<!-- <p class=""><?= $book->excerpt() ?></p> -->
			</div>
			
		</div>
	</div>
</div>
<div class="inner-x__2 inner-y__1">
	<div class="flex gap__1 justify__space-between">
		<!-- <h3 class="text-m">Book Your Event Today</h3> -->
		<?= snippet('atoms/Button', ['url' => $book->url(), 'label' => 'Event detail', 'theme' => 'ghost']) ?>
		<?= snippet('atoms/Button', ['url' => '', 'label' => 'Book event', 'theme' => 'dark']) ?>
	</div>
</div>

