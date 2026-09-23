<?php
	$custom ??= false;
	$type ??= false;
	$css ??= '';
	$output = '';
	foreach ($header->blocks()->toBlocks() as $block) {
		if ($type) {
			if (in_array($block->type(), $type)) {
				$output .= (string)$block;
			}
		} else {
			$output .= (string)$block;
		}
	}
?>
<?php if (trim($output) !== ''): ?>
<div class="grid gap__1 <?= esc($css) ?>">
	<?= $output ?>
</div>
<?php endif ?>