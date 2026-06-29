<li class="item --project" data-scroll>
	<a href="<?= $project->url() ?>" class="grid relative">	
		<?php if ($cover = $project->cover()->toFile()) : ?>
			<div class="item__figure grid img__radius"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 1, 'css' => 'vh__'.rand(12,16) ]) ?></div>
		<?php endif ?>
		<div class="item__meta relative flex justify__space-between align__center gap__2 inner-x__05 ">
			<div class="flex gap__05 upper ">
				<span class="">(<?= str_pad($project->indexOf(collection('Projects')) + 1, 2, '0', STR_PAD_LEFT); ?>)</span>
				<h3 class="font__size__5 wrap"><?= $project->title() ?></h3>
			</div>
			<p class="">(<?= $project->date()->toDate('Y') ?>)</p>
		</div>
	</a>
</li>