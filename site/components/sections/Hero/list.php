<?php
/**
 * Global List Hero Snippet
 * Used across list templates: Services, Positions, Feed
 * Styled according to sections/Hero/index with preserved Feed tabs & functions
 */

// 1. Inputs & Defaults
$id         = $id ?? null;
$theme      = $theme ?? 'dark';
$hero       = $hero ?? (isset($page) ? $page->hero() : null);
$hasHero    = false;
if ($hero instanceof \Kirby\Cms\Field) {
    $hasHero = $hero->toBlocks()->isNotEmpty();
} elseif ($hero instanceof \Kirby\Cms\Blocks) {
    $hasHero = $hero->isNotEmpty();
}

$cover = null;
if (isset($cover) && $cover instanceof \Kirby\Cms\File) {
    // Already resolved file
} elseif (isset($cover) && is_string($cover) && isset($page)) {
    $cover = $page->file($cover);
} elseif (isset($page) && $page->cover()->isNotEmpty()) {
    $cover = $page->cover()->toFile();
}

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

<section <?= $id ? 'id="' . esc($id) . '"' : '' ?> class="intro radius" theme="<?= $theme ?>" style="--in-delay: 500ms">
	<div class="intro__cover absolute inset__stretch grid overlay__harder" data-scroll>
		<?php if ($hasHero) : ?>
			<?= snippet('molecules/Header', ['header' => $hero, 'type' => ['cover']]) ?>
		<?php elseif ($cover) : ?>
			<?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => '']) ?>
		<?php endif ?>
	</div>
	<div data-scroll class="z__1 intro__header place__end-stretch grid__6 gap__2 mobile:grid__1 mobile:h__auto inner__4 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class="span__3 grid gap__1 place__end-start mobile:span__1">
			<?php if (!empty($tabs)) : ?>
				<div class="flex align__center gap__1 flex__wrap hero-tabs" data-scroll>
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
			<?php elseif ($hasHero) : ?>
				<?= snippet('molecules/Header', ['header' => $hero, 'type' => ['heading', 'label']]) ?>
			<?php else : ?>
				<h1 class="font__size__1 flex align__start gap__02" data-reveal-text>
					<span><?= esc(isset($page) ? $page->title()->value() : '') ?></span>
					<?php if ($itemCount !== null) : ?>
						<span class="font__size__small op__6">(<?= $itemCount ?>)</span>
					<?php endif ?>
				</h1>
			<?php endif ?>
		</div>

		<div></div>

		<div class="span__2 grid gap__1 place__end-start mobile:span__1" style="--in-delay: 500ms">
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
			<?php elseif ($hasHero) : ?>
				<?= snippet('molecules/Header', ['header' => $hero, 'type' => ['text', 'button']]) ?>
			<?php elseif (isset($page) && $page->date()->isNotEmpty()) : ?>
				<p class="font__size__small op__7">(<?= $page->date()->toDate('Y') ?>)</p>
			<?php endif ?>
		</div>
	</div>
</section>
