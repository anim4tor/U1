<?php if ($page->featuredProjects()->isNotEmpty()) : ?>
<section class="projects radius" theme="dark" >
	<div class="grid__3 gap__2 mobile:grid__1 inner__4 mobile:inner-x__1 " data-carousel>
		<div data-scroll class="flex align__start gap__01 span__2">
			<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['label']]) ?>
			<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['heading']]) ?>
		</div>
		<div class="flex gap__02 justify__end align__end ">
			<button data-carousel-prev class="button upper" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
			<button data-carousel-next class="button upper" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
		</div>
		<div class="span__3" data-carousel-scroll>
			<ol class="flex justify__start align__center no__wrap gap__1  " data-carousel-slides >	
			<?php foreach ($page->featuredProjects()->toPages() as $project) : ?>
				<li data-slide class="project__wrapper vw__4">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</li>
			<?php endforeach ?>
			</ol>
		</div>
	</div>
	<?= snippet('templates/globals/Testimonials/carousel') ?>
	<div class="flex span__3 justify__center inner-t__1 inner-b__4">
		<div class="span__3 flex justify__center">
			<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['button']]) ?>
		</div>
	</div>
</section>
<?php endif ?>