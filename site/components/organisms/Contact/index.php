<div>
	<div fab data-scroll class="fixed inset__bottom-right inner__05" data-contact-hide>
		<div style="--in-delay: 1000ms" data-reveal>
			<button class="button bg__acc " theme="acc" data-contact-toggle >
				<div icon class="grid__stack color__invert ">
					<div class="grid"><?= svg('public/assets/images/hand.svg') ?></div>
				</div>
				<!-- <label class="upper">Start project</label> -->
			</button>
		</div>
	</div>
	<section class="contact fixed" data-scroll data-contact data-lenis-prevent>
		<div class="grid place__end-end inner__05 h__100v" >
			<?php $page->intendedTemplate() != 'job' ? snippet('organisms/Contact/widget') : snippet('organisms/Contact/career') ?>
		</div>
	</section>
</div>
