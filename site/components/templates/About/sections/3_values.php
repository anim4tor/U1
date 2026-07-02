<?php if (collection('Values')->isNotEmpty()) : ?>
<section class="values" theme="invert">
	<div class="grid__2 gap__2 relative inner-y__1 border__top inner-b__5" data-tabs="">
		<div class="sticky top__0 gap__2 grid place__space-between-start h__100v inner-y__1" >
			<div class="relative flex inner-x__1 ">
				<?= snippet('atoms/Text', ['text' => '(Our values)', 'reveal' => true ]) ?>	
			</div>
			<div class="grid place__start-start gap__1">
				<div class="grid inner-x__1" >
					<?php foreach (collection('Values') as $step) : ?>
						<div data-tab="step-<?= $step->step()?>" class="flex align__start gap__02" data-scroll data-tab-reveal>
							<?= snippet('atoms/Heading', [ 'level' => 'h3', 'text' => $step->value(), 'reveal' => true, 'css' => 'm', 'node' => 'data-split-ignore' ]) ?>
						</div>
					<?php endforeach ?>
				</div>
				<div class="grid place__start-start inner-x__1 " data-scroll data-scroll-ignore>
					<div data-pane-container class="grid__stack">
						<?php foreach (collection('Values') as $step) : ?>
						<div data-pane="step-<?= $step->step()?>" class="grid__2" data-tab-reveal>
							<?= snippet('atoms/Text', ['text' => $step->detail()->inline(), 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>
						</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</div>
		<div class="grid inner-r__1">
			<?php foreach (collection('Values') as $step) : ?>
				<?php if ($img = $step->figure()->toFile()) : ?>
					<div data-pane-trigger="step-<?= $step->step() ?>" id="trigger-<?= $step->step() ?>" class="h__100v grid">
						<?= snippet('atoms/Image', ['img' => $img, 'parallax' => 5, 'reveal' => false, 'css' => 'radius']) ?>
					</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	</div>
</section>
<?php endif ?>