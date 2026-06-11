<section class="intro">
	<div class="intro__header grid__5 mobile:grid__1 place__end-stretch h__20 mobile:h__auto inner-b__2 inner-x__1 mobile:inner-t__10 mobile:gap__2 relative" >
		<div class="span__3 mobile:span__1" data-scroll>
		<?php if ($title = $slots->title()): ?>
			<?= $title ?>
		<?php else: ?>
			<?php if ($page->title()->isNotEmpty() || $page->customTitle()->isNotEmpty()) : ?>
				<h1 data-reveal-text class="xl bolder"><?= $page->customTitle()->isNotEmpty() ? $page->customTitle() : $page->title() ?>.</h1>
			<?php endif ?>
		<?php endif ?>
		</div>
		<?php if ($page->subtitle()->isNotEmpty()) : ?>
		<div class="span__2 mobile:span__1" data-scroll>
			<?php if ($subtitle = $slots->subtitle()): ?>
				<?= $subtitle ?>
			<?php else: ?>
				<div class="flex align__center gap__05 inner-r__2" ><p class="font__size__large" data-reveal-text="lines"><?= $page->subtitle() ?></p></div>
			<?php endif ?>
		</div>
		<?php endif ?>

	</div>
	<?php if ($cover = $slots->cover()): ?>
		<?= $cover ?>
	<?php else: ?>
		<?php if ($cover = $page->cover()->toFile()) : ?>
			<div class="intro__cover h__100v grid"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2]) ?></div>
		<?php endif ?>
	<?php endif ?>
	
</section>