<div class="grid content-start items-stretch rounded-radius" theme="dark" data-contact-widget>
	<div data-tabs="contact" class="relative grid content-end items-stretch" data-fluid>	
		<div class="flex sticky top-0 gap-03 px-1 py-06 border-b border-white/20 z-10" theme="dark">
			<div class="absolute top-03 right-03 z-10">
				<?= snippet('atoms/Button', [ 'url' => '', 'label' => false, 'icon' => 'close', 'theme' => false, 'css' => 'circle --small bg-light/20 text-invert/80', 'node' => 'data-contact-close']) ?>
			</div>
			<div data-tab="contact" class="uppercase text-xs">contact</div>
			<div data-tab="inquiry" class="uppercase text-xs">Inquiry</div>
		</div>
		
		<div data-pane-container class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] content-start items-stretch overflow-hidden">
			<div data-pane="contact">
				<?= snippet('organisms/Contact/contact') ?>
			</div>
			<div data-pane="inquiry" style="--booking-width: 50vw">
				<?= snippet('organisms/Contact/contact_form') ?>
			</div>
		</div>
		
	</div>
</div>