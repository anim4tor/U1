<?php
// Normalize hero input (podporuje Kirby Field i Blocks kolekci)
$hero ??= isset($page) ? $page->hero() : null;
$hasHero = false;
if ($hero instanceof \Kirby\Cms\Field) {
    $hasHero = $hero->toBlocks()->isNotEmpty();
} elseif ($hero instanceof \Kirby\Cms\Blocks) {
    $hasHero = $hero->isNotEmpty();
}

$cover = $cover ?? null;
if (!$cover && isset($coverImage) && $coverImage) {
    $cover = $coverImage;
} elseif (!$cover && isset($page) && $page->cover()->isNotEmpty()) {
    $cover = $page->cover()->toFile();
}

$css ??= '';
$info ??= null;
$text ??= null;
$titleSize ??= (isset($page) && in_array($page->intendedTemplate()->name(), ['post', 'article'])) ? 'font__size__large' : 'font__size__1';
$bottomRadius = isset($bottomRadius) ? (bool)$bottomRadius : true;
$gradientBottom = isset($gradientBottom) ? (bool)$gradientBottom : false;

$radiusClass = $bottomRadius ? 'radius' : 'radius-t radius-b__0';
$gradientClass = $gradientBottom ? 'intro--gradient-bottom' : '';
?>
<?php if ($hasHero || $cover || (isset($page) && $page->title()->isNotEmpty())) : ?>
<section class="intro <?= $radiusClass ?> <?= $gradientClass ?> <?= $css ?>" theme="dark" style="--in-delay: 500ms">
	<div class="intro__cover absolute inset__stretch grid overlay__harder" data-scroll>
		<?php if ($hasHero) : ?>
			<?= snippet('molecules/Header', ['header' => $hero, 'type' => ['cover']]) ?>
		<?php elseif ($cover) : ?>
			<?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => '']) ?>
		<?php endif ?>
	</div>
	<div data-scroll class="z__1 intro__header place__end-stretch grid__12 gap__2 mobile:grid__1 mobile:h__auto inner__4 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class="span__7 grid gap__1 place__end-start">
			<?php if (!empty($info)) : ?>
				<div class="intro__info label font__size__label" data-reveal="simple">
					<?= esc($info) ?>
				</div>
			<?php endif ?>
			<?php if ($hasHero) : ?>
				<?= snippet('molecules/Header', ['header' => $hero, 'type' => ['heading']]) ?>
			<?php else : ?>
				<h1 class="<?= esc($titleSize) ?>" data-reveal-text><?= $page->title() ?></h1>
			<?php endif ?>
		</div>
		<div></div>
		<div class="span__4 grid gap__1 place__end-start" style="--in-delay: 500ms">
			<?php if ($hasHero) : ?>
				<?= snippet('molecules/Header', ['header' => $hero, 'type' => ['text', 'button']]) ?>
			<?php elseif (!empty($text)) : ?>
				<p class="font__size__default op__8" data-reveal-text="lines"><?= $text ?></p>
			<?php elseif (isset($page) && $page->excerpt()->isNotEmpty()) : ?>
				<p class="font__size__default op__8" data-reveal-text="lines"><?= $page->excerpt()->inline() ?></p>
			<?php elseif (isset($page) && $page->date()->isNotEmpty()) : ?>
				<p class="font__size__small op__7">(<?= $page->date()->toDate('Y') ?>)</p>
			<?php endif ?>
		</div>
	</div>
</section>
<?php endif ?>
