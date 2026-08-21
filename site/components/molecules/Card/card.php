<div class="grid" data-clip-reveal="bottomleft" data-scroll data-scroll-repeat >
	<div class="card border grid gap-2 items-center justify-center p-5 max-w-md">
		<?php if (isset($header)) { ?>
			<h3 data-reveal-chars class=""><?= $header ?></h3>
		<?php } ?>
		<div class="grid gap-1 items-center justify-center">
			<?= snippet('molecules/blocks', [ 'blocks' => $card->text()->toBlocks() ]) ?>
		</div>
	</div>
</div>