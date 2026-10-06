<?php
$quoteLabel  = $page->quoteLabel()->or(t('testimonials', 'CITÁT'));
$quoteAuthor = $page->quoteAuthor()->or('David L., provozní manažer');
$quoteText   = $page->quoteText()->or('Dvacet pět let zkušeností promítnutých do ucelených architektonických a designových řešení vytvářejících prostředí, které podporuje radost ze společných okamžiků.');
$quoteImage  = $page->quoteImage()->toFile() ?? $page->file('david.webp');
?>
<section class="quote u1-block" theme="dark">
	<div class="u1-type-1 u1-type-1--reverse">
		<!-- Left (Mirrored): Photo 4:3 (6 cols) -->
		<div class="u1-type-1__col-media" data-scroll>
			<?php if ($quoteImage) : ?>
				<div class="u1-photo" data-reveal-image>
					<?= snippet('atoms/Image', ['img' => $quoteImage, 'reveal' => false, 'css' => 'w__full h__full']) ?>
				</div>
			<?php endif ?>
		</div>

		<!-- Right (Mirrored): Text (6 cols) -->
		<div class="u1-type-1__col-text">
			<div class="u1-type-1__top" data-scroll>
				<div class="u1-header">
					<div class="u1-label"><?= $quoteLabel ?></div>
					<div class="u1-type-1__quote" data-reveal-text="lines">“<?= $quoteText ?>”</div>
				</div>
			</div>

			<div class="u1-type-1__bottom" data-scroll>
				<div class="u1-label op__7"><?= $quoteAuthor ?></div>
			</div>
		</div>
	</div>
</section>
