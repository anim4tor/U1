<li class="item" data-scroll>
	<a href="<?= $feed->url() ?>" class="grid grid-cols-1 md:grid-cols-2 items-stretch gap-2 py-1 border-t flex-wrap">	
		<div class="grid pr-10">
			<?php if ($cover = $feed->cover()->toFile()) : ?>
				<div class="item__figure grid rounded-img overflow-hidden"><?= snippet('atoms/Image', ['img' => $cover, 'css' => 'h-[60vh] grid' ]) ?></div>
			<?php endif ?>
		</div>
		<div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:-ml-5">
			<div class="grid content-between justify-start gap-3">
				<h3 class="font-size-4 text-s"><?= $feed->title() ?></h3>
				<!-- <p class="">(<?= $feed->excerpt()->or($feed->intro()) ?>)</p> -->
				<div class="flex justify-start">
					<!-- <?= snippet('atoms/Button', [ 'label' => 'Read more', 'theme' => 'light', 'icon' => 'arrow-right']) ?> -->
				</div>
			</div>
			<div class="grid content-start justify-end">
				<span class="">(<?= $feed->category()->or($feed->industry()) ?>)</span>
				<span class="opacity-4"><?= $feed->date()->toDate('Y-m-d') ?></span>
			</div>
		</div>
		<!-- <div class="grid ">
			<p class="text-xs uppercase"><?= $feed->intro()->inline() ?></p>
		</div> -->
	</a>
</li>