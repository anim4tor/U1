<?= snippet('templates/globals/Hero/list', ['theme' => 'light']) ?>

<?php $testimonials = collection('AboutTestimonials'); ?>
<?php if ($testimonials && $testimonials->isNotEmpty()) : ?>
<section class="about radius" theme="light">
	<div class="grid__4 gap__2 place__stretch-stretch inner__4 inner-t__0" data-tabs="default">
		<div class="hidden absolute">
			<?php foreach ($testimonials as $testimonial) : ?>
				<div data-tab="testimonial-<?= $testimonial->indexOf($testimonials) ?>"></div>
			<?php endforeach ?>
		</div>

		<div class="relative grid gap__5 place__space-between-start" data-scroll>
			<div class="grid place__start-stretch" data-reveal-text>
				
			</div>
			
			<div class="grid gap__1 place__start-start">
				<div data-pane-container class="grid__stack place__end-start" data-scroll>
					<?php foreach ($testimonials as $testimonial) : ?>
					<div data-scroll data-scroll-ignore data-tab-reveal data-pane="testimonial-<?= $testimonial->indexOf($testimonials) ?>" id="testimonial-<?= $testimonial->indexOf($testimonials) ?>" class="grid gap__1 place__start-start">
						<p class="font__size__3 ff__heading">“<?= $testimonial->testimonialQuote()->inline() ?>”</p>
						<?= snippet('atoms/Label', [
							'text' => $testimonial->testimonialAuthor()->inline() . ($testimonial->testimonialPosition()->isNotEmpty() ? ', ' . $testimonial->testimonialPosition()->inline() : ''),
							'css'  => 'op__7'
						]) ?>
					</div>
					<?php endforeach ?>
				</div>
				<div class="flex gap__02 justify__start align__end">
					<button data-tab-prev class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
					<button data-tab-next class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
				</div>
			</div>
		</div>
		<div></div>
		<div data-pane-container class="span__2 grid__stack" data-scroll>
			<?php foreach ($testimonials as $testimonial) : ?>
				<?php 
					$img = $testimonial->testimonialImage()->toFile() ?? (page('about') ? page('about')->file($testimonial->testimonialImage()->value()) : null); 
				?>
				<?php if ($img) : ?>
					<div data-scroll data-scroll-ignore data-tab-reveal data-pane="testimonial-<?= $testimonial->indexOf($testimonials) ?>" id="testimonial-<?= $testimonial->indexOf($testimonials) ?>" class="grid">
						<div class="grid" data-reveal-image>
							<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'aspect__5/4']) ?>
						</div>
					</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	</div>
</section>
<?php endif ?>

