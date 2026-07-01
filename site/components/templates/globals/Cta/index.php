<section class="cta" data-scroll>
	<div class="bg radius absolute inset__stretch" theme="acc"></div>
	<div class="relative grid__4 gap__1 mobile:grid__1 inner__1 inner-y__2">
		<div class="item__figure grid img__radius"><?= snippet('atoms/Image', ['url' => 'home_cta.png', 'parallax' => 2 ]) ?></div>
		<div class="span__3 grid gap__6 place__start-start">
			<h2 class="" data-reveal-text>Good design. <br>Good business. <br>Let's talk.</h2>
			<?= snippet('atoms/Button', [ 'label' => 'Tell us about your project', 'icon' => 'arrow-right', 'node' => 'data-contact-toggle="inquiry"']) ?>
		</div>
	</div>
</section>