<li class="class__item --small">
	<a href="<?= $lecture->url() ?>" class="py-05 grid grid-cols-1 md:grid-cols-2 items-center border-b">	
		<div class="flex items-center">
			<?php if ($cover = $lecture->cover()->toFile()) : ?>
				<div class="lecture__figure w-2 h-2 aspect-square grid place-items-start"><?= snippet('atoms/Image', [ 'img' => $cover ]) ?></div>
			<?php endif ?>
			<h2 class="text-s"><?= $lecture->title() ?></h2>
		</div>
		<div class="flex justify-between items-center">
			<p class="flex items-center gap-02 font-size-small uppercase text-m max-md:text-df"><span class="icon --circle"></span><?= $lecture->subtitle()->inline() ?></p>
			<div class="icon --open"><?= svg('public/assets/images/ui/ui_arrow-top-right.svg') ?></div>
		</div>

	</a>
</li>