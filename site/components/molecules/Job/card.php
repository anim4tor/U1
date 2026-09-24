<div class="item --project" data-scroll>
	<a href="<?= $job->url() ?>" class="grid gap__05 relative">
		<?php if ($cover = $job->cover()->toFile()) : ?>
			<div class="item__figure grid img__radius"><?= snippet('atoms/Image', ['img' => $cover, 'reveal' => true, 'css' => 'vh__'.rand(8,8), 'node' => 'data-reveal-image']) ?></div>
		<?php endif ?>
		<div class="item__meta relative flex justify__space-between align__center gap__2">
			<div class="flex gap__05 upper">
				<h3 class="wrap font__size__5"><?= $job->title() ?></h3>
			</div>
			<div class="flex gap__1 align__center no__wrap">
				<?php if ($job->location()->isNotEmpty()) : ?>
					<p class="font__size__small">(<?= $job->location() ?>)</p>
				<?php endif ?>
				<?php if ($job->duration()->isNotEmpty()) : ?>
					<p class="font__size__small"><?= $job->duration() ?></p>
				<?php endif ?>
			</div>
		</div>
	</a>
</div>
