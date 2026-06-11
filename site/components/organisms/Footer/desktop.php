<footer id="footer " class="" data-footer data-scroll>
	<div class="grid gap__1 place__center-center inner-x__10 inner-y__4">
		<div class="flex align__center gap__1 mobile:grid mobile:justify__center">
			<a class="flex align__center" data-reveal href="<?= page('home')->url() ?>"><?= svg('public/assets/images/fig_logo_poly.svg') ?></a>	
			<nav data-reveal-text="words" class="flex align__center gap__1 font__size__default">
				<?php foreach ($site->social()->toStructure() as $social): ?>
					<?= snippet('atoms/Link', ['url' => $social->link()->toUrl(), 'label' => $social->platform(), 'icon' => false]) ?>
				<?php endforeach ?>
				<?= snippet('atoms/Link', ['url' => page('kontakt')->url(), 'label' => page('kontakt')->title(), 'icon' => false]) ?>
				<div data-reveal>	
					<?= snippet('atoms/Button', ['url' => $page->url($kirby->languages()->not($kirby->language())->first()->code()), 'label' => $kirby->languages()->not($kirby->language())->first()->code(), 'theme' => 'ghost', 'css' => '--small op__5']) ?>
				</div>
			</nav>
		</div>
		<nav data-reveal-text="words" class="flex align__center gap__1 op__5 font__size__default">
			<?= snippet('atoms/Link', ['url' => 'terms', 'label' => 'Terms & Conditions', 'icon' => false]) ?>
			<?= snippet('atoms/Link', ['url' => 'privacy', 'label' => 'Privacy Statement', 'icon' => false]) ?>
			<?= snippet('atoms/Link', ['url' => 'cookies', 'label' => 'Cookies', 'icon' => false]) ?>
		</nav>
	</div>
</footer>

