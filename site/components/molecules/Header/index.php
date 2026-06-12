<?php
	$custom ??= false;
	$type ??=false;
?>
<div class="grid gap__1 <?= $custom ? $custom : 'place__start-start'?>">
<?php foreach ($header->blocks()->toBlocks() as $block): ?>
	<?php if ($type) : ?>
		<?php if (in_array($block->type(), $type)): ?>
			<div class="block__<?= $block->type() ?> "><?= $block ?></div>
		<?php endif ?>
	<?php else : ?>
		<div class="block__<?= $block->type() ?> "><?= $block ?></div>
	<?php endif ?>

<?php endforeach ?>
</div>