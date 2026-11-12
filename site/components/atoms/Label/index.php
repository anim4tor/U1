<?php 
$hasText = isset($text) && trim(strip_tags((string)$text)) !== '';
$css     = $css ?? '';
$node    = $node ?? '';
$url     = $url ?? ($href ?? null);
?>
<?php if ($url): ?>
<a href="<?= esc($url) ?>" class="label flex<?= $hasText ? ' gap__05' : '' ?> align__center font__size__label no__wrap <?= $css ?>" data-scroll <?= $node ?>>
    <?php if ($hasText): ?>
        <div class="" data-reveal="simple">
            <?= $text ?>
        </div>
    <?php endif; ?>
</a>
<?php else: ?>
<div class="label flex<?= $hasText ? ' gap__05' : '' ?> align__center font__size__label no__wrap <?= $css ?>" data-scroll <?= $node ?>>
    <?php if ($hasText): ?>
        <div class="" data-reveal="simple">
            <?= $text ?>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>