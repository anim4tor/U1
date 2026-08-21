<?php
	$custom ??= false;
	$type ??=false;
?>
<div class="grid gap-1">
<?php foreach ($header->blocks()->toBlocks() as $block): ?>
	<?php if ($type) : ?>
		<?php if (in_array($block->type(), $type)): ?>
			<?= $block ?>
		<?php endif ?>
	<?php else : ?>
		<?= $block ?>
	<?php endif ?>

<?php endforeach ?>
</div>