<section class="intro">
	<div class="intro__header grid__4 mobile:grid__1 h__100v mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative" theme="dark" data-scroll>
		<?php if ($cover = $page->cover()->toFile()) : ?>
			<div class="intro__cover absolute inset__stretch grid overlay__bottom"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2]) ?></div>
		<?php endif ?>
		<div class="span__4 grid__4 relative flex justify__space-between align__end" data-reveal-text="words">
			<div class="upper s">Featured project</div>
			<div class="upper s ">Myrtle Pool House</div>
			<div class="upper s flex justify__end">2024</div>
			<div class="upper s flex justify__end">Next</div>
		</div>
		<div class="intro__title relative place__end-stretch span__4 mobile:span__1" data-scroll data-scroll-speed="-0.5">
			<h1 class="xl">
				<?php 
					$title = explode(' ', $page->customTitle()->inline());
				?>
				<div class="flex justify__space-between">
					<div data-reveal-text="chars" ><?= $title[0] ?></div>
					<div data-reveal-text="chars" ><?= $title[1] ?></div>
				</div>
				<div class="flex justify__center">
					<div data-reveal-text="chars" class="wrap-l__20"><?= $title[2] ?></div>
				</div>
			</h1>
		</div>
	</div>
</section>

<?php if ($page->intro()->isNotEmpty()) : ?>
<section class="about">
	<div class="grid__3 gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2">
		<div class="span__2 grid place__start-start gap__3 mobile:inner-x__0">
			<?= snippet('molecules/Header', ['header' => $page->intro(), 'type' => ['heading']]) ?>
		</div>
		<div></div>
		<div></div>
		<?php if ($fig = $page->introFigure()->toFile()) : ?>
			<div class="grid" >
				<?= snippet('atoms/Image', ['img' => $fig, 'parallax' => 5, 'css' => 'h__20 mobile:h__20']) ?>
			</div>
		<?php endif ?>
		<div class="grid place__start-end"><?= snippet('molecules/Header', ['header' => $page->intro(), 'type' => ['label']]) ?></div>
		<div></div>
		<div class="grid place__center-start gap__3">
			<?= snippet('molecules/Header', ['header' => $page->intro(), 'type' => ['text']]) ?>
		</div>
		<div></div>
		<div class="span__3 flex justify__space-between">
			<?php foreach ($page->introFeatures()->toStructure() as $feature) : ?>
				<div class="flex inner-y__2" data-scroll>
					<div class="font__size__1 ff__heading xxl" data-reveal-text><?= $feature->feature() ?></div>
					<div class="s" data-reveal-text="lines"><?= $feature->label() ?></div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</section>
<?php endif ?>

<section class="projects" theme="dark">
	<div class="grid__3 gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2">
		<div data-scroll class="span__2">
			<h2 class="font__size__1 xl" data-reveal-text>
				Featured Works
			</h2>

		</div>
		<div class="relative font__size__1 xl flex justify__end align__end">(↓)</div>
		<?php if ($fig = $page->introFigure()->toFile()) : ?>
			<div class="grid" >
				<?= snippet('atoms/Image', ['img' => $fig, 'parallax' => 5, 'css' => 'h__20 mobile:h__20']) ?>
			</div>
			<div class="grid" >
				<?= snippet('atoms/Image', ['img' => $fig, 'parallax' => 5, 'css' => 'h__20 mobile:h__20']) ?>
			</div>
			<div class="grid" >
				<?= snippet('atoms/Image', ['img' => $fig, 'parallax' => 5, 'css' => 'h__20 mobile:h__20']) ?>
			</div>
		<?php endif ?>
	</div>
</section>

<section class="testimonials" theme="dark">
	<div class="grid__3 gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2">
		
	</div>
</section>

<section class="process" theme="darl">
	<div class="intro__header grid__4 mobile:grid__1 h__100v mobile:h__auto inner__1 inner-y__2 mobile:inner-t__10 mobile:gap__2 relative" theme="dark" data-scroll>
		<?php if ($cover = $page->cover()->toFile()) : ?>
			<div class="intro__cover absolute inset__stretch grid overlay__bottom"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2]) ?></div>
		<?php endif ?>
		<div class="intro__title relative span__3 mobile:span__1" data-scroll data-scroll-speed="-0.5">
			<h1 class="xl" data-reveal-text>Overview Of Our 6-Stage Process</h1>
		</div>
		<div class="relative font__size__1 xl flex justify__end align__end">(↓)</div>
	</div>
</section>


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