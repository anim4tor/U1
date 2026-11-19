<div class="grid place__start-stretch radius " theme="dark" data-contact-widget>
	<div data-tabs="contact" class="relative grid place__start-stretch ">	
		<nav class="flex sticky top__0 gap__05 inner-x__1 inner-y__06 border__bottom z__10" theme="dark">
			<div class="absolute top__03 right__03 z__1">
				<?= snippet('atoms/Button', [ 'url' => '', 'label' => false, 'icon' => 'close', 'theme' => false, 'css' => 'circle --small bg__light/20 color__invert/80', 'node' => 'data-contact-close']) ?>
			</div>
			<div data-tab="contact" class="upper font__size__small">Kontakt</div>
			<div data-tab="inquiry" class="upper font__size__small">Poptávka</div>
		</nav>
		
		<div data-pane-container class="grid__stack place__start-stretch no__overflow w__100">
			<div data-pane="contact">
				<?= snippet('organisms/Contact/contact') ?>
			</div>
			<div data-pane="inquiry">
				<?= snippet('organisms/Contact/contact_form') ?>
			</div>
			<div data-pane="success">
				<?= snippet('organisms/Contact/success') ?>
			</div>
		</div>
		
	</div>
</div>