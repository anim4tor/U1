<?php if ($page->about()->isNotEmpty()) : ?>
<section class="about radius" theme="invert">
	<div class="grid__4 place__start-stretch gap__2 mobile:grid__1 inner__4 mobile:inner-x__1">
		<div class="grid span__3 gap__4 place__space-between-start mobile:inner-x__0">
			<div class="grid gap__1">
				<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['label']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['heading']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['text']]) ?>
			</div>
			<div class="grid">
			</div>
		</div>
		<div class="span__4">
			<?= snippet('templates/globals/Figures') ?>
		</div>
	</div>
</section>
<?php endif ?>