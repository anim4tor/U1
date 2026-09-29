<?= snippet('templates/globals/Hero') ?>


<section class="about" theme="invert">
	<div data-scroll class="grid__4 gap__2 mobile:grid__1 inner__4 mobile:inner-x__1 ">
		<div class="span__2">
			<?= snippet('atoms/Label', ['text' => t('about-solution')]) ?>
		</div>
		<div class="span__2 grid place__start-start gap__2 mobile:inner-x__0">
			<h3 data-reveal-text="lines" class="font__size__3"><?= $page->intro()->inline() ?></h3>
			<div class=" grid place__start-start gap__3 mobile:inner-x__0">
				<p data-reveal-text="lines" class=""><?= $page->details()->inline() ?></p>
			</div>
		</div>
	</div>
</section>

<?php if ($page->gallery()->isNotEmpty() && ($galleryImages = $page->gallery()->toFiles()) && $galleryImages->isNotEmpty()) : ?>
<section class="gallery" theme="invert">
	<!-- randomizace -->
	<div class="grid__4 gap__2 gap-y__4 inner__4">
		<?php foreach ($galleryImages as $image) : ?>
			<?php if($image->orientation() == "landscape") : ?>
				<div class="grid place__center-center span__2 inner__0" data-scroll ><?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'vw__'.rand(5,9) . ' vh__'.rand(10,14) . ' aspect__1/1']) ?></div>
			<?php else : ?>
				<div class="grid place__center-center inner__0" data-scroll ><?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => 'vw__'.rand(5,9) . ' vh__'.rand(10,14) . ' aspect__1/1']) ?></div>
			<?php endif; ?>
		<?php endforeach ?>
	</div>
</section>
<?php endif ?>

<?= snippet('templates/globals/Projects/related', ['projects' => $page->relatedProjects()]) ?>
<?= snippet('templates/globals/Feed/related') ?>
<?= snippet('templates/globals/Cta') ?>