<?php
	$theme   = (!isset($theme)   || trim($theme)   === '') ? 'light' : $theme;
	$color   = (!isset($color)   || trim($color)   === '') ? match($theme) {
		'dark'        => 'color__light',
		'transparent' => 'color__invert',
		'invert'      => 'color__text',
		'acc'         => 'color__text',
		default       => 'color__text'
	} : $color;
?>

<?php if (collection('Process')->isNotEmpty()) : ?>
<section class="process relative" <?= $theme ? 'theme="'.$theme.'"' : null ?>>
	<div class="radius absolute inset__stretch" <?= $theme ? 'theme="'.$theme.'"' : null ?>></div>
	<div class="grid__stack gap__3 relative" data-tabs="scrollable" >
		<div class="process__fullscreen-sticky sticky top__0 inner-x__4 mobile:inner-x__1 radius gap__3" >
			<div class="process__header relative z__1 grid place__start-start gap__2">
				<div class="inner-b__0 grid gap__1 <?= $color ?>" data-scroll>
					<?= snippet('molecules/Header', ['header' => page('home')->process(), 'type' => ['heading']]) ?>
				</div>
			</div>
			<div class="grid gap__1">
				<div class="process__cards-wrapper relative z__1">
					<div class="process__grid gap__2" data-scroll >
						<?php foreach (collection('Process') as $step) : ?>
							<div data-tab="step-<?= $step->step()?>" class="grid gap__1 relative <?= $color ?>" >
								<?php if ($img = $step->figure()->toFile()) : ?>
									<div class="process-card__figure relative no__overflow img__radius" data-reveal-image>
										<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'radius overlay__bottom']) ?>
									</div>
								<?php endif ?>
								<div class="process-card__progress relative">
									<div class="progress__line"></div>
								</div>
								<div class=" flex gap__02 no__wrap align__center relative z__1">
									<?= snippet('atoms/Heading', [ 'level' => 'h3', 'text' => $step->label(), 'reveal' => true, 'css' => '', 'node' => 'data-split-ignore' ]) ?>
									<div class="-wrap-t__02">
										<?= snippet('atoms/Label', ['text' => $step->step()]) ?>
									</div>
								</div>
							</div>
						<?php endforeach ?>
					</div>
				</div>
				<div class="process__cards-detail grid__stack">
					<?php foreach (collection('Process') as $step) : ?>
						<div class="process-card__detail" data-tab-reveal data-pane="step-<?= $step->step() ?>">
							<div class="op__7">
								<p data-reveal-text="lines" data-split-ignore ><?= $step->detail()->inline() ?></p>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
		
		<div class="grid">
			<?php foreach (collection('Process') as $step) : ?>
				<?php if ($img = $step->figure()->toFile()) : ?>
					<div data-pane-trigger="step-<?= $step->step() ?>" id="trigger-<?= $step->step() ?>" class="vh__10 grid">
					</div>
				<?php endif ?>
			<?php endforeach ?>
			<div class="vh__10 grid"></div>
		</div>
		
	</div>

	<style>
		.process__grid [data-tab]:not([data-active]) .process-card__figure img {
			filter: grayscale(1);
			opacity: 0.75;
		}
		.process__grid [data-tab]:not([data-active]):hover .process-card__figure img {
			filter: grayscale(0.2);
			opacity: 0.95;
		}
		.process__grid [data-tab][data-active] .process-card__figure img {
			filter: grayscale(0);
			opacity: 1;
		}
	</style>
</section>
<?php endif ?>
