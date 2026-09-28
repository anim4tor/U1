<?php
/**
 * Global Project Hero Snippet
 */
$theme = $theme ?? 'acc';
$cover = $cover ?? $page->cover()->toFile();
?>
<section class="intro radius" theme="<?= $theme ?>" style="--in-delay: 0ms">
	<?php if ($cover) : ?>
		<div class="intro__cover absolute inset__stretch grid" data-scroll >
			<?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?>
		</div>
	<?php endif ?>
	
	<div data-scroll class="z__1 intro__header place__end-stretch grid__4 mobile:grid__1 h__100v mobile:h__auto inner__4 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class="span__4 grid gap__1 place__stretch-stretch">
			<h1 class="secret-door">
				<div data-reveal-text=""><?= $page->title() ?></div>
			</h1>
			<div class="grid__4 border__top inner-y__1">
				<a href="<?= $page->parent() ? $page->parent()->url() : '#' ?>" data-reveal-text="lines" class="upper font__size__small">(<?= $page->parent() ? $page->parent()->title() : $page->title() ?>)</a>
				<?php if ($page->date()->isNotEmpty()) : ?>
					<div data-reveal-text="lines" class="upper font__size__small">(<?= $page->date()->toDate('Y') ?>)</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</section>
