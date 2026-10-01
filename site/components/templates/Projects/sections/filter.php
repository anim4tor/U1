<?php
/**
 * Projects Filter Section (Theme Light)
 */
$filterSearch     = trim((string)($filterSearch ?? get('search') ?? get('q') ?? ''));
$filterSpace      = $filterSpace ?? get('space');
$filterIndustry   = $filterIndustry ?? get('industry');
$filterSolution   = $filterSolution ?? get('solution');
$filterProduction = $filterProduction ?? get('production');
$filterHash       = $filterHash ?? get('hash') ?? get('tag');
$targetPage       = $page ?? (function_exists('page') && page() ? page() : null);
$targetUrl        = $targetPage ? $targetPage->url() : url('projects');

if (empty($spaces) && empty($industries)) {
    $projectsPage = $targetPage ?? page('projects');
    if ($projectsPage && method_exists($projectsPage, 'controller')) {
        $ctrl = $projectsPage->controller();
        if (is_array($ctrl)) {
            $spaces           = $ctrl['spaces'] ?? [];
            $industries       = $ctrl['industries'] ?? [];
            $solutions        = $ctrl['solutions'] ?? [];
            $productions      = $ctrl['productions'] ?? [];
            $hashes           = $ctrl['hashes'] ?? [];
            $isFiltered       = $ctrl['isFiltered'] ?? false;
            $filterSpace      = $filterSpace ?? $ctrl['filterSpace'] ?? null;
            $filterIndustry   = $filterIndustry ?? $ctrl['filterIndustry'] ?? null;
            $filterSolution   = $filterSolution ?? $ctrl['filterSolution'] ?? null;
            $filterProduction = $filterProduction ?? $ctrl['filterProduction'] ?? null;
            $filterHash       = $filterHash ?? $ctrl['filterHash'] ?? null;
        }
    }
}
?>
<section id="project-filter-section" class="project-filter-section relative z__2 radius" theme="light" data-ajax-filter-panel>
	<div class="project-filter-inner inner__4 inner-y__2">
		<form action="<?= $targetUrl ?>" method="GET" class="project-filter__form grid gap__1" data-project-filter-form role="search">
			
			<!-- Row 1: Large Search Bar with autocomplete -->
			<div class="project-filter__search-row relative" data-project-search data-api-url="<?= url('ajax/projects/search') ?>">
				<div class="project-filter__search-bar flex align__center justify__space-between inner-b__05">
					<input 
						type="text" 
						name="search" 
						value="<?= esc($filterSearch) ?>" 
						placeholder="<?= esc(t('search-projects', 'Hledat prostor, odvětví, klienta...')) ?>" 
						autocomplete="off" 
						spellcheck="false"
						class="project-filter__input font__size__2 smaller"
						aria-label="<?= esc(t('search-projects', 'Hledat prostor, odvětví, klienta...')) ?>"
					>
					<div class="project-filter__search-actions flex align__center gap__05">
						<button 
							type="button" 
							class="project-filter__clear <?= !empty($filterSearch) ? 'is-visible' : '' ?>" 
							aria-label="Vymazat hledání"
							tabindex="-1"
						>
							&times;
						</button>
						<div class="project-filter__spinner" aria-hidden="true"></div>
					</div>
				</div>

				<div class="project-filter__autocomplete inner-t__05" data-search-list></div>
			</div>

			<!-- Row 2: Filter Dropdowns linked to blueprint fields -->
			<div class="project-filter__dropdowns-row flex align__center gap__05 flex__wrap" data-scroll>
				<?php if (!empty($spaces)) : ?>
					<?= snippet('molecules/Dropdown/filter', [ 
						'label'    => 'Prostory', 
						'param'    => 'space',
						'options'  => $spaces,
						'active'   => $filterSpace ?? null,
						'theme'    => 'ghost',
						'formMode' => true
					]) ?> 
				<?php endif ?>

				<?php if (!empty($industries)) : ?>
					<?= snippet('molecules/Dropdown/filter', [ 
						'label'    => 'Odvětví', 
						'param'    => 'industry',
						'options'  => $industries,
						'active'   => $filterIndustry ?? null,
						'theme'    => 'ghost',
						'formMode' => true
					]) ?> 
				<?php endif ?>

				<?php if (!empty($solutions)) : ?>
					<?= snippet('molecules/Dropdown/filter', [ 
						'label'    => 'Služby', 
						'param'    => 'solution',
						'options'  => $solutions,
						'active'   => $filterSolution ?? null,
						'theme'    => 'ghost',
						'formMode' => true
					]) ?> 
				<?php endif ?>

				<?php if (!empty($productions)) : ?>
					<?= snippet('molecules/Dropdown/filter', [ 
						'label'    => 'Výroba', 
						'param'    => 'production',
						'options'  => $productions,
						'active'   => $filterProduction ?? null,
						'theme'    => 'ghost',
						'formMode' => true
					]) ?> 
				<?php endif ?>

				<?php if (!empty($hashes)) : ?>
					<?= snippet('molecules/Dropdown/filter', [ 
						'label'    => 'Hashtagy', 
						'param'    => 'hash',
						'options'  => $hashes,
						'active'   => $filterHash ?? null,
						'theme'    => 'ghost',
						'formMode' => true
					]) ?> 
				<?php endif ?>
			</div>

			<!-- Row 3: Footer with Reset (left) and Submit (right) -->
			<div class="project-filter__footer-row flex justify__space-between align__center">
				<div>
					<?php if (!empty($isFiltered)) : ?>
						<?= snippet('atoms/Button', [
							'url'    => $targetUrl,
							'label'  => 'Resetovat filtry',
							'theme'  => 'ghost',
							'node'   => 'data-ajax-filter-reset'
						]) ?>
					<?php endif ?>
				</div>

				<div class="flex align__center gap__1">
					<button type="submit" class="button upper" theme="dark" hover="acc">
						<span>Filtrovat</span>
					</button>
				</div>
			</div>

		</form>
	</div>
</section>
