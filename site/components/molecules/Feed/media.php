<a href="<?= $feed->url() ?>" class="grid flex-wrap">	
	<?php if ($cover = $feed->cover()->toFile()) : ?>
		<div class="item__figure grid rounded-img overflow-hidden h-[40vh]"><?= snippet('atoms/Image', ['img' => $cover, 'css' => 'grid', 'reveal' => false, 'node' => 'data-reveal-image' ]) ?></div>
	<?php endif ?>
	<div class="flex justify-between items-center gap-2 py-05">
		<div class="flex gap-05 uppercase">
			<span class="" data-reveal-text="lines">(<?= str_pad($feed->indexOf(collection('Projects')) + 1, 2, '0', STR_PAD_LEFT); ?>)</span>
			<h3 class="font-size-default font-body" data-reveal-text="lines"><?= $feed->title() ?></h3>
		</div>
		<p class="" data-reveal-text="lines">(<?= $feed->date()->toDate('Y') ?>)</p>
	</div>
	<!-- <div class="grid ">
		<p class="text-xs uppercase"><?= $feed->intro()->inline() ?></p>
	</div> -->
</a>
