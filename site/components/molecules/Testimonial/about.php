<div class="testimonial" data-scroll>
	<div class="grid gap__05 relative">	
		<div class="relative">
			<?php if ($cover = $testimonial->testimonialImage()->toFile()) : ?>
				<div class="testimonial__figure grid img__radius"><?= snippet('atoms/Image', ['img' => $cover, 'reveal' => true, 'css' => 'vh__'.rand(10,15), 'node' => 'data-reveal-image']) ?></div>
			<?php endif ?>
			
			<div class="testimonial__hover absolute bottom__1 right__1 w__15">
				<div class="grid gap__3 img__radius inner__1 border" theme="dark">
					<div class="grid gap__1">
						<div class="grid gap__4 place__space-between-start">
							<div class="grid place__start-stretch gap__1">
								<!-- Quote is already formatted as inline string -->
								<p class="quote m ff__heading wrap" data-reveal-text="lines" data-split-ignore>"<?= $testimonial->testimonialQuote()->inline() ?>"</p>
							</div>
						</div>
					</div>
					<div class="flex justify__space-between gap__05 align__end">
						<div class="grid gap__01">
							<div class="s upper op__4" data-reveal-text="lines"><?= $testimonial->testimonialAuthor()->or($testimonial->parent()->client()) ?></div>
							<?php if ($testimonial->testimonialPosition()->isNotEmpty()) : ?>
								<div class="s upper op__4" data-reveal-text="lines">(<?= $testimonial->testimonialPosition() ?>)</div>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>