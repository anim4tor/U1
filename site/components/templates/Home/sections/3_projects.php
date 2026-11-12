<?php if ($page->featuredProjects()->isNotEmpty()) : ?>
<section class="projects radius" theme="dark" >
	<div class="grid__3 gap__2 mobile:grid__1 inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3" data-carousel data-per=4>
		<div data-scroll class="span__3 flex justify__space-between align__center mobile:flex__flow-column mobile:align__start gap__2">
			<div class="grid gap__05">
				<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['label']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['heading']]) ?>
			</div>
			<div class="flex gap__1 align__center no__wrap">
				<div class="flex align__center">
					<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['button']]) ?>
				</div>
				<div class="flex gap__02 align__center no__wrap">
					<button data-carousel-prev class="button upper circle" theme="invert-ghost" hover="invert" aria-label="Předchozí"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
					<button data-carousel-next class="button upper circle" theme="invert-ghost" hover="invert" aria-label="Další"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
				</div>
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
		<div class="span__3">
			<?= snippet('templates/globals/Testimonials/carousel') ?>
		</div>
	</div>
</section>
<?php endif ?>