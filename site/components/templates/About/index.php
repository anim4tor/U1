<section class="intro radius" theme="acc" style="--in-delay: 500ms">
	<?php if ($cover = $page->cover()->toFile()) : ?>
	<div class="intro__cover absolute inset__stretch grid" data-scroll ><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
	<?php endif ?>
	<div data-scroll class="z__1 intro__header place__stretch-stretch grid__4 gap__2 intro__rows mobile:grid__1 h__100v mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative color__invert">
		<div class=""></div>
		<div class="span__4 grid place__space-between-stretch">
			<div class="span__4 place__start-start grid__4 gap__2 border__top inner-t__05">
				<div class="span__2">
					<div data-reveal-text="lines" class="upper">(About)</div>
				</div>
				<div>
					<p data-reveal-text="lines" class="font__size__5 lower"><?= $page->intro()->inline() ?></p>
				</div>
			</div>
			<div class="intro__title relative place__end-stretch span__4 mobile:span__1 inner-y__05" style="--in-delay: 500ms">
				<h1 class="l flex justify__space-between">
					<div data-reveal-text=""><?= $page->title() ?></div>
					<div data-reveal-text="">Us</div>
				</h1>
			</div>
		</div>
	</div>
</section>

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
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		</div>
		<div class="flex justify__end">(<?= snippet('molecules/Header', ['header' => $page->about(), 'type' => ['label']]) ?>)</div>
	</div>
</section>
<?php endif ?>

<?php if (collection('Values')->isNotEmpty()) : ?>
<section class="values" theme="invert">
	<div class="grid__2 gap__2 relative place__start-start inner-y__1 border__top inner-b__5" data-tabs="">
		<div class="sticky top__0 gap__2 grid place__space-between-start h__100v inner-y__1" >
			<div class="relative flex inner-x__1 " data-scroll><p class=" upper" data-reveal-text="lines">(Our values)</p></div>
			<div class="grid place__start-start gap__1">
				<div class="grid inner-x__1" >
					<?php foreach (collection('Values') as $step) : ?>
						<div data-tab="step-<?= $step->step()?>" class="flex align__start gap__02" data-scroll data-tab-reveal>
							<h3 class="m" data-reveal-text data-split-ignore><?= $step->value() ?></h3>
							<!-- <span data-reveal-text="lines" class="-wrap-t__03">(<?= $step->step() ?>)</span> -->
						</div>
					<?php endforeach ?>
				</div>
				<div class="grid place__start-start inner-x__1 " data-scroll data-scroll-ignore>
					<div data-pane-container class="grid__stack">
						<?php foreach (collection('Values') as $step) : ?>
						<div data-pane="step-<?= $step->step()?>" class="grid__2" data-tab-reveal>
							<p class="upper" data-reveal-text="lines" data-split-ignore data-tab-reveal><?= $step->detail()->inline() ?></p>
						</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</div>
		<div class="grid inner-r__1">
			<?php foreach (collection('Values') as $step) : ?>
				<?php if ($img = $step->figure()->toFile()) : ?>
					<div data-pane-trigger="step-<?= $step->step() ?>" id="trigger-<?= $step->step() ?>" class="">
						<?= snippet('atoms/Image', ['img' => $img, 'parallax' => 8, 'reveal' => false, 'css' => 'vh__20 radius']) ?>
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
			<span class="upper">(Divisions)</span>
			<div></div>
		</div>
		<div class="grid__4 gap__2 relative place__start-start inner-y__2 inner-b__5" data-tabs="hoverable">
			<div class="grid place__start-start" data-pane-container>
				<div class="grid__stack no__overflow img__radius">
					<?php foreach (collection('Team') as $team) : ?>
						<?php if ($leader = $team->leader()->toPage()) : ?>
						<div data-pane="team-<?= $team->indexOf(collection('Team')) ?>" class="" data-scroll data-scroll-ignore data-tab-reveal>
							<div class="grid place__start-start gap__05">
								<?php if ($img = $team->figure()->toFile()) : ?>
									<div data-tab-reveal-image class="item__figure img__radius no__overflow "><?= snippet('atoms/Image', ['img' => $img, 'parallax' => 1, 'css' => 'aspect__4/3 grid' ]) ?></div>
								<?php endif ?>

								<p class="" data-reveal-text="lines" data-split-ignore ><?= $team->details()->inline() ?></p>

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
							<h3 class="m" data-reveal-text data-split-ignore><?= $team->name() ?></h3>
							<!-- <div data-reveal-text="" data-split-ignore style="--in-delay: 800ms" class="-wrap-t__01">(<?= $employees ?>)</div> -->
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
						<div class="grid place__start-start gap__1 ">
							<div class="upper">(<?= $team->name() ?>)</div>
							<!-- <p class=""><?= $team->details()->inline() ?></p> -->
							
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
									<div data-tab-reveal-image class="item__figure img__radius no__overflow "><?= snippet('atoms/Image', ['img' => $photo, 'parallax' => 1, 'css' => 'w__10 aspect__3/4 grid' ]) ?></div>
								<?php endif ?>

								<div class="flex gap__05 justify__space-between upper wrap">
									<h3 class="font__size__default s ff__body" data-split-ignore data-reveal-text="lines" >(<?= $employee->role() ?>)</h3>
								</div>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
	
</section>


<?php if (collection('Jobs')->isNotEmpty()) : ?>
<section class="careers" theme="invert">
	<div class="grid__2 gap__2 place__stretch-stretch inner__1 inner-y__2 inner-b__5">
		<div class="relative grid gap__5 place__start-stretch">
			<div class="grid place__space-between-stretch">
				<h2 class="">Be part of a team creating meaningful places.</h2>
			</div>
			<div class="flex justify__space-between gap__4 inner-y__1 inner-b__3 border__top">
				<p class="l lower">Be part of a team creating meaningful places. We are looking for motivated, curious and dedicated talent who want to contribute to our growth while sharing our values.</p>
				<?= snippet('atoms/Button', [ 'url' => page('Career')->url(), 'label' => 'Open positions', 'theme' => 'invert', 'icon' => 'arrow-right']) ?>
			</div>
		</div>
		<div class="grid inner-l__3">
			<?= snippet('atoms/Image', ['img' => collection('Process')->first()->figure()->toFile(), 'parallax' => 5, 'reveal' => false, 'css' => 'radius']) ?>
		</div>

	</div>
</section>
<?php endif ?>

<?= snippet('templates/globals/Feed') ?>
<?= snippet('templates/globals/Cta') ?>



