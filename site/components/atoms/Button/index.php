<?php
	$theme ??= 'dark';
	$url ??= false;
	$label ??= false;
	$css ??= false;
	$node ??= false;
	$icon ??= true;
	$target = isset($target) ? $target->toBool() : false;
?>
<?php if ($url) : ?>
	<a href="<?= $url ?>" <?= $target ? 'target=_blank' : null ?> class="button upper <?= $css ?>" <?= $theme != false ? 'theme='.$theme : null ?> <?= $node ?>>
		<?php if ($label) : ?>
			<span aria-label="<?= $label ?>"><?= $label ?></span>
		<?php endif ?>
		<?php if ($icon) : ?>
			<span class="icon"><?= svg('public/assets/images/ui/ui_'.$icon.'.svg') ?></span>
		<?php endif ?>
	</a>
<?php else: ?>
	<button class="button upper <?= $css ?>" <?= $node ?> <?= $theme != false ? 'theme='.$theme : null ?> >
		<?php if ($label) : ?>
			<span aria-label="<?= $label ?>"><?= $label ?></span>
		<?php endif ?>
		<?php if ($icon) : ?>
			<span class="icon"><?= svg('public/assets/images/ui/ui_'.$icon.'.svg') ?></span>
		<?php endif ?>
	</button>
<?php endif ?>
