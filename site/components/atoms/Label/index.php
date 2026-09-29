<?php 
$hasText = isset($text) && trim(strip_tags((string)$text)) !== '';
?>
<div class="flex<?= $hasText ? ' gap__05' : '' ?> align__center upper font__size__small no__wrap" data-scroll><?php if ($hasText): ?><div data-reveal-text><?= $text ?></div><?php endif; ?></div>