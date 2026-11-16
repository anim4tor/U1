<?php
/**
 * Career Employee Testimonials / References Section
 * Same carousel layout as client testimonials on projects page.
 */
$careerPage = $page ?? page('career');
$theme      = $theme ?? 'dark';
$title      = ($careerPage && $careerPage->testimonialsHeading()->isNotEmpty()) 
                ? $careerPage->testimonialsHeading()->value() 
                : 'Co o práci v U1 říkají kolegové';

$testimonials = ($careerPage && $careerPage->testimonials()->isNotEmpty()) 
                ? $careerPage->testimonials()->toStructure() 
                : [];

$hasTestimonials = $testimonials && $testimonials->isNotEmpty();
?>

<?php if ($hasTestimonials) : ?>
<section class="testimonials-section relative z__2 radius" theme="<?= $theme ?>">
	<div class="grid gap__3 inner__4 inner-y__5">
		<div class="flex justify__space-between align__end gap__2" data-scroll>
			<div class="flex align__start gap__02">
				<h2 class="font__size__2" data-reveal-text><?= esc($title) ?></h2>
			</div>
		</div>
		<?= snippet('sections/Testimonials/carousel', [
			'testimonials' => $testimonials,
			'theme'        => $theme,
			'width'        => $width ?? '5',
			'template'     => $template ?? 'index'
		]) ?>
	</div>
</section>
<?php endif ?>

