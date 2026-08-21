<div class="grid place__start-stretch radius " theme="dark" data-contact-widget>
	<div data-tabs="contact" class="relative grid place__end-stretch " data-fluid>	
		<div class="flex sticky top__0 gap__03 inner-x__1 inner-y__06 border__bottom z__10" theme="dark">
			<div class="absolute top__03 right__03 z__1">
				<?= snippet('atoms/Button', [ 'url' => '', 'label' => false, 'icon' => 'close', 'theme' => false, 'css' => 'circle --small bg__light/20 color__invert/80', 'node' => 'data-contact-close']) ?>
			</div>
			<div data-tab="contact" class="upper xs">contact</div>
			<div data-tab="inquiry" class="upper xs">Inquiry</div>
			<!-- <div data-tab="sales" class="upper xs">Sales</div>
			<div data-tab="design" class="upper xs">Design</div>
			<div data-tab="accounts" class="upper xs">Accounts</div> -->
			<!-- <div data-tab="form" class="upper s">Form</div> -->
		</div>
		
		<div data-pane-container class="grid__stack place__start-stretch no__overflow">
			<div data-pane="contact">
				<?= snippet('organisms/Contact/contact') ?>
			</div>
			<div data-pane="inquiry" style="--booking-width: 50vw">
				<?= snippet('organisms/Contact/contact_form') ?>
			</div>
		</div>
		
	</div>
</div>