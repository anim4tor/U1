<?= snippet('molecules/Gradient', [ 'from' => $page->gradientFrom(), 'to' => $page->gradientTo() ]) ?>

<?php snippet('templates/globals/Intro', compact('page'), slots: true) ?>
  <?php slot('subtitle') ?>
  	<div class="intro__subtitle flex align__end gap__05 inner-r__2"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-bottom-left.svg') ?></span><p class="font__size__3 mobile:xs" data-reveal-text="words"><?= $page->subtitle() ?></p></div>
  <?php endslot() ?>
<?php endsnippet() ?>

<?php if ($page->intro()->isNotEmpty()) : ?>
<section class="intro">
	<div class="inner-x__1 inner-y__5 grid__3 mobile:grid__1">
		<div class="span__2 grid gap__1">
			<?= snippet('molecules/Header', ['header' => $page->intro()]) ?>
		</div>
	</div>
</section>
<?php endif ?>

<?php if ($page->features()->isNotEmpty()) : ?>
	<?php $gallery = $page->features()->toBlocks()->findBy('type', 'gallery')->images()->toFiles() ?>
	<section class="features">
		<div class="grid__2 mobile:grid__1 inner-x__1 inner-b__2">
			<?php if ($gallery->first()) : ?>
				<div class="grid" >
					<?= snippet('atoms/Image', ['img' => $gallery->first(), 'parallax' => 5]) ?>
				</div>
			<?php endif ?>
			<div class="grid place__center-start gap__1 inner__4 mobile:inner-x__0">
				<?= snippet('molecules/Header', ['header' => $page->features()]) ?>
				<?php if ($gallery->nth(1)) : ?>
					<div class="grid wrap-t__1" >
						<?= snippet('atoms/Image', ['img' => $gallery->last(), 'parallax' => 2, 'css' => 'aspect__square']) ?>
					</div>
				<?php endif ?>
			</div>
		</div>
	</section>
<?php endif ?>

<?php if ($page->details()->isNotEmpty()) : ?>
	<section class="details">
		<div class="grid inner-x__15 mobile:inner-x__1 inner-y__4 gap__3">
			<?= snippet('molecules/Header', ['header' => $page->details()]) ?>
		</div>
	</section>
<?php endif ?>
