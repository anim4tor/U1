<?php
    // Catch empty strings, unset parameters, or spaces, and force clean fallbacks
    $theme   = (!isset($theme)   || trim($theme)   === '') ? false : $theme;
    $hover   = (isset($hover) && ($hover === false || $hover === 'none' || $hover === '' || $hover === 'false')) ? false : 'acc'; 
    $url     = (!isset($url)     || trim($url)     === '') ? false    : $url;
    $label   = (!isset($label)   || trim($label)   === '') ? false    : $label;
    $css     = (!isset($css)     || trim($css)     === '') ? ''       : $css;
    $node    = (!isset($node)    || trim($node)    === '') ? ''       : $node;
    $icon    = (!isset($icon)    || trim($icon)    === '') ? false    : $icon;
    $tag     = (!isset($tag)     || trim($tag)     === '') ? false    : $tag;
    
    // Counter Sanitization
    $counter = (!isset($counter) || trim((string)$counter) === '') ? false : $counter;
    
    // Clean Animation Boolean Sanitization
    $reveal  = (isset($reveal) && ($reveal === 'true' || $reveal === true)) ? true : false;
    
    // Explicit check for Target field/object setup
    $target  = isset($target) ? (is_bool($target) ? $target : (is_string($target) ? ($target === 'true' || $target === '1') : (is_object($target) && method_exists($target, 'toBool') ? $target->toBool() : (bool)$target))) : false;
?>

<?php if ($url) : ?>
	<a href="<?= $url ?>" <?= $target ? 'target="_blank" rel="noopener"' : null ?> class="button font__size__button <?= $css ?>" <?= $theme ? 'theme="'.$theme.'"' : null ?> <?= $hover ? 'hover="'.$hover.'"' : null ?> <?= $reveal ? 'data-reveal-text' : '' ?> <?= $node ?>>
		<?php if ($label) : ?>
			<span aria-label="<?= $label ?><?= $counter !== false ? ' (' . $counter . ')' : '' ?>">
				<?= $label ?><?= $counter !== false ? ' (' . $counter . ')' : '' ?>
			</span>
		<?php endif ?>
		<?php if ($icon) : ?>
			<?= snippet('atoms/Icon', ['name' => $icon]) ?>
		<?php endif ?>
	</a>
<?php else: ?>
	<?php $btnTag = $tag ? $tag : 'button'; ?>
	<<?= $btnTag ?> class="button font__size__button <?= $css ?>" <?= $node ?> <?= $theme ? 'theme="'.$theme.'"' : null ?> <?= $hover ? 'hover="'.$hover.'"' : null ?> <?= $reveal ? 'data-reveal="simple"' : '' ?>>
		<?php if ($label) : ?>
			<span aria-label="<?= $label ?><?= $counter !== false ? ' (' . $counter . ')' : '' ?>">
				<?= $label ?><?= $counter !== false ? ' (' . $counter . ')' : '' ?>
			</span>
		<?php endif ?>
		<?php if ($icon) : ?>
			<?= snippet('atoms/Icon', ['name' => $icon]) ?>
		<?php endif ?>
	</<?= $btnTag ?>>
<?php endif ?>