<?php
	$testimonials = (collection('Projects')) 
    ? collection('Projects')->filterBy('testimonialQuote', '!=', '') 
    : new Kirby\Cms\Pages();
?>
<?php if ($testimonials->isNotEmpty()) : ?>
<section class="testimonials rounded-radius" data-tabs="noinit" theme="dark">
	<div class="hidden">
		<?php foreach ($testimonials as $project) : ?>
			<div data-tab="testimonial-<?= $project->indexOf($testimonials) ?>"></div>
		<?php endforeach ?>
	</div>
	<div class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] relative">
		<div data-pane-container class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] absolute inset-0">
			<?php foreach ($testimonials as $project) : ?>
				<?php if ($cover = $project->cover()->toFile()) : ?>
				<div data-tab-reveal data-pane="testimonial-<?= $project->indexOf($testimonials) ?>" >
					<div class="intro__cover grid " data-reveal-cover><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
				</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
		<div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-2 h-screen p-1 md:px-1 py-2" >
			<div data-tab-prev></div>
			<div class="grid place-items-center">
				<div data-pane-container class="grid " data-scroll data-scroll-ignore data-reveal-image>
					<div class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] p-1 rounded-img" theme="dark">
						<?php foreach ($testimonials as $project) : ?>
							<div data-pane="testimonial-<?= $project->indexOf($testimonials) ?>" class="grid" data-tab-reveal>
								<?= snippet('molecules/Testimonial/featured', compact('project','testimonials')) ?>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
			<div data-tab-next></div>
		</div>
	</div>
</section>
<?php endif ?>