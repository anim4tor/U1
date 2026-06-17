<footer id="footer" class="color__invert" data-footer data-scroll>
	<div class="bg radius absolute inset__stretch" theme="dark"></div>

	<div class="grid__3 gap__1 inner-x__1 inner-y__2">
		<a class="footer__logo flex" data-reveal href="<?= page('home')->url() ?>"><?= svg('public/assets/images/fig_logo.svg') ?></a>	
		<div class="span__2 flex align__center gap__1 mobile:grid mobile:justify__center">
			<nav data-reveal-text="words" class="flex align__center gap__1">
				<!-- <?php foreach ($site->social()->toStructure() as $social): ?>
					<?= snippet('atoms/Link', ['url' => $social->link()->toUrl(), 'label' => $social->platform(), 'icon' => false]) ?>
				<?php endforeach ?> -->
				<?= snippet('atoms/Link', ['url' => page('home')->url(), 'label' => page('home')->title(), 'size' => 'font__size__1 xs', 'icon' => false]) ?>
				<?= snippet('atoms/Link', ['url' => page('projects')->url(), 'label' => page('projects')->title(), 'size' => 'font__size__1 xs', 'icon' => false]) ?>
				<?= snippet('atoms/Link', ['url' => page('services')->url(), 'label' => page('services')->title(), 'size' => 'font__size__1 xs', 'icon' => false]) ?>
				<?= snippet('atoms/Link', ['url' => page('studio')->url(), 'label' => page('studio')->title(), 'size' => 'font__size__1 xs', 'icon' => false]) ?>
				<?= snippet('atoms/Link', ['url' => page('kontakt')->url(), 'label' => page('kontakt')->title(), 'size' => 'font__size__1 xs', 'icon' => false]) ?>
				
			</nav>
		</div>
		<div class="span__3 inner-t__10">		
			<nav data-reveal-text="words" class="flex align__center gap__1 op__5 font__size__default">
				<?= snippet('atoms/Link', ['url' => 'terms', 'label' => 'Terms & Conditions', 'icon' => false]) ?>
				<?= snippet('atoms/Link', ['url' => 'privacy', 'label' => 'Privacy Statement', 'icon' => false]) ?>
				<?= snippet('atoms/Link', ['url' => 'cookies', 'label' => 'Cookies', 'icon' => false]) ?>
			</nav>
		</div>
	</div>
</footer>

