<header class="header grid place__start-center inner__05" data-header>
	<div navbar class="grid bg__dark/60 color__invert bg__blur img__radius">
		<div navbar-header data-scroll class="flex gap__0 align__center inner-x__02">
			<div class="header__seg header__logo flex justify__start align__center" data-reveal>
				<a class="header__logo-link flex align__center" href="<?= page('home')->url() ?>" aria-label="U1 Space Design">
					<div class="header__logo-wrap flex align__center">
						<?= svg('public/assets/images/fig_logo_type.svg') ?>
					</div>
				</a>	
			</div>

			<?php 
			$headerLinks = $site->menuHeader()->isNotEmpty() 
				? $site->menuHeader()->toPages() 
				: $pages->listed()->limit(4);
			?>
			<?php if ($headerLinks->isNotEmpty()): ?>
			<nav class="header__seg header__nav flex gap__2 align__center inner-x__2 font__size__label hide--mobile" aria-label="Hlavní menu">
				<?php foreach ($headerLinks as $navItem): ?>
					<?= snippet('atoms/Label', [
						'url'    => $navItem->url(),
						'text'   => $navItem->title(),
						'css'    => 'header__nav-link ' . (($navItem->isActive() || $page->parents()->has($navItem)) ? 'active op__10' : 'op__10'),
						'node'   => 'data-split-ignore',
						'reveal' => false
					]) ?>
				<?php endforeach ?>
			</nav>
			<?php endif ?>

			<div class="header__seg header__toggle flex gap__02 inner-x__1 align__center" navbar-toggle role="button" aria-label="Menu" tabindex="0">
				<!-- <div class="header__toggle-text grid__stack place__center-center" data-on-navbar-toggle>
					<?= snippet('atoms/Label', ['text' => 'Menu', 'node' => 'data-default', 'css' => 'op__10', 'reveal' => false]) ?>
					<?= snippet('atoms/Label', ['text' => 'Close', 'css' => 'op__10', 'reveal' => false]) ?>
				</div> -->
				<div class="header__toggle-icon grid__stack place__center-end" data-on-navbar-toggle>
					<?= snippet('atoms/Button', [ 'label' => false, 'icon' => 'menu', 'node' => 'data-navbar-toggle data-default', 'theme' => 'transparent', 'hover' => false, 'css' => 'circle' ]) ?>
					<?= snippet('atoms/Button', [ 'label' => false, 'icon' => 'close', 'node' => 'data-navbar-toggle', 'theme' => 'transparent', 'hover' => false, 'css' => 'circle' ]) ?>
				</div>
			</div>

			<div class="header__seg header__cta flex align__center inner-x__05 inner-r__02">
				<?= snippet('atoms/Button', [
					'label' => 'Poptat projekt',
					'theme' => 'acc',
					'css'   => 'inner-x__1 font__size__small bold',
					'node'  => 'data-contact-toggle="inquiry" type="button"'
				]) ?>
			</div>
		</div>
		<div navbar-widget class="" data-scroll data-scroll-ignore >
			<div >
				<div class="grid gap__1 inner__05">
					<div class="grid gap__05 inner-y__1">
						<!-- <div class="label upper xs op__4">(Menu)</div> -->
						<nav navbar-menu class="grid upper no__wrap">
							<?php foreach ($pages->listed() as $p): ?>
								<div class="grid place__center-center">
									<a href="<?= $p->url() ?>" class="link <?= ($p->isActive() || $page->parents()->has($p)) ? '' : 'op__4' ?>">
										<h3 class="larger" data-reveal-text data-reveal-on-navbar data-split-ignore><?= $p->title() ?></h3>
									</a>
								</div>
							<?php endforeach ?>
						</nav>
						
					</div>
					<div class="grid gap__02">
						<!-- <div class="label upper xs op__4">(Contact)</div> -->
						<div class="grid__2 gap__02">
							<?= snippet('atoms/Button', [
								'label' => 'Domluvit schůzku',
								'theme' => 'invert-ghost',
								'css'   => 'justify__center',
								'node'  => 'data-scroll data-contact-toggle="contact" type="button"'
							]) ?>
							<?= snippet('atoms/Button', [
								'label' => 'Poptat projekt',
								'theme' => 'acc',
								'css'   => 'justify__center',
								'node'  => 'data-scroll data-contact-toggle="inquiry" type="button"'
							]) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
