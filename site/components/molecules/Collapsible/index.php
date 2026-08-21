<collapsible>
	<summary class="p-1" <?php e($item->isOpen(), 'aria-current="page"') ?> href="<?= $item->url() ?>" collapsible-trigger>
		<div class="grid grid-cols-1 md:grid-cols-<?= $grid ?> items-center p-1 border-t">
			<?php if($counter = $item->counter()->toBool()): ?>
				<div class="font-size-3 pr-2"><?= str_pad($item->indexOf($list) + 1, 1, "0", STR_PAD_LEFT) ?></div>
			<?php endif ?>
			<h3 data-reveal-lines class="uppercase font-size-4 pr-5"><?= $item->summary()->inline() ?></h3>
			<div class="plus flex justify-end pl-1" ><div collapsible-icon><span></span><span></span></div></div>
		</div>
	</summary>
	<detail collapsible-detail>
		<div class="p-1">
			<div class="grid gap-1 pt-2 pb-5" data-collapsible-reveal>
				<?php if($item->detail()->isNotEmpty()): ?>
					<?= $item->detail() ?>
				<?php endif ?>
			</div>
		</div>
	</detail>
</collapsible>