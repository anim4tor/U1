<?php
$theme = 'light';
$steps = collection('Process');
?>
<?php if ($steps->isNotEmpty()) : ?>
<section class="process radius" theme="<?= $theme ?>" data-tabs="hoverable" data-scroll>
	<div class="inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3 grid place__start-stretch gap__2">
		<div class="process__header grid gap__1 span__4" data-scroll>
			<?= snippet('molecules/Header', ['header' => page('home')->process(), 'type' => ['label']]) ?>
			<?= snippet('molecules/Header', ['header' => page('home')->process(), 'type' => ['heading']]) ?>
		</div>

		<div class="process__cards-wrapper span__4 relative z__1 inner-t__1">
			<div class="process__grid" data-scroll>
				<?php foreach ($steps as $step) : ?>
					<div data-tab="step-<?= $step->step() ?>" class="process-card cursor__pointer" <?= $step->step()->toInt() === 1 ? 'data-active' : '' ?>>
						<?php if ($img = $step->figure()->toFile()) : ?>
							<div class="process-card__figure relative no__overflow img__radius" data-reveal-image>
								<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'radius overlay__bottom']) ?>
							</div>
						<?php endif ?>
						<div class="process-card__title">
							<?= snippet('atoms/Heading', ['level' => 'h3', 'text' => $step->label(), 'reveal' => false, 'css' => 'font__size__large', 'node' => 'data-split-ignore']) ?>
							<div class="font__size__small op__5">(0<?= $step->step() ?>)</div>
						</div>
						<div class="process-card__progress">
							<div class="progress__line"></div>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>

		<div class="process__cards-detail grid__stack span__4">
			<?php foreach ($steps as $step) : ?>
				<div class="process-card__detail" data-tab-reveal data-pane="step-<?= $step->step() ?>">
					<p class="font__size__default op__8"><?= $step->detail()->inline() ?></p>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</section>
<?php endif ?>
