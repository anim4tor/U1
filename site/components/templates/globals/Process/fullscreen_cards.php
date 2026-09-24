<?php
	$theme   = (!isset($theme)   || trim($theme)   === '') ? 'light' : $theme;
?>

<?php if (collection('Process')->isNotEmpty()) : ?>
<section class="process relative" <?= $theme ? 'theme="'.$theme.'"' : null ?>>
	<div class="radius absolute inset__stretch" ></div>
	<div class="grid__stack gap__2 relative" data-tabs="scrollable" >
		<div class="process__fullscreen-sticky sticky top__0 inner__4 radius gap__2" >
			<div class="process__header relative z__1 grid gap__2">
				<div class="inner-b__0 flex align__start gap__01 span__4" data-scroll>
					<?= snippet('molecules/Header', ['header' => page('Home')->process(), 'type' => ['label']]) ?>
					<?= snippet('molecules/Header', ['header' => page('Home')->process(), 'type' => ['heading']]) ?>
				</div>
			</div>
			<div class="process__cards-wrapper relative z__1">
				<div class="process__grid" data-scroll >
					<?php foreach (collection('Process') as $step) : ?>
						<div data-tab="step-<?= $step->step()?>" class="process-card relative" >
							<?php if ($img = $step->figure()->toFile()) : ?>
								<div class="process-card__figure relative no__overflow img__radius" data-reveal-image>
									<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'radius overlay__bottom']) ?>
								</div>
							<?php endif ?>
							<div class="process-card__title flex no__wrap align__center gap__02 relative z__1 inner-y__05">
								<?= snippet('atoms/Heading', [ 'level' => 'h3', 'text' => $step->label(), 'reveal' => true, 'css' => '', 'node' => 'data-split-ignore' ]) ?>
								<div data-reveal-text="" class="font__size__small" data-split-ignore style="--in-delay: 800ms">(<?= $step->step() ?>)</div>
							</div>
							<div class="process-card__detail" data-tab-reveal data-pane="step-<?= $step->step() ?>" id="trigger-<?= $step->step() ?>">
								<div class="op__7">
									<p data-reveal-text="lines" data-split-ignore ><?= $step->detail()->inline() ?></p>
								</div>
							</div>
						</div>
					<?php endforeach ?>
				</div>
				<div class="process__progress-line border__top absolute left__0 right__0">
					<div data-tabs-progress-line class="progress__line"></div>
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