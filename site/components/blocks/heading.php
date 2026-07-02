<?php
// 1. Core properties extraction
$text  = $block->text()->isNotEmpty()  ? $block->text()->value()  : '';
$level = $block->level()->isNotEmpty() ? $block->level()->value() : 'h2';

// Compile CSS typography modification classes dynamically
$classes = [];

$modVal = $block->mod()->value();
if ($modVal && $modVal !== 'default') {
    $classes[] = $modVal;
}

// Support for optional block blueprint custom CSS class injections
$cssVal = $block->css()->isNotEmpty() ? $block->css()->value() : '';
if ($cssVal) {
    $classes[] = $cssVal;
}

$cssClasses = implode(' ', $classes);

// 2. Extract Node Group Settings (bid, attr, select wrapper configurations)
$bid     = $block->bid()->isNotEmpty()  ? $block->bid()->value()  : null;
$attr    = $block->attr()->isNotEmpty() ? $block->attr()->value() : '';
$nodeVal = $block->node()->isNotEmpty() ? $block->node()->value() : '';

// 3. Extract Text Animation Flags (Simplified to clean boolean flags)
$reveal = $block->hasReveal()->toBool() === true;
$revealDirection = $reveal ? ($block->reveal()->isNotEmpty() ? $block->reveal()->value() : 'bottom') : false;

// Gather structural block parent layout strings
$blockId         = $bid ? 'id="' . esc($bid) . '"' : '';
$blockAttributes = trim($attr . ' ' . $nodeVal);
?>

<div class="block__<?= $block->type() ?>" <?= $blockId ?> <?= $blockAttributes ?>>

    <?= snippet('atoms/Heading', [
        'text'            => $text,
        'level'           => $level,
        'css'             => $cssClasses,
        'node'            => $attr,
        'reveal'          => $reveal,
        'revealDirection' => $revealDirection
    ]) ?>

</div>