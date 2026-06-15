<li class="project__item --large w__15" data-scroll>
	<a href="<?= $project->url() ?>" class="grid relative">	
		<?php if ($cover = $project->cover()->toFile()) : ?>
			<div class="project__figure grid radius"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 1, 'css' => 'vh__'.rand(12,16) ]) ?></div>
		<?php endif ?>
		<div class="relative flex justify__space-between align__center gap__2 inner-y__05 ">
			<div class="flex gap__1 align__center upper ">
				<span class="font__size__default s ff__body">(01)</span>
				<h3 class="font__size__default s ff__body"><?= $project->title() ?></h3>
			</div>
			<p class="font__size__default s ff__body">(<?= $project->date()->toDate('Y') ?>)</p>
		</div>
	</a>
</li>