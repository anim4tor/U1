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
			<div data-pane-trigger=team-<?= $team->slug()?> class=vh__15></div>
		<?php endforeach ?>
	</div>
	<div class=vh__15></div>
</section>