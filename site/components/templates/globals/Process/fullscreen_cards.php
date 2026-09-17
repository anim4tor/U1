<?php
	$theme   = (!isset($theme)   || trim($theme)   === '') ? 'light' : $theme;
?>

<?php if (collection('Process')->isNotEmpty()) : ?>
<section class="process relative" <?= $theme ? 'theme="'.$theme.'"' : null ?>>
	<div class="radius absolute inset__stretch" ></div>
	<div class="grid__stack gap__2 relative" data-tabs="scrollable" >
		<div class="sticky top__0 gap__1 grid place__stretch-stretch rows__auto-1 h__100v inner__4 radius" >
			<!-- <div class="grid absolute inset__stretch" theme="dark">
				<div data-pane-container class="grid__stack">
					<?php foreach (collection('Process') as $step) : ?>
						<?php if ($img = $step->figure()->toFile()) : ?>
							<div data-scroll data-scroll-ignore data-tab-reveal data-pane="step-<?= $step->step() ?>" id="trigger-<?= $step->step() ?>" class="vh__20 grid overlay__bottom">
								<div class="grid w__100v h__100v" data-reveal-image>
									<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'radius overlay__bottom']) ?>
								</div>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				</div>
			</div> -->
			<div class="relative z__1 grid gap__2">
				<div class="inner-b__0 flex align__start gap__01 span__4" data-scroll>
					<?= snippet('molecules/Header', ['header' => page('Home')->process(), 'type' => ['label']]) ?>
					<?= snippet('molecules/Header', ['header' => page('Home')->process(), 'type' => ['heading']]) ?>
				</div>
			</div>
			<!-- <div class="relative flex inner-x__1 z__1 color__invert">
				<?= snippet('atoms/Text', ['text' => '(Our process)', 'reveal' => true, 'css' => 'upper' ]) ?>	
			</div> -->
			<div class="grid gap__05 place__stretch-stretch z__1 relative">
				<div class="process__grid place__stretch-stretch" data-scroll >
					<?php foreach (collection('Process') as $step) : ?>
						<!-- <div class="grid place__end-start gap__1 inner__1 relative"> -->
							<div data-tab="step-<?= $step->step()?>" class="relative grid gap__2 inner-y__1 inner-b__2" >
								<?php if ($img = $step->figure()->toFile()) : ?>
									<div class="grid h__18 inset__stretch top__0 bottom__10" data-reveal-image>
										<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'radius overlay__bottom']) ?>
									</div>
								<?php endif ?>
								<div class="grid place__start-start gap__1 h__5">
									<div class="flex no__wrap align__start gap__02  relative z__1">
										<?= snippet('atoms/Heading', [ 'level' => 'h3', 'text' => $step->label(), 'reveal' => true, 'css' => '', 'node' => 'data-split-ignore' ]) ?>
										<div data-reveal-text="" class="font__size__small" data-split-ignore style="--in-delay: 800ms">(<?= $step->step() ?>)</div>
									</div>
									<div class="gap__1 bottom__0 left__0" data-tab-reveal data-pane="step-<?= $step->step() ?>" id="trigger-<?= $step->step() ?>">
										<p class="w__20" data-reveal-text="lines" data-split-ignore ><?= $step->detail()->inline() ?></p>
									</div>
								</div>
							</div>
						<!-- </div> -->

					<?php endforeach ?>
					<div class="border__top absolute bottom__8 left__0 right__0 grid">
						<div data-tabs-progress-line class="progress__line"></div>
					</div>
				</div>
			</div>

		</div>
		
		<div class="grid">
			<?php foreach (collection('Process') as $step) : ?>
				<?php if ($img = $step->figure()->toFile()) : ?>
					<div data-pane-trigger="step-<?= $step->step() ?>" id="trigger-<?= $step->step() ?>" class="vh__15 grid">
					</div>
				<?php endif ?>
			<?php endforeach ?>
			<div class="vh__15 grid"></div>
		</div>
	</div>
</section>
<?php endif ?>