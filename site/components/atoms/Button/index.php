<?php
	$theme ??= 'dark';
	$url ??= false;
	$label ??= false;
	$css ??= false;
	$node ??= false;
	$target = isset($target) ? $target->toBool() : false;
?>
<?php if ($url) : ?>
	<a href="<?= $url ?>" <?= $target ? 'target=_blank' : null ?> class="button upper <?= $css ?>" theme="<?= $theme ?>" <?= $node ?>><span aria-label="<?= $label ?>"><?= $label ?></span></a>
<?php else: ?>
	<button class="button upper <?= $css ?>" <?= $node ?> theme="<?= $theme ?>" ><span aria-label="<?= $label ?>"><?= $label ?></span></button>
<?php endif ?>
