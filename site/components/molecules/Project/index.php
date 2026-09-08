<div class="item --project relative" data-scroll>
	<a href="<?= $project->url() ?>" class="grid gap__05 relative">	
		<div class="relative">
			<?php if ($cover = $project->cover()->toFile()) : ?>
				<div class="item__figure grid img__radius"><?= snippet('atoms/Image', ['img' => $cover, 'reveal' => true, 'css' => 'vh__'.rand(8,10), 'node' => 'data-reveal-image']) ?></div>
			<?php endif ?>
			
			
		</div>
		<div class="item__meta relative flex justify__space-between align__center gap__2">
			<div class="flex gap__05 upper ">
				<!-- <span class="">(<?= str_pad($project->indexOf(collection('Projects')) + 1, 2, '0', STR_PAD_LEFT); ?>)</span> -->
				<h3 class="font__size__5 wrap"><?= $project->title() ?></h3>
			</div>
			<p class="">(<?= $project->date()->toDate('Y') ?>)</p>
		</div>
	</a>
</div>