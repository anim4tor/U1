<header class="header grid place__start-center inner__05" data-header>
	<div navbar class="grid bg__dark/60 color__invert bg__blur img__radius">
		<div navbar-header data-scroll class="flex align__center inner-x__02">
			<div class="header__seg header__logo flex justify__start align__center">
				<a class="button circle flex justify__center align__center" href="<?= page('home')->url() ?>" aria-label="U1 Space Design">
					<div class="flex align__center" data-reveal><?= svg('public/assets/images/fig_logo.svg') ?></div>
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
						'url'  => $navItem->url(),
						'text' => $navItem->title(),
						'css'  => 'header__nav-link ' . (($navItem->isActive() || $page->parents()->has($navItem)) ? 'active op__10' : 'op__8'),
						'node' => 'data-split-ignore'
					]) ?>
				<?php endforeach ?>
			</nav>
			<?php endif ?>

			<div class="header__seg header__toggle flex gap__1 inner-x__1 align__center" navbar-toggle role="button" aria-label="Menu" tabindex="0">
				<div class="grid__stack place__center-center" data-on-navbar-toggle>
					<?= snippet('atoms/Label', ['text' => 'Menu', 'node' => 'data-default', 'css' => 'op__8']) ?>
					<?= snippet('atoms/Label', ['text' => 'Close', 'css' => 'op__8']) ?>
				</div>
				<div class="grid__stack place__center-end" data-on-navbar-toggle>
					<?= snippet('atoms/Button', [ 'label' => false, 'icon' => 'menu', 'node' => 'data-navbar-toggle data-default', 'theme' => 'transparent', 'css' => 'circle' ]) ?>
					<?= snippet('atoms/Button', [ 'label' => false, 'icon' => 'close', 'node' => 'data-navbar-toggle', 'theme' => 'transparent', 'css' => 'circle' ]) ?>
				</div>
			</div>

			<div class="header__seg header__cta flex align__center inner-x__05">
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
						<nav navbar-menu class="grid upper ff__heading font__size__4 no__wrap">
							<?php foreach ($pages->listed() as $p): ?>
								<div class="grid place__center-center">
									<?= snippet('atoms/Link', ['url' => $p->url(), 'label' => $p->title(), 'icon' => false, 'css' => $p->isActive() || $page->parents()->has($p) ? '' : 'op__4', 'node' => 'data-reveal-text data-reveal-on-navbar data-split-ignore']) ?>
								</div>
							<?php endforeach ?>
						</nav>
						<div class="grid gap__02">
							<!-- <div class="label upper xs op__4">(Socials)</div> -->
							<nav class="flex justify__center gap__02 op__4 s">
								<?php foreach ($site->social()->toStructure() as $s): ?>
									<?php if(!$s->isFirst()) : ?>
										<span class="light ff__body op__2">/</span>
									<?php endif ?>
									<?= snippet('atoms/Link', ['url' => $s->link()->url(), 'label' => '('.$s->platform().')', 'icon' => false, 'node' => 'data-reveal-text data-split-ignore']) ?>
								<?php endforeach ?>

							</nav>
						</div>
					</div>
					<div class="grid gap__02">
						<!-- <div class="label upper xs op__4">(Contact)</div> -->
						<div class="grid__2 gap__02">
							<button class="img__radius flex inner__05 gap__02 justify__center align__center" theme="invert-ghost" data-scroll data-contact-toggle="contact" type="button">
								<label class="upper">Kontakt</label>
							</button>
							<button class="img__radius flex inner__05 gap__02 justify__center align__center" theme="acc" data-scroll data-contact-toggle="inquiry" type="button">
								<label class="upper">Poptat projekt</label>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
