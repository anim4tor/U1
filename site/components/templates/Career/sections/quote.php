<?php
$quoteLabel  = $page->quoteLabel()->or(t('testimonials', 'Citát'));
$quoteAuthor = $page->quoteAuthor()->or('David L., provozní manažer');
$quoteText   = $page->quoteText()->or('Dvacet pět let zkušeností promítnutých do ucelených architektonických a designových řešení vytvářejících prostředí, které podporuje radost ze společných okamžiků.');
$quoteImage  = $page->quoteImage()->toFile() ?? $page->file('david.webp');
?>
<section class="quote radius" theme="dark">
	<div class="grid__4 gap__2 place__stretch-stretch inner__4 mobile:grid__1 mobile:inner__2">
		<div class="span__2 grid mobile:span__1" data-scroll>
			<?php if ($quoteImage) : ?>
				<div class="grid" data-reveal-image>
					<?= snippet('atoms/Image', ['img' => $quoteImage, 'reveal' => false, 'css' => 'aspect__5/4']) ?>
				</div>
			<?php endif ?>
		</div>
		<div class="span__2 grid gap__5 place__space-between-start mobile:gap__2" data-scroll>
			<div class="grid place__start-stretch">
				<div data-scroll class="flex align__start gap__01 span__2">
					<?= snippet('atoms/Label', ['text' => $quoteLabel]) ?>
				</div>
			</div>
			
			<div class="grid gap__1 place__start-start">
				<p class="font__size__3 ff__heading" data-reveal-text="lines">“<?= $quoteText ?>”</p>
				<?= snippet('atoms/Label', [
					'text' => $quoteAuthor,
					'css'  => 'op__7'
				]) ?>
			</div>
		</div>
	</div>
</section>
