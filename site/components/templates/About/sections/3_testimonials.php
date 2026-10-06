<?php $testimonials = collection('AboutTestimonials'); ?>
<?php if ($testimonials && $testimonials->isNotEmpty()) : ?>
<section class="testimonials u1-block" theme="light">
	<div class="u1-type-1" data-tabs="default">
		<div class="hidden absolute">
			<?php foreach ($testimonials as $testimonial) : ?>
				<div data-tab="testimonial-<?= $testimonial->indexOf($testimonials) ?>"></div>
			<?php endforeach ?>
		</div>

		<!-- Left: Text (6 cols) -->
		<div class="u1-type-1__col-text">
			<div class="u1-type-1__top" data-scroll>
				<div class="u1-header">
					<div class="u1-label"><?= t('testimonials', 'REFERENCE') ?></div>
					<div data-pane-container class="grid__stack">
						<?php foreach ($testimonials as $testimonial) : ?>
							<div data-scroll data-scroll-ignore data-tab-reveal data-pane="testimonial-<?= $testimonial->indexOf($testimonials) ?>" id="testimonial-<?= $testimonial->indexOf($testimonials) ?>">
								<div class="u1-type-1__quote">“<?= $testimonial->testimonialQuote()->inline() ?>”</div>
								<div class="u1-label op__7 inner-t__05">
									<?= $testimonial->testimonialAuthor()->inline() . ($testimonial->testimonialPosition()->isNotEmpty() ? ', ' . $testimonial->testimonialPosition()->inline() : '') ?>
								</div>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>

			<div class="u1-type-1__bottom" data-scroll>
				<div class="flex gap__02 justify__start align__center">
					<button data-tab-prev class="button upper" theme="ghost" hover="dark" aria-label="Předchozí reference">
						<span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span>
					</button>
					<button data-tab-next class="button upper" theme="ghost" hover="dark" aria-label="Další reference">
						<span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span>
					</button>
				</div>
			</div>
		</div>

		<!-- Right: Photo 4:3 (6 cols) -->
		<div class="u1-type-1__col-media" data-pane-container data-scroll>
			<div class="grid__stack no__overflow w__full">
				<?php foreach ($testimonials as $testimonial) : ?>
					<?php 
						$img = $testimonial->testimonialImage()->toFile() ?? (page('about') ? page('about')->file($testimonial->testimonialImage()->value()) : null); 
					?>
					<?php if ($img) : ?>
						<div data-scroll data-scroll-ignore data-tab-reveal data-pane="testimonial-<?= $testimonial->indexOf($testimonials) ?>" class="w__full h__full">
							<div class="u1-photo" data-reveal-image>
								<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'w__full h__full']) ?>
							</div>
						</div>
					<?php endif ?>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>