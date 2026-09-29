<?php
	$testimonials = $testimonials ?? ($page->featuredTestimonials()->isNotEmpty() ? $page->featuredTestimonials()->toPages() : collection('Projects')->filterBy('testimonialQuote', '!=', ''));
	$theme      = (!isset($theme) || trim($theme) === '') ? 'dark' : $theme;
	$width      = (!isset($width) || trim($width) === '') ? '5' : $width;
	$template   = (!isset($template) || trim($template) === '') ? 'index' : $template;
	$hasTestimonials = $testimonials && (is_countable($testimonials) ? count($testimonials) > 0 : $testimonials->isNotEmpty());
	$btnTheme   = ($theme === 'dark' || $theme === 'invert') ? 'invert-ghost' : 'ghost';
	$btnHover   = ($theme === 'dark' || $theme === 'invert') ? 'invert' : 'dark';
?>	

<?php if ($hasTestimonials) : ?>
<div class="testimonials" theme="<?= $theme ?>">
	<div class="grid__3 gap-x__1 gap-y__2 mobile:grid__1 inner-x__1 inner-y__2" data-carousel>
		<div class="span__3 flex gap__02 justify__end align__end">
			<button data-carousel-prev class="button upper" theme="<?= $btnTheme ?>" hover="<?= $btnHover ?>"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
			<button data-carousel-next class="button upper" theme="<?= $btnTheme ?>" hover="<?= $btnHover ?>"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
		</div>
		<div class="span__3" data-carousel-scroll>
			<ol class="flex justify__start align__center no__wrap gap__1" data-carousel-slides>
			<?php foreach ($testimonials as $testimonial) : ?>
				<?php if ($testimonial->testimonialQuote()->isNotEmpty()) : ?>
				<li data-slide class="project__wrapper vw__<?= $width ?>">
					<?= snippet('molecules/Testimonial/' . $template, compact('testimonial')) ?>
				</li>
				<?php endif; ?>
			<?php endforeach ?>
			</ol>
		</div>
	</div>
</div>
<?php endif ?>tListener("touchmove", pointerMove, { passive: false });
	    slider.addEventListener("touchend", pointerUp);
	});
</script>