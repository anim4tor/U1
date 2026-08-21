<header class="header grid content-start justify-end p-05" data-header>
	<div class="header__wrapper grid content-start justify-start">
		<div navbar theme="dark" class="grid bg-dark/60 text-invert backdrop-blur-md rounded-radius">
			<div navbar-header data-scroll class="absolute top-0 left-0 right-0 grid grid-cols-3 justify-stretch px-02" >
				<div class="flex items-center justify-start">
					
					<div class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] place-items-center" data-on-navbar-toggle>
						<a data-default class="button circle flex justify-center items-center" href="<?= page('home')->url() ?>"><div class="flex items-center" data-reveal ><?= svg('public/assets/images/fig_logo.svg') ?></div></a>	
						<span class="uppercase px-05"> </span>
					</div>
				</div>
						
				<div data-on-navbar-toggle class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] place-items-center uppercase">
					<nav data-default class="flex items-center gap-2 flex-nowrap whitespace-nowrap">
						<?php foreach ($pages->find('projects', 'career', 'feed') as $p): ?>
							<div class="grid content-start justify-start">
								<?= snippet('atoms/Link', ['url' => $p->url(), 'label' => $p->title(), 'icon' => false, 'css' => 'uppercase', 'node' => 'data-reveal-text  data-split-ignore']) ?>
							</div>
						<?php endforeach ?>
					</nav>
					<span> </span>
				</div>
				<div class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] items-center justify-end" navbar-toggle data-on-navbar-toggle>
					<?= snippet('atoms/Button', [ 'label' => false, 'icon' => 'menu', 'node' => 'data-navbar-toggle data-default', 'theme' => 'transparent', 'css' => 'circle' ]) ?>
					<?= snippet('atoms/Button', [ 'label' => false, 'icon' => 'close', 'node' => 'data-navbar-toggle', 'theme' => 'transparent', 'css' => 'circle' ]) ?>
				</div>
			</div>
			<div navbar-widget class="" data-scroll data-scroll-ignore >
				<div class="grid">
					<div navbar-content class="grid content-between items-stretch gap-1 p-05">
						<div class="grid gap-05">
							<nav navbar-menu class="grid uppercase font-heading font-size-3 flex-nowrap whitespace-nowrap">
								<?php foreach ($pages->find('home', 'projects', 'services') as $p): ?>
									<div class="grid content-start justify-start">
										<?= snippet('atoms/Link', ['url' => $p->url(), 'label' => $p->title(), 'icon' => false, 'css' => $p->isActive() || $page->parents()->has($p) ? '' : 'opacity-4', 'node' => 'data-reveal-text data-reveal-on-navbar data-split-ignore']) ?>
									</div>
								<?php endforeach ?>
							</nav>
							<div class="grid gap-02">
								<nav class="flex justify-center gap-02 opacity-4 text-s">
									<?php foreach ($site->social()->toStructure() as $s): ?>
										<?php if(!$s->isFirst()) : ?>
											<span class="font-light font-body opacity-2">/</span>
										<?php endif ?>
										<?= snippet('atoms/Link', ['url' => $s->link()->url(), 'label' => '('.$s->platform().')', 'icon' => false, 'node' => 'data-reveal-text data-split-ignore']) ?>
									<?php endforeach ?>
								</nav>
							</div>
						</div>
						<div class="grid gap-1">
							<div class="grid grid-cols-2 gap-02">
								<div class="flex"><span class="opacity-4 uppercase">Who we are</span></div>
								<nav navbar-menu class="grid uppercase font-heading font-size-4 font-light flex-nowrap whitespace-nowrap">
									<?php foreach ($pages->find('about', 'career', 'contact') as $p): ?>
										<div class="grid content-start justify-start">
											<?= snippet('atoms/Link', ['url' => $p->url(), 'label' => $p->title(), 'icon' => false, 'css' => '', 'node' => 'data-reveal-text data-reveal-on-navbar data-split-ignore']) ?>
										</div>
									<?php endforeach ?>
								</nav>
							</div>
							<div class="grid grid-cols-2 gap-02">
								<div class="flex"><span class="opacity-4 uppercase">Feed</span></div>
								<nav navbar-menu class="grid uppercase font-heading font-size-4 font-light flex-nowrap whitespace-nowrap">
									<div class="grid content-start justify-start">
										<?= snippet('atoms/Link', ['url' => page('feed')->url() . '#blog', 'label' => 'Blog', 'icon' => false, 'css' => '', 'node' => 'data-reveal-text data-reveal-on-navbar data-split-ignore']) ?>
									</div>
									<div class="grid content-start justify-start">
										<?= snippet('atoms/Link', ['url' => page('feed')->url() . '#socials', 'label' => 'Socials', 'icon' => false, 'css' => '', 'node' => 'data-reveal-text data-reveal-on-navbar data-split-ignore']) ?>
									</div>
									<div class="grid content-start justify-start">
										<?= snippet('atoms/Link', ['url' => page('feed')->url() . '#media', 'label' => 'Media', 'icon' => false, 'css' => '', 'node' => 'data-reveal-text data-reveal-on-navbar data-split-ignore']) ?>
									</div>
								</nav>
							</div>
							<div class="grid gap-02 pt-1">
								<div class="grid grid-cols-2 gap-02">
									<button class="rounded-img flex p-05 gap-02 justify-center items-center" theme="invert-ghost" data-scroll data-booking-toggle >
										<label class="uppercase">Schedule a call</label>
									</button>
									<button class="rounded-img flex p-05 gap-02 justify-center items-center" theme="acc" data-scroll data-booking-toggle >
										<label class="uppercase">Start project</label>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</header>
