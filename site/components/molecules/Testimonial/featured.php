<div class="grid gap-4 content-between justify-start" theme="dark">
	<div class="grid content-start items-stretch gap-1">
		<div class="flex justify-between">
			<div class="overflow-hidden" >
				<?php if ($image = $project->testimonialImage()->toFile()) : ?>
					<div class="item__figure" data-reveal-image>
						<?= snippet('atoms/Image', ['img' => $image, 'parallax' => false, 'css' => 'max-w-[20rem] max-h-[25rem]']) ?>
					</div>
				<?php endif ?>
			</div>
			<div class="flex gap-02 justify-end items-start" data-reveal-image>
				<button data-tab-prev class="button uppercase" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
				<button data-tab-next class="button uppercase" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>

				<!-- <?= snippet('atoms/Link', ['url' => 'projects', 'label' => 'All projects']) ?> -->
			</div>
		</div>
		<p class="quote font-size-4 font-heading uppercase" data-reveal-text="lines" data-split-ignore>"<?= $project->testimonialQuote()->inline() ?>"</p>
	</div>
	<div class="flex justify-between">
		<div class="text-s uppercase" >(Testimonials)</div>
		<div class="text-s" ><span data-reveal-text="lines" data-split-ignore><?= $project->indexOf(collection('Projects')) + 1 ?></span><span>/<?= $testimonials->count() ?></span></div>
	</div>
	<!-- <div class="flex justify-between">
		<div class="text-s uppercase" data-reveal-text="lines">David L.</div>
		<div class="text-s uppercase" data-reveal-text="lines">(Operations Manager)</div>
	</div> -->
</div>
