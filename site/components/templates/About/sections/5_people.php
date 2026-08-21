<?php if (collection('Employees')->isNotEmpty()) : ?>
<section class="people " theme="invert" >
	<div class="relative grid gap-5 px-1 ">
		<div class="border-t border-white/20 py-1" data-scroll>
			<h2 class="text-4xl flex justify-between" data-reveal-text>
				<span class="">The</span>
				<span class="">People</span>
			</h2>
		</div>
		<div class="grid grid-cols-1 md:grid-cols-3 pb-5" data-tabs="hoverable">
			<div class="grid gap-02 content-start items-stretch col-span-1 md:col-span-2">
				
			<?php foreach (collection('Team') as $team) : ?>
				<div id="<?= $team->name()->slug() ?>" class="grid grid-cols-1 md:grid-cols-2 gap-2 relative" >
					
					<div class="grid content-start justify-start " >
						<div class="grid content-start justify-start gap-1 " data-scroll>
							<?= snippet('atoms/Text', ['text' => '(' . $team->name()  . ')', 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>							
						</div>
					</div>
					<div class="grid gap-02 content-start justify-start" >
						<?php foreach (collection('Employees')->filterBy('team', $team->name()) as $employee) : ?>
							<div data-tab="people-<?= $employee->indexOf(collection('Employees')) ?>" class="flex gap-02" data-scroll>
								<h3 class="flex-nowrap whitespace-nowrap" data-reveal-text data-split-ignore><?= $employee->title() ?></h3>
							</div>
						<?php endforeach ?>
					</div>
					
				</div>
			<?php endforeach ?>
			</div>
			<div class="grid content-start justify-end" data-pane-container>
				<div class="sticky top-8 grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] overflow-hidden rounded-img">
					<?php foreach (collection('Employees') as $employee) : ?>
						<div data-pane="people-<?= $employee->indexOf(collection('Employees')) ?>" class="" data-scroll data-scroll-ignore data-tab-reveal>
							<div class="grid content-start justify-end gap-05">
								<?php if ($photo = $employee->photo()->toFile()) : ?>
									<?= snippet('atoms/Image', ['img' => $photo, 'parallax' => false, 'reveal' => false, 'css' => 'w-[10em] aspect-[3/4]', 'node' => 'data-reveal-image']) ?>
								<?php endif ?>
								<div class="flex gap-05 justify-between uppercase flex-wrap">
									<?= snippet('atoms/Text', ['text' => '(' . $employee->role() . ')', 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>
								</div>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif ?>
