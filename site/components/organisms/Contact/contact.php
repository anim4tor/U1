<div class="z-10 flex flex-wrap gap-1 px-1 pt-1 pb-05">
	<h3 class="text-s"><span class="text-acc">Get in touch</span> with us directly or leave us your contact details.</h3>
</div>
<div class="grid place-items-center -mb-2 px-2"><?= snippet('atoms/Image', ['url' => 'contact_sales.jpg', 'css' => '']) ?></div>
<div class="relative grid gap-05 items-end px-1 py-1">
	<div class="grid gap-05">
		<p class="lowercase text-l">Sales</p>
		<div class="flex gap-02">
			<?= snippet('atoms/Button', [ 'url' => 'mailto: svacinova@u1.cz', 'label' => 'svacinova@u1.cz', 'icon' => false, 'theme' => false, 'css' => 'bg-light/20 text-invert/60']) ?>
			<?= snippet('atoms/Button', [ 'url' => 'tel:+402 601 088 517', 'label' => '+402 601 088 517', 'icon' => false, 'theme' => false, 'css' => 'bg-light/20 text-invert/60']) ?>
		</div>
	</div>
</div>
		