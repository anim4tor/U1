<section class="projects radius" theme="dark">
	<div class="grid__3 gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2 inner-b__5">
		<div data-scroll class="span__2">
			<h2 class="font__size__1 xxl" data-reveal-text>
				Work
			</h2>
		</div>

		<div class="flex justify__end align__end m"><?= snippet('atoms/Link', ['url' => 'projects', 'label' => 'All projects']) ?></div>
		<ul class="flex justify__start align__center no__wrap gap__1">	
		<?php foreach (collection('Projects') as $project) : ?>
			<?= snippet('molecules/Project', compact('project')) ?>
		<?php endforeach ?>
		<?php foreach (collection('Projects') as $project) : ?>
			<?= snippet('molecules/Project', compact('project')) ?>
		<?php endforeach ?>
		</ul>
		
	</div>
</section>