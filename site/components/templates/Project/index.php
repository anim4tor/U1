<section class="intro radius" theme="acc" style="--in-delay: 500ms">
	<?php if ($cover = $page->cover()->toFile()) : ?>
	<div class="intro__cover absolute inset__stretch grid" data-scroll ><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
	<?php endif ?>
	<div data-scroll class="z__1 intro__header place__stretch-stretch grid__4 rows__2 mobile:grid__1 h__100v mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class="span__4 border__bottom"></div>
		<div class="span__4 inner-t__05 grid__4 place__space-between-stretch">
			<div data-reveal-text="lines" class="upper s">(<?= $page->parent() ? $page->parent()->title() : $page->title() ?>)</div>
			<div data-reveal-text="lines" class="upper s">(<?= $page->industry() ?>)</div>
			<div class="span__2">
				<h1 class="xs">
					<div data-reveal-text=""><?= $page->title() ?></div>
				</h1>
			</div>
			<div class="span__2"></div>
			<div class="span__2 grid__2 gap__2 relative place__end-stretch mobile:span__1 inner-y__05" style="--in-delay: 500ms">
				<!-- <div data-reveal-text="lines" class="upper s"><?= $page->client() ?></div> -->
				<!-- <div data-reveal-text="lines" class="upper s"><?= $page->space() ?></div> -->
				<div data-reveal-text="lines" class="upper s"><?= $page->date()->toDate('Y') ?></div>
				<div data-reveal-text="lines" class="upper s"><?= $page->place() ?></div>
			</div>
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

<section class="gallery" theme="invert">
	<div class="grid__2 gap__2 inner__1">
		<?php foreach ($page->gallery()->toFiles() as $image) : ?>
			<?php if($image->orientation() == "landscape") : ?>
				<div class="grid span__2" data-scroll ><?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => '']) ?></div>
			<?php else : ?>
				<div class="grid" data-scroll ><?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => '']) ?></div>
			<?php endif; ?>
		<?php endforeach ?>
	</div>
</section>

<?= snippet('templates/globals/News') ?>

<?= snippet('templates/globals/Cta') ?>