<footer id="footer" class="radius" theme="invert" data-footer data-scroll>
	<div class="bg radius absolute inset__stretch"></div>

	<div class="grid__4 gap__2 inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3">
		<div class="span__1 grid gap__1">
			<a class="footer__logo" href="<?= page('home')->url() ?>">
				<span data-reveal><?= svg('public/assets/images/fig_logo_invert.svg') ?></span>
			</a>
			<p class="font__size__small op__7">Dobrý design.<br>Dobrý byznys.</p>
		</div>

		<nav class="span__3 footer__nav flex wrap align__center gap__02 ff__heading">
			<?php foreach ($pages->listed() as $p): ?>
				<?php if(!$p->isFirst()) : ?>
					<span class="ff__body op__2">/</span>
				<?php endif ?>
				<?= snippet('atoms/Link', ['url' => $p->url(), 'label' => $p->title(), 'icon' => false, 'css' => !$p->isActive() ? 'op__4 font__size__3' : 'font__size__3', 'node' => 'data-reveal-text data-split-ignore']) ?>
			<?php endforeach ?>
		</nav>

		<div class="relative span__4 grid__4 gap__2 inner-t__4 border__top">	
			
			<div class="grid place__space-between-start gap__2">
				<div class="grid gap__05">
					<div class="label upper font__size__small op__4">(Kde nás najdete)</div>
					<div class="font__size__small">
						<p class="strong">Brno, sídlo</p>
						<p class="op__7">Nejedlého 373/1<br>638 00 Brno-Lesná</p>
					</div>
					<div class="font__size__small inner-t__02">
						<p class="strong">Praha</p>
						<p class="op__7">Na Valentince 3336/4<br>150 00 Praha 5</p>
					</div>
				</div>
			</div>	

			<div class="grid place__space-between-start gap__2">
				<div class="grid gap__05">
					<div class="label upper font__size__small op__4">(Služby)</div>
					<nav class="grid gap__02 font__size__small">
						<?= snippet('atoms/Link', ['url' => url('services'), 'label' => 'Kanceláře na klíč', 'icon' => false, 'css' => 'op__7']) ?>
						<?= snippet('atoms/Link', ['url' => url('services'), 'label' => 'Návrh interiéru', 'icon' => false, 'css' => 'op__7']) ?>
						<?= snippet('atoms/Link', ['url' => url('services'), 'label' => 'Fit-out a refit', 'icon' => false, 'css' => 'op__7']) ?>
						<?= snippet('atoms/Link', ['url' => url('services'), 'label' => 'Nábytek na míru', 'icon' => false, 'css' => 'op__7']) ?>
						<?= snippet('atoms/Link', ['url' => url('services'), 'label' => 'Pro architekty', 'icon' => false, 'css' => 'op__7']) ?>
					</nav>
				</div>
			</div>

			<div class="grid place__space-between-start gap__2">
				<div class="grid gap__05">
					<div class="label upper font__size__small op__4">(Kontakt)</div>
					<div class="grid gap__02 font__size__small">
						<a class="op__7" href="mailto:info@u1.cz">info@u1.cz</a>
						<a class="op__7" href="mailto:sales@u1.cz">sales@u1.cz</a>
					</div>
				</div>
				<div class="grid gap__05 inner-t__05">
					<div class="label upper font__size__small op__4">(Sociální sítě)</div>
					<nav class="flex gap__02">
						<?php foreach ($site->social()->toStructure() as $s): ?>
							<?php if(!$s->isFirst()) : ?>
								<span class="light ff__body op__2">/</span>
							<?php endif ?>
							<?= snippet('atoms/Link', ['url' => $s->link()->url(), 'label' => $s->platform(), 'icon' => false, 'node' => 'data-reveal="simple" data-split-ignore']) ?>
						<?php endforeach ?>
					</nav>
				</div>
			</div>

			<div class="grid place__space-between-start gap__2">
				<div class="grid gap__05">
					<div class="label upper font__size__small op__4">(Firma)</div>
					<p class="font__size__small op__7">© 2026 U1 s.r.o.<br>dříve U1 Interiors<br>IČO 26273179</p>
				</div>
				<div class="grid">
					<nav data-reveal-text="words" class="flex flex__flow-column gap__02 op__5 font__size__small">
						<?= snippet('atoms/Link', ['url' => 'privacy', 'label' => 'Ochrana osobních údajů', 'icon' => false]) ?>
						<?= snippet('atoms/Link', ['url' => 'cookies', 'label' => 'Cookies', 'icon' => false]) ?>
						<?= snippet('atoms/Link', ['url' => 'terms', 'label' => 'Obchodní podmínky', 'icon' => false]) ?>
					</nav>
				</div>
			</div>	
			
		</div>

	</div>
</footer>
