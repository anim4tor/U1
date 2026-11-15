<?php
/**
 * Šablona: Detail Článku / Post (podle v65 clanek-*.html)
 */
$cover = $page->cover()->toFile() 
    ?? site()->images()->filterBy('name', '*=', 'studio')->first() 
    ?? site()->images()->first();

$dateStr = $page->date()->isNotEmpty() ? $page->date()->toDate('d. m. Y') : null;
$readTime = $page->readTime()->or('5 min čtení');
$category = $page->category()->isNotEmpty() ? (is_array($page->category()->value()) ? implode(', ', $page->category()->value()) : $page->category()->value()) : 'Články';

$perex = $page->excerpt()->isNotEmpty() ? $page->excerpt()->inline() : null;

// FAQ položky
$faqs = $page->faq()->toStructure();

// Související realizace
$relatedProjects = $page->related()->toPages();
?>

<!-- Hero sekce článku -->
<section class="intro radius" theme="dark" style="--in-delay: 500ms">
	<div class="intro__cover absolute inset__stretch grid overlay__harder" data-scroll>
		<?php if ($cover) : ?>
			<?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => '']) ?>
		<?php endif ?>
	</div>
	<div data-scroll class="z__1 intro__header place__stretch-stretch grid__4 intro__rows mobile:grid__1 h__100v mobile:h__auto inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class=""></div>
		<div class="span__4 grid__2 place__space-between-stretch mobile:grid__1">
			<div class="span__2 h__5 place__start-start grid__4 gap__2 border__top inner-t__05 mobile:span__1">
				<?= snippet('atoms/Label', [
					'text' => $category . ($dateStr ? ' · ' . $dateStr : '') . ($readTime ? ' · ' . $readTime : ''),
					'css'  => 'span__2'
				]) ?>
			</div>
			<div class="intro__title relative place__end-stretch mobile:span__1 inner-y__05 grid gap__1" style="--in-delay: 500ms">
				<h1 class="font__size__1" data-reveal-text><?= $page->title() ?></h1>
				<?php if ($perex): ?>
					<p class="font__size__default op__8 max-w__6" data-reveal-text="lines"><?= $perex ?></p>
				<?php endif ?>
			</div>
		</div>
	</div>
</section>

<!-- Tělo článku (Editorial bloky) -->
<article class="post-article radius" theme="invert" aria-label="Text článku">
	<div class="inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3">
		<div class="post-body grid gap__2" data-scroll>
			
			<!-- Editorial bloky -->
			<?php if ($page->details()->isNotEmpty()): ?>
				<?= snippet('molecules/Blocks', ['blocks' => $page->details()->toBlocks()]) ?>
			<?php elseif ($perex): ?>
				<div class="font__size__default leading__relaxed">
					<p><?= $perex ?></p>
				</div>
			<?php endif ?>

			<!-- Poznámka pod čarou / Zdroje -->
			<?php if ($page->footnote()->isNotEmpty()): ?>
				<div class="post-footnote border__top inner-t__1 inner-b__1 font__size__small op__7">
					<?= $page->footnote()->kt() ?>
				</div>
			<?php endif ?>

		</div>
	</div>
</article>

<!-- Časté otázky k tématu článku (pokud jsou vyplněny) -->
<?php if ($faqs->isNotEmpty()): ?>
<section class="faq radius" theme="invert" data-scroll aria-labelledby="post-faq-heading">
	<div class="grid__4 gap__2 inner-x__4 inner-y__5 mobile:grid__1 mobile:inner-x__1 mobile:inner-y__3">
		<div class="span__2 grid gap__1 place__start-start">
			<h2 id="post-faq-heading" class="font__size__2"><?= esc($page->faqHeadline()->or('Časté otázky')) ?></h2>
		</div>
		<div class="span__2 grid gap__1">
			<ol class="faq__list grid" data-scroll data-collapsibles="true">
				<?php foreach ($faqs as $item): ?>
					<?= snippet('molecules/Collapsible', ['item' => $item, 'list' => $faqs]) ?>
				<?php endforeach ?>
				<div class="border__top"></div>
			</ol>
			<?php if ($page->faqNote()->isNotEmpty()): ?>
				<p class="inner-t__1 font__size__small op__5"><?= esc($page->faqNote()) ?></p>
			<?php endif ?>
		</div>
	</div>
</section>
<?php endif ?>

<!-- Související realizace (pokud jsou vybrány) -->
<?php if ($relatedProjects->isNotEmpty()): ?>
	<?= snippet('sections/Projects/related', [
		'projects' => $relatedProjects,
		'title'    => 'Související realizace',
		'theme'    => 'dark'
	]) ?>
<?php endif ?>

<!-- Další články -->
<?= snippet('sections/Feed/related') ?>

<!-- Výzva / CTA -->
<?= snippet('sections/Cta') ?>
