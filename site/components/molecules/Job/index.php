<li class="item --job" data-scroll>
	<a href="<?= $job->url() ?>" class="grid relative py-1 border-t">	
		
		<div class="item__meta relative grid grid-cols-1 md:grid-cols-4 items-start gap-2">
			<div class="col-span-1 md:col-span-2 flex gap-2">
				<span class="">(<?= str_pad($job->indexOf(collection('Jobs')) + 1, 2, '0', STR_PAD_LEFT); ?>)</span>
				<h3 class="font-size-4 text-s flex-wrap"><?= $job->title() ?></h3>
			</div>
			<p class="">(<?= $job->location() ?>)</p>
			<div class="flex justify-end">
				<?php if ($cover = $job->cover()->toFile()) : ?>
					<div class="item__figure grid rounded-img overflow-hidden"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 1, 'css' => 'w-[25vw] aspect-[4/3]' ]) ?></div>
				<?php endif ?>
			</div>
		</div>
	</a>
</li>