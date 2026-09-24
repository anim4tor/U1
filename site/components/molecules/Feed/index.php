<a href="<?= $feed->url() ?>" class="grid gap__05 wrap">	
	<?php if ($cover = $feed->cover()->toFile()) : ?>
		<div class="item__figure grid img__radius no__overflow aspect__1/1"><?= snippet('atoms/Image', ['img' => $cover, 'reveal' => false, 'node' => 'data-reveal-image', 'css' => 'aspect__1/1 grid' ]) ?></div>
	<?php endif ?>
	<div class="flex justify__space-between align__start gap__5">
		<div class="flex gap__2 upper ">
			<h3 class="font__size__4" data-reveal-text="lines"><?= $feed->title() ?></h3>
		</div>
		<p class="no__wrap op__7 font__size__small" data-reveal-text="lines">(<?= $feed->date()->toDate('Y-m-d') ?>)</p>
	</div>
	<!-- <div class="grid ">
		<p class="font__size__small upper"><?= $feed->intro()->inline() ?></p>
	</div> -->
</a>
