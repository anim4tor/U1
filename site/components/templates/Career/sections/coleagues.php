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
					<figure class="vh__8"><?= $benefit->image()->toFile() ?></figure>
					<div class="flex justify__space-between align__start gap__2">
						<h3 class=""><?= $benefit->title()->inline() ?></h3>
						<p class="op__8"><?= $benefit->text()->inline() ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif ?>