<div class="grid items-start rounded-radius" theme="dark" data-contact-widget>
	<div data-tabs="cta" class="relative grid items-end" data-fluid>	
		<div class="flex sticky top-0 gap-03 px-1 py-06 border-b z-10" theme="dark">
			<div class="absolute top-03 right-03 z-10">
				<?= snippet('atoms/Button', [ 'url' => '', 'label' => false, 'icon' => 'close', 'theme' => false, 'css' => 'circle --small bg-light/20 text-invert/80', 'node' => 'data-contact-close']) ?>
			</div>
			<!-- <div data-tab="cta" class="uppercase text-xs none">Cta</div> -->
			<div data-tab="contact" class="uppercase text-xs">HR manager</div>
			<div data-tab="inquiry" class="uppercase text-xs">Inquiry</div>
		</div>
		
		<div data-pane-container class="grid items-start overflow-hidden">

			<div data-pane="contact">
				<div class="z-10 grid flex-wrap gap-05 px-1 pt-1 pb-05">
					<h3 class="text-s">Máš o pozici zájem? <span class="text-acc">Just say it!</span></h3>
					<div class="flex gap-02">
						<?= snippet('atoms/Button', [ 'url' => false, 'label' => 'Mám zájem', 'icon' => false, 'theme' => 'invert', 'node' => 'data-tab=inquiry']) ?>
						<?= snippet('atoms/Button', [ 'url' => page('Career')->url().'#opened-positions', 'label' => 'Zpět na Volné pozice', 'icon' => false, 'theme' => 'invert-ghost', 'node' => 'data-contact-close']) ?>
					</div>
				</div>
				<div class="relative grid place-items-center -mb-3 px-2"><?= snippet('atoms/Image', ['url' => 'contact_hr.jpg', 'css' => '']) ?></div>
				<!-- <div class="px-1 py-02"><p class="text-s opacity-4">Jitka Burdová</p></div> -->
				<div class="relative grid gap-05 items-end px-1 pb-1">
					<div class="grid gap-05">
						<div>
							<p class="text-xs opacity-4">HR Business partner</p>
							<p class="lowercase text-l">Jitka Burdová</p>
						</div>
						<div class="flex gap-02">
							<?= snippet('atoms/Button', [ 'url' => 'mailto: hr@u1.cz', 'label' => 'hr@u1.cz', 'icon' => false, 'theme' => false, 'css' => 'bg-light/20 text-invert/60']) ?>
							<?= snippet('atoms/Button', [ 'url' => 'tel:+402 601 088 517', 'label' => '+402 601 088 517', 'icon' => false, 'theme' => false, 'css' => 'bg-light/20 text-invert/60']) ?>
						</div>
						
					</div>
				</div>
			</div>

			<div data-pane="inquiry" style="--booking-width: 50vw">
				<?= snippet('organisms/Contact/career_form') ?>
			</div>

		</div>
		
	</div>
</div>