<section class="process" theme="invert">
	<div class="bg rounded-radius absolute inset-0" theme="invert"></div>
	<div class="grid grid-cols-1 md:grid-cols-4 md:h-auto p-1 py-2 md:pt-10 md:gap-2 relative" data-scroll>
		<!-- <?php if ($cover = $page->cover()->toFile()) : ?>
			<div class="intro__cover absolute inset-0 grid overlay__bottom"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2]) ?></div>
		<?php endif ?> -->
		<div class="intro__title relative col-span-1 md:col-span-3" data-scroll data-scroll-speed="-0.5">
			<h2 class="text-l" data-reveal-text>The Process</h2>
		</div>
		<div class="relative flex justify-end items-start"><strong class="text-s uppercase" data-reveal-text="lines">(The Process)</strong></div>
	</div>
	<div class="grid grid-cols-1 md:grid-cols-2 gap-2 relative content-start justify-start py-2 pb-5" data-tabs>
		<div class="sticky top-0 grid h-screen py-1" >
			<div class="grid content-start justify-start px-1" >
				<?php foreach (collection('Process') as $step) : ?>
					<div data-tab="step-<?= $step->step()?>" class="flex items-start gap-02 py-02" data-scroll >
						<h3 class="" data-reveal-text data-split-ignore><?= $step->label() ?></h3>
						<span data-reveal-text="lines" class="-mt-03">(<?= $step->step() ?>)</span>
					</div>
				<?php endforeach ?>
			</div>
			<div class="grid content-end justify-end px-1 " data-scroll data-scroll-ignore>
				<div data-pane-container class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] content-end justify-end">
					<?php foreach (collection('Process') as $step) : ?>
					<div data-pane="step-<?= $step->step()?>" class="grid grid-cols-1 md:grid-cols-2">
						<div></div>
						<p class="uppercase text-s" data-reveal-text="lines" data-split-ignore data-tab-reveal><?= $step->detail()->inline() ?></p>
					</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
		<div class="grid pr-1">
			<?php foreach (collection('Process') as $step) : ?>
				<?php if ($img = $step->figure()->toFile()) : ?>
					<div data-pane-trigger=step-<?= $step->step()?> id="trigger-<?= $step->step() ?>" class=""><?= snippet('atoms/Image', ['img' => $img, 'parallax' => 10, 'reveal' => false, 'css' => 'h-screen rounded-radius']) ?></div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	</div>
</section>