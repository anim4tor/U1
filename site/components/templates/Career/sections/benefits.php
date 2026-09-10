<?php if ($page->culture()->isNotEmpty()) : ?>
<section class="about radius" theme="invert">
	<div class="grid__4 gap__2 place__stretch-stretch inner-x__4 inner-y__4" data-scroll>
		<?= snippet('molecules/Header', ['header' => $page->cultureHeader()]) ?>
		<div class="relative span__3 grid__3 gap__2 place__start-start" data-scroll >
			<?php foreach ($page->culture()->toStructure() as $benefit) : ?>
				<div class="grid gap__1">
					<figure class="h__2 w__2"><?= $benefit->image()->toFile() ?></figure>
					<h3 class="font__size__4"><?= $benefit->label()->inline() ?></h3>
					<p><?= $benefit->text()->inline() ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif ?>