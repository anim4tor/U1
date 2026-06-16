<?= snippet('templates/Home/Intro') ?>

<?= snippet('templates/Home/About') ?>

<?= snippet('templates/Home/Projects') ?>

<?= snippet('templates/Home/Testimonials') ?>

<?= snippet('templates/Home/Process') ?>

<?= snippet('templates/Home/Services') ?>

<?php if ($page->events()->isNotEmpty()) : ?>
<section class="events" theme="light">
	<div class="relative grid__2 gap__2 inner-x__1 inner-y__2">
		<div class="" data-scroll>
			<h1 class="xl" data-reveal-text>Studio</h1>
		</div>
		<div class="grid gap__1" data-scroll>
			<h2 class="font__size__1 s" data-reveal-text>News</h2>
			<h2 class="font__size__1 s op__4" data-reveal-text>Socials</h2>
			<h2 class="font__size__1 s op__4" data-reveal-text>Media</h2>
		</div>
	</div>
	<div class="inner__1 inner-y__2 inner-b__5">
		<ul class="flex justify__start align__start no__wrap gap__1">	
		<?php foreach (collection('Projects') as $new) : ?>
			<?= snippet('molecules/New', compact('new')) ?>
		<?php endforeach ?>
		<?php foreach (collection('Projects') as $new) : ?>
			<?= snippet('molecules/New', compact('new')) ?>
		<?php endforeach ?>
		</ul>
	</div>
</section>
<?php endif ?>

<section class="team" theme="invert" data-tabs>
	<div class="relative grid gap__2 inner-x__1 inner-y__2">
		<div class="" data-scroll>
			<h1 class="xl flex justify__space-between" data-reveal-text><span>Our</span><span>Teams</span></h1>
		</div>
	</div>
	<div data-scroll data-scroll-progress>
		<div class="sticky top__0 h__100v grid__3 gap__2 inner__1 inner-b__5" data-pane-container>
			<div></div>
			<ul class="grid place__center-center" data-pane-scroll>	
			<?php foreach (collection('Team') as $team) : ?>
				<?= snippet('molecules/Team', [ 'team' => $team, 'collapsed' => false ]) ?>
			<?php endforeach ?>
			</ul>
			<div></div>
		</div>
		<?php foreach (collection('Team') as $team) : ?>
			<div data-pane-trigger=team-<?= $team->slug()?> class=vh__20></div>
		<?php endforeach ?>
	</div>
	<div class=vh__20></div>


</section>

<?= snippet('templates/globals/Cta') ?>