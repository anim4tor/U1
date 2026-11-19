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

$info = $category . ($dateStr ? ' · ' . $dateStr : '') . ($readTime ? ' · ' . $readTime : '');
?>

<!-- Hero sekce článku -->
<?= snippet('sections/Hero', [
	'text'      => $info,
	'cover'     => $cover,
	'titleSize' => 'font__size__2'
]) ?>

<!-- Tělo článku (Editorial bloky) -->
<article class="post-article radius" theme="invert" aria-label="Text článku">
	<div class="inner-x__4 inner-y__5 mobile:inner-y__3">
		<div class="post-body grid gap__3">
			
			<?php if ($page->excerpt()->isNotEmpty()): ?>
				<div class="post-block-content mobile:inner-x__1" data-scroll>
					<p class="font__size__3 font__weight__500"><?= $perex ?></p>
				</div>
			<?php endif ?>

			<div class="grid">
				<!-- Editorial bloky -->
				<?php if ($page->details()->isNotEmpty()): ?>
					<?php foreach ($page->details()->toBlocks() as $block): ?>
						<?php if ($block->type() === 'image'): ?>
							<?php if ($block->image()->toFile()): ?>
								<div class="post-block-bleed">
									<?= $block ?>
								</div>
							<?php endif ?>
						<?php else: ?>
							<div class="post-block-content mobile:inner-x__1">
								<?= $block ?>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				<?php endif ?>
			</div>

			<!-- Poznámka pod čarou / Zdroje -->
			<?php if ($page->footnote()->isNotEmpty()): ?>
				<div class="post-block-content mobile:inner-x__1">
					<div class="post-footnote border__top inner-t__1 inner-b__1 font__size__small op__7">
						<?= $page->footnote()->kt() ?>
					</div>
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
