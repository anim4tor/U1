<?php if ($page->projects()->isNotEmpty()) : ?>
<?php $projList = $page->projects()->toPages(); ?>
<section class="career-projects u1-block" theme="invert">
	<div class="u1-type-1" data-tabs="default">
		<div class="hidden absolute">
			<?php foreach ($projList as $project) : ?>
				<div data-tab="project-<?= $project->indexOf($projList) ?>"></div>
			<?php endforeach ?>
		</div>

		<!-- Left: Text (6 cols) -->
		<div class="u1-type-1__col-text">
			<div class="u1-type-1__top" data-scroll>
				<div class="u1-header">
					<div class="u1-label"><?= t('projects', 'POJĎ DĚLAT NA PROJEKTECH') ?></div>
					<div data-pane-container class="grid__stack">
						<?php foreach ($projList as $project) : ?>
							<div data-scroll data-scroll-ignore data-tab-reveal data-pane="project-<?= $project->indexOf($projList) ?>">
								<h2 class="u1-h2"><?= $project->title()->inline() ?></h2>
								<?php if ($project->intro()->isNotEmpty()) : ?>
									<p class="u1-perex"><?= $project->intro()->inline() ?></p>
								<?php endif ?>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>

			<div class="u1-type-1__bottom" data-scroll>
				<div class="flex gap__02 justify__start align__center">
					<button data-tab-prev class="button upper" theme="ghost" hover="dark" aria-label="Předchozí projekt">
						<span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span>
					</button>
					<button data-tab-next class="button upper" theme="ghost" hover="dark" aria-label="Další projekt">
						<span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span>
					</button>
				</div>
			</div>
		</div>

		<!-- Right: Photo 4:3 (6 cols) -->
		<div class="u1-type-1__col-media" data-pane-container data-scroll>
			<div class="grid__stack no__overflow w__full">
				<?php foreach ($projList as $project) : ?>
					<?php if ($img = $project->cover()->toFile()) : ?>
						<div data-scroll data-scroll-ignore data-tab-reveal data-pane="project-<?= $project->indexOf($projList) ?>" class="w__full h__full">
							<div class="u1-photo" data-reveal-image>
								<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'w__full h__full']) ?>
							</div>
						</div>
					<?php endif ?>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>