<?php
/**
 * Projects List Section (Filtration Bar & Autocomplete Panel + Grid)
 */

// 1. Controller fallback & data extraction
if (!isset($images) && !isset($projects)) {
    $projectsPage = $page ?? page('projects');
    $ctrlData = ($projectsPage && method_exists($projectsPage, 'controller')) ? $projectsPage->controller() : [];
    if (is_array($ctrlData)) {
        extract($ctrlData, EXTR_SKIP);
    }
}

// 2. Inputs & Parameter Defaults
$id               = $id ?? 'projects-list';
$theme            = $theme ?? 'invert';
$filterSearch     = trim((string)($filterSearch ?? get('search') ?? get('q') ?? ''));
$filterSpace      = $filterSpace ?? get('space');
$filterIndustry   = $filterIndustry ?? get('industry');
$filterClient     = $filterClient ?? get('client');
$filterSolution   = $filterSolution ?? get('solution');
$filterProduction = $filterProduction ?? get('production');
$filterHash       = $filterHash ?? get('hash') ?? get('tag');
$filterYear       = $filterYear ?? get('year') ?? get('rok');
$filterGeneric    = $filterGeneric ?? get('filter');
$targetPage       = $page ?? page('projects');
$targetUrl        = $targetPage ? $targetPage->url() : url('projects');

// Parse active values into arrays of slugs
$filterSpaceSlugs      = array_values(array_filter(explode(',', (string)$filterSpace)));
$filterIndustrySlugs   = array_values(array_filter(explode(',', (string)$filterIndustry)));
$filterClientSlugs     = array_values(array_filter(explode(',', (string)$filterClient)));
$filterSolutionSlugs   = array_values(array_filter(explode(',', (string)$filterSolution)));
$filterProductionSlugs = array_values(array_filter(explode(',', (string)$filterProduction)));
$filterHashSlugs       = array_values(array_filter(explode(',', (string)$filterHash)));
$filterYearSlugs       = array_values(array_filter(explode(',', (string)$filterYear)));

// Build current query array
$currentQuery = [];
if (!empty($filterSpace))      $currentQuery['space']      = $filterSpace;
if (!empty($filterClient))     $currentQuery['client']     = $filterClient;
if (!empty($filterIndustry))   $currentQuery['industry']   = $filterIndustry;
if (!empty($filterSolution))   $currentQuery['solution']   = $filterSolution;
if (!empty($filterProduction)) $currentQuery['production'] = $filterProduction;
if (!empty($filterHash))       $currentQuery['hash']       = $filterHash;
if (!empty($filterYear))       $currentQuery['year']       = $filterYear;
if (!empty($filterGeneric))    $currentQuery['filter']     = $filterGeneric;
if (!empty($filterSearch))     $currentQuery['search']     = $filterSearch;

// Search clear URL
$clearSearchQuery = $currentQuery;
unset($clearSearchQuery['search'], $clearSearchQuery['q']);
$clearSearchUrl = $targetUrl . (!empty($clearSearchQuery) ? '?' . http_build_query($clearSearchQuery) : '');

// 3. Count detection and label formatting
$itemCount = null;
$countLabel = '';
if (!empty($isFiltered) && isset($images) && $images instanceof \Kirby\Cms\Collection) {
    $itemCount = $images->pagination()->total();
    $countLabel = $itemCount . ' ' . ($itemCount === 1 ? 'fotografie' : ($itemCount >= 2 && $itemCount <= 4 ? 'fotografie' : 'fotografií'));
} elseif (isset($projects) && $projects instanceof \Kirby\Cms\Collection) {
    $itemCount = $projects->pagination()->total();
    $countLabel = $itemCount . ' ' . ($itemCount === 1 ? 'realizace' : ($itemCount >= 2 && $itemCount <= 4 ? 'realizace' : 'realizací'));
} elseif (isset($items) && (is_countable($items) || is_array($items))) {
    $itemCount = count($items);
    $countLabel = $itemCount . ' ' . ($itemCount === 1 ? 'položka' : ($itemCount >= 2 && $itemCount <= 4 ? 'položky' : 'položek'));
}
?>

<section <?= $id ? 'id="' . esc($id) . '"' : '' ?> class="list radius relative z__2" theme="<?= $theme ?>">
	
	<?php if (!empty($tabs)) : ?>
		<!-- Optional Tab Navigation (Feed / Sub-tabs) -->
		<div class="list__tabs intro inner__4 inner-y__1 inner-t__3 flex align__center gap__1" data-ajax-filter-hero>
			<?php foreach ($tabs as $index => $tabItem) : ?>
				<?php if ($index > 0) : ?>
					<div class="w__03 h__03 bg__text op__4"></div>
				<?php endif ?>
				<h2 data-tab="<?= esc($tabItem['id']) ?>" class="cursor__pointer flex align__start gap__02 font__size__1">
					<span><?= esc($tabItem['label']) ?></span>
					<?php if (isset($tabItem['count']) && $tabItem['count'] !== null) : ?>
						<span class="font__size__small op__6" data-projects-count>(<?= $tabItem['count'] ?>)</span>
					<?php endif ?>
				</h2>
			<?php endforeach ?>
		</div>
	<?php endif ?>

	<!-- Unified Search & Filter Panel (Na pevno viditelný na stránce, bez lupy a bez horní dělící linky) -->
	<div id="project-filter-section" class="project-filter-section relative z__2" theme="invert" data-ajax-filter-panel>
		<div class="project-filter-inner inner__4 inner-y__2">
			<form action="<?= $targetUrl ?>" method="GET" class="project-filter__form grid gap__1" data-project-filter-form role="search">
				
				<!-- Row 1: Search Bar with Autocomplete (Zachovat náš našeptávač) -->
				<div class="project-filter__search-row relative" data-project-search data-api-url="<?= url('ajax/projects/search') ?>">
					<div class="project-filter__search-bar flex align__center justify__space-between">
						<input 
							type="text" 
							name="search" 
							value="<?= esc($filterSearch) ?>" 
							placeholder="<?= esc(t('search-projects-placeholder', 'Hledat klienta, prostor nebo obor...')) ?>" 
							autocomplete="off" 
							spellcheck="false"
							class="project-filter__input font__size__3"
							aria-label="<?= esc(t('search-projects', 'Hledat klienta, prostor nebo obor')) ?>"
						>
						<div class="project-filter__search-actions flex align__center gap__05">
							<div class="project-filter__spinner" aria-hidden="true"></div>
							<?php if (!empty($filterSearch)) : ?>
								<a href="<?= esc($clearSearchUrl) ?>" class="button circle --small" theme="ghost" hover="dark" data-ajax-filter="true" title="Vymazat hledání" aria-label="Vymazat hledání">
									<?= snippet('atoms/Icon', ['name' => 'close', 'css' => 'icon-close']) ?>
								</a>
							<?php endif ?>
						</div>
					</div>

					<div class="project-filter__autocomplete inner-t__05" data-search-list></div>
				</div>

				<!-- Row 2: Pills & Tags Row directly visible (klient, prostor, obor) -->
				<div class="project-filter__pills-row flex align__center justify__space-between gap__05 flex__wrap">
					<div class="project-header__dropdowns flex align__center gap__05 flex__wrap">
						<!-- Pill Dropdown: Klient -->
						<?php if (!empty($clients)) : ?>
							<?= snippet('molecules/Dropdown/filter', [ 
								'label'    => 'Klient', 
								'param'    => 'client',
								'options'  => $clients,
								'active'   => $filterClient ?? null,
								'theme'    => 'ghost',
								'formMode' => false
							]) ?> 
						<?php endif ?>

						<!-- Pill Dropdown: Prostor -->
						<?php if (!empty($spaces)) : ?>
							<?= snippet('molecules/Dropdown/filter', [ 
								'label'    => 'Prostor', 
								'param'    => 'space',
								'options'  => $spaces,
								'active'   => $filterSpace ?? null,
								'theme'    => 'ghost',
								'formMode' => false
							]) ?> 
						<?php endif ?>

						<!-- Pill Dropdown: Obor -->
						<?php if (!empty($industries)) : ?>
							<?= snippet('molecules/Dropdown/filter', [ 
								'label'    => 'Obor', 
								'param'    => 'industry',
								'options'  => $industries,
								'active'   => $filterIndustry ?? null,
								'theme'    => 'ghost',
								'formMode' => false
							]) ?> 
						<?php endif ?>

						<!-- Pill Dropdown: Služby -->
						<?php if (!empty($solutions)) : ?>
							<?= snippet('molecules/Dropdown/filter', [ 
								'label'    => 'Služby', 
								'param'    => 'solution',
								'options'  => $solutions,
								'active'   => $filterSolution ?? null,
								'theme'    => 'ghost',
								'formMode' => false
							]) ?> 
						<?php endif ?>

						<!-- Pill Dropdown: Rok -->
						<?php if (!empty($years)) : ?>
							<?= snippet('molecules/Dropdown/filter', [ 
								'label'    => 'Rok', 
								'param'    => 'year',
								'options'  => $years,
								'active'   => $filterYear ?? null,
								'theme'    => 'ghost',
								'formMode' => false
							]) ?> 
						<?php endif ?>

						<!-- Reset Button (jako při vyhledávání) -->
						<?php if (!empty($isFiltered)) : ?>
							<a 
								href="<?= esc($targetUrl) ?>" 
								class="button circle --small project-filter__clear-btn flex align__center justify__center" 
								theme="ghost" 
								hover="dark" 
								data-ajax-filter-reset="true" 
								title="<?= esc(t('reset-filters', 'Zrušit filtry')) ?>" 
								aria-label="<?= esc(t('reset-filters', 'Zrušit filtry')) ?>"
							>
								<?= snippet('atoms/Icon', ['name' => 'close', 'css' => 'icon-close']) ?>
							</a>
						<?php endif ?>
					</div>

					<!-- Right side: Count of results -->
					<?php if (!empty($countLabel)) : ?>
						<div class="project-filter__count font__size__small op__6" aria-live="polite">
							<span data-projects-count><?= esc($countLabel) ?></span>
						</div>
					<?php endif ?>
				</div>

			</form>
		</div>
	</div>

	<!-- 3. Projects / Images Grid (Morphed via [data-ajax-filter-list]) -->
	<div class="list__content" data-ajax-filter-list>
		<?php if (!empty($isFiltered) && isset($images)) : ?>
			<?php if ($images->isNotEmpty()) : ?>
				<ol class="grid__3 gap__2 gap-y__3 inner__4 inner-y__5 inner-t__2">
					<?php foreach ($images as $image) : ?>
						<?php $project = $image->parent(); ?>
						<div data-slide class="">	
							<?= snippet('molecules/Project/list', ['project' => $project, 'img' => $image]) ?>
						</div>
					<?php endforeach ?>
				</ol>
			<?php else : ?>
				<div class="inner__4 inner-y__5 inner-t__2 text__center justify__center gap__1">
					<p class="font__size__3 op__6"><?= t('search-no-results', 'Žádné projekty nebyly nalezeny') ?></p>
					<?= snippet('atoms/Button', [
						'url'   => $targetUrl,
						'label' => t('reset-filters', 'Zrušit filtry'),
						'theme' => 'light',
						'node'  => 'data-ajax-filter-reset'
					]) ?>
				</div>
			<?php endif ?>
		<?php else : ?>
			<?php if ($projects && $projects->isNotEmpty()) : ?>
				<ol class="grid__3 gap__2 gap-y__3 inner__4 inner-y__5 inner-t__2">
					<?php foreach ($projects as $project) : ?>
						<div data-slide class="">	
							<?= snippet('molecules/Project/list', compact('project')) ?>
						</div>
					<?php endforeach ?>
				</ol>
			<?php elseif (!empty($isFiltered)) : ?>
				<div class="inner__4 inner-y__5 text__center justify__center gap__1">
					<p class="font__size__3 op__6"><?= t('search-no-results', 'Žádné projekty nebyly nalezeny') ?></p>
					<?= snippet('atoms/Button', [
						'url'   => $targetUrl,
						'label' => t('reset-filters', 'Zrušit filtry'),
						'theme' => 'light',
						'node'  => 'data-ajax-filter-reset'
					]) ?>
				</div>
			<?php endif ?>
		<?php endif ?>
	</div>
</section>
