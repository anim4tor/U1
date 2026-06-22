<section class="intro radius" theme="acc" style="--in-delay: 500ms">
	<?php if ($cover = $page->cover()->toFile()) : ?>
	<div class="intro__cover absolute inset__stretch grid" data-scroll ><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
	<?php endif ?>
	<div data-scroll class="z__1 intro__header place__end-stretch grid__4 rows__2 mobile:grid__1 h__100v mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class="span__4 place__start-start grid__2 border__top inner-t__05">
			<a href="<?= $page->parent()->url() ?>" data-reveal-text="lines" class="upper">(<?= $page->parent() ? $page->parent()->title() : $page->title() ?>)</a>
			<div>
				<div data-reveal-text="lines" class="font__size__large lower m"><?= $page->excerpt()->or($page->intro()) ?></div>
			</div>
		</div>
		<div class="intro__title relative place__end-stretch span__4 mobile:span__1 inner-y__05" style="--in-delay: 500ms">
			<h1 class="">
				<div data-reveal-text=""><?= $page->title() ?></div>
			</h1>
		</div>
	</div>
</section>

<section class="about" theme="invert">
	<div data-scroll class="grid__3 gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2">
		<div class="span__2 grid place__start-start gap__3 mobile:inner-x__0">
			<h2 data-reveal-text="lines" class="font__size__4"><?= $page->intro()->inline() ?></h2>
		</div>
		
	</div>
	<div data-scroll class="grid__3 gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2">
		<div></div>
		<div class=" grid place__start-start gap__3 mobile:inner-x__0">
			<p data-reveal-text="lines" class=""><?= $page->details()->inline() ?></p>
		</div>
		
	</div>
</section>

<?= snippet('templates/globals/News') ?>

<?= snippet('templates/globals/Cta') ?>