<section class="projects radius" theme="dark" data-carousel>
	<div class="grid__3 gap__2 mobile:grid__1 inner-y__2 inner-b__5 mobile:inner-x__1 ">
		<div data-scroll class="span__2 inner-x__1 ">
			<h2 class="l" data-reveal-text>
				Selected <br>Works
			</h2>
		</div>

		<div class="flex gap__02 justify__end align__end inner-x__1 m">
			<button data-carousel-prev class="button upper" theme="invert-ghost" ><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
			<button data-carousel-next class="button upper" theme="invert-ghost" ><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>

			<!-- <?= snippet('atoms/Link', ['url' => 'projects', 'label' => 'All projects']) ?> -->
		</div>
		
		<div class="span__3" data-carousel-scroll>
			<ul class="flex justify__start align__center no__wrap gap__1 inner-x__1 " data-carousel-slides >	
			<?php foreach (collection('Projects') as $project) : ?>
				<div data-slide class="vw__7">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</div>
			<?php endforeach ?>
			<?php foreach (collection('Projects') as $project) : ?>
				<div data-slide class="vw__7">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</div>
			<?php endforeach ?>
			<?php foreach (collection('Projects') as $project) : ?>
				<div data-slide class="vw__7">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</div>
			<?php endforeach ?>
			<?php foreach (collection('Projects') as $project) : ?>
				<div data-slide class="vw__7">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</div>
			<?php endforeach ?>
			<?php foreach (collection('Projects') as $project) : ?>
				<div data-slide class="vw__7">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</div>
			<?php endforeach ?>
			</ul>
		</div>
		
	</div>
</section>