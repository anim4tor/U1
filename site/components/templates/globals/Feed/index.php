<section class="events" data-carousel>
	<div class="bg radius absolute inset__stretch" theme="light"></div>

	<div class="relative grid__2 gap__2 inner-x__1 inner-y__1">
		<div class="" data-scroll>
			<h2 class="l" data-reveal-text>Studio</h2>
		</div>
		<div class="flex justify__space-between">
			<div class="grid gap__02 inner-b__5" data-scroll>
				<h3 class="" data-reveal-text>Blog</h3>
				<h3 class=" op__4" data-reveal-text>Socials</h3>
				<h3 class=" op__4" data-reveal-text>Media</h3>
			</div>
			<div class="flex gap__02 justify__end align__end m">
				<button data-carousel-prev class="button upper" theme="ghost" ><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
				<button data-carousel-next class="button upper" theme="ghost" ><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>

				<!-- <?= snippet('atoms/Link', ['url' => 'projects', 'label' => 'All projects']) ?> -->
			</div>
		</div>
	</div>
	<div class="inner-b__5" data-carousel-scroll>
		<ol class="flex justify__start align__start no__wrap gap__1 inner-x__1 " data-carousel-slides >	
		<?php foreach (collection('Blog') as $feed) : ?>
			<div data-slide class="vw__7">	
				<?= snippet('molecules/Feed', compact('feed')) ?>
			</div>
		<?php endforeach ?>
		</ol>
	</div>
</section>