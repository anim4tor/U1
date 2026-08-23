<a href="<?= $feed->url() ?>" class="grid wrap">	
	<?php if ($cover = $feed->cover()->toFile()) : ?>
		<div class="item__figure grid img__radius no__overflow "><?= snippet('atoms/Image', ['img' => $cover, 'reveal' => false, 'node' => 'data-reveal-image', 'css' => 'h__12 grid' ]) ?></div>
	<?php endif ?>
	<div class="flex justify__space-between align__start gap__5 inner-y__05 ">
		<div class="flex gap__2 upper ">
			<h4 class="font__size__4 text-xs" data-reveal-text="lines"><?= $feed->title() ?></h4>
		</div>
		<p class="no__wrap op__5" data-reveal-text="lines">(<?= $feed->date()->toDate('Y-m-d') ?>)</p>
	</div>
	<!-- <div class="grid ">
		<p class="text-xs upper"><?= $feed->intro()->inline() ?></p>
	</div> -->
</a>
