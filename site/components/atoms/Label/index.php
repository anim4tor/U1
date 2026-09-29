<?php 
$hasText = isset($text) && trim(strip_tags((string)$text)) !== '';
$css     = $css ?? '';
?>
<div class="flex<?= $hasText ? ' gap__05' : '' ?> align__center upper font__size__small no__wrap <?= $css ?>" data-scroll>
    <?php if ($hasText): ?>
    <div class="op__7" data-reveal-text>
        (<?= $text ?>)
    </div>
    <?php endif; ?>
</div>