<?php if ($page->about()->isNotEmpty()) : ?>
<section class="about radius border__top" theme="invert">
	<div class="grid__4 place__start-stretch gap__2 mobile:grid__1 inner__4 mobile:inner-x__1">
		<div class="span__2 flex align__center gap__05 mobile:inner-x__0">
			
			<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['label']]) ?>
		</div>
		<div class="span__2 grid place__start-start gap__2 mobile:inner-x__0">
			<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['heading']]) ?>
		</div>
		<div class="span__2"></div>
		<div class="span__2">
		<?= snippet('templates/globals/Figures') ?>
			
		<!-- <div></div>
		<?php if ($fig = $page->introFigure()->toFile()) : ?>
			<div class="grid h__20" >
				<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['image']]) ?>
			</div>
		<?php endif ?>
		<div class="grid place__start-end"><?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['label']]) ?></div>
		<div></div>
		<div class="grid place__center-start gap__3">
			<?= null //snippet('molecules/Header', ['header' => $page->about(), 'type' => ['text']]) ?>
		</div>
		<div></div> -->
		</div>
		
	</div>
</section>
<?php endif ?>