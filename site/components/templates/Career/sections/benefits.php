<?php if ($page->culture()->isNotEmpty()) : ?>
<section class="benefits-icons u1-block" theme="invert">
	<div class="u1-type-2" data-scroll>
		<div class="u1-type-2__header">
			<div class="u1-header">
				<?= snippet('molecules/Header', ['header' => $page->cultureHeader(), 'type' => ['label']]) ?>
				<?php if ($page->cultureHeader()->isNotEmpty() && $page->cultureHeader()->toBlocks()->filterBy('type', 'heading')->isNotEmpty()) : ?>
					<?= snippet('molecules/Header', ['header' => $page->cultureHeader(), 'type' => ['heading']]) ?>
				<?php else : ?>
					<h2 class="u1-h2"><?= t('benefits', 'Benefity') ?></h2>
				<?php endif ?>
			</div>
		</div>

		<div class="u1-type-2__items">
			<?php foreach ($page->culture()->toStructure() as $benefit) : ?>
				<div class="u1-type-2__item">
					<?php if ($img = $benefit->image()->toFile()) : ?>
						<div class="u1-type-2__item-icon">
							<img src="<?= $img->url() ?>" alt="<?= $benefit->label()->inline() ?>">
						</div>
					<?php endif ?>
					<h3 class="u1-type-2__item-title"><?= $benefit->label()->inline() ?></h3>
					<p class="u1-type-2__item-text op__7"><?= $benefit->text()->inline() ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif ?>