<div class="grid gap__4 place__space-between-start" theme="dark">
	<div class="grid place__start-stretch gap__1">
		<div class="flex justify__space-between">
			<div class="no__overflow " >
				<?php if ($image = $project->testimonialImage()->toFile()) : ?>
					<div class="item__figure" data-reveal-image>
						<?= snippet('atoms/Image', ['img' => $image, 'parallax' => false, 'css' => 'max-w__5 max-h__7']) ?>
					</div>
				<?php endif ?>
			</div>
			<div class="flex gap__02 justify__end align__start">
				<button data-tab-prev class="button upper" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
				<button data-tab-next class="button upper" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>

				<!-- <?= snippet('atoms/Link', ['url' => 'projects', 'label' => 'All projects']) ?> -->
			</div>
		</div>
		<p class="quote font__size__4 ff__heading upper" data-reveal-text="lines" data-split-ignore>"<?= $project->testimonialQuote()->inline() ?>"</p>
	</div>
	<div class="flex justify__space-between">
		<div class="upper font__size__small" >(Testimonials)</div>
		<div class="font__size__small" ><span data-reveal-text="lines" data-split-ignore><?= $project->indexOf(collection('Projects')) + 1 ?></span><span>/<?= $testimonials->count() ?></span></div>
	</div>
	<!-- <div class="flex justify__space-between">
		<div class="upper font__size__small" data-reveal-text="lines">David L.</div>
		<div class="upper font__size__small" data-reveal-text="lines">(Operations Manager)</div>
	</div> -->
</div>
