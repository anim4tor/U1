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
    if (!empty($filterIndustry) && !empty($industries)) {
        foreach ($industries as $item) {
            if (($item['slug'] ?? '') === $filterIndustry) {
                $activeLabels[] = $item['text'] ?? $item['name'] ?? $filterIndustry;
                break;
            }
        }
    }
    if (!empty($filterSpace) && !empty($spaces)) {
        foreach ($spaces as $item) {
            if (($item['slug'] ?? '') === $filterSpace) {
                $activeLabels[] = $item['text'] ?? $item['name'] ?? $filterSpace;
                break;
            }
        }
    }
    if (empty($activeLabels) && !empty($filterGeneric)) {
        $allTags = array_merge($industries ?? [], $spaces ?? []);
        foreach ($allTags as $item) {
            if (($item['slug'] ?? '') === $filterGeneric) {
                $activeLabels[] = $item['text'] ?? $item['name'] ?? $filterGeneric;
                break;
            }
        }
    }
    $activeHeading = !empty($activeLabels) ? implode(' / ', $activeLabels) : 'Filtrováno';
}
?>

<section <?= $id ? 'id="' . esc($id) . '"' : '' ?> class="intro relative z__2" theme="<?= $theme ?>" style="--in-delay: 500ms">
	<div class="z__1 relative intro__header inner-b__2 place__stretch-stretch grid__4 gap__2 mobile:grid__1 mobile:h__auto inner__4 mobile:inner-t__10 mobile:gap__2 relative">
		<div class="span__4 h__2"></div>
		<div class="span__4 inner-y__1 border__bottom flex justify__space-between align__end">
			<div class="span__2">
				<div class="flex align__start gap__02 inner-y__02">
					<?php if ($activeHeading) : ?>
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

					<?php if ($itemCount !== null) : ?>
						<?= snippet('atoms/Text', ['text' => '(' . $itemCount . ')', 'reveal' => true, 'css' => 'font__size__small']) ?>
					<?php endif ?>
				</div>
			</div>
			
			<div class="span__2 flex justify__end gap__05 align__center" data-scroll>
				<?php if (isset($controls)) : ?>
					<?= $controls ?>
				<?php elseif (!empty($industries) || !empty($spaces)) : ?>
					<div class="flex align__start gap__05">
						<?= snippet('atoms/Button', [ 
							'url'     => isset($page) ? $page->url() : '#', 
							'label'   => 'Vše', 
							'theme'   => empty($isFiltered) ? 'dark' : 'light', 
							'reveal'  => true
						]) ?>
						<?php if (!empty($industries)) : ?>
							<?= snippet('molecules/Dropdown/filter', [ 
								'label'   => 'Odvětví', 
								'param'   => 'industry',
								'options' => $industries,
								'active'  => $filterIndustry ?? null
							]) ?> 
						<?php endif ?>
						<?php if (!empty($spaces)) : ?>
							<?= snippet('molecules/Dropdown/filter', [ 
								'label'   => 'Prostory', 
								'param'   => 'space',
								'options' => $spaces,
								'active'  => $filterSpace ?? null
							]) ?> 
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
	</div>
</section>
