<div class="grid gap__2 place__space-between-start img__radius inner__2 border" theme="dark">
	<div class="grid gap__1">
		<p class="font__size__4 ff__heading wrap" data-reveal-text="lines" data-split-ignore>"<?= $testimonial->testimonialQuote()->inline() ?>"</p>
	</div>
	<div class="flex gap__1 align__center">
		<?php 
		// Retrieve image file object from the structure's parent page
		$image = $testimonial->testimonialImage()->toFile() ?? $testimonial->parent()->file($testimonial->testimonialImage()->value()); 
		?>
		<?php if ($image) : ?>
			<div class="flex gap__1">
				<div class="no__overflow">
					<div class="figure grid place__center-center circle w__3 h__3 img__radius" data-reveal-image>
						<?= snippet('atoms/Image', ['img' => $image, 'parallax' => false, 'css' => '']) ?>
					</div>
				</div>
			</div>
		<?php endif ?>
		<div class="grid">
			<?= snippet('atoms/Label', ['text' => $testimonial->testimonialAuthor()->or($testimonial->parent()->client())]) ?>
			<?php if ($testimonial->testimonialPosition()->isNotEmpty()) : ?>
				<?= snippet('atoms/Label', ['text' => $testimonial->testimonialPosition()]) ?>
			<?php endif ?>
		</div>
	</div>
</div>