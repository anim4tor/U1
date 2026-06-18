<?php if ($page->intro()->isNotEmpty()) : ?>
<section class="about" theme="invert">
	<div class="grid__3 gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2">
		<div class="span__2 grid place__start-start gap__3 mobile:inner-x__0">
			<?= snippet('molecules/Header', ['header' => $page->intro(), 'type' => ['heading']]) ?>
		</div>
		<div></div>
		<div></div>
		<?php if ($fig = $page->introFigure()->toFile()) : ?>
			<div class="grid" >
				<?= snippet('atoms/Image', ['img' => $fig, 'parallax' => 5, 'css' => 'h__20 mobile:h__20 radius']) ?>
			</div>
		<?php endif ?>
		<div class="grid place__start-end"><?= snippet('molecules/Header', ['header' => $page->intro(), 'type' => ['label']]) ?></div>
		<div></div>
		<div class="grid place__center-start gap__3 s upper">
			<?= snippet('molecules/Header', ['header' => $page->intro(), 'type' => ['text']]) ?>
		</div>
		<div></div>
		<div class="span__3 flex justify__space-between">
			<?php foreach ($page->introFeatures()->toStructure() as $feature) : ?>
				<div class="flex inner-y__2" data-scroll>
					<div class="font__size__1 ff__heading xxl outlined" data-reveal-text><?= $feature->feature() ?></div>
					<div class="s" data-reveal-text="lines"><?= $feature->label() ?></div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</section>
<?php endif ?>