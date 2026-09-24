<?php if ($page->coleagues()->isNotEmpty()) : ?>
<section class="about radius" theme="light">
	<div class="grid__4 gap__2 place__stretch-stretch inner-x__4 inner-y__4" data-scroll>
		<div data-scroll class="flex align__start gap__01 span__2">
			<?= snippet('molecules/Header', ['header' => $page->coleaguesHeader(), 'type' => ['label']]) ?>
			<?= snippet('molecules/Header', ['header' => $page->coleaguesHeader(), 'type' => ['heading']]) ?>
		</div>
		<div class="span__4 grid__3 gap__2">
			<?php foreach ($page->coleagues()->toStructure() as $benefit) : ?>
				<div class="grid gap__05">
					<figure class=""><?= $benefit->image()->toFile() ?></figure>
					<h4 class="font__size__5"><?= $benefit->title()->inline() ?></h4>
					<p><?= $benefit->text()->inline() ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif ?>