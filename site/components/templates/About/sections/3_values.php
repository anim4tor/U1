<?php if (collection('Values')->isNotEmpty()) : ?>
<section class="values" theme="invert">
	<div class="grid grid-cols-1 md:grid-cols-2 gap-2 relative py-1 border-t border-white/20 pb-5" data-tabs="scrollable">
		<div class="sticky top-0 gap-2 grid content-between items-start h-screen py-1" >
			<div class="relative flex px-1">
				<?= snippet('atoms/Text', ['text' => '(Our values)', 'reveal' => true ]) ?>	
			</div>
			<div class="grid content-start justify-start gap-1">
				<div class="grid px-1" data-scroll>
					<?php foreach (collection('Values') as $step) : ?>
						<div data-tab="step-<?= $step->step()?>" class="flex items-start gap-02" >
							<?= snippet('atoms/Heading', [ 'level' => 'h3', 'text' => $step->value(), 'reveal' => true, 'css' => 'text-lg', 'node' => 'data-split-ignore' ]) ?>
							<div data-reveal-text="" class="mt-03 text-base" data-split-ignore style="--in-delay: 800ms">(<?= $step->indexOf(collection('Values')) + 1 ?>)</div>

						</div>
						
					<?php endforeach ?>
				</div>
				<div class="grid content-start justify-start px-1" data-scroll data-scroll-ignore>
					<div data-pane-container class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack]">
						<?php foreach (collection('Values') as $step) : ?>
						<div data-pane="step-<?= $step->step()?>" class="grid grid-cols-2" data-tab-reveal>
							<?= snippet('atoms/Text', ['text' => $step->detail()->inline(), 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>
						</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</div>
		<div class="grid gap-05 pr-1">
			<?php foreach (collection('Values') as $step) : ?>
				<?php if ($img = $step->figure()->toFile()) : ?>
					<div data-pane-trigger="step-<?= $step->step() ?>" id="trigger-<?= $step->step() ?>" class="h-screen grid">
						<?= snippet('atoms/Image', ['img' => $img, 'parallax' => 6, 'reveal' => false, 'css' => 'rounded-radius']) ?>
					</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	</div>
</section>
<?php endif ?>