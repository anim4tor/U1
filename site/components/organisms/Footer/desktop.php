<footer id="footer" class="" theme="invert" data-footer data-scroll>
	<div class="bg rounded-radius absolute inset-0"></div>

	<div class="grid grid-cols-1 md:grid-cols-4 gap-1 px-1 py-2 pb-1">
		<a class="footer__logo" href="<?= page('home')->url() ?>"><span data-reveal ><?= svg('public/assets/images/fig_logo_invert.svg') ?></span></a>	
		<nav class="col-span-1 md:col-span-3 footer__nav flex flex-wrap items-center gap-02 font-heading font-size-3">
			<?php foreach ($pages->listed() as $p): ?>
				<?php if(!$p->isFirst()) : ?>
					<span class="font-light font-body opacity-2">/</span>
				<?php endif ?>
				<?= snippet('atoms/Link', ['url' => $p->url(), 'label' => $p->title(), 'icon' => false, 'css' => !$p->isActive() ? 'opacity-4' : '', 'node' => 'data-reveal-text data-split-ignore']) ?>
			<?php endforeach ?>
			
		</nav>
		<div class="relative col-span-1 md:col-span-4 grid grid-cols-1 md:grid-cols-4 gap-1 pt-6">	
			
			<div class="grid content-between items-start gap-2">
				<div class="grid gap-02">
					<div class="label uppercase text-xs opacity-4">(Contact)</div>
					<p class="">U1 s.r.o. <br>Nejedlého 373/1, Brno-Lesná, 638 00 <br>IČ 26273179</p>
				</div>
				<div class=""><a href="">sales@u1.cz</a></div>
			</div>	
			<div class="grid content-between items-start gap-2">
				<div class="grid gap-02">
					<div class="label uppercase text-xs opacity-4">(Newsletter)</div>
					<p class="">subscribe for weekly design inspiration.</p>
				</div>
				<div class="opacity-4"><a href="">email</a></div>
			</div>
			<div></div>
			<div class="grid content-between items-start gap-02">
				<div class="grid gap-02">
					<div class="label uppercase text-xs opacity-4">(Socials)</div>
					<nav class="flex gap-02">
						<?php foreach ($site->social()->toStructure() as $s): ?>
							<?php if(!$s->isFirst()) : ?>
								<span class="font-light font-body opacity-2">/</span>
							<?php endif ?>
							<?= snippet('atoms/Link', ['url' => $s->link()->url(), 'label' => $s->platform(), 'icon' => false, 'node' => 'data-reveal-text data-split-ignore']) ?>
						<?php endforeach ?>
					</nav>
				</div>
				<div class="grid">
					<nav data-reveal-text="words" class="flex justify-between gap-05 opacity-5 text-default text-s">
						<?= snippet('atoms/Link', ['url' => 'terms', 'label' => 'Terms', 'icon' => false]) ?>
						<?= snippet('atoms/Link', ['url' => 'privacy', 'label' => 'Privacy', 'icon' => false]) ?>
						<?= snippet('atoms/Link', ['url' => 'cookies', 'label' => 'Cookies', 'icon' => false]) ?>
					</nav>
				</div>
			</div>	
			
		</div>

	</div>
</footer>

