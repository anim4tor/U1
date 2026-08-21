<div class="grid" data-clip-reveal="bottomleft" data-scroll data-scroll-repeat >
	<div class="card border | grid gap__2 grid__middle grid__center | inner__5 wrap__<?= isset($size) ? $size : 5 ?> | sm__wrap__10">
		<?php if (isset($header)) { ?>
			<h3 data-reveal-chars class=""><?= $header ?></h3>
		<?php } ?>
		<div class="grid gap__1 grid__center">
			<?= snippet('molecules/blocks', [ 'blocks' => $card->text()->toBlocks() ]) ?>
		</div>
	</div>
</div>