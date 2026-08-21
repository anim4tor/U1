<?php if ($page->featuredProjects()->isNotEmpty()) : ?>
<section class="projects rounded-radius" theme="dark" >
	<div class="grid grid-cols-1 md:grid-cols-3 gap-1 pb-2 px-1 md:px-0" data-carousel>
		<div data-scroll class="col-span-1 md:col-span-2 px-1 pt-2">
			<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['heading']]) ?>
		</div>
		<div class="flex gap-02 justify-end items-end px-1 text-base">
			<button data-carousel-prev class="button uppercase" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
			<button data-carousel-next class="button uppercase" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
		</div>
		<div class="col-span-1 md:col-span-3" data-carousel-scroll>
			<ol class="flex justify-start items-center flex-nowrap gap-1 px-1" data-carousel-slides >	
			<?php foreach ($page->featuredProjects()->toPages() as $project) : ?>
				<li data-slide class="project__wrapper w-[25vw] flex-shrink-0">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</li>
			<?php endforeach ?>
			</ol>
		</div>
	</div>
	<?= snippet('templates/globals/Testimonials/carousel') ?>
	<div class="flex col-span-3 justify-center p-2">
		<div class="col-span-3 flex justify-center">
			<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['button']]) ?>
		</div>
	</div>
</section>
<?php endif ?>