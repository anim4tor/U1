<div class="item --project relative" data-scroll>
	<a href="<?= $project->url() ?>" class="grid gap__1 relative">	
		<div class="relative">
			<?php if ($cover = $project->cover()->toFile()) : ?>
				<div class="item__figure grid img__radius"><?= snippet('atoms/Image', ['img' => $cover, 'reveal' => true, 'css' => 'vh__'.rand(10,10), 'node' => 'data-reveal-image']) ?></div>
			<?php endif ?>
		</div>
		<div class="item__meta relative grid gap__05">
			<?= snippet('atoms/Label', ['text' => $project->date()->toDate('Y')]) ?>
			<h3 class=" wrap "><?= $project->title() ?></h3>
		</div>
	</a>
</div>