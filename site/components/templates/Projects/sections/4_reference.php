<?php
/**
 * Projects Testimonials / Reference Section
 */
$projectsPage = $page ?? page('projects');
$theme        = $theme ?? 'dark';
$title        = $title ?? t('testimonials', 'Reference');

// 1. Fetch testimonials (explicit $testimonials, or featured, or listed project subpages with quotes)
if (!isset($testimonials)) {
    if ($projectsPage && method_exists($projectsPage, 'featuredTestimonials') && $projectsPage->featuredTestimonials()->isNotEmpty()) {
        $testimonials = $projectsPage->featuredTestimonials()->toPages();
    } elseif ($projectsPage) {
        $testimonials = $projectsPage->children()->listed()->filter(function ($p) {
            return $p->testimonialQuote()->isNotEmpty();
        });
    } else {
        $testimonials = [];
    }
}

$hasTestimonials = !empty($testimonials) && (is_countable($testimonials) ? count($testimonials) > 0 : $testimonials->isNotEmpty());
$hasReferenceBlocks = $projectsPage && $projectsPage->reference()->isNotEmpty();
?>

<?php if ($hasTestimonials) : ?>
<section class="testimonials-section relative z__2 radius" theme="<?= $theme ?>">
	<div class="grid gap__3 inner__4 inner-y__5">
		<div class="flex justify__space-between align__end gap__2" data-scroll>
			<?php if ($hasReferenceBlocks) : ?>
				<div class="grid gap__05">
					<?= snippet('molecules/Header', ['header' => $projectsPage->reference(), 'type' => ['label']]) ?>
					<?= snippet('molecules/Header', ['header' => $projectsPage->reference(), 'type' => ['heading']]) ?>
					<?= snippet('molecules/Header', ['header' => $projectsPage->reference(), 'type' => ['text']]) ?>
				</div>
			<?php else : ?>
				<div class="flex align__start gap__02">
					<h2 class="font__size__2" data-reveal-text><?= esc($title) ?></h2>
				</div>
			<?php endif ?>
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
