<section class="intro radius">
	<div class="intro__header grid__4 mobile:grid__1 h__100v mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative color__invert" data-scroll>
		<?php if ($cover = $page->cover()->toFile()) : ?>
			<div class="intro__cover absolute inset__stretch grid "><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
		<?php endif ?>
		<div class="span__4 grid__4 relative flex justify__space-between align__end" data-reveal-text="words">
			<div class="upper s">Featured project</div>
			<div class="upper s ">Myrtle Pool House</div>
			<div class="upper s flex justify__end">2024</div>
			<div class="upper s flex justify__end">Next</div>
		</div>
		<div class="intro__title relative place__end-stretch span__4 mobile:span__1 inner-y__1" data-scroll data-scroll-speed="-0.5">
			<h1 class="xl">
				<div data-reveal-text="">We deliver <br> workspaces <br>that works</div>
				
				<!-- <?php 
					$title = explode(' ', $page->customTitle()->inline());
				?>
				<div class="flex justify__space-between">
					<div data-reveal-text="chars" ><?= $title[0] ?></div>
					<div data-reveal-text="chars" ><?= $title[1] ?></div>
				</div>
				<div class="flex justify__center">
					<div data-reveal-text="chars" class="wrap-l__20"><?= $title[2] ?></div>
				</div> -->
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
				<?= snippet('atoms/Image', ['img' => $fig, 'parallax' => 5, 'css' => 'h__20 mobile:h__20 radius']) ?>
			</div>
		<?php endif ?>
		<div class="grid place__start-end"><?= snippet('molecules/Header', ['header' => $page->intro(), 'type' => ['label']]) ?></div>
		<div></div>
		<div class="grid place__center-start gap__3 s upper">
			<?= snippet('molecules/Header', ['header' => $page->intro(), 'type' => ['text']]) ?>
		</div>
		<div></div>
		<div class="span__3 flex justify__space-between">
			<?php foreach ($page->introFeatures()->toStructure() as $feature) : ?>
				<div class="flex inner-y__2" data-scroll>
					<div class="font__size__1 ff__heading xxl outlined" data-reveal-text><?= $feature->feature() ?></div>
					<div class="s" data-reveal-text="lines"><?= $feature->label() ?></div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</section>
<?php endif ?>

<section class="projects radius" theme="dark">
	<div class="grid__3 gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2 inner-b__5">
		<div data-scroll class="span__2">
			<h2 class="font__size__1 xl" data-reveal-text>
				Featured Work
			</h2>
		</div>

		<div class="flex justify__end align__end m"><?= snippet('atoms/Link', ['url' => 'projects', 'label' => 'All projects']) ?></div>
		<ul class="flex justify__start align__start no__wrap gap__1">	
		<?php foreach (collection('Projects') as $project) : ?>
			<?= snippet('molecules/Project', compact('project')) ?>
		<?php endforeach ?>
		<?php foreach (collection('Projects') as $project) : ?>
			<?= snippet('molecules/Project', compact('project')) ?>
		<?php endforeach ?>
		</ul>
		
	</div>
</section>

<section class="testimonials radius">
	<?php if ($cover = $page->cover()->toFile()) : ?>
		<div class="intro__cover absolute inset__stretch grid "><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
	<?php endif ?>
	<div class="relative grid__3 gap__2 h__100v mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2" >
		<div></div>
		<div class="grid place__center-center" data-scroll data-reveal-image>
			<div class="grid gap__2 place__space-between-start h__20 inner__1 radius" theme="light">
				<div class="grid gap__1">
					<div class="flex justify__space-between">
						<div class="s upper " data-reveal-text="lines">(Testimonials)</div>
						<div class="s" data-reveal-text="lines">01/08</div>
					</div>
					<p class="quote ff__body upper m">"Working with this team has been a game-changer for our business. Their attention to detail and ability to deliver high-quality results on schedule is unmatched. I highly recommend them to anyone looking for reliable and professional expertise."</p>
				</div>
					<?= snippet('atoms/Image', ['url' => 'testimonial.png', 'parallax' => 2, 'css' => 'w__3']) ?>
				<!-- <div class="flex justify__space-between">
					<div class="s upper " data-reveal-text="lines">David L.</div>
					<div class="s upper" data-reveal-text="lines">(Operations Manager)</div>
				</div> -->
			</div>
		</div>
		<div></div>
	</div>
</section>

<section class="process" theme="light">
	<div class="grid__4 mobile:grid__1 mobile:h__auto inner__1 inner-y__2 mobile:inner-t__10 mobile:gap__2 relative" theme="light" data-scroll>
		<!-- <?php if ($cover = $page->cover()->toFile()) : ?>
			<div class="intro__cover absolute inset__stretch grid overlay__bottom"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2]) ?></div>
		<?php endif ?> -->
		<div class="intro__title relative span__3 mobile:span__1" data-scroll data-scroll-speed="-0.5">
			<h1 class="xl" data-reveal-text>Overview Of Our 5-Stage Process</h1>
		</div>
		<div class="relative flex justify__end align__end"><strong class="s upper" data-reveal-text="lines">(The Process)</strong></div>
	</div>
	<div class="grid__3 gap__2 relative place__start-start inner-y__2" theme="light" data-tabs>
		<div class="span__2 sticky top__0 grid__2 place__end-start" >
			<div class="sticky bottom__0 grid place__start-start gap__05 inner__1 inner-y__2" >
				<?php foreach (collection('Process') as $step) : ?>
					<div data-tab class="flex align__start gap__05" data-scroll >
						<span data-reveal-text="lines" class="-wrap-t__05">(<?= $step->step() ?>)</span>
						<h3 class="font__size__1 s" data-reveal-text="lines"><?= $step->label() ?></h3>
					</div>
				<?php endforeach ?>
			</div>
			<div class="grid place__start-end h__100v inner__1 inner-y__2" data-scroll >
				<div data-pane-container class="">
					<?php foreach (collection('Process') as $step) : ?>
					<div data-pane="step-<?= $step->step()?>">
						<p class="upper s" data-reveal-text="lines"><?= $step->detail()->inline() ?></p>
					</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
		<div class="grid gap__1">
			<?php foreach (collection('Process') as $step) : ?>
				<?php if ($img = $step->figure()->toFile()) : ?>
					<div data-pane-trigger=step-<?= $step->step()?> id="trigger-<?= $step->step() ?>" class=""><?= snippet('atoms/Image', ['img' => $img, 'parallax' => 10, 'reveal' => false, 'css' => 'h__20 radius']) ?></div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	</div>
</section>

<section class="solutions radius" theme="dark">
	<div class="grid__2 mobile:grid__1 mobile:h__auto inner__1 inner-y__2 mobile:inner-t__10 mobile:gap__2 relative" >
		<div class="sticky top__0 grid place__space-between-start" data-scroll>
			<strong class="s upper" data-reveal-text="lines">(Our solutions)</strong>
			<div class="grid__stack">
				<?php foreach (collection('Solutions') as $solution) : ?>
					<?php if ($img = $solution->cover()->toFile()) : ?>
						<div class=""><?= snippet('atoms/Image', ['img' => $img, 'parallax' => 10, 'reveal' => false, 'css' => 'h__5 radius']) ?></div>
					<?php endif ?>
				<?php endforeach ?>
			</div>
		</div>
		<ul class="grid gap__05">
			<?php foreach (collection('Solutions') as $solution) : ?>
				<div class="flex align__start gap__05" data-scroll>
					<h3 class="font__size__1 s" data-reveal-text><?= $solution->title() ?></h3>
				</div>
			<?php endforeach ?>
		</ul>
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

<?php if ($page->projects()->isNotEmpty()) : ?>
<section class="lectures">
	<div class="inner-y__5 grid gap__5">
		<div class="grid inner-x__4 mobile:inner-x__1">
			<div class="grid place__center-start gap__1 wrap-x__10 mobile:wrap-x__0">
				<?= snippet('molecules/Header', ['header' => $page->projects()]) ?>
			</div>
		</div>
		<div class="grid inner-x__4 mobile:inner-x__1">
			<div class="inner-y__1 border__bottom">
				<p class="s"><?= t('explore-lectures') ?></p>
			</div>
			<ul class="class__list grid">
				<?php foreach (collection('Projects') as $project) : ?>
					<?= snippet('molecules/Project', compact('project')) ?>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
</section>
<?php endif ?>


<?= snippet('templates/globals/Cta') ?>