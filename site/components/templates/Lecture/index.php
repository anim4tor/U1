<?= snippet('molecules/Gradient', [ 'from' => $page->gradientFrom()->or('#f49a32'), 'to' => $page->gradientTo()->or('#db6b57') ]) ?>

<?php snippet('templates/globals/Intro', compact('page'), slots: true) ?>
  <?php slot('subtitle') ?>
  	<div class="intro__subtitle flex align__end gap__05 inner-r__2"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-bottom-left.svg') ?></span><p class="font__size__3" data-reveal-text="words"><?= $page->subtitle() ?></p></div>
  <?php endslot() ?>
<?php endsnippet() ?>

<?php if ($page->intro()->isNotEmpty()) : ?>
<section class="intro">
	<div class="inner-x__1 inner-y__5 grid__3 mobile:grid__1">
		<div class="span__2 mobile:span__1 grid gap__1">
			<p>About <?= $page->title() ?> yoga</p>
			<?= snippet('molecules/Header', ['header' => $page->intro()]) ?>
		</div>
	</div>
</section>
<?php endif ?>

<?php if ($page->features()->isNotEmpty()) : ?>
	<?php $gallery = $page->features()->toBlocks()->findBy('type', 'gallery')->images()->toFiles() ?>
	<section class="features">
		<div class="grid__2 mobile:grid__1 inner-x__1 inner-b__2">
			<?php if ($gallery->first()->isNotEmpty()) : ?>
				<div class="grid" >
					<?= snippet('atoms/Image', ['img' => $gallery->first(), 'parallax' => 5]) ?>
				</div>
			<?php endif ?>
			<div class="grid place__center-start gap__1 inner__4 mobile:inner-x__1">
				<?= snippet('molecules/Header', ['header' => $page->features()]) ?>
				<?php if ($gallery->last()->isNotEmpty()) : ?>
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
		<div class="grid inner-x__15 mobile:inner-x__1 inner-t__4 gap__3">
			<?= snippet('molecules/Header', ['header' => $page->details()]) ?>
		</div>
	</section>
<?php endif ?>

<?php if ($page->meditation()->isNotEmpty()) : ?>
	<section class="meditation">
		<div class="sticky__wrapper relative" data-scroll data-scroll-repeat data-scroll-ignore data-scroll-progress data-scroll-offset="100%,100%">
			<div class="sticky top__0 inner-y__5 grid place__center-center h__100v gap__5 no__overflow" > 
				<div class="grid wrap-x__12 mobile:wrap-x__2">
					<h3 data-reveal-text="words" data-reveal-progress class="m lighter text__center"><?= $page->meditation() ?></h3>
				</div>
				<div class="octagon grid grid__stack absolute inset__center" data-scroll-trigger style="--start: 0.01; --end: 0.95">
					<?= svg('public/assets/images/octagon.svg') ?>
					<?= svg('public/assets/images/octagon.svg') ?>
				</div>
			</div>
		</div>
	</section>
<?php endif ?>

<?php if ($page->gallery()->isNotEmpty()) : ?>
	<?php $gallery = $page->gallery()->toBlocks()->findBy('type', 'gallery')->images()->toFiles() ?>
	<section class="photos">
		<?php if ($gallery->count() == 3) : ?>
			<div class="inner-x__4 mobile:inner-x__1 grid__2 gap__2">
					<?php if ($gallery->nth(0)) : ?>
						<div class="grid inner-r__2 h__12 wrap-t__4 ">
							<?= snippet('atoms/Image', ['img' => $gallery->nth(0), 'parallax' => 2 ]) ?>
						</div>
					<?php endif ?>
					<?php if ($gallery->nth(1)) : ?>
						<div class="grid -wrap-l__2">
							<?= snippet('atoms/Image', ['img' => $gallery->nth(1), 'parallax' => 2, 'css' => 'aspect__6/8']) ?>
						</div>
					<?php endif ?>
					<?php if ($gallery->nth(2)) : ?>
						<div class="span__2 grid place__start-center -wrap-t__10">
							<div class="grid h__20">
								<?= snippet('atoms/Image', ['img' => $gallery->nth(2), 'parallax' => 2, 'css' => 'aspect__6/8']) ?>
							</div>
						</div>
					<?php endif ?>
			</div>
		<?php endif ?>
	</section>
<?php endif ?>

<section class="classes">
	<div class="inner-y__5 grid gap__5">
		<div class="grid inner-x__4 mobile:inner-x__1">
			<div class="inner-y__1 border__bottom">
				<p class="s"><?= t('other-lectures') ?></p>
			</div>
			<ul class="class__list grid">
				<?php foreach (collection('Lectures')->not($page) as $lecture) : ?>
					<?= snippet('molecules/Lecture/small', compact('lecture')) ?>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
</section>
