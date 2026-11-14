<?php if (collection('Team')->isNotEmpty()) : ?>
<section class="team radius" theme="light" data-tabs="hoverable" data-tabs-reset>
	<div class="grid__4 gap__2 mobile:grid__1 inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3">
		<div class="grid span__2 gap__4 place__space-between-stretch mobile:inner-x__0">
			<div class="grid gap__1">
				<?= snippet('molecules/Header', ['header' => $page->teams(), 'type' => ['label']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->teams(), 'type' => ['heading']]) ?>
				<div class="grid__stack place__start-start " data-pane-container data-scroll data-reveal-image >
					<div class="team-intro" data-team-intro>
						<?= snippet('molecules/Header', ['header' => $page->teams(), 'type' => ['text']]) ?>
					</div>
					<?php foreach (collection('Team') as $team) : ?>
						<div data-pane="team-<?= $team->indexOf(collection('Team')) ?>" class="" data-scroll data-scroll-ignore data-tab-reveal>
							<div class="op__7">
								<?= snippet('atoms/Text', ['text' => $team->details()->inline(), 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>
							</div>
						</div>
					<?php endforeach ?>
				</div>
				<?= snippet('molecules/Header', ['header' => $page->teams(), 'type' => ['button']]) ?>
			</div>
			<div class="grid">
				<ol class="grid place__start-stretch gap-y__0 gap-x__1" data-scroll >
					<?php foreach (collection('Team') as $team) : ?>
						<?php $employees = collection('Employees')->filterBy('team', '*=', $team->name())->count(); ?>
						<a href="<?= $pages->find('about')->url() ?>/#<?= $team->name()->slug() ?>" class="flex justify__space-between align__center border__top inner-y__05 gap__02" data-tab="team-<?= $team->indexOf(collection('Team')) ?>">
							<h3 data-reveal-text data-split-ignore class=""><?= $team->name() ?></h3>
							<?= snippet('atoms/Icon', ['name' => 'arrow-right', 'css' => 'team__arrow']) ?>
						</a>
					<?php endforeach ?>
				</ol>
			</div>
		</div>
		<div class="span__2 team__media">
			<div class="grid__stack place__stretch-stretch no__overflow img__radius" data-pane-container data-scroll data-reveal-image >
				<?php foreach (collection('Team') as $team) : ?>
					<div data-pane="team-<?= $team->indexOf(collection('Team')) ?>" class="grid place__stretch-stretch" data-scroll data-scroll-ignore data-tab-reveal>
						<?php if ($img = $team->figure()->toFile()) : ?>
							<div class="grid place__stretch-stretch" data-reveal-image><?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'img__radius']) ?></div>
						<?php endif ?>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>