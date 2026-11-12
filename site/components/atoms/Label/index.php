<?php 
$hasText = isset($text) && trim(strip_tags((string)$text)) !== '';
$css     = $css ?? '';
$node    = $node ?? '';
$url     = $url ?? ($href ?? null);
?>
<div class="label flex<?= $hasText ? ' gap__05' : '' ?> align__center font__size__label no__wrap <?= $css ?>" data-scroll <?= $node ?>>
    <?php if ($hasText): ?>
        <?php if ($url): ?>
            <a href="<?= esc($url) ?>" data-reveal="simple">
                <?= $text ?>
            </a>
        <?php else: ?>
            <div class="" data-reveal="simple">
                <?= $text ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>