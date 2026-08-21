<?php
	$collapsed ??= true;
?>

<li class="team__item item --large" data-scroll>
	<div class="grid place-items-center gap-0">	
		<div data-tab class="flex justify-center gap-05 py-05" data-scroll data-hover-toggle="service-<?= $team->slug() ?>">
			<h3 class="font-size-1 text-center flex-nowrap" data-reveal-text data-split-ignore><?= $team->title() ?></h3>
		</div>
		<div data-pane="team-<?= $team->slug() ?>">
			<div>	
				<div class="grid place-items-center w-[60vw] gap-1 pb-2" >
					<?php if ($cover = $team->photo()->toFile()) : ?>
						<div class="item__figure grid rounded-radius overflow-hidden"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 1, 'css' => 'h-[30vh] grid' ]) ?></div>
					<?php endif ?>
					<div class="grid ">
						<p class="text-s uppercase text-center"><?= $team->bio()->inline() ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>