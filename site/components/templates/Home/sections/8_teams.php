<?php
$teamsHeader = $teamsHeader ?? (isset($page) && $page->teams()->isNotEmpty() ? $page->teams() : (isset($page) && $page->teamsHeader()->isNotEmpty() ? $page->teamsHeader() : null));
$theme       = $theme ?? 'invert';
?>
<?php if (collection('Team')->isNotEmpty()) : ?>
<section class="team u1-block" theme="<?= $theme ?>">
	<div class="u1-type-1" data-tabs="hoverable">
		<!-- Left: Text (6 cols) -->
		<div class="u1-type-1__col-text">
			<div class="u1-type-1__top" data-scroll>
				<?php if ($teamsHeader) : ?>
					<div class="u1-header">
						<?= snippet('molecules/Header', ['header' => $teamsHeader, 'type' => ['label']]) ?>
						<?= snippet('molecules/Header', ['header' => $teamsHeader, 'type' => ['heading']]) ?>
						<?= snippet('molecules/Header', ['header' => $teamsHeader, 'type' => ['text']]) ?>
					</div>
				<?php else : ?>
					<div class="u1-header">
						<div class="u1-label"><?= t('our-teams', 'Naše týmy') ?></div>
						<h2 class="u1-h2"><?= t('our-teams-headline', 'Lidé za projekty U1') ?></h2>
					</div>
				<?php endif ?>
			</div>

			<div class="u1-type-1__bottom">
				<div class="grid gap__05 place__start-start" data-scroll>
					<?php foreach (collection('Team') as $team) : ?>
						<?php
							$employees = collection('Employees')->filterBy('team', '*=', $team->name())->count();
						?>
						<a href="<?= $pages->find('about')->url() ?>/#<?= $team->name()->slug() ?>" data-tab="team-<?= $team->indexOf(collection('Team')) ?>" class="flex gap__02 no__wrap align__baseline" data-scroll>
							<h3 data-reveal-text data-split-ignore class="font__size__large ff__body"><?= $team->name() ?></h3>
							<div data-reveal-text="" data-split-ignore style="--in-delay: 800ms" class="font__size__small op__7">(<?= $employees ?>)</div>
						</a>
					<?php endforeach ?>
				</div>
			</div>
		</div>

		<!-- Right: Photo 4:3 (6 cols) -->
		<div class="u1-type-1__col-media" data-pane-container>
			<div class="grid__stack no__overflow w__full" data-scroll data-reveal-image>
				<?php foreach (collection('Team') as $team) : ?>
					<?php if ($leader = $team->leader()->toPage()) : ?>
						<div data-pane="team-<?= $team->indexOf(collection('Team')) ?>" class="w__full h__full" data-scroll data-scroll-ignore data-tab-reveal>
							<div class="grid gap__1 w__full h__full">
								<?php if ($img = $team->figure()->toFile()) : ?>
									<div class="u1-photo">
										<?= snippet('atoms/Image', ['img' => $img, 'parallax' => false, 'reveal' => false, 'css' => 'w__full h__full', 'node' => 'data-reveal-image']) ?>
									</div>
								<?php endif ?>
								<?php if ($team->details()->isNotEmpty()) : ?>
									<div class="op__7 font__size__default">
										<?= snippet('atoms/Text', ['text' => $team->details()->inline(), 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>
									</div>
								<?php endif ?>
							</div>
						</div>
					<?php endif ?>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>