<?= snippet('molecules/Gradient', [ 'from' => $page->gradientFrom(), 'to' => $page->gradientTo()->or('#db6b57') ]) ?>

<?php snippet('templates/globals/Intro', compact('page'), slots: true) ?>
  <?php slot('title') ?>
  	<div class="grid gap__02">
			<p data-reveal-text class="font__size__2 bolder m"><?= $page->date()->toDate('F d, Y') ?><span data-reveal data-scroll class="icon --circle wrap-l__04"></span></p>
			<h1 data-reveal-text class="font__size__2 lighter m"><?= $page->title() ?> </h1>
			<div class="flex gap__05 align__center wrap-t__1">
				<?= snippet('atoms/Button', ['url' => '', 'label' => 'Get your tickets', 'theme' => 'invert']) ?>
				<p class="flex gap__02 align__center">
					<span><?= $page->limit()->toBool() ? $page->seats() . ' tickets left' : 'Unlimited entry' ?></span>
					<span class="xs">•</span> 
					<span><?= !$page->free()->toBool() ? $page->price() . ',- Kč' : 'Free of charge' ?></span>
				</p>
			</div>
		</div>
  <?php endslot() ?>
  <?php slot('cover') ?><?php endslot() ?>
<?php endsnippet() ?>

<section class="about">
	<div class="grid__5 mobile:grid__1 place__start-stretch">
		<?php if ($cover = $page->cover()->toFile()) : ?>
			<div class="grid span__3 inner-r__2 mobile:inner-r__0 ( h__100v mobile:h__20 ) sticky top__0 mobile:relative " >
				<?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 0.2]) ?>
			</div>
		<?php endif ?>
		<div class="grid span__2 place__start-start gap__3 inner-y__4 inner-r__4 mobile:inner-x__1">
			<div class="grid place__start-start gap__1" data-scroll data-reveal-text="lines">
				<?= $page->desc() ?>
			</div>
		</div>
	</div>
</section>