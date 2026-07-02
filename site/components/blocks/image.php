<?php
// 1. Resolve Image File object safely
$imgFile = $block->image()->toFile();

// 2. Resolve basic configuration parameters
$url = $block->url()->isNotEmpty() ? $block->url()->value() : null;
$css = $block->css()->isNotEmpty() ? $block->css()->value() : '';

// 3. Extract Node Group Settings
$nodeTag = $block->node()->isNotEmpty() ? $block->node()->value() : 'div';
$bid     = $block->bid()->isNotEmpty()  ? $block->bid()->value()  : null;
$attr    = $block->attr()->isNotEmpty() ? $block->attr()->value() : '';

$nodeHref = false;
if ($block->href()->isNotEmpty()) {
    $nodeHref = $block->href()->toPage() ? $block->href()->toPage()->url() : $block->href()->value();
}

// 4. Resolve Image Animations Group Settings
$parallaxValue = false;
if ($block->hasParallax()->toBool() === true) {
    $parallaxValue = $block->parallax()->isNotEmpty() ? $block->parallax()->value() : 0;
}

$reveal = $block->hasReveal()->toBool() === true;
$revealDirection = $reveal ? ($block->reveal()->isNotEmpty() ? $block->reveal()->value() : 'bottom') : false;

// Build wrapper properties cleanly
$blockId         = $bid ? 'id="' . esc($bid) . '"' : '';
$blockAttributes = trim($attr); 
?>

<<?= $nodeTag ?> class="grid block__<?= $block->type() ?>" <?= $blockId ?> <?= $blockAttributes ?>>

    <?= snippet('atoms/Image', [
        'img'             => $imgFile,
        'url'             => $url,
        'css'             => $css,
        'node'            => $attr,
        'nodeTag'         => $nodeTag,
        'nodeHref'        => $nodeHref,
        'parallax'        => $parallaxValue,
        'reveal'          => $reveal, // Passed as a clean check
        'revealDirection' => $revealDirection
    ]) ?>

</<?= $nodeTag ?>>