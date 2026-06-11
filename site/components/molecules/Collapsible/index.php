<collapsible>
	<summary class="wrap__1" <?php e($item->isOpen(), 'aria-current="page"') ?> href="<?= $item->url() ?>" collapsible-trigger>
		<div class="grid__<?= $grid ?> grid__middle inner__1 border__top">
			<?php if($counter = $item->counter()->toBool()): ?>
				<div class="font__size__3 wrap__right__2"><?= str_pad($item->indexOf($list) + 1, 1, "0", STR_PAD_LEFT) ?></div>
			<?php endif ?>
			<h3 data-reveal-lines class="upper font__size__lg smaller wrap__right__5"><?= $item->summary()->inline() ?></h3>
			<div class="plus flex flex__end wrap__left__1" ><div collapsible-icon><span></span><span></span></div></div>
		</div>
	</summary>
	<detail collapsible-detail>
		<div class="wrap__1">
			<div class="grid gap__1 inner__top__2 inner__bottom__5" data-collapsible-reveal>
				<?php if($item->detail()->isNotEmpty()): ?>
					<?= $item->detail() ?>
				<?php endif ?>
			</div>
		</div>
	</detail>
</collapsible>