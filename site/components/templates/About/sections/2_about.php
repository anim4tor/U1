<?php if ($page->about()->isNotEmpty()) : ?>
<section class="about u1-block" theme="invert">
	<div class="u1-type-2">
		<!-- Left: Label & H2 (6 cols) -->
		<div class="u1-type-2__header">
			<div class="u1-header">
				<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['label']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['heading']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['text']]) ?>
			</div>
		</div>

		<!-- Right: Výrok & čísla (6 cols) -->
		<div class="u1-type-2__items">
			<div class="span__2">
				<?= snippet('templates/globals/Figures') ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>