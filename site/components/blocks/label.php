<?php 
$text = $block->text()->isNotEmpty() ? $block->text()->inline()->value() : '';
$css  = $block->css()->isNotEmpty() ? $block->css()->value() : '';
?>
<?= snippet('atoms/Label', [
    'text' => $text,
    'css'  => $css
]) ?>