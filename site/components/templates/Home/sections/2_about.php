<?php if ($page->about()->isNotEmpty()) : ?>
<section class="about" theme="invert">
	<div class="grid grid-cols-1 md:grid-cols-3 gap-2 p-1 px-1 py-2">
		<div class="col-span-1 md:col-span-2 grid content-start justify-start gap-3 text-s">
			<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['heading']]) ?>
		</div>
		<div></div>
		<div></div>
		
		<?= snippet('templates/globals/Figures') ?>
	</div>
</section>
<?php endif ?>