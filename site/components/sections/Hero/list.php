<?php
/**
 * Global List Hero Snippet
 * Used across list templates: Services, Positions, Feed
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
} elseif (isset($solutions) && $solutions instanceof \Kirby\Cms\Collection) {
    $itemCount = $solutions->count();
} elseif (isset($items) && (is_countable($items) || is_array($items))) {
    $itemCount = count($items);
}
?>

<section <?= $id ? 'id="' . esc($id) . '"' : '' ?> class="intro relative z__2 radius" theme="<?= $theme ?>" style="--in-delay: 500ms">
	<div class="z__1 relative intro__header place__stretch-stretch grid__4 gap__2 mobile:grid__1 mobile:h__auto inner__4 inner-b__0 mobile:inner-t__10 mobile:gap__2 relative">
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
					<?php elseif (isset($title) && !empty($title)) : ?>
						<h1 class="flex align__start gap__02 font__size__1" data-reveal-text>
							<span><?= esc($title) ?></span>
							<?php if ($itemCount !== null) : ?>
								<span class="font__size__small op__6">(<?= $itemCount ?>)</span>
							<?php endif ?>
						</h1>
					<?php elseif ($hasBlocks) : ?>
						<?= snippet('molecules/Header', ['header' => $hero, 'type' => ['heading', 'label']]) ?>
					<?php else : ?>
						<h1 class="flex align__start gap__02 font__size__1" data-reveal-text>
							<span><?= esc(isset($page) ? $page->title()->value() : '') ?></span>
							<?php if ($itemCount !== null) : ?>
								<span class="font__size__small op__6">(<?= $itemCount ?>)</span>
							<?php endif ?>
						</h1>
					<?php endif ?>
				</div>
			</div>
			
			<div class="span__1 flex justify__end gap__02 align__center" data-scroll>
				<?php if (isset($controls)) : ?>
					<?= $controls ?>
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
