<?php
/**
 * Unified Feed List Item Molecule (Blog, Social, Media)
 */
$item = $item ?? $feed ?? $post ?? null;
if (!$item) return;

// 1. Detect item type
$type = $type ?? null;
if (!$type) {
    if ($item->content()->has('platform') && $item->platform()->isNotEmpty()) {
        $type = 'social';
    } elseif ($item->intendedTemplate()->name() === 'project') {
        $type = 'media';
    } else {
        $type = 'blog';
    }
}

$isSocial = ($type === 'social');

// 2. Resolve URL and attributes
$url      = $isSocial ? ($item->content()->has('social_url') ? $item->social_url()->value() : '#') : $item->url();
$target   = $isSocial ? '_blank' : null;
$rel      = $isSocial ? 'noopener noreferrer' : null;
$title    = $isSocial ? $item->title()->excerpt(200) : $item->title();

// 3. Meta data (similar to Project molecule)
$meta = [];

if ($type === 'media' || $item->intendedTemplate()->name() === 'project') {
    $meta = array_filter([
        $item->industry()->isNotEmpty() ? implode(', ', $item->industry()->split()) : null,
        $item->place()->isNotEmpty() ? $item->place()->value() : null,
        $item->date()->isNotEmpty() ? $item->date()->toDate('Y') : null,
    ]);
} elseif ($isSocial) {
    $socialDate = null;
    if ($item->content()->has('date') && $item->date()->isNotEmpty()) {
        $socialDate = $item->date()->toDate('j. n. Y');
    } elseif ($item->content()->has('timestamp') && $item->timestamp()->isNotEmpty()) {
        $socialDate = date('j. n. Y', strtotime($item->timestamp()->value()));
    }
    $meta = array_filter([
        $item->content()->has('platform') && $item->platform()->isNotEmpty() ? ucfirst($item->platform()->value()) : null,
        $socialDate,
    ]);
} else {
    // Blog / Post
    $category = null;
    if ($item->content()->has('category') && $item->category()->isNotEmpty()) {
        $category = $item->category()->value();
    } elseif ($item->content()->has('topic') && $item->topic()->isNotEmpty()) {
        $category = $item->topic()->value();
    } elseif ($item->content()->has('tags') && $item->tags()->isNotEmpty()) {
        $category = implode(', ', $item->tags()->split());
    }

    $authorName = null;
    if ($item->content()->has('author') && $item->author()->isNotEmpty()) {
        $author = $item->author()->toUser();
        $authorName = $author ? $author->name() : $item->author()->value();
    }

    $dateVal = null;
    if ($item->content()->has('date') && $item->date()->isNotEmpty()) {
        $dateVal = $item->date()->toDate('j. n. Y');
    }

    $meta = array_filter([
        $category,
        $authorName,
        $dateVal,
    ]);
}

// 4. Figure & Media
$coverFile = $item->cover()->toFile();
$mediaUrl  = $isSocial && $item->content()->has('media_url') ? $item->media_url()->value() : null;
$platform  = $isSocial && $item->content()->has('platform') ? $item->platform()->value() : null;
$isVideo   = $isSocial && $item->content()->has('media_type') && ($item->media_type()->value() === 'VIDEO');

?>

<div class="item --feed --feed-<?= esc($type) ?>" data-scroll>
	<a href="<?= esc($url) ?>" <?= $target ? 'target="' . esc($target) . '"' : '' ?> <?= $rel ? 'rel="' . esc($rel) . '"' : '' ?> class="grid gap__1 relative">
		<?php if ($coverFile || $mediaUrl) : ?>
			<div class="item__figure grid img__radius no__overflow relative <?= $isSocial ? 'color__invert' : '' ?>">
				<?= snippet('atoms/Image', [
					'img'    => $coverFile,
					'url'    => $mediaUrl,
					'reveal' => true, 
					'css'    => 'aspect__4/3' . ($isSocial ? ' overlay__bottom' : ''), 
					'node'   => 'data-reveal-image'
				]) ?>
				<?php if ($isSocial && $platform) : ?>
					<div class="badge absolute bottom__1 right__1 z__1">
						<?= svg('public/assets/images/' . $platform . '.svg') ?>
					</div>
				<?php endif ?>
				<?php if ($isSocial && $isVideo) : ?>
					<span class="video-badge absolute top__1 right__1 z__1">▶ Video</span>
				<?php endif ?>
			</div>
		<?php endif ?>
		<div class="item__meta relative grid gap__05">
			<?php if (!empty($meta)) : ?>
				<div class="font__size__small op__7"><?= implode(' · ', $meta) ?></div>
			<?php endif ?>
			<h3 class="wrap inner-r__2"><?= $title ?></h3>
		</div>
	</a>
</div>
