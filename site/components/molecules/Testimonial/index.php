<div class="grid gap-3 rounded-img p-1 border" theme="dark">
	<div class="grid gap-1">
		<div class="grid gap-4 content-between justify-start">
			<div class="grid content-start items-stretch gap-1">
				<!-- Quote is already formatted as inline string -->
				<p class="quote text-m font-heading flex-wrap" data-reveal-text="lines" data-split-ignore>"<?= $testimonial->testimonialQuote()->inline() ?>"</p>
			</div>
		</div>
	</div>
	<div class="flex justify-between gap-05 items-end">
		<?php 
		// Retrieve image file object from the structure's parent page
		$image = $testimonial->testimonialImage()->toFile() ?? $testimonial->parent()->file($testimonial->testimonialImage()->value()); 
		?>
		<?php if ($image) : ?>
			<div class="flex justify-between">
				<div class="overflow-hidden">
					<div class="figure" data-reveal-image>
						<?= snippet('atoms/Image', ['img' => $image, 'parallax' => false, 'css' => 'max-w-[4rem] max-h-[6rem]']) ?>
					</div>
				</div>
			</div>
		<?php endif ?>
		<div class="grid gap-01">
			<div class="text-s uppercase opacity-4" data-reveal-text="lines"><?= $testimonial->testimonialAuthor()->or($testimonial->parent()->client()) ?></div>
			<?php if ($testimonial->testimonialPosition()->isNotEmpty()) : ?>
				<div class="text-s uppercase opacity-4" data-reveal-text="lines">(<?= $testimonial->testimonialPosition() ?>)</div>
			<?php endif ?>
		</div>
	</div>
</div>