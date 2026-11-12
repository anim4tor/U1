<?php if ($page->faq()->isNotEmpty()) : ?>
<section class="faq radius" theme="invert" data-scroll>
	<div class="grid__4 gap__2 inner-x__4 inner-y__5 mobile:grid__1 mobile:inner-x__1 mobile:inner-y__3">
		<div class="span__2 grid gap__1 place__start-start">
			<h2 class="font__size__2"><?= $page->faqHeading()->or('Časté otázky') ?></h2>
		</div>
		<div class="span__2 grid gap__1">
			<ol class="faq__list grid" data-scroll data-collapsibles="true">
				<?php foreach ($page->faq()->toStructure() as $item) : ?>
					<?= snippet('molecules/Collapsible', ['item' => $item, 'list' => $page->faq()->toStructure()]) ?>
				<?php endforeach ?>
				<div class="border__top"></div>
			</ol>
		</div>
	</div>
</section>
<?php endif ?>

