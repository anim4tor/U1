<div class="testimonial" data-scroll>
	<div class="grid gap-05 relative">	
		<div class="relative">
			<?php if ($cover = $testimonial->testimonialImage()->toFile()) : ?>
				<div class="testimonial__figure grid rounded-img"><?= snippet('atoms/Image', ['img' => $cover, 'reveal' => true, 'css' => 'h-['.rand(50,75).'vh]', 'node' => 'data-reveal-image']) ?></div>
			<?php endif ?>
			
			<div class="testimonial__hover absolute bottom-1 right-1 w-15">
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
						<div class="grid gap-01">
							<div class="text-s uppercase opacity-4" data-reveal-text="lines"><?= $testimonial->testimonialAuthor()->or($testimonial->parent()->client()) ?></div>
							<?php if ($testimonial->testimonialPosition()->isNotEmpty()) : ?>
								<div class="text-s uppercase opacity-4" data-reveal-text="lines">(<?= $testimonial->testimonialPosition() ?>)</div>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>