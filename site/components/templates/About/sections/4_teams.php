<?php
/**
 * Sekce: Týmy (v65 o-nas.html)
 * Interaktivní přepínání týmů s fotografiemi a informacemi
 */
$teams = collection('Team');
if (!$teams || $teams->isEmpty()) {
    $teams = $page->teams()->toStructure();
}
?>

<?php if ($teams && (is_countable($teams) ? count($teams) > 0 : $teams->isNotEmpty())) : ?>
<section class="team radius relative z__2" theme="invert" data-tabs="hoverable">
	<div class="grid__4 gap__2 mobile:grid__1 inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3">
		
		<div class="grid span__2 gap__4 place__space-between-stretch mobile:inner-x__0">
			<div class="grid gap__1" data-scroll>
				<h2 class="font__size__2" data-reveal-text>Týmy</h2>
				
				<div class="grid__stack place__start-start" data-pane-container data-scroll data-reveal-image>
					<div class="team-intro op__7" data-team-intro>
						<p>S vámi projdeme zadání a rozsah spolupráce na interiéru.</p>
					</div>
					<?php foreach ($teams as $idx => $team) : ?>
						<?php 
						$tName = is_array($team) ? ($team['name'] ?? '') : $team->name()->value();
						$tDetails = is_array($team) ? ($team['details'] ?? '') : $team->details()->inline();
						?>
						<div data-pane="team-<?= $idx ?>" class="" data-scroll data-scroll-ignore data-tab-reveal>
							<div class="op__7">
								<?= snippet('atoms/Text', ['text' => $tDetails, 'reveal' => true, 'node' => 'data-split-ignore data-scroll-ignore']) ?>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>

			<div class="grid">
				<ol class="grid place__start-stretch gap-y__0 gap-x__1" data-scroll>
					<?php foreach ($teams as $idx => $team) : ?>
						<?php $tName = is_array($team) ? ($team['name'] ?? '') : $team->name()->value(); ?>
						<a href="#<?= \Kirby\Toolkit\Str::slug($tName) ?>" class="flex justify__space-between align__center border__top inner-y__05 gap__02" data-tab="team-<?= $idx ?>">
							<h3 data-reveal-text data-split-ignore class="font__size__3"><?= esc($tName) ?></h3>
							<?= snippet('atoms/Icon', ['name' => 'arrow-right', 'css' => 'team__arrow']) ?>
						</a>
					<?php endforeach ?>
				</ol>
			</div>
		</div>

		<div class="span__2 team__media">
			<div class="grid__stack place__stretch-stretch no__overflow img__radius" data-pane-container data-scroll data-reveal-image>
				<?php foreach ($teams as $idx => $team) : ?>
					<?php 
					$tFig = is_array($team) ? null : $team->figure()->toFile();
					?>
					<div data-pane="team-<?= $idx ?>" class="grid place__stretch-stretch" data-scroll data-scroll-ignore data-tab-reveal>
						<?php if ($tFig) : ?>
							<div class="grid place__stretch-stretch" data-reveal-image>
								<?= snippet('atoms/Image', ['img' => $tFig, 'reveal' => false, 'css' => 'img__radius']) ?>
							</div>
						<?php else : ?>
							<div class="aspect__4/3 bg__dark img__radius flex align__center justify__center op__5"></div>
						<?php endif ?>
					</div>
				<?php endforeach ?>
			</div>
		</div>

	</div>
</section>
<?php endif ?>
