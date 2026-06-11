<?php
	$custom ??= false;
?>
<div class="grid gap__1 <?= $custom ? $custom : 'place__start-start'?>">
<?php foreach ($header->blocks()->toBlocks() as $block): ?>

	<!-- character reveals -->
	<?php if (in_array($block->type(), ['heading','text'])): ?>
		<div class="block__<?= $block->type() ?> "><?= $block ?></div>

	<!-- character reveals -->
	<?php elseif (in_array($block->type(), ['gallery'])): ?>
		<!--  -->

	<!-- default reveals -->
	<?php else: ?>
		<div class="block__<?= $block->type() ?> "><?= $block ?></div>
	<?php endif ?>

<?php endforeach ?>
</div>