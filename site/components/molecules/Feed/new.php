<li class="item" data-scroll>
	<a href="<?= $feed->url() ?>" class="grid__2 place__stretch-stretch gap__2 inner-y__1 border__top wrap">	
		<div class="grid inner-r__10">
			<?php if ($cover = $feed->cover()->toFile()) : ?>
				<div class="item__figure grid img__radius no__overflow "><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 1, 'css' => 'min-h__10 grid' ]) ?></div>
			<?php endif ?>
		</div>
		<div class="grid__2 gap__2 -wrap-l__5">
			<div class="grid place__space-between-start gap__3">
				<h3 class="font__size__4 xs"><?= $feed->title() ?></h3>
				<!-- <p class="">(<?= $feed->excerpt()->or($feed->intro()) ?>)</p> -->
				<div class="flex justify__start">
					<!-- <?= snippet('atoms/Button', [ 'label' => 'Read more', 'theme' => 'light', 'icon' => 'arrow-right']) ?> -->
				</div>
			</div>
			<div class="grid place__start-end">
				<span class="">(<?= $feed->category()->or($feed->industry()) ?>)</span>
				<span class="op__4"><?= $feed->date()->toDate('Y-m-d') ?></span>
			</div>
		</div>
		<!-- <div class="grid ">
			<p class="xs upper"><?= $feed->intro()->inline() ?></p>
		</div> -->
	</a>
</li>