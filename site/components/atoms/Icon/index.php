<?php
$name = $name ?? $icon ?? null;
$css  = $css ?? '';
$node = $node ?? '';

if ($name) {
    $path = 'public/assets/images/ui/ui_' . $name . '.svg';
} elseif (isset($svg)) {
    $path = $svg;
} else {
    $path = null;
}
?>
<?php if ($path) : ?>
<span class="icon <?= esc($css) ?>" <?= $node ?>>
	<?= svg($path) ?>
</span>
<?php endif ?>
