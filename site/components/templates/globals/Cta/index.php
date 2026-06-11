<section class="cta">
	<div class="grid__5 mobile:grid__1 border__top ">
		<div class="span__3 grid no__overflow relative">
			<div class="absolute inset__stretch grid mobile:relative mobile:h__20">
				<?= snippet('atoms/Image', ['url' => 'fig_home_cta.jpg', 'parallax' => 10]) ?>
			</div>
		</div>
		<div class="span__2 grid place__start-stretch border__bottom">
			<div class="grid place__center-start gap__1 inner-x__2 mobile:inner-x__1 inner-y__4">
				<?= snippet('molecules/Header', ['header' => $site->ctaContact()]) ?>
			</div>
			<?php if ($site->ctaMenu()->isNotEmpty()) : ?>
				<ul>
					<?php foreach ($site->ctaMenu()->toPages() as $page): ?>
						<li class="inner-x__2 mobile:inner-x__1 border__top inner-y__05">
							<?= snippet('atoms/Link', ['url' => $page->url(), 'label' => $page->menuTitle()->isNotEmpty() ? $page->menuTitle() : $page->title(), 'css' => 'inner-y__1 font__size__4 m']) ?>
						</li>
					<?php endforeach ?>
				</ul>
			<?php endif ?>
		</div>
	</div>
</section>