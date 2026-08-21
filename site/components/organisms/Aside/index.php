<aside class="" data-aside data-scroll>
	<div data-aside-widget theme="dark" class="grid px-1 h-screen">
		<div class="aside__header flex gap-1 justify-between items-center" theme="dark">
			<div data-reveal>
				<a href="<?= page('home')->url() ?>" class="logo flex relative"><?= svg('public/assets/images/fig_logo_poly.svg') ?></a>
			</div>
			<a data-reveal data-aside-toggle>	
				<?= snippet('atoms/Button', ['label' => '✕', 'theme' => 'invert-ghost']) ?>
			</a>
		</div>
		<nav data-reveal-text="words" class="grid items-center gap-1 font-size-1 text-m" >
			<?php foreach ($pages->listed()->not('home') as $item): ?>
				<?= snippet('atoms/Link', ['url' => $item->url(), 'label' => $item->title(), 'icon' => false]) ?>
			<?php endforeach ?>
		</nav>
	</div>
</aside>
