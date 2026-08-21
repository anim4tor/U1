<div>
	<div fab data-scroll class="fixed bottom-0 right-0 p-1" data-contact-hide>
		<div class="flex" style="--in-delay: 1000ms" data-reveal>
			<button class="button bg-acc" theme="acc" hover="dark" data-contact-toggle >
				<div icon class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] place-items-center text-invert">
					<div class="grid place-items-center -ml-01"><?= svg('public/assets/images/ui/ui_contact.svg') ?></div>
				</div>
				<label class="uppercase"><div>
					<span class="flex pr-1"><?= !in_array($page->intendedTemplate(), ['job']) ? 'Start project' : 'Apply for job' ?></span>
				</div></label>
			</button>
		</div>
	</div>
	<section class="contact fixed" data-scroll data-contact data-lenis-prevent>
		<div class="grid content-end justify-end p-1 h-screen" >
			<?php !in_array($page->intendedTemplate(), ['job']) ? snippet('organisms/Contact/widget') : snippet('organisms/Contact/career') ?>
		</div>
	</section>
</div>
