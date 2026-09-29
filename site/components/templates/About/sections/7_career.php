<?php if ($page->career()->isNotEmpty()) : ?>
<section class="careers radius" theme="dark">
	<div class="grid__4 gap__2 place__stretch-stretch inner__4">
		<div class="span__2 relative grid__2 gap__2 place__space-between-stretch" data-scroll >
			<div class="span__2 flex align__start gap__01 inner-r__5" data-scroll>
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['label']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['heading']]) ?>
			</div>
			<div class="grid gap__1 place__start-start inner-y__1">
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['text']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['button']]) ?>
			</div>
		</div>
		<div class="span__2 grid aspect__4/3" data-scroll >
			<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['image']]) ?>
		</div>

	</div>
</section>
<?php endif ?>