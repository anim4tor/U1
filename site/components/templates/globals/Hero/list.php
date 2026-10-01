<?php
/**
 * Global List Hero Snippet
 * Used across list templates: Services, Positions, Projects, Feed
 */

// 1. Inputs & Defaults
$id         = $id ?? null;
$theme      = $theme ?? 'invert';
$hero       = $hero ?? (isset($page) ? $page->hero() : null);
$hasBlocks  = ($hero instanceof \Kirby\Cms\Blocks && $hero->isNotEmpty()) 
              || ($hero instanceof \Kirby\Cms\Field && $hero->toBlocks()->isNotEmpty());

// 2. Count detection (supports explicit $count, or auto-detecting collection objects)
$itemCount = null;
if (isset($count) && $count !== null && $count !== false) {
    $itemCount = $count;
} elseif (isset($jobs) && $jobs instanceof \Kirby\Cms\Collection) {
    $itemCount = $jobs->count();
} elseif (isset($projects) && $projects instanceof \Kirby\Cms\Collection) {
    $itemCount = (!empty($isFiltered) && isset($images)) ? $images->pagination()->total() : $projects->pagination()->total();
} elseif (isset($solutions) && $solutions instanceof \Kirby\Cms\Collection) {
    $itemCount = $solutions->count();
} elseif (isset($items) && (is_countable($items) || is_array($items))) {
    $itemCount = count($items);
}

// 3. Filter Label Calculation (for filterable lists like Projects)
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

<section <?= $id ? 'id="' . esc($id) . '"' : '' ?> class="intro relative z__2" theme="<?= $theme ?>" style="--in-delay: 500ms" data-ajax-filter-hero>
	<div class="z__1 relative intro__header inner-b__2 place__stretch-stretch grid__4 gap__2 mobile:grid__1 mobile:h__auto inner__4 mobile:inner-t__10 mobile:gap__2 relative">
		<div class="span__4 h__2"></div>
		<div class="span__4 inner-y__1 border__bottom flex justify__space-between align__end">
			<div class="span__3">
				<div class="flex align__start gap__02 inner-y__02">
					<?php if (!empty($tabs)) : ?>
						<div class="flex align__center gap__1" data-scroll>
							<?php foreach ($tabs as $index => $tabItem) : ?>
								<?php if ($index > 0) : ?>
									<div class="w__03 h__03 bg__text op__4"></div>
								<?php endif ?>
								<h1 data-tab="<?= esc($tabItem['id']) ?>" class="cursor__pointer flex align__start gap__02 font__size__1" data-reveal-text>
									<span><?= esc($tabItem['label']) ?></span>
									<?php if (isset($tabItem['count']) && $tabItem['count'] !== null) : ?>
										<span class="font__size__small op__6">(<?= $tabItem['count'] ?>)</span>
									<?php endif ?>
								</h1>
							<?php endforeach ?>
						</div>
					<?php elseif ($activeHeading) : ?>
						<?= snippet('atoms/Heading', [
							'text'   => $activeHeading, 
							'level'  => 'h1',
							'reveal' => true
						]) ?>
					<?php elseif (isset($title) && !empty($title)) : ?>
						<?= snippet('atoms/Heading', [
							'text'   => $title, 
							'level'  => 'h1',
							'reveal' => true
						]) ?>
					<?php elseif ($hasBlocks) : ?>
						<?= snippet('molecules/Header', ['header' => $hero, 'type' => ['heading', 'label']]) ?>
					<?php else : ?>
						<?= snippet('atoms/Heading', [
							'text'   => isset($page) ? $page->title()->value() : '', 
							'level'  => 'h1',
							'reveal' => true
						]) ?>
					<?php endif ?>

					<?php if (empty($tabs) && $itemCount !== null) : ?>
						<?= snippet('atoms/Label', ['text' => $itemCount]) ?>
					<?php endif ?>
				</div>
			</div>
			
			<div class="span__1 flex justify__end gap__02 align__center" data-scroll>
				<?php if (isset($controls)) : ?>
					<?= $controls ?>
				<?php elseif (!empty($industries) || !empty($spaces)) : ?>
					<div class="flex align__center gap__02 flex__wrap">
						<?php if (!empty($isFiltered)) : ?>
							<?= snippet('atoms/Button', [ 
								'url'     => isset($page) ? $page->url() : '#', 
								'label'   => 'Reset', 
								'theme'   => 'light', 
								'reveal'  => true,
								'node'    => 'data-ajax-filter-reset'
							]) ?>
						<?php endif ?>
						<?php if (!empty($industries)) : ?>
							<?= snippet('molecules/Dropdown/filter', [ 
								'label'   => 'Odvětví', 
								'param'   => 'industry',
								'options' => $industries,
								'active'  => $filterIndustry ?? null,
								'theme'   => 'ghost'
							]) ?> 
						<?php endif ?>
						<?php if (!empty($spaces)) : ?>
							<?= snippet('molecules/Dropdown/filter', [ 
								'label'   => 'Prostory', 
								'param'   => 'space',
								'options' => $spaces,
								'active'  => $filterSpace ?? null,
								'theme'   => 'ghost'
							]) ?> 
						<?php endif ?>
						<?php if (!empty($searchable)) : ?>
							<button 
								type="button" 
								class="button circle project-search__trigger <?= !empty($filterSearch) ? 'is-active' : '' ?>" 
								theme="<?= ($theme === 'dark') ? 'invert-ghost' : 'ghost' ?>" 
								hover="dark"
								data-search-trigger
								aria-label="<?= esc(t('search-projects', 'Hledat prostor, odvětví...')) ?>" 
								aria-expanded="<?= !empty($filterSearch) ? 'true' : 'false' ?>"
								title="<?= esc(t('search-projects', 'Hledat prostor, odvětví...')) ?>"
							>
								<?= snippet('atoms/Icon', ['name' => 'search', 'css' => 'icon-search']) ?>
								<?= snippet('atoms/Icon', ['name' => 'close', 'css' => 'icon-close']) ?>
							</button>
						<?php endif ?>
					</div>
				<?php elseif (!empty($nav)) : ?>
					<div class="flex align__center gap__1">
						<?php foreach ($nav as $navItem) : ?>
							<a data-scroll-to href="<?= $navItem['url'] ?>" class="font__size__3 ff__heading op__4" data-reveal-text>
								<?= $navItem['label'] ?>
							</a>
						<?php endforeach ?>
					</div>
				<?php endif ?>
			</div>
		</div>

		<?php if (!empty($searchable)) : ?>
			<div class="span__4 project-search__panel-wrapper <?= !empty($filterSearch) ? 'is-open' : '' ?>" data-search-panel-wrapper>
				<?= snippet('molecules/Search', [
					'theme' => ($theme === 'dark') ? 'dark' : 'light',
					'url'   => isset($page) ? $page->url() : url('projects'),
					'query' => $filterSearch ?? '',
				]) ?>
			</div>
		<?php endif ?>
	</div>
</section>
