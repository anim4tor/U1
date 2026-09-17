<div class="grid gap__4 place__space-between-stretch w__15 h__15" theme="dark">
	<div class="grid place__start-stretch gap__1">
		<div class="flex justify__space-between">
			<div></div>
			<div class="flex gap__02 justify__end align__start">
				<button data-tab-prev class="button upper" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
				<button data-tab-next class="button upper" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
			</div>
		</div>

		<div class="grid gap__02">
			<h3 class="font__size__3"><?= $showroom['city'] ?? '' ?></h3>
			<p class="op__8 font__size__default"><?= $showroom['address'] ?? '' ?></p>
		</div>
	</div>

	<div class="flex justify__space-between">
		<div class="upper font__size__small">(Showroomy)</div>
		<div class="font__size__small"><span data-reveal-text="lines" data-split-ignore><?= ($index ?? 0) + 1 ?></span><span>/<?= $total ?? 1 ?></span></div>
	</div>
</div>
