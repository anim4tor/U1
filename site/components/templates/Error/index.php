<?= snippet('molecules/Gradient', [ 'from' => $page->gradientFrom(), 'to' => $page->gradientTo() ]) ?>

<section class="intro">
	<div class="grid place__end-stretch h__20 inner-b__2 inner-x__2 relative" data-scroll>
		<?php if ($page->error()->isNotEmpty()) : ?>
		<div class="grid place__center-start gap__3 wrap-x__10">
			<?= snippet('molecules/Header', ['header' => $page->error()]) ?>
		</div>
		<?php endif ?>
	</div>
</section>