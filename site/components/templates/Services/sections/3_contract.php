<?php 
$heading = $page->contractHeading()->or('Vše pod jednou smlouvou');
$text = $page->contractText()->or('Od architektonického návrhu po vybavení jednáte s jedním odpovědným partnerem. Celý dohodnutý rozsah zastřešujeme my.');
$steps = $page->contractSteps()->toStructure();
?>
<section class="contract radius" theme="dark" data-scroll>
	<div class="grid gap__3 inner-x__4 inner-y__5 mobile:inner-x__1 mobile:inner-y__3">
		<div class="grid__4 gap__2 mobile:grid__1">
			<div class="span__2 grid gap__1">
				<h2 class="font__size__2" data-reveal-text><?= $heading ?></h2>
				<p class="font__size__default op__7" data-reveal-text="lines"><?= $text ?></p>
			</div>
		</div>

		<?php if ($steps->isNotEmpty()) : ?>
			<ol class="grid__4 gap__2 mobile:grid__1" data-scroll>
				<?php foreach ($steps as $step) : ?>
					<?php 
					$num = $step->number()->isNotEmpty() 
						? $step->number()->value() 
						: str_pad($step->indexOf($steps) + 1, 2, '0', STR_PAD_LEFT);
					?>
					<li class="grid place__start-stretch gap__1 border__top inner-t__1">
						<span class="label font__size__small color__acc"><?= $num ?></span>
						<h3 class="" data-reveal-text><?= $step->title()->inline() ?></h3>
						<p class="font__size__default op__7" data-reveal-text="lines"><?= $step->text()->inline() ?></p>
					</li>
				<?php endforeach ?>
			</ol>
		<?php endif ?>
	</div>
</section>

