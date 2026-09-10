<?php if ($page->culture()->isNotEmpty()) : ?>
<section class="about radius" theme="invert">
	<div class="grid__4 gap__2 place__stretch-stretch inner-x__4 inner-y__4" data-scroll>
		<div data-scroll class="flex align__start gap__01 span__1">
			<?= snippet('molecules/Header', ['header' => $page->cultureHeader(), 'type' => ['label']]) ?>
		</div>
		<div></div>
		<div class="relative span__2 grid__2 gap__2 place__start-start" data-scroll >
			<?php foreach ($page->culture()->toStructure() as $benefit) : ?>
				<div class="grid gap__1">
					<figure class="h__3 w__3"><?= $benefit->image()->toFile() ?></figure>
					<h3 class=""><?= $benefit->label()->inline() ?></h3>
					<p><?= $benefit->text()->inline() ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif ?>