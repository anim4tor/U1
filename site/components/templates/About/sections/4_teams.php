<?php if (collection('Team')->isNotEmpty()) : ?>
<section class="teams rounded-radius" theme="invert" >
	<div class="relative grid gap-0 px-1">
		<div class="flex justify-between border-t border-white/20 py-1" data-scroll>
			<?= snippet('atoms/Text', ['text' => '(Our teams)', 'reveal' => true ]) ?>	
			<div></div>
		</div>
		<div class="grid grid-cols-1 md:grid-cols-4 gap-2 relative content-start justify-start py-2 pb-5" data-tabs="hoverable">
			<div class="grid content-start justify-start" data-pane-container>
				<div class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] overflow-hidden rounded-img">
					<?php foreach (collection('Team') as $team) : ?>
						<?php if ($leader = $team->leader()->toPage()) : ?>
						<div data-pane="team-<?= $team->indexOf(collection('Team')) ?>" class="" data-scroll data-scroll-ignore data-tab-reveal>
							<div class="grid gap-05">
								<?php if ($img = $team->figure()->toFile()) : ?>
									<?= snippet('atoms/Image', ['img' => $img, 'parallax' => false, 'reveal' => false, 'css' => 'aspect-[4/3]', 'node' => 'data-reveal-image']) ?>
								<?php endif ?>
								<?= snippet('atoms/Text', ['text' => $team->details()->inline(), 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>
							</div>
						</div>
						<?php endif ?>
					<?php endforeach ?>
				</div>
			</div>
			<div></div>
			<div class="col-span-1 md:col-span-2 grid content-start justify-start gap-2" >
				<div class="grid gap-02 content-start justify-start" >
					<?php foreach (collection('Team') as $team) : ?>
						<?php
							$employees = collection('Employees')->filterBy('team', '*=', $team->name())->count();
						?>
						<div data-tab="team-<?= $team->indexOf(collection('Team')) ?>" class="flex gap-02" data-scroll>
							<?= snippet('atoms/Heading', [ 'level' => 'h3', 'text' => $team->name(), 'reveal' => true, 'node' => 'data-split-ignore' ]) ?>
						</div>
					<?php endforeach ?>
				</div>
				
			</div>
		</div>
	</div>	
</section>
<?php endif ?>
