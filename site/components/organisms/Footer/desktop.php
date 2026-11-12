<?php
$featuredServices = [
	'services/offices' => 'Kanceláře na klíč',
	'services/interior-design' => 'Návrh interiéru',
	'services/fit-out' => 'Fit-out a refit',
	'services/interior-tailoring' => 'Nábytek na míru',
	'services/realizace-pro-architekty' => 'Pro architekty',
];
?>
<footer id="footer" class="footer radius" theme="dark" data-footer data-scroll>
	<div class="inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3">
		
		<div class="footer__grid">
			
			<!-- Značka -->
			<div class="grid gap__1">
				<a class="footer__logo" href="<?= page('home')->url() ?>" aria-label="U1 Space Design, úvodní stránka">
					<?= svg('public/assets/images/fig_logo_type.svg') ?>
				</a>
				<h3 class="">
					Dobrý design.<br>Dobrý byznys.
				</h3>
			</div>

			<!-- Web -->
			<div class="footer__col">
				<h3 class="footer__title label upper ">Web</h3>
				<ul class="footer__list ">
					<?php foreach ($pages->listed()->not('home') as $p): ?>
						<li>
							<a href="<?= $p->url() ?>" class="footer__link <?= $p->isActive() || $page->parents()->has($p) ? 'active' : '' ?>">
								<?= $p->title() ?>
							</a>
						</li>
					<?php endforeach ?>
				</ul>
			</div>

			<!-- Služby -->
			<div class="footer__col">
				<h3 class="footer__title label upper ">Služby</h3>
				<ul class="footer__list ">
					<?php foreach ($featuredServices as $slug => $label): ?>
						<?php 
						$targetPage = page($slug);
						$url = $targetPage ? $targetPage->url() : url('services');
						$isActive = $targetPage ? ($targetPage->isActive() || $page->id() === $targetPage->id()) : false;
						?>
						<li>
							<a href="<?= $url ?>" class="footer__link <?= $isActive ? 'active' : '' ?>">
								<?= $label ?>
							</a>
						</li>
					<?php endforeach ?>
				</ul>
			</div>

			<!-- Kde nás najdete -->
			<div class="footer__col">
				<h3 class="footer__title label upper ">Kde nás najdete</h3>
				<div class="">
					<address class="footer__address">
						<span class="strong op__10">Brno, sídlo</span>
						<span class="op__7">Nejedlého 373/1<br>638 00 Brno-Lesná</span>
					</address>
					<address class="footer__address">
						<span class="strong op__10">Praha</span>
						<span class="op__7">Na Valentince 3336/4<br>150 00 Praha 5</span>
					</address>
				</div>
			</div>

			<!-- Kontakt -->
			<div class="footer__col">
				<h3 class="footer__title label upper ">Kontakt</h3>
				<ul class="footer__list ">
					<li><a href="mailto:info@u1.cz" class="footer__link">info@u1.cz</a></li>
					<li><a href="mailto:sales@u1.cz" class="footer__link">sales@u1.cz</a></li>
					<?php if ($site->social()->isNotEmpty()): ?>
						<?php foreach ($site->social()->toStructure() as $s): ?>
							<li>
								<a href="<?= $s->link()->url() ?>" target="_blank" rel="noopener noreferrer" class="footer__link">
									<?= $s->platform() ?>
								</a>
							</li>
						<?php endforeach ?>
					<?php else: ?>
						<li><a href="https://www.linkedin.com/company/u1spacedesign" target="_blank" rel="noopener noreferrer" class="footer__link">LinkedIn</a></li>
						<li><a href="https://www.instagram.com/u1space_design/" target="_blank" rel="noopener noreferrer" class="footer__link">Instagram</a></li>
						<li><a href="https://www.facebook.com/u1spacedesign" target="_blank" rel="noopener noreferrer" class="footer__link">Facebook</a></li>
					<?php endif ?>
				</ul>
			</div>

		</div>

		<!-- Právní informace -->
		<div class="footer__bottom font__size__small">
			<div class="footer__copy">
				<p class="font__size__small">© <?= date('Y') ?> U1 s.r.o., dříve U1 Interiors · IČO 26273179</p>
			</div>
			<nav class="footer__legal" aria-label="Právní informace">
				<a href="<?= url('privacy') ?>" class="footer__legal-link">Ochrana osobních údajů</a>
				<a href="<?= url('cookies') ?>" class="footer__legal-link">Cookies</a>
				<a href="<?= url('terms') ?>" class="footer__legal-link">Obchodní podmínky</a>
			</nav>
		</div>

	</div>
</footer>
