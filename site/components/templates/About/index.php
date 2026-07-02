<?php if ($page->hero()->isNotEmpty()) : ?>
<section class="intro radius" theme="acc" style="--in-delay: 500ms">
	<div class="intro__cover overlay__bottom absolute inset__stretch grid">
		<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['cover']]) ?>		
	</div>
	<div class="z__1 intro__header place__stretch-stretch grid__4 gap__2 intro__rows mobile:grid__1 h__100v mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class=""></div>
		<div class="span__4 grid place__space-between-stretch">
			<div class="span__4 place__start-start grid__4 gap__2 border__top inner-t__05">
				<div class="span__2">
					<?= snippet('atoms/Text', ['text' => '(' . $page  . ')', 'reveal' => true ]) ?>	
				</div>
				<div>
					<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['text']]) ?>
				</div>
			</div>
			<div class="intro__title relative place__end-stretch span__4 mobile:span__1 inner-y__05" style="--in-delay: 500ms">
				<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['heading']]) ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>


<?php if ($page->about()->isNotEmpty()) : ?>
<section class="about" theme="invert">
	<div class="grid__3 gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2 inner-b__5">
		<div class="span__2 grid place__start-start gap__3 mobile:inner-x__0 s">
			<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['heading']]) ?>
		</div>
		<div></div>
		<div></div>
		<div class="grid gap__2">
			<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['image']]) ?>
			<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['text']]) ?>
		</div>
		<div class="flex justify__end">(<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['label']]) ?>)</div>
	</div>
</section>
<?php endif ?>

<?php if (collection('Values')->isNotEmpty()) : ?>
<section class="values" theme="invert">
	<div class="grid__2 gap__2 relative inner-y__1 border__top inner-b__5" data-tabs="">
		<div class="sticky top__0 gap__2 grid place__space-between-start h__100v inner-y__1" >
			<div class="relative flex inner-x__1 ">
				<?= snippet('atoms/Text', ['text' => '(Our values)', 'reveal' => true ]) ?>	
			</div>
			<div class="grid place__start-start gap__1">
				<div class="grid inner-x__1" >
					<?php foreach (collection('Values') as $step) : ?>
						<div data-tab="step-<?= $step->step()?>" class="flex align__start gap__02" data-scroll data-tab-reveal>
							<?= snippet('atoms/Heading', [ 'level' => 'h3', 'text' => $step->value(), 'reveal' => true, 'css' => 'm', 'node' => 'data-split-ignore' ]) ?>
						</div>
					<?php endforeach ?>
				</div>
				<div class="grid place__start-start inner-x__1 " data-scroll data-scroll-ignore>
					<div data-pane-container class="grid__stack">
						<?php foreach (collection('Values') as $step) : ?>
						<div data-pane="step-<?= $step->step()?>" class="grid__2" data-tab-reveal>
							<?= snippet('atoms/Text', ['text' => $step->detail()->inline(), 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>
						</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</div>
		<div class="grid inner-r__1">
			<?php foreach (collection('Values') as $step) : ?>
				<?php if ($img = $step->figure()->toFile()) : ?>
					<div data-pane-trigger="step-<?= $step->step() ?>" id="trigger-<?= $step->step() ?>" class="h__100v grid">
						<?= snippet('atoms/Image', ['img' => $img, 'parallax' => 5, 'reveal' => false, 'css' => 'radius']) ?>
					</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	</div>
</section>
<?php endif ?>


<section class="teams radius" theme="invert" >
	<div class="relative grid gap__0 inner-x__1">
		<div class="flex justify__space-between border__top inner-y__1" data-scroll>
			<?= snippet('atoms/Text', ['text' => '(Our teams)', 'reveal' => true ]) ?>	
			<div></div>
		</div>
		<div class="grid__4 gap__2 relative place__start-start inner-y__2 inner-b__5" data-tabs="hoverable">
			<div class="grid place__start-start" data-pane-container>
				<div class="grid__stack no__overflow img__radius">
					<?php foreach (collection('Team') as $team) : ?>
						<?php if ($leader = $team->leader()->toPage()) : ?>
						<div data-pane="team-<?= $team->indexOf(collection('Team')) ?>" class="" data-scroll data-scroll-ignore data-tab-reveal>
							<div class="grid gap__05">
								<?php if ($img = $team->figure()->toFile()) : ?>
									<?= snippet('atoms/Image', ['img' => $img, 'parallax' => false, 'reveal' => false, 'css' => 'aspect__4/3', 'node' => 'data-reveal-image']) ?>
								<?php endif ?>
								<?= snippet('atoms/Text', ['text' => $team->details()->inline(), 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>
							</div>
						</div>
						<?php endif ?>
					<?php endforeach ?>
				</div>
			</div>
			<div></div>
			<div class="span__2 grid place__start-start gap__2" >
				<div class="grid gap__02 place__start-start" >
					<?php foreach (collection('Team') as $team) : ?>
						<?php
							$employees = collection('Employees')->filterBy('team', '*=', $team->name())->count();
						?>
						<div data-tab="team-<?= $team->indexOf(collection('Team')) ?>" class="flex gap__02" data-scroll>
							<?= snippet('atoms/Heading', [ 'level' => 'h3', 'text' => $team->name(), 'reveal' => true, 'css' => 'm', 'node' => 'data-split-ignore' ]) ?>
						</div>
					<?php endforeach ?>
				</div>
				
			</div>
		</div>
	</div>
	
</section>

<?= snippet('templates/Home/Testimonials') ?>

<section class="people " theme="invert" >
	<div class="relative grid gap__5 inner-x__1 ">
		<div class="border__top inner-y__1" data-scroll>
			<h2 class="l flex justify__space-between" data-reveal-text>
				<span class="">The</span>
				<span class="">People</span>
			</h2>
		</div>
		<div class="grid__3 inner-b__5" data-tabs="hoverable">
			<div class="grid gap__02 place__start-stretch span__2">
				
			<?php foreach (collection('Team') as $team) : ?>
				<div id="<?= $team->name()->slug() ?>" class="grid__2 gap__2 relative" >
					
					<div class="grid place__start-start " >
						<div class="grid place__start-start gap__1 " data-scroll>
							<?= snippet('atoms/Text', ['text' => '(' . $team->name()  . ')', 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>							
						</div>
					</div>
					<div class="grid gap__02 place__start-start gap__2 " >
						<?php foreach (collection('Employees')->filterBy('team', $team->name()) as $employee) : ?>
							<div data-tab="people-<?= $employee->indexOf(collection('Employees')) ?>" class="flex gap__02" data-scroll>
								<h3 class="no__wrap" data-reveal-text data-split-ignore><?= $employee->title() ?></h3>
							</div>
						<?php endforeach ?>
					</div>
					
				</div>
			<?php endforeach ?>
			</div>
			<div class="grid place__start-end" data-pane-container>
				<div class="sticky top__8 grid__stack no__overflow img__radius">
					<?php foreach (collection('Employees') as $employee) : ?>
						<div data-pane="people-<?= $employee->indexOf(collection('Employees')) ?>" class="" data-scroll data-scroll-ignore data-tab-reveal>
							<div class="grid place__start-end gap__05">
								<?php if ($photo = $employee->photo()->toFile()) : ?>
									<?= snippet('atoms/Image', ['img' => $photo, 'parallax' => false, 'reveal' => false, 'css' => 'w__10 aspect__3/4', 'node' => 'data-reveal-image']) ?>
								<?php endif ?>
								<div class="flex gap__05 justify__space-between upper wrap">
									<?= snippet('atoms/Text', ['text' => '(' . $employee->role() . ')', 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>
								</div>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
	
</section>

<?php if ($page->career()->isNotEmpty()) : ?>
<section class="careers" theme="invert">
	<div class="grid__2 gap__2 place__stretch-stretch inner__1 inner-y__2 inner-b__5">
		<div class="relative grid gap__5 place__start-stretch" data-scroll >
			<div class="grid place__space-between-stretch" data-reveal-text>
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['heading']]) ?>
			</div>
			<div class="flex justify__space-between gap__4 inner-y__1 inner-b__3 border__top">
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['text']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['button']]) ?>
			</div>
		</div>
		<div class="grid inner-l__3" data-scroll >
			<?= snippet('molecules/Header', ['header' => $page->career(), 'type' => ['image']]) ?>
		</div>

	</div>
</section>
<?php endif ?>

<?= snippet('templates/globals/Feed') ?>
<?= snippet('templates/globals/Cta') ?>



