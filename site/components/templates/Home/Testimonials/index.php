<section class="testimonials radius">
	<?php if ($cover = $page->cover()->toFile()) : ?>
		<div class="intro__cover absolute inset__stretch grid "><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
	<?php endif ?>
	<div class="relative grid__3 gap__2 h__100v mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2" >
		<div></div>
		<div class="grid place__center-center" data-scroll data-reveal-image>
			<div class="grid gap__2 place__space-between-start h__16 inner__1 radius" theme="dark">
				<div class="grid gap__1">
					<?= snippet('atoms/Image', ['url' => 'testimonial.png', 'parallax' => 2, 'css' => 'w__3']) ?>
					<p class="quote ff__body upper">"Working with this team has been a game-changer for our business. Their attention to detail and ability to deliver high-quality results on schedule is unmatched. I highly recommend them to anyone looking for reliable and professional expertise."</p>
				</div>
				<div class="flex justify__space-between">
					<div class="xs upper " data-reveal-text="lines">(Testimonials)</div>
					<div class="xs" data-reveal-text="lines">01/08</div>
				</div>
				<!-- <div class="flex justify__space-between">
					<div class="s upper " data-reveal-text="lines">David L.</div>
					<div class="s upper" data-reveal-text="lines">(Operations Manager)</div>
				</div> -->
			</div>
		</div>
		<div></div>
	</div>
</section>