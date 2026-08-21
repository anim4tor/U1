<a href="<?= $feed->url() ?>" class="grid flex-wrap">	
	<?php if ($cover = $feed->cover()->toFile()) : ?>
		<div class="item__figure grid rounded-img overflow-hidden"><?= snippet('atoms/Image', ['img' => $cover, 'reveal' => false, 'node' => 'data-reveal-image', 'css' => 'h-[40vh] grid' ]) ?></div>
	<?php endif ?>
	<div class="flex justify-between items-start gap-5 py-05">
		<div class="flex gap-2 uppercase">
			<h4 class="font-size-4 text-xs font-semibold" data-reveal-text="lines"><?= $feed->title() ?></h4>
		</div>
		<p class="flex-nowrap whitespace-nowrap opacity-5" data-reveal-text="lines">(<?= $feed->date()->toDate('Y-m-d') ?>)</p>
	</div>
</a>
