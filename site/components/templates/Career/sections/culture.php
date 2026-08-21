<?php if ($page->culture()->toStructure()->isNotEmpty()) : ?>
<section class="culture" theme="invert">
	<div class="grid px-1 pt-1 border-t border-white/20">
		<?php foreach ($page->culture()->toStructure() as $culture) : ?>
			<div class="grid grid-cols-1 md:grid-cols-3 gap-2">
				<div class="flex justify-start">
					<?= snippet('atoms/Heading', [ 'level' => 'h3', 'text' => $culture->label(), 'reveal' => true, 'css' => 'text-xs font-size-4' ]) ?>
				</div>
				<div class="grid gap-2">
					<?= snippet('atoms/Image', ['img' => $culture->image()->toFile(), 'parallax' => 5, 'reveal' => true, 'css' => 'h-[60vh]']) ?>
				</div>
				<div class="">
					<?= snippet('atoms/Text', ['text' => $culture->text()->inline(), 'reveal' => true]) ?>
				</div>
			</div>
		<?php endforeach ?>
	</div>
</section>
<?php endif ?>