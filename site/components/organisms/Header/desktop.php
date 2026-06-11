<header class="header" data-header data-scroll style="--in-delay: 600ms">
	<div class="flex gap__1 justify__space-between align__center inner-x__1">
		<div data-reveal>
			<a href="<?= page('home')->url() ?>" class="logo flex relative"><?= svg('public/assets/images/fig_logo_poly.svg') ?></a>
		</div>
		<nav data-reveal-text="words" class="flex align__center gap__1 font__size__default mobile:none" >
			<?php foreach ($pages->listed()->not('home') as $item): ?>
				<?= snippet('atoms/Link', ['url' => $item->url(), 'label' => $item->title(), 'icon' => false]) ?>
			<?php endforeach ?>
			<a href data-reveal data-booking-toggle>	
				<?= snippet('atoms/Button', ['label' => 'Booking', 'theme' => 'ghost']) ?>
			</a>
		</nav>
		<a class="none mobile:block" data-reveal data-aside-toggle>	
			<?= snippet('atoms/Button', ['label' => 'Menu', 'theme' => 'ghost']) ?>
		</a>
	</div>
</header>
