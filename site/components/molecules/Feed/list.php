<?php
/**
 * Unified Feed List Item Molecule (Blog, Social, Media)
 */
$item = $item ?? $feed ?? $post ?? null;
if (!$item) return;

// 1. Detect item type
$type = $type ?? null;
if (!$type) {
    if (is_object($item) && method_exists($item, 'platform') && $item->platform()->isNotEmpty()) {
        $type = 'social';
    } elseif (is_object($item) && method_exists($item, 'intendedTemplate') && $item->intendedTemplate()->name() === 'project') {
        $type = 'media';
    } else {
        $type = 'blog';
    }
}

$isSocial = ($type === 'social');

// 2. Resolve URL and attributes
$url      = $isSocial ? (method_exists($item, 'social_url') ? $item->social_url()->value() : '#') : $item->url();
$target   = $isSocial ? '_blank' : null;
$rel      = $isSocial ? 'noopener noreferrer' : null;
$title    = $isSocial ? (method_exists($item, 'title') ? $item->title()->excerpt(200) : '') : $item->title();

// 3. Date / Meta
$dateText = null;
if (!$isSocial && method_exists($item, 'date') && $item->date()->isNotEmpty()) {
    $dateText = '(' . ($type === 'media' ? $item->date()->toDate('Y') : $item->date()->toDate('Y-m-d')) . ')';
}

// 4. Figure & Media
$coverFile = method_exists($item, 'cover') ? $item->cover()->toFile() : null;
$mediaUrl  = ($isSocial && method_exists($item, 'media_url')) ? $item->media_url()->value() : null;
$platform  = ($isSocial && method_exists($item, 'platform')) ? $item->platform()->value() : null;
$isVideo   = ($isSocial && method_exists($item, 'media_type')) ? ($item->media_type()->value() === 'VIDEO') : false;
?>

<div class="item --feed --feed-<?= esc($type) ?>" data-scroll>
	<a href="<?= esc($url) ?>" <?= $target ? 'target="' . esc($target) . '"' : '' ?> <?= $rel ? 'rel="' . esc($rel) . '"' : '' ?> class="grid gap__05 relative">
		<?php if ($coverFile) : ?>
			<div class="item__figure grid img__radius no__overflow">
				<?= snippet('atoms/Image', [
					'img'    => $coverFile, 
					'reveal' => true, 
					'css'    => 'vh__8 grid', 
					'node'   => 'data-reveal-image'
				]) ?>
			</div>
		<?php elseif ($mediaUrl) : ?>
			<div class="item__figure grid img__radius no__overflow relative color__invert">
				<figure class="overlay__bottom relative vh__8 grid">
					<img src="<?= esc($mediaUrl) ?>" alt="<?= esc($title) ?>" loading="lazy" class="w__full h__full object__cover vh__8 grid" data-reveal-image />
					<?php if ($platform) : ?>
						<div class="badge absolute bottom__1 right__1 z__1">
							<?= svg('public/assets/images/' . $platform . '.svg') ?>
						</div>
					<?php endif ?>
					<?php if ($isVideo) : ?>
						<span class="video-badge absolute top__1 right__1 z__1">▶ Video</span>
					<?php endif ?>
				</figure>
			</div>
		<?php endif ?>

		<div class="item__meta relative flex justify__space-between align__center gap__2">
			<div class="flex gap__05 upper">
				<h3 class="font__size__4 wrap <?= $type === 'media' ? 'ff__body' : '' ?>" data-reveal-text="lines"><?= $title ?></h3>
			</div>
			<?php if ($dateText) : ?>
				<p class="font__size__small op__7 no__wrap" data-reveal-text="lines"><?= $dateText ?></p>
			<?php endif ?>
		</div>
	</a>
</div>
