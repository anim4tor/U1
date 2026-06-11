<nav class="carousel__arrows flex flex__end " style="<?= isset($position) ? '--position: ' . $position : null ?>">
	<div class="button__group">
		<div class="button has-border" data-label="<?php echo t('hover-previous') ?>" data-carousel-prev><span class=""><?= svg('assets/images/ui_arrow_left.svg') ?></span></div>
		<div class="button has-border" data-label="<?php echo t('hover-next') ?>" data-carousel-next><span class=""><?= svg('assets/images/ui_arrow_right.svg') ?></span></div>
	</div>
</nav>