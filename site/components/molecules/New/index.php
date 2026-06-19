<li class="item vw__7" data-scroll>
	<a href="<?= $new->url() ?>" class="grid wrap">	
		<?php if ($cover = $new->cover()->toFile()) : ?>
			<div class="item__figure grid img__radius no__overflow "><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 1, 'css' => 'h__12 grid' ]) ?></div>
		<?php endif ?>
		<div class=" flex justify__space-between align__center gap__2 inner-y__05 ">
			<div class="flex gap__05 upper ">
				<span class="">(01)</span>
				<h3 class="font__size__default ff__body"><?= $new->title() ?></h3>
			</div>
			<p class="">(<?= $new->date()->toDate('Y') ?>)</p>
		</div>
		<!-- <div class="grid ">
			<p class="xs upper"><?= $new->intro()->inline() ?></p>
		</div> -->
	</a>
</li>