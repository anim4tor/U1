<?php
$author = $page->quoteAuthor()->or('David L., Operations Manager');
$text   = $page->quoteText()->or('Twenty-five years of refined expertise, distilled into a comprehensive suite of architectural and design solutions creating experiences that amplify the joy felt in shared human moments.');
$image  = $page->quoteImage()->toFile() ?? $page->file('david.webp');
?>
<section class="quote radius" theme="dark">
	<div class="grid__4 gap__3 place__stretch-stretch inner-x__4 inner-y__5 mobile:grid__1 mobile:inner__2" data-scroll>
		<div class="span__1 flex align__start justify__start mobile:justify__center">
			<?php if ($image) : ?>
				<div class="item__figure grid img__radius overflow__hidden w__100">
					<?= snippet('atoms/Image', ['img' => $image, 'reveal' => true, 'parallax' => 1, 'node' => 'data-reveal-image', 'css' => 'w__10 h__15']) ?>
				</div>
			<?php endif ?>
		</div>
		<div></div>
		<div class="span__2 grid place__space-between-start justify__space-between gap__4 mobile:gap__2">
			<div class="flex align__start">
				<span class="font__size__small op__6" data-reveal-text="lines"><?= $author ?></span>
			</div>
			<div class="grid place__end-start">
				<h4 class="font__size__3 " data-reveal-text="lines" data-split-ignore>
					<?= $text ?>
				</h4>
			</div>
		</div>
	</div>
</section>
