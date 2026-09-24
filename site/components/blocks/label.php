<?php 
$labelText = $block->text()->inline();
$hasText = trim(strip_tags((string)$labelText)) !== '';
?>
<div class="flex<?= $hasText ? ' gap__05' : '' ?> align__center upper font__size__small no__wrap relative " data-scroll>
    <div class="absolute -left__03 w__03 h__03 bg__acc"></div>
    <?php if ($hasText): ?>
        <div data-reveal-text class="inner-l__02">
            <?= $labelText ?>
        </div>
    <?php endif; ?>
</div>