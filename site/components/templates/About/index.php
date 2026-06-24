<section class="intro radius" theme="acc" style="--in-delay: 500ms">
	<?php if ($cover = $page->cover()->toFile()) : ?>
	<div class="intro__cover absolute inset__stretch grid" data-scroll ><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
	<?php endif ?>
	<div data-scroll class="z__1 intro__header place__stretch-stretch grid__4 intro__rows mobile:grid__1 h__100v mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class=""></div>
		<div class="span__4 grid place__space-between-stretch">
			<div class="span__4 place__start-start grid__4 border__top inner-t__05">
				<div class="span__2">
					<div data-reveal-text="lines" class="upper">(About)</div>
				</div>
				<div>
					<p data-reveal-text="lines" class="font__size__5 lower"><?= $page->intro()->inline() ?></p>
				</div>
			</div>
			<div class="intro__title relative place__end-stretch span__4 mobile:span__1 inner-y__05" style="--in-delay: 500ms">
				<h1 class="l flex justify__space-between">
					<div data-reveal-text=""><?= $page->title() ?></div>
					<div data-reveal-text="">Us</div>
				</h1>
			</div>
		</div>
	</div>
</section>

<?= snippet('templates/globals/Cta') ?>