<?php
$html = preg_replace('/<li>\s*<p>(.*?)<\/p>\s*<\/li>/s', '<li>$1</li>', $block->text()->value());
?>
<div class="grid gap__05" data-scroll><?= $html ?></div>