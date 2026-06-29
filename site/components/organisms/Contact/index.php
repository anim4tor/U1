<div fab data-scroll style="--in-delay: 600ms" class="fixed inset__bottom-right inner__05">
	<button class="button circle --large bg__acc " theme="acc" data-scroll data-contact-toggle >
		<div icon class="grid__stack color__invert ">
			<div data-contact-hide class="grid"><?= svg('public/assets/images/hand.svg') ?></div>
		</div>
		<!-- <label class="upper">Start project</label> -->
	</button>
</div>
<section class="contact fixed" data-scroll data-contact data-lenis-prevent>
	<div class="grid place__end-end inner__05 h__100v" >
		<div class="grid place__start-stretch radius " theme="dark" data-contact-widget>
			
			<?= snippet('organisms/Contact/widget') ?>
		</div>
	</div>
</section>
