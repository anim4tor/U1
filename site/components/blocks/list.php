<?php
$mod = ($block->mod()->isNotEmpty() && $block->mod()->value() !== 'default') ? 'text-' . $block->mod()->value() : '';
?>
<div class="<?= $mod ?> grid gap__05" data-scroll data-reveal-text="lines"><?= $block->text(); ?></div>