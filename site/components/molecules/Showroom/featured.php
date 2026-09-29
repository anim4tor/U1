<div class="grid gap__4 w__20 h__15" theme="dark">
	<div class="grid place__space-between-stretch gap__1">
		<div class="flex justify__space-between op__6">
			<div class="upper font__size__small">(Showroom)</div>
			<div class="font__size__small"><span data-reveal-text="lines" data-split-ignore><?= ($index ?? 0) + 1 ?></span><span>/<?= $total ?? 1 ?></span></div>
		</div>
		<div class="grid gap__02">
			<h2 class=""><?= $showroom['city'] ?? '' ?></h2>
			<p class="op__8 font__size__default"><?= $showroom['address'] ?? '' ?></p>
		</div>
		<div class="flex justify__end align__start">
			<button data-tab-prev class="button upper" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
			<button data-tab-next class="button upper" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
		</div>

	</div>

	
</div>
