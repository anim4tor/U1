<?php if ($page->intro()->isNotEmpty()) : ?>
<section class="about" theme="invert">
	<div class="grid__3 gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2">
		<div class="span__2 grid place__start-start gap__3 mobile:inner-x__0 s">
			<?= snippet('molecules/Header', ['header' => $page->intro(), 'type' => ['heading']]) ?>
		</div>
		<div></div>
		<div></div>
		<?php if ($fig = $page->introFigure()->toFile()) : ?>
			<div class="grid" >
				<?= snippet('atoms/Image', ['img' => $fig, 'parallax' => 5, 'css' => 'h__20 mobile:h__20 img__radius']) ?>
			</div>
		<?php endif ?>
		<div class="grid place__start-end"><?= snippet('molecules/Header', ['header' => $page->intro(), 'type' => ['label']]) ?></div>
		<div></div>
		<div class="grid place__center-start gap__3">
			<?= snippet('molecules/Header', ['header' => $page->intro(), 'type' => ['text']]) ?>
		</div>
		<div></div>
		<div class="span__3 flex justify__space-between">
			<?php foreach ($page->introFeatures()->toStructure() as $feature) : ?>
				<div class="flex inner-y__2" data-scroll>
					<h2 class="font__size__1 l outlined" data-reveal-text><?= $feature->feature() ?></h2>
					<div class="s label" data-reveal-text="lines"><?= $feature->label() ?></div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</section>
<?php endif ?>