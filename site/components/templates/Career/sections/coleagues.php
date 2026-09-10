<?php if ($page->coleagues()->isNotEmpty()) : ?>
<section class="about radius" theme="light">
	<div class="grid__4 gap__2 place__stretch-stretch inner-x__4 inner-y__4" data-scroll>
		<div class="span__2">
			<?= snippet('molecules/Header', ['header' => $page->coleaguesHeader()]) ?>
		</div>
		<div class="span__4 grid__3 gap__2">
			<?php foreach ($page->coleagues()->toStructure() as $benefit) : ?>
				<div class="grid gap__1">
					<figure class=""><?= $benefit->image()->toFile() ?></figure>
					<h4 class="s"><?= $benefit->title()->inline() ?></h4>
					<p><?= $benefit->text()->inline() ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif ?>