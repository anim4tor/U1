<section class="events" data-carousel>
	<div class="bg radius absolute inset__stretch" theme="light"></div>

	<div class="relative grid__2 gap__2 inner-x__1 inner-y__2">
		<div class="" data-scroll>
			<h1 class="xl" data-reveal-text>Studio</h1>
		</div>
		<div class="flex justify__space-between">
			<div class="grid gap__02 inner-b__5" data-scroll>
				<h2 class="font__size__1 s" data-reveal-text>News</h2>
				<h2 class="font__size__1 s op__4" data-reveal-text>Socials</h2>
				<h2 class="font__size__1 s op__4" data-reveal-text>Media</h2>
			</div>
			<div class="flex gap__02 justify__end align__end m">
				<button data-carousel-prev class="button upper" theme="ghost" ><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
				<button data-carousel-next class="button upper" theme="ghost" ><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>

				<!-- <?= snippet('atoms/Link', ['url' => 'projects', 'label' => 'All projects']) ?> -->
			</div>
		</div>
	</div>
	<div class="inner-b__5" data-carousel-scroll>
		<ul class="flex justify__start align__center no__wrap gap__1 inner-x__1 " data-carousel-slides >	
		<?php foreach (collection('Projects') as $new) : ?>
			<div data-slide class="vw__7">	
				<?= snippet('molecules/New', compact('new')) ?>
			</div>
		<?php endforeach ?>
		<?php foreach (collection('Projects') as $new) : ?>
			<div data-slide class="vw__7">	
				<?= snippet('molecules/New', compact('new')) ?>
			</div>
		<?php endforeach ?>
		<?php foreach (collection('Projects') as $new) : ?>
			<div data-slide class="vw__7">	
				<?= snippet('molecules/New', compact('new')) ?>
			</div>
		<?php endforeach ?>
		<?php foreach (collection('Projects') as $new) : ?>
			<div data-slide class="vw__7">	
				<?= snippet('molecules/New', compact('new')) ?>
			</div>
		<?php endforeach ?>
		<?php foreach (collection('Projects') as $new) : ?>
			<div data-slide class="vw__7">	
				<?= snippet('molecules/New', compact('new')) ?>
			</div>
		<?php endforeach ?>
		</ul>
	</div>
</section>