<?php if ($page->coleagues()->isNotEmpty()) : ?>
<section class="colleagues u1-block" theme="light">
	<div class="u1-type-3" data-scroll>
		<div class="u1-header">
			<?= snippet('molecules/Header', ['header' => $page->coleaguesHeader(), 'type' => ['label']]) ?>
			<?= snippet('molecules/Header', ['header' => $page->coleaguesHeader(), 'type' => ['heading']]) ?>
		</div>

		<div class="u1-type-3__cards u1-type-3__cards--3col">
			<?php foreach ($page->coleagues()->toStructure() as $colleague) : ?>
				<div class="u1-card" data-scroll>
					<div class="u1-card__figure">
						<?php if ($img = $colleague->image()->toFile()) : ?>
							<?= snippet('atoms/Image', ['img' => $img, 'reveal' => true, 'css' => 'w__full h__full']) ?>
						<?php endif ?>
					</div>
					<?php if ($colleague->title()->isNotEmpty()) : ?>
						<h3 class="u1-card__number color__acc"><?= $colleague->title()->inline() ?></h3>
					<?php endif ?>
					<?php if ($colleague->name()->isNotEmpty()) : ?>
						<h4 class="u1-card__title"><?= $colleague->name()->inline() ?></h4>
					<?php endif ?>
					<p class="u1-card__text op__7"><?= $colleague->text()->inline() ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif ?>