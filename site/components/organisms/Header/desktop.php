<header class="header grid place__start-center inner__05" data-header>
	<div navbar class="grid  bg__dark/60 color__invert bg__blur img__radius">
		<div navbar-header data-scroll class="flex inner-x__02" >
			<div class="flex justify__start align__center">
				<a class="button circle flex justify__center align__center" href="<?= page('home')->url() ?>"><div class="flex align__center" data-reveal ><?= svg('public/assets/images/fig_logo.svg') ?> <!-- <span class="upper">Space Design</span> --></div></a>	
			</div>
			<div class="flex gap__4 inner-l__4 align__center" navbar-toggle>
				<div class="grid__stack place__center-center" data-on-navbar-hover>
					<nav data-default class="grid__stack">
						<?= snippet('atoms/Link', ['url' => false, 'label' => $page->parent() ? $page->parent()->title() : $page->title(), 'icon' => false, 'css' => '', 'node' => 'data-reveal-text  data-split-ignore']) ?>
					</nav>
					<div data-on-navbar-toggle class="grid__stack place__center-center upper">
						<span data-default>Menu</span>
						<span>Close</span>
					</div>
				</div>
				<div class="grid__stack place__center-end" data-on-navbar-toggle>
					<?= snippet('atoms/Button', [ 'label' => false, 'icon' => 'menu', 'node' => 'data-navbar-toggle data-default', 'theme' => 'transparent', 'css' => 'circle' ]) ?>
					<?= snippet('atoms/Button', [ 'label' => false, 'icon' => 'close', 'node' => 'data-navbar-toggle', 'theme' => 'transparent', 'css' => 'circle' ]) ?>
							
				</div>
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
							<button class="img__radius flex inner__05 gap__02 justify__center align__center" theme="invert-ghost" data-scroll data-booking-toggle >
								<!-- <div icon class="grid__stack ">
									<div data-booking-hide class="grid"><?= svg('public/assets/images/hand.svg') ?></div>
									<div data-booking-reveal class="grid"><?= svg('public/assets/images/ui/ui_close.svg') ?></div>
								</div> -->
								<label class="upper">Schedule a call</label>
							</button>
							<button class="img__radius flex inner__05 gap__02 justify__center align__center" theme="acc" data-scroll data-booking-toggle >
								<!-- <div icon class="grid__stack ">
									<div data-booking-hide class="grid"><?= svg('public/assets/images/hand.svg') ?></div>
									<div data-booking-reveal class="grid"><?= svg('public/assets/images/ui/ui_close.svg') ?></div>
								</div> -->
								<label class="upper">Start project</label>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
