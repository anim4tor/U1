<a href="<?= $feed->url() ?>" class="grid gap__05 wrap">	
	<?php if ($cover = $feed->cover()->toFile()) : ?>
		<div class="item__figure grid img__radius no__overflow aspect__1/1"><?= snippet('atoms/Image', ['img' => $cover, 'css' => 'aspect__1/1 grid', 'reveal' => false, 'node' => 'data-reveal-image' ]) ?></div>
	<?php endif ?>
	<div class=" flex justify__space-between align__center gap__2 ">
		<div class="flex gap__05 upper ">
			<span class="font__size__small" data-reveal-text="lines">(<?= str_pad($feed->indexOf(collection('Projects')) + 1, 2, '0', STR_PAD_LEFT); ?>)</span>
			<h3 class="font__size__default ff__body" data-reveal-text="lines"><?= $feed->title() ?></h3>
		</div>
		<p class="font__size__small" data-reveal-text="lines">(<?= $feed->date()->toDate('Y') ?>)</p>
	</div>
	<!-- <div class="grid ">
		<p class="font__size__small upper"><?= $feed->intro()->inline() ?></p>
	</div> -->
</a>
