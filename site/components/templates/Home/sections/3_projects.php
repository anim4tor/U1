<?php if ($page->featuredProjects()->isNotEmpty()) : ?>
<section class="projects radius" theme="dark" >
	<div class="grid__3 gap__2 mobile:grid__1 inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3" data-carousel data-per=4>
		<div data-scroll class="grid gap__1 span__2">
			<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['label']]) ?>
			<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['heading']]) ?>
		</div>
		<div class="flex gap__1 justify__end align__center mobile:justify__space-between wrap">
			<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['button']]) ?>
			<div class="flex gap__02 align__center">
				<button data-carousel-prev class="button upper" theme="invert-ghost" hover="invert" aria-label="Předchozí"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
				<button data-carousel-next class="button upper" theme="invert-ghost" hover="invert" aria-label="Další"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
			</div>
		</div>
		<div class="span__3" data-carousel-scroll>
			<ol class="flex justify__start align__start no__wrap gap__2  " data-carousel-slides >	
			<?php foreach ($page->featuredProjects()->toPages() as $project) : ?>
				<li data-slide class="project__wrapper">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</li>
			<?php endforeach ?>
			</ol>
		</div>
	</div>
	<?= snippet('templates/globals/Testimonials/carousel') ?>
</section>
<?php endif ?>