<li class="item vw__7" data-scroll>
	<a href="<?= $feed->url() ?>" class="grid wrap">	
		<?php if ($cover = $feed->cover()->toFile()) : ?>
			<div class="item__figure grid img__radius no__overflow "><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 1, 'css' => 'h__12 grid' ]) ?></div>
		<?php endif ?>
		<div class="flex justify__space-between align__start gap__5 inner-y__05 ">
			<div class="flex gap__2 upper ">
				<!-- <span class="">(<?= str_pad($feed->indexOf(collection('Projects')) + 1, 2, '0', STR_PAD_LEFT); ?>)</span> -->
				<h4 class="font__size__5 xs"><?= $feed->title() ?></h4>
			</div>
			<p class="no__wrap op__5">(<?= $feed->date()->toDate('Y-m-d') ?>)</p>
		</div>
		<!-- <div class="grid ">
			<p class="xs upper"><?= $feed->intro()->inline() ?></p>
		</div> -->
	</a>
</li>