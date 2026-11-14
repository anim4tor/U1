<?php if ($page->about()->isNotEmpty()) : ?>
<section class="about radius" theme="invert">
	<div class="grid__4 place__end-stretch gap__2 mobile:grid__1 inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3">
		<div class="grid span__2 gap__2 place__space-between-start mobile:inner-x__0">
			<div class="grid gap__1">
				<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['label', 'heading', 'text', 'button']]) ?>
			</div>
		</div>
		<div class="span__2">
			<?= snippet('sections/Figures') ?>
		</div>
	</div>
</section>
<?php endif ?>