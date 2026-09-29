<?php 
$hasText = isset($text) && trim(strip_tags((string)$text)) !== '';
$css     = $css ?? '';
$node    = $node ?? '';
$url     = $url ?? ($href ?? null);
?>
<div class="flex<?= $hasText ? ' gap__05' : '' ?> align__center upper font__size__small no__wrap op__7 <?= $css ?>" data-scroll <?= $node ?>>
    <?php if ($hasText): ?>
        <?php if ($url): ?>
            <a href="<?= esc($url) ?>" data-reveal="simple">
                (<?= $text ?>)
            </a>
        <?php else: ?>
            <div class="" data-reveal="simple">
                (<?= $text ?>)
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>