<?php if ($page->projects()->isNotEmpty()) : ?>
<section class="about radius" theme="invert">
	<div class="grid__3 gap__2 place__stretch-stretch inner__4" data-tabs="default">
		<div class="hidden absolute">
			<?php foreach ($page->projects()->toPages() as $project) : ?>
				<div data-tab="project-<?= $project->indexOf($page->projects()->toPages()) ?>"></div>
			<?php endforeach ?>
		</div>
		<div data-scroll>
			<div class="grid place__start-stretch" data-reveal-text>
				<div data-scroll class="flex align__start gap__01 span__2">
					<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['label']]) ?>
					<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['heading']]) ?>
				</div>
			</div>
		</div>
		<div data-pane-container class="grid__stack" data-scroll>
			<?php foreach ($page->projects()->toPages() as $project) : ?>
				<?php if ($img = $project->cover()->toFile()) : ?>
					<div data-scroll data-scroll-ignore data-tab-reveal data-pane="project-<?= $project->indexOf($page->projects()->toPages()) ?>" id="project-<?= $project->indexOf($page->projects()->toPages()) ?>" class="grid">
						<div class="grid" data-reveal-image>
							<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => '']) ?>
						</div>
					</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
		<div class="relative grid gap__5 place__end-start" data-scroll >

			<div class="grid gap__1 place__start-start">
				<div data-pane-container class="grid__stack place__end-start" data-scroll>
					<?php foreach ($page->projects()->toPages() as $project) : ?>
					<div data-scroll data-scroll-ignore data-tab-reveal data-pane="project-<?= $project->indexOf($page->projects()->toPages()) ?>" id="project-<?= $project->indexOf($page->projects()->toPages()) ?>" class="grid gap__1 place__start-start">
						<h3><?= $project->title()->inline() ?></h3>
						<p><?= $project->intro()->inline() ?></p>
					</div>
					<?php endforeach ?>
				</div>
				<div class="flex gap__02 justify__start align__end">
					<button data-tab-prev class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
					<button data-tab-next class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
				</div>
			</div>
		</div>
		<!--  -->

	</div>
</section>
<?php endif ?>