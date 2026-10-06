<?php if (collection('Values')->isNotEmpty()) : ?>
<section class="process values u1-type-4" theme="dark">
	<!-- Background Fullscreen Media with enhanced dark gradient overlay -->
	<div class="u1-type-4__bg">
		<div data-pane-container class="grid__stack w__full h__full">
			<?php foreach (collection('Values') as $value) : ?>
				<?php if ($img = $value->figure()->toFile()) : ?>
					<div data-scroll data-scroll-ignore data-tab-reveal data-pane="step-<?= $value->indexOf(collection('Values')) ?>" id="trigger-<?= $value->indexOf(collection('Values')) ?>" class="w__full h__full">
						<div class="w__full h__full" data-reveal-image>
							<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'w__full h__full']) ?>
						</div>
					</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	</div>

	<!-- Top: Label -->
	<div class="u1-type-4__top" data-scroll>
		<div class="u1-label"><?= t('our-values', 'NAŠE HODNOTY') ?></div>
	</div>

	<!-- Bottom: Tabs 36px & Details 16px -->
	<div class="u1-type-4__bottom" data-scroll>
		<div class="span__12 grid gap__1">
			<!-- Tabs with 36px Arizona titles -->
			<div class="grid__<?= collection('Values')->count() ?> mobile:grid__1 gap__1" data-scroll>
				<?php foreach (collection('Values') as $value) : ?>
					<div data-tab="step-<?= $value->indexOf(collection('Values')) ?>" class="flex align__start gap__02 cursor__pointer">
						<h3 class="font__size__3 ff__heading" data-reveal-text data-split-ignore><?= $value->value() ?></h3>
						<span class="font__size__small op__7" data-reveal-text data-split-ignore style="--in-delay: 800ms">(<?= $value->indexOf(collection('Values')) + 1 ?>)</span>
					</div>
				<?php endforeach ?>
			</div>

			<div class="border__top grid">
				<div data-tabs-progress-line class="progress__line"></div>
			</div>

			<!-- Details in 16px Inter -->
			<div data-pane-container class="grid__<?= collection('Values')->count() ?> mobile:grid__1 gap__1" data-scroll>
				<?php foreach (collection('Values') as $value) : ?>
					<div data-tab-reveal data-pane="step-<?= $value->indexOf(collection('Values')) ?>" id="pane-text-<?= $value->indexOf(collection('Values')) ?>">
						<p class="font__size__default ff__body op__8" data-reveal-text="lines" data-split-ignore><?= $value->detail()->inline() ?></p>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>