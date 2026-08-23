<?php
// 1. Core text properties extraction
$text = $block->text()->isNotEmpty() ? $block->text()->value() : '';

// Compile CSS typography modification classes dynamically
$classes = [];

$modVal = $block->mod()->value();
if ($modVal && $modVal !== 'default') {
    $classes[] = 'text-' . $modVal;
}

$faceVal = $block->face()->value();
if ($faceVal) {
    $classes[] = 'ff__' . $faceVal; // e.g., font__family__heading
}

$caseVal = $block->case()->value();
if ($caseVal && $caseVal !== 'none') {
    $classes[] = $caseVal; // e.g., upper
}

$cssClasses = implode(' ', $classes);

// 2. Extract Node Group Settings (bid, attr, select wrapper configurations)
$bid     = $block->bid()->isNotEmpty()  ? $block->bid()->value()  : null;
$attr    = $block->attr()->isNotEmpty() ? $block->attr()->value() : '';
$nodeVal = $block->node()->isNotEmpty() ? $block->node()->value() : '';

// 3. Extract Text Animation Flags
$hasReveal = $block->hasReveal()->toBool() === true;
$revealDirection = $hasReveal ? ($block->reveal()->isNotEmpty() ? $block->reveal()->value() : 'bottom') : false;

// Gather structural block parent layout strings
$blockId         = $bid ? 'id="' . esc($bid) . '"' : '';
$blockAttributes = trim($attr . ' ' . $nodeVal);
?>

<div class="block__<?= $block->type() ?>" <?= $blockId ?> <?= $blockAttributes ?>>

    <?= snippet('atoms/Text', [
        'text'            => $text,
        'css'             => $cssClasses,
        'node'            => $attr,
        'reveal'          => $hasReveal,
        'revealDirection' => $revealDirection
    ]) ?>

</div>