<header class="header grid place__start-center" data-header data-scroll style="--in-delay: 600ms">
	<div navbar class="grid inner__05">
		<div navbar-widget class="header__widget grid__3 gap__2 bg__dark/30 color__invert inner-x__02 bg__blur">
			<div class="flex justify__start align__center">
				<a class="button circle flex justify__center align__center" href="<?= page('home')->url() ?>"><div class="flex align__center" data-reveal ><?= svg('public/assets/images/fig_logo.svg') ?> <!-- <span class="upper">Space Design</span> --></div></a>	
			</div>
			<div class="flex justify__center align__center">
				<!-- <nav navbar-menu class="flex justify__center align__center gap__1 upper s no__wrap">
					<?php foreach ($pages->listed() as $p): ?>
						<?= snippet('atoms/Link', ['url' => $p->url(), 'label' => $p->title(), 'icon' => false, 'css' => !$p->isActive() ? 'op__4' : '', 'node' => 'data-reveal-text data-split-ignore']) ?>
					<?php endforeach ?>
				</nav> -->
				<a href="" class="s">Menu</a>
			</div>
			<div class="flex gap__02 justify__end align__center">
				<?= snippet('atoms/Button', [ 'label' => false, 'icon' => 'menu', 'node' => 'data-menu-trigger', 'theme' => 'transparent', 'css' => 'circle' ]) ?>
				<!-- <?= snippet('atoms/Button', [ 'label' => 'Start project', 'icon' => false, 'node' => 'data-menu-trigger', 'theme' => 'acc', 'css' => '' ]) ?> -->
				
			</div>
		</div>
	</div>
	<div fab data-scroll style="--in-delay: 600ms" class="fixed inset__bottom-right inner__05">
		<!-- <button class="bg__acc" data-scroll data-booking-toggle >
			<div class="grid__stack color__invert ">
				<div data-booking-hide class="grid"><?= svg('public/assets/images/hand.svg') ?></div>
				<div data-booking-reveal class="grid"><?= svg('public/assets/images/ui/ui_close.svg') ?></div>
			</div>
		</button> -->
		<button class="button bg__acc " theme="acc" data-scroll data-booking-toggle >
			<div icon class="grid__stack color__invert ">
				<div data-booking-hide class="grid"><?= svg('public/assets/images/hand.svg') ?></div>
				<div data-booking-reveal class="grid"><?= svg('public/assets/images/ui/ui_close.svg') ?></div>
			</div>
			<label class="upper">Start project</label>
		</button>
	</div>
</header>
