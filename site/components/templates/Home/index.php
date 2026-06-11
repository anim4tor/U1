<?= snippet('molecules/Gradient', [ 'from' => $page->gradientFrom(), 'to' => $page->gradientTo() ]) ?>

<section class="intro">
	<div class="intro__header grid__5 mobile:grid__1 place__end-stretch h__20 mobile:h__auto inner-b__2 inner-x__1 mobile:inner-t__10 mobile:gap__2 relative" >
		<div class="intro__title span__3 mobile:span__1" data-scroll data-scroll-speed="-0.5">
			<h1 class="xl bolder">
				<?php 
					$title = explode(' ', $page->customTitle()->inline());
				?>
				<div data-reveal-text ><?= $title[0] ?></div>
				<div class="grid__stack place__start-start">
					<div data-reveal-text data-split-ignore data-reveal-text-out style="--in-delay: 200ms; --out-delay: 1600ms"><?= $title[1] ?></div>
					<div data-reveal-text data-split-ignore style="--in-delay: 2000ms"><?= $title[2] ?></div>
				</div>
				<!-- <?= $page->customTitle()->isNotEmpty() ? $page->customTitle() : $page->title() ?>. -->
			</h1>
		</div>
		<div class="intro__subtitle span__2 mobile:span__1 flex align__center gap__05 font__size__3" data-scroll data-scroll-ignore>
  		<div class="icon --circle" data-reveal data-scroll></div>
  		<div intro-slider class="intro__slider grid__stack">
  			<?php foreach ($page->subtitle()->toStructure() as $slide) : ?>
  				<p slide class="" data-reveal-repeat data-reveal-text data-split-ignore><?= $slide->text() ?></p>
  			<?php endforeach ?>
  		</div>
  	</div>
	</div>
	<?php if ($cover = $page->cover()->toFile()) : ?>
		<div class="intro__cover h__100v grid"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2]) ?></div>
	<?php endif ?>
</section>

<?php if ($page->intro()->isNotEmpty()) : ?>
<section class="about">
	<div class="grid__2 mobile:grid__1 inner-x__4 mobile:inner-x__1 inner-y__5">
		<?php if ($fig = $page->introFigure()->toFile()) : ?>
			<div class="grid" >
				<?= snippet('atoms/Image', ['img' => $fig, 'parallax' => 10, 'css' => 'h__100v mobile:h__20']) ?>
			</div>
		<?php endif ?>
		<div class="grid place__center-start gap__3 inner__4 mobile:inner-x__0">
			<?= snippet('molecules/Header', ['header' => $page->intro()]) ?>
		</div>
	</div>
</section>
<?php endif ?>

<?php if ($page->events()->isNotEmpty()) : ?>
<section class="events">
	<div class="relative grid__2 inner-x__4 -wrap-b__6 z__1">
		<div></div>
		<div class="wrap-x__4">
			<?php if ($fig = $page->eventsFigure()->toFiles()->nth(1)) : ?>
				<?= snippet('atoms/Image', ['img' => $fig, 'parallax' => 2]) ?>
			<?php endif ?>
		</div>
	</div>
	<div class="grid relative">
		<div class="absolute inset__stretch grid" >
			<?php if ($fig = $page->eventsFigure()->toFiles()->nth(0)) : ?>
				<?= snippet('atoms/Image', ['img' => $fig, 'parallax' => 2]) ?>
			<?php endif ?>
		</div>
		<div class="relative grid gap__07 place__end-center h__100v wrap-x__10 mobile:wrap-x__1 inner-y__2 text__center color__invert">
			<?php $header = $page->events() ?>
			<h3 class="m lighter"><?= $header->toBlocks()->findBy('type', 'heading') ?></h3>
			<div class="flex gap__02 mobile:grid__1 mobile:place__center-center mobile:gap__05 align__center">
				<p><?= $header->toBlocks()->findBy('type', 'text') ?></p>
				<?php if($button = $header->toBlocks()->findBy('type', 'button')) : ?>
					<?= snippet('atoms/Button', ['url' => $button->link()->toPage() ? $button->link()->toPage()->url() : $button->link()->url(), 'label' => $button->label(), 'theme' => $button->style()]) ?>
				<?php endif ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>

<?php if ($page->lectures()->isNotEmpty()) : ?>
<section class="lectures">
	<div class="inner-y__5 grid gap__5">
		<div class="grid inner-x__4 mobile:inner-x__1">
			<div class="grid place__center-start gap__1 wrap-x__10 mobile:wrap-x__0">
				<?= snippet('molecules/Header', ['header' => $page->lectures()]) ?>
			</div>
		</div>
		<div class="grid inner-x__4 mobile:inner-x__1">
			<div class="inner-y__1 border__bottom">
				<p class="s"><?= t('explore-lectures') ?></p>
			</div>
			<ul class="class__list grid">
				<?php foreach (collection('Lectures') as $lecture) : ?>
					<?= snippet('molecules/Lecture', compact('lecture')) ?>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
</section>
<?php endif ?>


<?= snippet('templates/globals/Cta') ?>