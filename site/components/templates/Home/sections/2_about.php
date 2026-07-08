<?php if ($page->about()->isNotEmpty()) : ?>
<section class="about" theme="invert">
	<div class="grid__3 gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2">
		<div class="span__2 grid place__start-start gap__3 mobile:inner-x__0 s">
			<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['heading']]) ?>
		</div>
		<div></div>
		<!-- <div></div>
		<?php if ($fig = $page->introFigure()->toFile()) : ?>
			<div class="grid h__20" >
				<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['image']]) ?>
			</div>
		<?php endif ?>
		<div class="grid place__start-end"><?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['label']]) ?></div>
		<div></div>
		<div class="grid place__center-start gap__3">
			<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['text']]) ?>
		</div>
		<div></div> -->
		<div></div>
		<div class="span__2 flex justify__space-between">
			<?php foreach ($page->aboutFigures()->toStructure() as $figure) : ?>
				<div class="flex inner-y__2" data-scroll>
					<h2 class="font__size__1 l outlined lighter" data-reveal-text><?= $figure->feature() ?></h2>
					<div class="s label" data-reveal-text="lines"><?= $figure->label() ?></div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</section>
<?php endif ?>