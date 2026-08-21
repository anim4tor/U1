<div class="item --project relative" data-scroll>
	<a href="<?= $project->url() ?>" class="grid gap-05 relative">	
		<div class="relative">
			<?php if ($cover = $project->cover()->toFile()) : ?>
				<div class="item__figure grid rounded-img"><?= snippet('atoms/Image', ['img' => $cover, 'reveal' => true, 'css' => 'h-['.rand(30,40).'vh]', 'node' => 'data-reveal-image']) ?></div>
			<?php endif ?>
		</div>
		<div class="item__meta relative flex justify-between items-center gap-2">
			<div class="flex gap-05 uppercase">
				<h3 class="font-size-4 text-sm font-semibold flex-wrap"><?= $project->title() ?></h3>
			</div>
			<p class="">(<?= $project->date()->toDate('Y') ?>)</p>
		</div>
	</a>
</div>