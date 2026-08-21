<div class="loader grid" data-loader data-scroll>
	<div data-loader-bg class="">
		<?php for ($i=0; $i < 1; $i++) : ?>
			<div style="--index: <?= $i ?>"></div>
		<?php endfor; ?>
	</div>
	<div class="grid place-items-center text-text p-1">
		<div data-loader-logo class="grid p-05">
			<?= svg('public/assets/images/fig_logo.svg') ?>
		</div>
		<!-- <p class="uppercase text-invert opacity-5 overflow-hidden"><span data-counter>0%</span></p> -->
	</div>
	<!-- <div class="loader__bar grid items-end gap-05 absolute bottom-0 inset-x-0 p-1">
		<div class="font-size-2 flex justify-end items-center font-heading"><span data-counter>0%</span></div>
		<div class="bar border-b" data-progress></div>
	</div> -->
</div>