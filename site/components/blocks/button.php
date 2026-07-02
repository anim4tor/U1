<?php
// 1. Resolve Link (Maps to the blueprint's "href" field key)
$hrefField = $block->href();
$url = false;
$isAnchorLink = false;

if ($hrefField->isNotEmpty()) {
    $url = $hrefField->toPage() ? $hrefField->toPage()->url() : $hrefField->value();
    if (strpos(trim($url), '#') === 0) {
        $isAnchorLink = true;
    }
}

// 2. Resolve Counter
$counterValue = false;
if ($block->counter()->isNotEmpty() && $counterPage = $block->counter()->toPages()->first()) {
    $counterValue = $counterPage->children()->count();
}

// 3. Extract core visual properties
$label  = $block->label()->isNotEmpty()  ? $block->label()->value()  : false;
$theme  = $block->theme()->isNotEmpty()  ? $block->theme()->value()  : 'invert';
$hover  = $block->hover()->isNotEmpty()  ? $block->hover()->value()  : false;
$icon   = $block->icon()->isNotEmpty()   ? $block->icon()->value()   : false;
$target = $block->target()->isNotEmpty() ? $block->target()          : false;
$sizeClass = $block->size()->isNotEmpty() ? '--' . $block->size()->value() : '';

// 4. Extract Node Group Settings (bid, attr, custom node datasets)
$bid     = $block->bid()->isNotEmpty()  ? $block->bid()->value()  : null;
$attr    = $block->attr()->isNotEmpty() ? $block->attr()->value() : '';
$nodeVal = $block->node()->isNotEmpty() ? $block->node()->value() : '';

// 5. Handle Animation Properties (Simplified to clean boolean check)
$reveal  = $block->hasReveal()->toBool() === true;

// Build structural wrapper properties cleanly
$blockId         = $bid ? 'id="' . esc($bid) . '"' : '';
$blockAttributes = trim($attr . ' ' . $nodeVal);

// Gather inner button-specific helper attributes
$buttonAttributes = '';
if ($isAnchorLink) {
    $buttonAttributes .= 'data-scroll-to ';
}
?>

<div class="block__<?= $block->type() ?>" <?= $blockId ?> <?= $reveal ? 'data-scroll' : '' ?> <?= $blockAttributes ?>>
    
    <?= snippet('atoms/Button', [ 
        'url'     => $url, 
        'label'   => $label, 
        'theme'   => $theme, 
        'hover'   => $hover, 
        'icon'    => $icon, 
        'target'  => $target, 
        'css'     => $sizeClass,
        'node'    => trim($buttonAttributes),
        'counter' => $counterValue,
        'reveal'  => $reveal // Passed downstream as boolean
    ]) ?>

</div>