<section class="team" theme="invert" data-tabs>
	<div class="relative grid gap__2 inner-x__1 inner-y__2">
		<div class="" data-scroll>
			<h1 class="xl flex justify__space-between" data-reveal-text><span>Our</span><span>Teams</span></h1>
		</div>
	</div>
	<div class="grid__3 gap__2 relative place__start-start inner-y__2 inner-b__5" data-tabs>
		<div class="span__2 grid place__start-start gap__2 inner__1" >
			<div class="grid gap__05 place__start-start" >
				<?php foreach (collection('Team') as $team) : ?>
					<?php
						$employees = collection('Employees')->filterBy('team', '*=', $team->name())->count();
					?>
					<div data-tab="team-<?= $team->indexOf(collection('Team')) ?>" class="flex gap__02" data-scroll>
						<h3 class="font__size__1 no__wrap" data-reveal-text data-split-ignore><?= $team->name() ?></h3>
						<span data-reveal-text="lines" class="-wrap-t__03">(<?= $employees ?>)</span>
					</div>
				<?php endforeach ?>
			</div>
			<div class="grid__2" data-scroll data-scroll-ignore>
				<div data-pane-container class="grid__stack">
					<?php foreach (collection('Team') as $team) : ?>
					<div data-pane="team-<?= $team->indexOf(collection('Team')) ?>" class="grid ">
						<p class="s upper" data-reveal-text="lines" data-split-ignore data-tab-reveal><?= $team->details()->inline() ?></p>
					</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
		<div class="grid place__start-end inner-r__1 " data-pane-container>
			<div class="grid__stack no__overflow">
				<?php foreach (collection('Team') as $team) : ?>
					<?php if ($leader = $team->leader()->toPage()) : ?>
					<div data-pane="team-<?= $team->indexOf(collection('Team')) ?>" class="" data-scroll data-scroll-ignore>
						<div class="grid place__start-end gap__05">
							<?php if ($photo = $leader->photo()->toFile()) : ?>
								<div class="item__figure radius no__overflow "><?= snippet('atoms/Image', ['img' => $photo, 'parallax' => 1, 'css' => 'w__10 aspect__3/4 grid' ]) ?></div>
							<?php endif ?>

							<div class="flex gap__05 justify__space-between upper wrap">
								<span class="font__size__default s ff__body" data-split-ignore data-reveal-text="lines" data-tab-reveal><?= $leader->title() ?></span>
								<h3 class="font__size__default s ff__body" data-split-ignore data-reveal-text="lines" data-tab-reveal>(<?= $leader->role() ?>)</h3>
							</div>
						</div>
					</div>
					<?php endif ?>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>