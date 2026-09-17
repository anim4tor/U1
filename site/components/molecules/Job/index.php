<li class="item --job" data-scroll>
	<a href="<?= $job->url() ?>" class="grid relative inner-y__1 border__top">	
		
		<div class="item__meta relative grid__4 place__start-stretch gap__2">
			<div class="span__2 flex gap__2">
				<span class="font__size__small">(<?= str_pad($job->indexOf(collection('Jobs')) + 1, 2, '0', STR_PAD_LEFT); ?>)</span>
				<h3 class="font__size__4 wrap"><?= $job->title() ?></h3>
			</div>
			<p class="font__size__small">(<?= $job->location() ?>)</p>
			<div class="flex justify__end">
				<?php if ($cover = $job->cover()->toFile()) : ?>
					<div class="item__figure grid img__radius"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 1, 'css' => 'w__5 aspect__4/3' ]) ?></div>
				<?php endif ?>
			</div>
		</div>
	</a>
</li>