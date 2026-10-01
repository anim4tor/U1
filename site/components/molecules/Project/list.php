<?php
$project = $project ?? null;
$img     = $img ?? $image ?? ($project ? $project->cover()->toFile() : null);
$url     = $project ? $project->url() : '#';
$title   = $project ? $project->title()->value() : '';
$caption = $caption ?? ($img && $img->caption()->isNotEmpty() ? $img->caption()->value() : null);
$date    = $project && $project->date()->isNotEmpty() ? $project->date()->toDate('Y') : null;
?>
<div class="item --project" data-scroll>
	<a href="<?= $url ?>" class="grid gap__05 relative">	
		<?php if ($img) : ?>
			<div class="item__figure grid img__radius no__overflow">
				<?= snippet('atoms/Image', ['img' => $img, 'reveal' => true, 'css' => 'vh__8 grid', 'node' => 'data-reveal-image']) ?>
			</div>
		<?php endif ?>
		<div class="item__meta relative flex justify__space-between align__start gap__2">
			<div class="flex gap__05 upper">
				<h3 class="font__size__4 wrap"><?= $title ?></h3>
				<?php if ($caption) : ?>
					<span class="op__6 font__size__small">(<?= $caption ?>)</span>
				<?php endif ?>
			</div>
			<?php if ($date) : ?>
				<p class="font__size__small">(<?= $date ?>)</p>
			<?php endif ?>
		</div>
	</a>
</div>