<header class="header" data-header data-scroll style="--in-delay: 600ms">
	<div class="grid place__start-center inner__1">
		<div class="header__widget grid__3 gap__2 bg__dark/30 color__invert radius inner-x__05 inner-y__03 bg__blur">
			<div class="flex justify__start align__center">
				<a class="" href="<?= page('home')->url() ?>"><span data-reveal ><?= svg('public/assets/images/fig_logo.svg') ?></span></a>	
			</div>
			<div class="flex justify__center align__center">
				<a class="flex align__center inner-t__01" href="<?= page('home')->url() ?>"><?= svg('public/assets/images/fig_logo_type.svg') ?></a>	
			</div>
			<!-- <nav class="flex justify__center align__center gap__05 upper s no__wrap">
				<?php foreach ($pages->listed() as $p): ?>
					<?= snippet('atoms/Link', ['url' => $p->url(), 'label' => $p->title(), 'icon' => false, 'css' => !$p->isActive() ? 'op__4' : '', 'node' => 'data-reveal-text data-split-ignore']) ?>
				<?php endforeach ?>
			</nav> -->
			<div class="flex justify__end align__center">
				<?= snippet('atoms/Button', [ 'label' => false, 'icon' => 'menu', 'node' => 'data-menu-trigger', 'theme' => 'transparent', 'css' => 'circle' ]) ?>
			</div>
		</div>
	</div>
</header>
