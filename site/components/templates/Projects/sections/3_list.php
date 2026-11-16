<?php
/**
 * Projects List Section (Filtration Bar & Trigger + Expandable Panel under Trigger + Grid)
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
$filterSolution   = $filterSolution ?? get('solution');
$filterProduction = $filterProduction ?? get('production');
$filterHash       = $filterHash ?? get('hash') ?? get('tag');
$filterYear       = $filterYear ?? get('year') ?? get('rok');
$filterGeneric    = $filterGeneric ?? get('filter');
$targetPage       = $page ?? page('projects');
$targetUrl        = $targetPage ? $targetPage->url() : url('projects');

// 3. Count detection
$itemCount = null;
if (isset($count) && $count !== null && $count !== false) {
    $itemCount = $count;
} elseif (!empty($isFiltered) && isset($images) && $images instanceof \Kirby\Cms\Collection) {
    $itemCount = $images->pagination()->total();
} elseif (isset($projects) && $projects instanceof \Kirby\Cms\Collection) {
    $itemCount = $projects->pagination()->total();
} elseif (isset($items) && (is_countable($items) || is_array($items))) {
    $itemCount = count($items);
}

// 4. Filter Label Calculation (fallback when activeTokens is empty)
$activeHeading = null;
if (!empty($isFiltered)) {
    $activeLabels = [];
    if (!empty($filterIndustry)) {
        $indSlug = \Kirby\Toolkit\Str::slug($filterIndustry);
        $found = false;
        if (!empty($industries)) {
            foreach ($industries as $item) {
                if (($item['slug'] ?? '') === $indSlug || ($item['text'] ?? '') === $filterIndustry) {
                    $activeLabels[] = $item['text'] ?? $item['name'] ?? $filterIndustry;
                    $found = true;
                    break;
                }
            }
        }
        if (!$found) {
            $activeLabels[] = ucfirst(str_replace('-', ' ', $filterIndustry));
        }
    }
    if (!empty($filterSpace)) {
        $spaceSlug = \Kirby\Toolkit\Str::slug($filterSpace);
        $found = false;
        if (!empty($spaces)) {
            foreach ($spaces as $item) {
                if (($item['slug'] ?? '') === $spaceSlug || ($item['text'] ?? '') === $filterSpace) {
                    $activeLabels[] = $item['text'] ?? $item['name'] ?? $filterSpace;
                    $found = true;
                    break;
                }
            }
        }
        if (!$found) {
            $activeLabels[] = ucfirst(str_replace('-', ' ', $filterSpace));
        }
    }
    if (empty($activeLabels) && !empty($filterGeneric)) {
        $genSlug = \Kirby\Toolkit\Str::slug($filterGeneric);
        $allTags = array_merge($industries ?? [], $spaces ?? []);
        $found = false;
        foreach ($allTags as $item) {
            if (($item['slug'] ?? '') === $genSlug || ($item['text'] ?? '') === $filterGeneric) {
                $activeLabels[] = $item['text'] ?? $item['name'] ?? $filterGeneric;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $activeLabels[] = ucfirst(str_replace('-', ' ', $filterGeneric));
        }
    }
    if (!empty($filterSearch)) {
        $activeLabels[] = '„' . $filterSearch . '“';
    }
    $activeHeading = !empty($activeLabels) ? implode(' / ', $activeLabels) : 'Filtrováno';
}
?>

<section <?= $id ? 'id="' . esc($id) . '"' : '' ?> class="list radius relative z__2" theme="<?= $theme ?>">
	
	<!-- 1. Filtration Bar & Trigger (Morphed via [data-ajax-filter-hero]) -->
	<div class="list__header intro inner__4 inner-y__1 border__bottom flex justify__space-between align__center mobile:gap__2 flex__wrap" data-ajax-filter-hero>
		<div class="flex align__center gap__2 flex__wrap">
			<div class="flex align__start gap__02 inner-y__02">
				<?php if (!empty($tabs)) : ?>
					<div class="flex align__center gap__1" data-scroll>
						<?php foreach ($tabs as $index => $tabItem) : ?>
							<?php if ($index > 0) : ?>
								<div class="w__03 h__03 bg__text op__4"></div>
							<?php endif ?>
							<h2 data-tab="<?= esc($tabItem['id']) ?>" class="cursor__pointer flex align__start gap__02 font__size__1" data-reveal-text>
								<span><?= esc($tabItem['label']) ?></span>
								<?php if (isset($tabItem['count']) && $tabItem['count'] !== null) : ?>
									<span class="font__size__small op__6" data-projects-count>(<?= $tabItem['count'] ?>)</span>
								<?php endif ?>
							</h2>
						<?php endforeach ?>
					</div>
				<?php else : ?>
					<h2 class="flex align__start gap__02 font__size__1" data-reveal-text>
						<span><?= esc(isset($title) && !empty($title) ? $title : (isset($page) ? $page->title()->value() : 'Realizace')) ?></span>
						<?php if ($itemCount !== null) : ?>
							<span class="font__size__small op__6" data-projects-count>(<?= $itemCount ?>)</span>
						<?php endif ?>
					</h2>
				<?php endif ?>
			</div>

			<!-- Top 3 Filter Dropdowns directly in the bar -->
			<div class="project-header__dropdowns flex align__center gap__05 flex__wrap">
				<?php if (!empty($spaces)) : ?>
					<?= snippet('molecules/Dropdown/filter', [ 
						'label'    => 'Prostory', 
						'param'    => 'space',
						'options'  => $spaces,
						'active'   => $filterSpace ?? null,
						'theme'    => 'ghost',
						'formMode' => false
					]) ?> 
				<?php endif ?>

				<?php if (!empty($industries)) : ?>
					<?= snippet('molecules/Dropdown/filter', [ 
						'label'    => 'Odvětví', 
						'param'    => 'industry',
						'options'  => $industries,
						'active'   => $filterIndustry ?? null,
						'theme'    => 'ghost',
						'formMode' => false
					]) ?> 
				<?php endif ?>

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
			</div>
		</div>
		
		<div class="flex justify__end gap__02 align__center" data-scroll>
			<?php if (isset($controls)) : ?>
				<?= $controls ?>
			<?php else : ?>
				<div class="flex align__center gap__02 flex__wrap">
					<?php if (!empty($isFiltered)) : ?>
						<a 
							href="<?= $targetUrl ?>" 
							class="button circle project-filter__reset" 
							theme="ghost" 
							hover="dark" 
							title="Resetovat filtry" 
							aria-label="Resetovat filtry" 
							data-ajax-filter-reset
						>
							<?= snippet('atoms/Icon', ['name' => 'close', 'css' => 'icon-close']) ?>
						</a>
					<?php endif ?>

					<button 
						type="button" 
						class="button circle project-search__trigger <?= !empty($isFiltered) ? 'has-filter' : '' ?>" 
						theme="<?= !empty($isFiltered) ? 'acc' : (($theme === 'dark') ? 'invert-ghost' : 'ghost') ?>" 
						hover="<?= !empty($isFiltered) ? 'acc' : 'dark' ?>"
						data-search-trigger
						data-filter-trigger
						aria-label="<?= esc(t('search-projects', 'Hledat prostor, odvětví...')) ?>" 
						aria-expanded="false"
						title="<?= esc(t('search-projects', 'Hledat prostor, odvětví...')) ?>"
					>
						<?= snippet('atoms/Icon', ['name' => 'filter', 'css' => 'icon-filter']) ?>
						<?= snippet('atoms/Icon', ['name' => 'close', 'css' => 'icon-close']) ?>
					</button>
				</div>
			<?php endif ?>
		</div>
	</div>

	<!-- 2. Expandable Filter Panel - Opens directly under the trigger (Morphed via [data-ajax-filter-panel]) -->
	<div id="project-filter-section" class="project-filter-section relative z__2" theme="light" data-ajax-filter-panel>
		<div class="project-filter-inner inner__4 inner-y__2 border__bottom">
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
							class="project-filter__input font__size__3"
							aria-label="<?= esc(t('search-projects', 'Hledat prostor, odvětví, klienta...')) ?>"
						>
						<div class="project-filter__search-actions flex align__center gap__05">
							<div class="project-filter__spinner" aria-hidden="true"></div>
						</div>
					</div>

					<div class="project-filter__autocomplete inner-t__05" data-search-list></div>
				</div>

				<!-- Row 2: Filter Dropdowns and Submit Button -->
				<div class="project-filter__dropdowns-row flex align__center gap__05 flex__wrap" data-scroll>
					<?php if (!empty($spaces)) : ?>
						<?= snippet('molecules/Dropdown/filter', [ 
							'label'    => 'Prostory', 
							'param'    => 'space',
							'options'  => $spaces,
							'active'   => $filterSpace ?? null,
							'theme'    => 'ghost',
							'formMode' => false
						]) ?> 
					<?php endif ?>

					<?php if (!empty($industries)) : ?>
						<?= snippet('molecules/Dropdown/filter', [ 
							'label'    => 'Odvětví', 
							'param'    => 'industry',
							'options'  => $industries,
							'active'   => $filterIndustry ?? null,
							'theme'    => 'ghost',
							'formMode' => false
						]) ?> 
					<?php endif ?>

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

					<?php if (!empty($productions)) : ?>
						<?= snippet('molecules/Dropdown/filter', [ 
							'label'    => 'Výroba', 
							'param'    => 'production',
							'options'  => $productions,
							'active'   => $filterProduction ?? null,
							'theme'    => 'ghost',
							'formMode' => false
						]) ?> 
					<?php endif ?>

					<?php if (!empty($hashes)) : ?>
						<?= snippet('molecules/Dropdown/filter', [ 
							'label'    => 'Hashtagy', 
							'param'    => 'hash',
							'options'  => $hashes,
							'active'   => $filterHash ?? null,
							'theme'    => 'ghost',
							'formMode' => false
						]) ?> 
					<?php endif ?>

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

					<div class="project-filter__actions-wrap flex align__center gap__05">
						<?php if (!empty($isFiltered)) : ?>
							<a 
								href="<?= $targetUrl ?>" 
								class="button circle project-filter__reset" 
								theme="ghost" 
								hover="dark" 
								title="Resetovat filtry" 
								aria-label="Resetovat filtry" 
								data-ajax-filter-reset
							>
								<?= snippet('atoms/Icon', ['name' => 'close', 'css' => 'icon-close']) ?>
							</a>
						<?php endif ?>
					</div>
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
