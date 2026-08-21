<?php
	$theme   = (!isset($theme)   || trim($theme)   === '') ? 'invert' : $theme;
?>

<?php if (collection('Process')->isNotEmpty()) : ?>
<section class="process relative text-white">
	<div class="rounded-radius absolute inset-0" theme="dark"></div>
	<div class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] gap-2 relative" data-tabs="scrollable">
		<div class="sticky top-0 gap-5 grid items-stretch h-screen py-2 rounded-radius" >
			<!-- <div class="grid absolute inset-0" theme="dark">
				<div data-pane-container class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack]">
					<?php foreach (collection('Process') as $step) : ?>
						<?php if ($img = $step->figure()->toFile()) : ?>
							<div data-scroll data-scroll-ignore data-tab-reveal data-pane="step-<?= $step->step() ?>" id="trigger-<?= $step->step() ?>" class="vh__20 grid overlay__bottom">
								<div class="grid w-screen h-screen" data-reveal-image>
									<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'rounded-radius overlay__bottom']) ?>
								</div>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				</div>
			</div> -->
			<div class="relative z-10 grid gap-2 px-1 text-white">
				<div class="" data-scroll>
					<h2 class="text-l flex justify-between" data-reveal-text><span>The</span><span>Process</span></h2>
				</div>
			</div>
			<!-- <div class="relative flex px-1 z-10 text-white">
				<?= snippet('atoms/Text', ['text' => '(Our process)', 'reveal' => true, 'css' => 'uppercase' ]) ?>	
			</div> -->
			<div class="grid gap-05 items-stretch z-10 relative text-white">
				<div class="process__grid items-stretch" data-scroll >
					<?php foreach (collection('Process') as $step) : ?>
						<!-- <div class="grid place__end-start gap__1 inner__1 relative"> -->
							<div data-tab="step-<?= $step->step()?>" class="relative grid content-between items-stretch p-1 gap-1 h-[70vh]" >
								<div class="flex flex-nowrap items-start gap-02 relative z-10">
									<?= snippet('atoms/Heading', [ 'level' => 'h3', 'text' => $step->label(), 'reveal' => true, 'node' => 'data-split-ignore' ]) ?>
									<div data-reveal-text="" class="text-m" data-split-ignore style="--in-delay: 800ms">(<?= $step->step() ?>)</div>
								</div>
								<div class="gap-1 absolute bottom-1 left-1" data-tab-reveal data-pane="step-<?= $step->step() ?>" id="trigger-<?= $step->step() ?>">
									<p class="max-w-[25rem]" data-reveal-text="lines" data-split-ignore ><?= $step->detail()->inline() ?></p>
								</div>
								<?php if ($img = $step->figure()->toFile()) : ?>
									<div class="grid absolute inset-0" data-reveal-image>
										<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'rounded-radius overlay__bottom']) ?>
									</div>
								<?php endif ?>
							</div>
						<!-- </div> -->

					<?php endforeach ?>
				</div>
				<div class="border-t absolute bottom-0 left-0 right-0 grid">
					<div data-tabs-progress-line class="progress__line"></div>
				</div>
			</div>

		</div>
		
		<div class="grid">
			<?php foreach (collection('Process') as $step) : ?>
				<?php if ($img = $step->figure()->toFile()) : ?>
					<div data-pane-trigger="step-<?= $step->step() ?>" id="trigger-<?= $step->step() ?>" class="h-[75vh] grid">
					</div>
				<?php endif ?>
			<?php endforeach ?>
			<div class="h-[75vh] grid"></div>
		</div>
	</div>
</section>
<?php endif ?>