<?php if ($page->career()->isNotEmpty()) : ?>
<section class="careers" theme="invert">
	<div class="grid grid-cols-1 md:grid-cols-2 gap-2 items-stretch p-1 py-2 pb-5">
		<div class="relative grid gap-5 content-start items-stretch" data-scroll >
			<div class="grid justify-between items-stretch" data-reveal-text>
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['heading']]) ?>
			</div>
			<div class="flex justify-between gap-4 py-1 pb-3 border-t border-white/20">
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['text']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['button']]) ?>
			</div>
		</div>
		<div class="grid pl-3" data-scroll >
			<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['image']]) ?>
		</div>

	</div>
</section>
<?php endif ?>