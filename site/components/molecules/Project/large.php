<div class="item --project" data-scroll>
	<a href="<?= $project->url() ?>" class="grid gap-05 relative">	
		<?php if ($cover = $project->cover()->toFile()) : ?>
			<div class="item__figure grid rounded-img"><?= snippet('atoms/Image', ['img' => $cover, 'reveal' => true, 'css' => 'h-[40vh]', 'node' => 'data-reveal-image']) ?></div>
		<?php endif ?>
		<div class="item__meta relative flex justify-between items-center gap-2">
			<div class="flex gap-05 uppercase">
				<!-- <span class="">(<?= str_pad($project->indexOf(collection('Projects')) + 1, 2, '0', STR_PAD_LEFT); ?>)</span> -->
				<h3 class="font-size-5 text-m flex-wrap"><?= $project->title() ?></h3>
			</div>
			<p class="">(<?= $project->date()->toDate('Y') ?>)</p>
		</div>
	</a>
</div>