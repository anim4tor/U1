<header class="header grid place__start-end inner__05" data-header>
	<div class="header__wrapper grid place__start-start">
		<div navbar class="grid  bg__dark/60 color__invert bg__blur radius">
			<div navbar-header data-scroll class="absolute inset__top-stretch grid__3 justify__stretch inner-x__02" >
				<div class="flex align__center justify__start">
					
					<div class="grid__stack place__center-start" data-on-navbar-toggle>
						<a data-default class="button circle flex justify__center align__center" href="<?= page('home')->url() ?>"><div class="flex align__center" data-reveal ><?= svg('public/assets/images/fig_logo.svg') ?> <!-- <span class="upper">Space Design</span> --></div></a>	
						<span class="upper inner-x__05"> </span>
					</div>
				</div>
				<!-- <div class="flex gap__4 align__center" > -->
						
					<div data-on-navbar-toggle class="grid__stack place__center-center upper">
						<nav data-default class="flex align__center gap__2 no__wrap">
							<?php foreach ($pages->find('projects', 'career', 'feed') as $p): ?>
								<div class="grid place__start-start">
									<?= snippet('atoms/Link', ['url' => $p->url(), 'label' => $p->title(), 'icon' => false, 'css' => 'upper', 'node' => 'data-reveal-text  data-split-ignore']) ?>

								</div>
							<?php endforeach ?>
							<!-- <?= snippet('atoms/Link', ['url' => false, 'label' => $page->parent() ? $page->parent()->title() : $page->title(), 'icon' => false, 'css' => '', 'node' => 'data-reveal-text  data-split-ignore']) ?> -->
						</nav>
						<span> </span>
					</div>
					<div class="grid__stack place__center-end" navbar-toggle data-on-navbar-toggle>
						<?= snippet('atoms/Button', [ 'label' => false, 'icon' => 'menu', 'node' => 'data-navbar-toggle data-default', 'theme' => 'transparent', 'css' => 'circle' ]) ?>
						<?= snippet('atoms/Button', [ 'label' => false, 'icon' => 'close', 'node' => 'data-navbar-toggle', 'theme' => '', 'css' => 'circle --small bg__light/20 color__invert/80 wrap-r__05' ]) ?>
								
					</div>
				<!-- </div> -->
			</div>
			<div navbar-widget class="" data-scroll data-scroll-ignore >
				<div class="grid ">
					<div navbar-content class="grid place__space-between-stretch gap__1 inner__2">
						<div class="grid gap__05 place__start-start">
							<!-- <div class="label upper font__size__small op__4">(Menu)</div> -->
							<nav navbar-menu class="grid place__start-start upper ff__heading font__size__2 no__wrap">
								<?php foreach ($pages->find('home', 'projects', 'services') as $p): ?>
									<?= snippet('atoms/Link', ['url' => $p->url(), 'label' => $p->title(), 'icon' => false, 'css' => ($p->isActive() || $page->parents()->has($p) ? '' : 'op__4') . ' font__size__2', 'node' => 'data-reveal-text data-reveal-on-navbar data-split-ignore']) ?>
								<?php endforeach ?>
							</nav>
						</div>
						<div class="grid gap__1 ">
							<div class="grid__2 place__start-start gap__02">
								<div class="flex"><?= snippet('atoms/Label', ['text' => t('who-we-are'), 'css' => 'op__4']) ?></div>
								<nav navbar-menu class="grid upper ff__heading font__size__3 lighter no__wrap ">
									<?php foreach ($pages->find('about', 'career', 'contact') as $p): ?>
										<div class="grid place__start-start">
											<?= snippet('atoms/Link', ['url' => $p->url(), 'label' => $p->title(), 'icon' => false, 'css' => 'font__size__3', 'node' => 'data-reveal-text data-reveal-on-navbar data-split-ignore']) ?>

										</div>
									<?php endforeach ?>
								</nav>
							</div>
							<div class="grid__2 place__start-start gap__02">
								<div class="flex"><?= snippet('atoms/Label', ['text' => t('news'), 'css' => 'op__4']) ?></div>
								<nav navbar-menu class="grid upper ff__heading font__size__3 lighter no__wrap ">
									<div class="grid place__start-start">
										<?= snippet('atoms/Link', ['url' => page('feed')->url() . '#blog', 'label' => 'Články', 'icon' => false, 'css' => 'font__size__3', 'node' => 'data-reveal-text data-reveal-on-navbar data-split-ignore']) ?>

									</div>
									<div class="grid place__start-start">
										<?= snippet('atoms/Link', ['url' => page('feed')->url() . '#socials', 'label' => 'Sítě', 'icon' => false, 'css' => 'font__size__3', 'node' => 'data-reveal-text data-reveal-on-navbar data-split-ignore']) ?>

									</div>
									<div class="grid place__start-start">
										<?= snippet('atoms/Link', ['url' => page('feed')->url() . '#media', 'label' => 'Média', 'icon' => false, 'css' => 'font__size__3', 'node' => 'data-reveal-text data-reveal-on-navbar data-split-ignore']) ?>

									</div>
								</nav>
							</div>
							<div class="grid place__start-stretch gap__05 inner-t__1">
								<div class="flex"><?= snippet('atoms/Label', ['text' => t('contact'), 'css' => 'op__4']) ?></div>
								<div class="grid__2 gap__02">
									<?= snippet('atoms/Button', [
										'label' => t('book-call'),
										'theme' => 'invert-ghost',
										'hover' => 'invert',
										'node'  => 'data-scroll data-contact-toggle="contact" navbar-close',
										'css' => 'justify__center'
									]) ?>
									<?= snippet('atoms/Button', [
										'label' => t('inquire-project'),
										'theme' => 'acc',
										'hover' => 'invert',
										'node'  => 'data-scroll data-contact-toggle="inquiry" navbar-close',
										'css' => 'justify__center'
									]) ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</header>
