<?php if ($page->hero()->isNotEmpty()) : ?>
<section class="intro rounded-radius" theme="dark" data-tabs="" data-autoplay="10000">
	<div class="hidden">
		<?php foreach ($page->heroSlider()->toPages() as $project) : ?>
			<div data-tab="project-<?= $project->indexOf($page->heroSlider()->toPages()) ?>"></div>
		<?php endforeach ?>
	</div>
	<div data-pane-container class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] absolute inset-0" >
		<?php $heroProjects = $page->heroSlider()->toPages(); ?>
		<?php foreach ($heroProjects as $index => $project) : ?>
			<?php if ($cover = $project->cover()->toFile()) : ?>
			<div data-tab-reveal data-pane="project-<?= $project->indexOf($heroProjects) ?>" >
				<div class="intro__cover grid" data-reveal-image><?= snippet('atoms/Image', [
					'img' => $cover, 
					'parallax' => 2, 
					'reveal' => false, 
					'css' => 'overlay__bottom h-screen',
					'priority' => $project->indexOf($heroProjects) === 0
				]) ?></div>
			</div>
			<?php endif ?>
		<?php endforeach ?>
	</div>
	<div class="z-10 intro__header grid grid-cols-1 md:grid-cols-4 items-stretch justify-stretch h-screen intro__rows md:h-screen p-1 md:p-1 pt-10 md:pt-1 gap-2 md:gap-0 relative text-invert">
		<div class="h-1"></div>
		<div class="col-span-1 md:col-span-4 grid grid-cols-1 md:grid-cols-4 justify-between items-stretch">
			<div class="col-span-1 md:col-span-4 grid grid-cols-1 md:grid-cols-4 pt-05 relative flex justify-between items-start border-t border-white/20" data-scroll data-scroll-ignore>
				<div data-tabs-autoplay-line class="autoplay__line absolute left-0 right-0"></div>
				<div class="uppercase text-s" data-tab-next>Featured project</div>
				<div class="col-span-2 grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack]" data-pane-container>
					<?php foreach ($page->heroSlider()->toPages() as $project) : ?>
						<?php if ($cover = $project->cover()->toFile()) : ?>
						<div data-pane="project-<?= $project->indexOf($page->heroSlider()->toPages()) ?>" class="grid grid-cols-2" data-tab-reveal>
							<a href="<?= $project->url() ?>"><div data-reveal-text="words" data-split-ignore class="uppercase text-s"><?= $project->title() ?></div></a>
							<div data-reveal-text="words" data-split-ignore class="uppercase text-s flex justify-end"><?= $project->date()->toDate('Y') ?></div>
						</div>	
						<?php endif ?>
					<?php endforeach ?>
				</div>
				<div class="uppercase text-s flex justify-end" data-tab-next>(Next)</div>
			</div>
			<div class="intro__title relative content-end items-stretch col-span-1 md:col-span-3 py-05" style="--in-delay: 0ms">
				<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['heading']]) ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>

