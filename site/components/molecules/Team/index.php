<?php
	$collapsed ??= true;
?>

<li class="team__item item --large" data-scroll>
	<div class="grid place__center-center gap__0">	
		<div data-tab class="flex justify__center gap__05 inner-y__05" data-scroll data-hover-toggle="service-<?= $team->slug() ?>">
			<h3 class="font__size__1 text__center no__wrap" data-reveal-text data-split-ignore><?= $team->title() ?></h3>
		</div>
		<div data-pane="team-<?= $team->slug() ?>">
			<div>	
				<div class="grid place__center-center vw__6 gap__1 inner-b__2" >
					<?php if ($cover = $team->photo()->toFile()) : ?>
						<div class="item__figure grid radius no__overflow "><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 1, 'css' => 'vh__6 grid' ]) ?></div>
					<?php endif ?>
					<div class="grid ">
						<p class="s upper text__center"><?= $team->bio()->inline() ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>