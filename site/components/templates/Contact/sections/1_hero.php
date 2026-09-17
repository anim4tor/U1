<?php 
$cover = $page->cover()->toFile() ?? $page->image('contact_hero.jpg') ?? $page->images()->first(); 
?>
<section class="intro radius" theme="dark" style="--in-delay: 500ms">
	<?php if ($cover) : ?>
		<div class="intro__cover absolute inset__stretch grid" data-scroll><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
	<?php endif ?>
	<div data-scroll class="z__1 intro__header place__stretch-stretch grid__4 intro__rows mobile:grid__1 h__100v mobile:h__auto inner__4 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class=""></div>
		<div class="span__4 grid place__space-between-stretch">
			<div class="span__4 h__5 place__start-start grid__4 gap__2 border__top inner-t__05">
				<div class="span__2 upper font__size__small">
					(<?= $page->title() ?>)
				</div>
				<div class="span__2">
					<p data-reveal-text="lines" class="font__size__4 lower">
						<?= $page->intro()->isNotEmpty() ? $page->intro()->inline() : 'Spojte se s námi přímo nebo nám na vás zanechte kontakt. Ozveme se.' ?>
					</p>
				</div>
			</div>
			<div class="intro__title relative place__end-stretch span__4 mobile:span__1 inner-y__05" style="--in-delay: 500ms">
				<h1 class="font__size__1" data-reveal-text><?= $page->title() ?></h1>
			</div>
		</div>
	</div>
</section>
