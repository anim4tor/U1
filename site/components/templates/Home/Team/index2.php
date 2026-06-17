<section class="team" theme="invert" >
	<div class="relative grid gap__2 inner-x__1 inner-y__2">
		<div class="" data-scroll>
			<h1 class="xl flex justify__space-between" data-reveal-text><span>The</span><span>Process</span></h1>
		</div>
	</div>
	<div >
		<div class="grid__3 gap__2 inner__1 inner-b__5" >
			<div></div>
			<ul class="grid place__center-center" >	
			<?php foreach (collection('Team') as $team) : ?>
				<div data-scroll data-scroll-progress>
					<?= snippet('molecules/Team', [ 'team' => $team ]) ?>
				</div>
			<?php endforeach ?>
			</ul>
			<div></div>
		</div>
		<!-- <?php foreach (collection('Team') as $team) : ?>
			<div data-pane-trigger=team-<?= $team->slug()?> class=vh__15></div>
		<?php endforeach ?> -->
	</div>
	<!-- <div class=vh__15></div> -->
</section>