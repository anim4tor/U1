<div class="grid grid-cols-1 md:grid-cols-2 gap-2 py-1 border-t flex-wrap">	
	<div class="grid content-between items-stretch gap-2 pr-2" data-scroll>
		<div class="grid">
			<p class="uppercase">(Featured)</p>
			<span class="opacity-4"><?= $feed->date()->toDate('Y-m-d') ?></span>
		</div>
		<a href="<?= $feed->url() ?>" ><h3 class="" data-reveal-text><?= $feed->title() ?></h3></a>
		<div class="flex justify-start">
			<?= snippet('atoms/Button', [ 'url' => $feed->url(), 'label' => 'Read more', 'theme' => 'light', 'icon' => 'arrow-right']) ?>
		</div>
	</div>
	<?php if ($cover = $feed->cover()->toFile()) : ?>
	<a href="<?= $feed->url() ?>" class="grid">
		<div class="item__figure grid rounded-img overflow-hidden md:-ml-5"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 1, 'reveal' => true, 'css' => 'h-[50vh] grid' ]) ?></div>
	</a>
	<?php endif ?>
	<!-- <div class="grid ">
		<p class="text-xs uppercase"><?= $feed->intro()->inline() ?></p>
	</div> -->
</div>