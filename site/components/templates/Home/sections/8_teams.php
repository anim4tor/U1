<?php if (collection('Team')->isNotEmpty()) : ?>
<section class="team" theme="invert" >
	<div class="relative grid gap-2 px-1 py-1">
		<div class="" data-scroll>
			<?= snippet('molecules/Header', ['header' => $page->teams(), 'type' => ['heading']]) ?>
		</div>
	</div>
	<div class="grid grid-cols-1 md:grid-cols-3 gap-2 relative content-start justify-start pb-2 px-1" data-tabs="hoverable">
		<div class="col-span-1 md:col-span-2 grid content-start justify-start gap-1 py-1" >
			<div class="grid gap-02 content-start justify-start" >
				<?php foreach (collection('Team') as $team) : ?>
					<?php
						$employees = collection('Employees')->filterBy('team', '*=', $team->name())->count();
					?>
					<a href="<?= $pages->find('about')->url() ?>/#<?= $team->name()->slug() ?>" data-tab="team-<?= $team->indexOf(collection('Team')) ?>" class="flex gap-02 flex-nowrap" data-scroll>
						<h3 class="" data-reveal-text data-split-ignore><?= $team->name() ?></h3>
						<div data-reveal-text="" data-split-ignore style="--in-delay: 800ms" class="-mt-01">(<?= $employees ?>)</div>
					</a>
				<?php endforeach ?>
			</div>
		</div>
		<div class="grid content-start justify-end" data-pane-container>
			<div class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] overflow-hidden rounded-img" data-scroll data-reveal-image >
				<?php foreach (collection('Team') as $team) : ?>
					<?php if ($leader = $team->leader()->toPage()) : ?>
					<div data-pane="team-<?= $team->indexOf(collection('Team')) ?>" class="" data-scroll data-scroll-ignore data-tab-reveal>
						<div class="grid content-start justify-end gap-05">
							<div class="grid gap-05">
								<?php if ($img = $team->figure()->toFile()) : ?>
									<?= snippet('atoms/Image', ['img' => $img, 'parallax' => false, 'reveal' => false, 'css' => 'aspect-[6/4]', 'node' => 'data-reveal-image']) ?>
								<?php endif ?>
								<?= snippet('atoms/Text', ['text' => $team->details()->inline(), 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>
							</div>
						</div>
					</div>
					<?php endif ?>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>