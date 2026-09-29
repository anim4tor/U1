<?php 
$hasText = isset($text) && trim(strip_tags((string)$text)) !== '';
$css     = $css ?? '';
?>
<div class="flex<?= $hasText ? ' gap__05' : '' ?> align__center upper font__size__small no__wrap op__7 <?= $css ?>" data-scroll>
    <?php if ($hasText): ?>
    <div class="" data-reveal="simple">
        (<?= $text ?>)
    </div>
    <?php endif; ?>
</div>