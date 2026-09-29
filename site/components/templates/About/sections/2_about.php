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
		
	</div>
</section>
<?php endif ?>