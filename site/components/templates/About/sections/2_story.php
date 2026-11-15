<?php
/**
 * Sekce: Příběh (v65 o-nas.html)
 * 50/50 dělený layout s fotografií vlevo a příběhem + komponentou Figures vpravo
 */
$storyHeading = $page->storyHeading()->or('Příběh');
$storyText = $page->storyText()->or('Začali jsme v Brně v roce 2001. Dříve jsme vystupovali jako U1 Interiors, dnes nás najdete pod značkou U1 Space Design. Obě jména patří ke stejné firmě a její práci na interiérech.');

$photo = $page->storyPhoto()->toFile() 
    ?? $page->images()->filterBy('name', '*=', 'showroom')->first() 
    ?? $page->images()->first();

$milestones = $page->storyMilestones()->toStructure();
if ($milestones->isEmpty()) {
    $milestones = [
        ['number' => '2001', 'label' => 'založení v Brně'],
        ['number' => '4',    'label' => 'týmy pod jednou střechou: obchod, architektura, řízení, realizace'],
        ['number' => '2',    'label' => 'vlastní nábytkové řady Only1 a Only2']
    ];
}
?>

<section class="story-section radius relative z__2" theme="invert" aria-labelledby="story-heading">
	<div class="inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3">
		<div class="grid__4 gap__3 mobile:grid__1 story__grid">
			
			<!-- Levá polovina: Fotografie -->
			<div class="span__2 mobile:span__1 story__col-photo">
				<div class="story__photo aspect__4/3 relative no__overflow img__radius" data-scroll data-reveal-image>
					<?php if ($photo) : ?>
						<?= snippet('atoms/Image', ['img' => $photo, 'reveal' => false, 'css' => 'aspect__4/3 img__radius']) ?>
					<?php else : ?>
						<div class="aspect__4/3 bg__light img__radius flex align__center justify__center op__5 font__size__small">
							Showroom U1 v Brně
						</div>
					<?php endif ?>
				</div>
			</div>

			<!-- Pravá polovina: Text příběhu a komponenta Figures -->
			<div class="span__2 mobile:span__1 story__content" data-scroll>
				<div class="story__text grid gap__1">
					<h2 id="story-heading" class="font__size__2" data-reveal-text><?= esc($storyHeading) ?></h2>
					<p class="font__size__default op__7" data-reveal-text="lines"><?= esc($storyText) ?></p>
				</div>

				<div class="story__figures">
					<?= snippet('sections/Figures', ['figures' => $milestones]) ?>
				</div>
			</div>

		</div>
	</div>
</section>
