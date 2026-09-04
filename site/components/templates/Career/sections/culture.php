<?php if ($page->culture()->toStructure()->isNotEmpty()) : ?>
<section class="culture" theme="invert">
	<div class="grid inner-x__1 inner-t__1 border__top">
		<?php foreach ($page->culture()->toStructure() as $culture) : ?>
			<div class="grid__3 gap__2">
				<div class="flex justify__start">
					<?= snippet('atoms/Heading', [ 'level' => 'h3', 'text' => $culture->label(), 'reveal' => true, 'css' => 'font__size__4' ]) ?>
				</div>
				<div class="grid gap__2">
					<?= snippet('atoms/Image', ['img' => $culture->image()->toFile(), 'parallax' => 5, 'reveal' => true, 'css' => 'vh__12']) ?>
				</div>
				<div class="">
					<?= snippet('atoms/Text', ['text' => $culture->text()->inline(), 'reveal' => true]) ?>
				</div>
			</div>
		<?php endforeach ?>
	</div>
</section>
<?php endif ?>