<?php
	$theme   = (!isset($theme)   || trim($theme)   === '') ? 'invert' : $theme;
?>

<?php if (collection('Process')->isNotEmpty()) : ?>
<section class="process" <?= $theme ? 'theme="'.$theme.'"' : null ?>>
	<div class="relative grid gap-2 px-1 py-2">
		<div class="" data-scroll>
			<h2 class="text-xl flex justify-between" data-reveal-text><span>The</span><span>Process</span></h2>
		</div>
	</div>
	<div class="grid grid-cols-1 md:grid-cols-2 gap-2 relative py-1 pb-5" data-tabs="scrollable">
		<div class="sticky top-0 gap-2 grid content-between justify-start h-screen py-2" >
			<div class="relative flex px-1 ">
				<?= snippet('atoms/Text', ['text' => '(Our process)', 'reveal' => true ]) ?>	
			</div>
			<div class="grid content-start justify-start gap-1">
				<div class="grid px-1" data-scroll >
					<?php foreach (collection('Process') as $step) : ?>
						<div data-tab="step-<?= $step->step()?>" class="flex items-start gap-02" >
							<?= snippet('atoms/Heading', [ 'level' => 'h3', 'text' => $step->label(), 'reveal' => true, 'css' => 'text-l', 'node' => 'data-split-ignore' ]) ?>
							<div data-reveal-text="" class="mt-03 text-m" data-split-ignore style="--in-delay: 800ms">(<?= $step->step() ?>)</div>
						</div>
					<?php endforeach ?>
				</div>
				<div class="grid content-start justify-start px-1 " data-scroll data-scroll-ignore>
					<div data-pane-container class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack]">
						<?php foreach (collection('Process') as $step) : ?>
						<div data-pane="step-<?= $step->step()?>" class="grid grid-cols-1 md:grid-cols-2" data-tab-reveal>
							<p class="" data-reveal-text="lines" data-split-ignore ><?= $step->detail()->inline() ?></p>
						</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
			<!-- <div></div> -->
		</div>
		<div class="grid gap-05 pr-1" data-scroll data-reveal-image>
			<?php foreach (collection('Process') as $step) : ?>
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