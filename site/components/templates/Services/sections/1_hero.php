<?php if ($page->hero()->isNotEmpty()) : ?>
<section class="intro rounded-radius" theme="invert" >
	<div class="z-10 intro__header pb-2 items-stretch justify-stretch grid grid-cols-1 md:grid-cols-4 gap-2 p-1 pt-10 md:pt-1 gap-2 md:gap-2 relative ">
		<div class="col-span-1 md:col-span-4 h-6"></div>
		<div class="col-span-1 md:col-span-4 pt-05 border-t border-white/20 grid grid-cols-1 md:grid-cols-4 justify-between items-stretch">
			<div class="col-span-1 md:col-span-3">
				<div class="flex items-start gap-02 py-02">
					<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['heading']]) ?>
				</div>
			</div>
			<div class="flex justify-end">
				<?= snippet('atoms/Text', ['text' => '('.collection('Solutions')->count().')', 'reveal' => true, 'css' => 'font-size-4 text-xs' ]) ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>