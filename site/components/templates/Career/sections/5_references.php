<?php
/**
 * Career Employee Testimonials / References Section
 * 2-column tabs layout with navigation arrows and project preview (inspired by v3 Career projects tabs)
 */
$careerPage = page('career');
$theme      = $theme ?? 'light';
$title      = ($careerPage && $careerPage->testimonialsHeading()->isNotEmpty()) 
                ? $careerPage->testimonialsHeading()->value() 
                : 'Recenze zaměstnanců';

$rawTestimonials = ($careerPage && $careerPage->testimonials()->isNotEmpty()) 
                    ? $careerPage->testimonials()->toStructure() 
                    : [];

$testimonials = [];
foreach ($rawTestimonials as $t) {
    $authorImg = $t->testimonialimage()->toFile() ?? ($careerPage ? $careerPage->file($t->testimonialimage()->value()) : null);
    
    // Project resolution
    $projectSlug = $t->projectslug()->isNotEmpty() ? $t->projectslug()->value() : ($t->project()->isNotEmpty() ? $t->project()->value() : '');
    $projectPage = null;
    if ($projectSlug) {
        $projectPage = page('projects/' . $projectSlug) ?? (page('projects') ? page('projects')->children()->find($projectSlug) : null);
    }
    
    $projectTitle = $t->projectname()->isNotEmpty() ? $t->projectname()->value() : ($projectPage ? $projectPage->title()->value() : '');
    $projectUrl   = $projectPage ? $projectPage->url() : ($projectSlug ? url('projects/' . $projectSlug) : '#');
    
    $projectImg = null;
    if ($t->projectimage()->isNotEmpty()) {
        $projectImg = $t->projectimage()->toFile() ?? ($careerPage ? $careerPage->file($t->projectimage()->value()) : null);
    }
    if (!$projectImg && $projectPage) {
        $projectImg = $projectPage->cover()->toFile() ?? $projectPage->images()->first();
    }
    
    $testimonials[] = [
        'quote'        => $t->testimonialquote()->value(),
        'author'       => $t->testimonialauthor()->value(),
        'position'     => $t->testimonialposition()->value(),
        'authorImg'    => $authorImg,
        'projectTitle' => $projectTitle,
        'projectUrl'   => $projectUrl,
        'projectImg'   => $projectImg,
    ];
}

$hasTestimonials = !empty($testimonials);
$total = count($testimonials);
?>

<?php if ($hasTestimonials) : ?>
<section class="career-references radius relative z__2" theme="<?= $theme ?>" aria-labelledby="career-ref-heading">
	<div class="career-references__container inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3" data-tabs="default">
		
		<!-- Hidden tab items for Tabs.js -->
		<div class="hidden absolute" aria-hidden="true">
			<?php foreach ($testimonials as $idx => $item) : ?>
				<div data-tab="ref-<?= $idx ?>" class="<?= $idx === 0 ? 'is-active' : '' ?>" <?= $idx === 0 ? 'data-active' : '' ?>></div>
			<?php endforeach ?>
		</div>

		<div class="career-references__grid grid__4 gap__3 place__stretch-stretch mobile:grid__1 mobile:gap__2">
			
			<!-- Left column (span__2): Label, Quote, Author, Project link, Nav arrows -->
			<div class="span__2 relative flex grid gap__2mobile:span__1" data-scroll>
				
				<div class="grid gap__2 place__center-start w__100">

					
					
					<div data-pane-container class="grid__stack place__start-start w__100" data-scroll>
						<?php foreach ($testimonials as $idx => $item) : ?>
							<div data-scroll data-scroll-ignore data-tab-reveal data-pane="ref-<?= $idx ?>" id="ref-pane-text-<?= $idx ?>" class="grid gap__2 place__center-stretch <?= $idx === 0 ? 'is-active' : '' ?>" <?= $idx === 0 ? 'data-active' : '' ?>>
								
								<blockquote class="career-ref__quote font__size__3 ff__heading" data-reveal-text="lines">
									“<?= esc($item['quote']) ?>”
								</blockquote>

								<div class="flex justify__space-between">
								
									<div class="career-ref__meta flex align__center gap__1">
										<?php if ($item['authorImg']) : ?>
											<div class="career-ref__avatar radius__circle no__overflow" style="width: 52px; height: 52px; flex-shrink: 0;">
												<?= snippet('atoms/Image', ['img' => $item['authorImg'], 'reveal' => false, 'css' => 'aspect__1/1']) ?>
											</div>
										<?php endif ?>
										<div class="grid gap__01">
											<strong class="career-ref__name font__size__regular"><?= esc($item['author']) ?></strong>
											<?php if (!empty($item['position'])) : ?>
												<span class="career-ref__role font__size__small op__7"><?= esc($item['position']) ?></span>
											<?php endif ?>
										</div>
									</div>

									<div class="flex gap__02">
										<button data-tab-prev type="button" class="button upper" theme="<?= ($theme === 'dark') ? 'invert-ghost' : 'ghost' ?>" hover="<?= ($theme === 'dark') ? 'invert' : 'dark' ?>" aria-label="Předchozí reference">
											<span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span>
										</button>
										<button data-tab-next type="button" class="button upper" theme="<?= ($theme === 'dark') ? 'invert-ghost' : 'ghost' ?>" hover="<?= ($theme === 'dark') ? 'invert' : 'dark' ?>" aria-label="Další reference">
											<span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span>
										</button>
									</div>

								</div>

								
							</div>
						<?php endforeach ?>
					</div>
				</div>

				<!-- Navigation arrows & counter -->
				

			</div>

			<!-- Right column (span__2): Project photo with click-through to realization -->
			<div data-pane-container class="span__2 grid__stack mobile:span__1" data-scroll>
				<?php foreach ($testimonials as $idx => $item) : ?>
					<div data-scroll data-scroll-ignore data-tab-reveal data-pane="ref-<?= $idx ?>" id="ref-pane-img-<?= $idx ?>" class="career-ref__pane career-ref__media-pane grid <?= $idx === 0 ? 'is-active' : '' ?>" <?= $idx === 0 ? 'data-active' : '' ?>>
						<?php if ($item['projectImg']) : ?>
							<a href="<?= esc($item['projectUrl']) ?>" class="career-ref__card block relative radius no__overflow group" aria-label="Zobrazit realizaci <?= esc($item['projectTitle']) ?>">
								<div class="grid h__100" data-reveal-image>
									<?= snippet('atoms/Image', ['img' => $item['projectImg'], 'reveal' => false, 'css' => 'aspect__5/4 cover__img']) ?>
								</div>
							</a>
						<?php elseif ($item['authorImg']) : ?>
							<div class="career-ref__card block relative radius no__overflow">
								<div class="grid h__100" data-reveal-image>
									<?= snippet('atoms/Image', ['img' => $item['authorImg'], 'reveal' => false, 'css' => 'aspect__5/4 cover__img']) ?>
								</div>
							</div>
						<?php endif ?>
					</div>
				<?php endforeach ?>
			</div>

		</div>
	</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
	document.querySelectorAll('.career-references').forEach(sec => {
		const tabs = sec.querySelectorAll('[data-tab]');
		const panes = sec.querySelectorAll('[data-pane]');
		const prevBtn = sec.querySelector('[data-tab-prev]');
		const nextBtn = sec.querySelector('[data-tab-next]');
		const counterEl = sec.querySelector('[data-ref-current]');
		const total = tabs.length;
		if (total <= 1) return;

		let activeIdx = 0;

		function goTo(index) {
			activeIdx = (index + total) % total;
			const targetPane = 'ref-' + activeIdx;
			
			tabs.forEach((t, i) => {
				const isAct = (i === activeIdx);
				t.classList.toggle('is-active', isAct);
				t.toggleAttribute('data-active', isAct);
			});

			panes.forEach(p => {
				const isAct = (p.getAttribute('data-pane') === targetPane);
				p.classList.toggle('is-active', isAct);
				p.toggleAttribute('data-active', isAct);
			});

			if (counterEl) {
				counterEl.textContent = String(activeIdx + 1);
			}
		}

		if (prevBtn) {
			prevBtn.addEventListener('click', function(e) {
				e.preventDefault();
				goTo(activeIdx - 1);
			});
		}
		if (nextBtn) {
			nextBtn.addEventListener('click', function(e) {
				e.preventDefault();
				goTo(activeIdx + 1);
			});
		}
	});
});
</script>
<?php endif ?>