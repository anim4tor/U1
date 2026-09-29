<?php 
$labelText = $block->text()->inline();
$hasText = trim(strip_tags((string)$labelText)) !== '';
?>
<div class="flex<?= $hasText ? ' gap__05' : '' ?> align__center upper font__size__small no__wrap" data-scroll>
    <?php if ($hasText): ?>
        <div data-reveal-text class="inner-l__02">
            (<?= $labelText ?>)
        </div>
    <?php endif; ?>
</div>