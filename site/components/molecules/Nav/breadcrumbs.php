<nav class="carousel__breadcrumbs flex flex-nowrap" style="<?= isset($position) ? '--position: ' . $position : null ?>">
	<div class="bread flex">
		<?php foreach ($items as $item) : ?>
			<a href="#testimonial-<?= $item->slug() ?>" class="crumb" data-carousel-tab></a>
		<?php endforeach ?>
	</div>
	<div class="crumb walker"></div>
</nav>