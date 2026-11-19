<?php
$meta = array_filter([
	$project->industry()->isNotEmpty() ? implode(', ', $project->industry()->split()) : null,
	$project->place()->isNotEmpty() ? $project->place()->value() : null,
	$project->date()->isNotEmpty() ? $project->date()->toDate('Y') : null,
]);
?>
<div class="item --project relative" data-scroll>
	<a href="<?= $project->url() ?>" class="grid gap__1 relative">	
		<div class="relative">
			<?php if ($cover = $project->cover()->toFile()) : ?>
				<div class="item__figure grid img__radius"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 1,'reveal' => true, 'css' => 'aspect__3/4', 'node' => 'data-reveal-image']) ?></div>
			<?php endif ?>
		</div>
		<div class="item__meta relative grid gap__05">
			<div class="font__size__small op__7"><?= implode(' · ', $meta) ?></div>
			<h3 class=" wrap "><?= $project->title() ?></h3>
		</div>
	</a>
</div>