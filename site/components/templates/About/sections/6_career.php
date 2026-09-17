<?php if ($page->career()->isNotEmpty()) : ?>
<section class="careers radius" theme="dark">
	<div class="grid__2 gap__2 place__stretch-stretch inner__4">
		<div class="relative grid gap__5 place__start-stretch" data-scroll >
			<div class="flex align__start gap__01 " data-scroll>
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['label']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['heading']]) ?>
			</div>
			<div class="flex justify__space-between gap__4 inner-y__1 inner-b__3 border__top">
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['text']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['button']]) ?>
			</div>
		</div>
		<div class="grid inner-l__3" data-scroll >
			<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['image']]) ?>
		</div>

	</div>
</section>
<?php endif ?>