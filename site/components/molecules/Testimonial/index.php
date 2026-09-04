<div class="grid gap__3 img__radius inner__1 border" theme="dark">
	<div class="grid gap__1">
		<div class="grid gap__4 place__space-between-start">
			<div class="grid place__start-stretch gap__1">
				<!-- Quote is already formatted as inline string -->
				<p class="quote ff__heading wrap" data-reveal-text="lines" data-split-ignore>"<?= $testimonial->testimonialQuote()->inline() ?>"</p>
			</div>
		</div>
	</div>
	<div class="flex justify__space-between gap__05 align__end">
		<?php 
		// Retrieve image file object from the structure's parent page
		$image = $testimonial->testimonialImage()->toFile() ?? $testimonial->parent()->file($testimonial->testimonialImage()->value()); 
		?>
		<?php if ($image) : ?>
			<div class="flex justify__space-between">
				<div class="no__overflow">
					<div class="figure" data-reveal-image>
						<?= snippet('atoms/Image', ['img' => $image, 'parallax' => false, 'css' => 'max-w__4 max-h__5']) ?>
					</div>
				</div>
			</div>
		<?php endif ?>
		<div class="grid gap__01">
			<div class="upper op__4 font__size__small" data-reveal-text="lines"><?= $testimonial->testimonialAuthor()->or($testimonial->parent()->client()) ?></div>
			<?php if ($testimonial->testimonialPosition()->isNotEmpty()) : ?>
				<div class="upper op__4 font__size__small" data-reveal-text="lines">(<?= $testimonial->testimonialPosition() ?>)</div>
			<?php endif ?>
		</div>
	</div>
</div>