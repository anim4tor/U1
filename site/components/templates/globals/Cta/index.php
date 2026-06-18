<section class="cta" data-scroll>
	<div class="bg radius absolute inset__stretch" theme="acc"></div>
	<div class="relative grid__3 gap__1 mobile:grid__1 inner__1 inner-y__2">
		<div class="item__figure grid radius"><?= snippet('atoms/Image', ['url' => 'home_cta.png', 'parallax' => 2 ]) ?></div>
		<div class="span__2 grid gap__6 place__start-start">
			<h2 class="xxl" data-reveal-text>Let’s Discuss Your Next Vision.  </h2>
			<?= snippet('atoms/Button', [ 'label' => 'Tell us about your project']) ?>
		</div>
	</div>
</section>