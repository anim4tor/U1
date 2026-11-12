<?php 
$grid = $grid ?? null;
$summary = $summary ?? ($item->summary()->isNotEmpty() ? $item->summary() : ($item->question()->isNotEmpty() ? $item->question() : ($item->title()->isNotEmpty() ? $item->title() : null)));
$detail = $detail ?? ($item->detail()->isNotEmpty() ? $item->detail() : ($item->answer()->isNotEmpty() ? $item->answer() : ($item->text()->isNotEmpty() ? $item->text() : null)));
$isOpen = $isOpen ?? ($item->hasMethod('isOpen') ? $item->isOpen() : ($item->isOpen()->isNotEmpty() ? $item->isOpen()->toBool() : false));
$url = $url ?? ($item->hasMethod('url') ? $item->url() : ($item->url()->isNotEmpty() ? $item->url() : null));
$hasCounter = isset($list) && $item->counter()->isNotEmpty() && $item->counter()->toBool();
$upper = $upper ?? false;
?>
<collapsible>
	<summary class="wrap__1 cursor__pointer" <?php e($isOpen, 'aria-current="page"') ?> <?php e($url, 'href="' . $url . '"') ?> collapsible-trigger>
		<div class="<?= $grid ? 'grid__' . $grid : 'flex justify__space-between align__center' ?> inner-y__1 border__top gap__2">
			<?php if($hasCounter): ?>
				<div class="font__size__3 wrap-r__2"><?= str_pad($item->indexOf($list) + 1, 1, "0", STR_PAD_LEFT) ?></div>
			<?php endif ?>
			<h3 data-reveal-lines class="<?= $upper ? 'upper' : '' ?> font__size__default wrap-r__5"><?= $summary ? $summary->inline() : '' ?></h3>
			<div class="plus flex flex__end shrink__0" ><div collapsible-icon class="color__acc"><span></span><span></span></div></div>
		</div>
	</summary>
	<detail collapsible-detail>
		<div class="wrap__1">
			<div class="grid gap__1 inner-b__2 op__7" data-collapsible-reveal>
				<?php if($detail && $detail->isNotEmpty()): ?>
					<?= $detail ?>
				<?php endif ?>
			</div>
		</div>
	</detail>
</collapsible>