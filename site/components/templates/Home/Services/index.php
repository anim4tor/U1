<section class="solutions color__invert" data-tabs="hoverable">
	<div class="bg radius absolute inset__stretch" theme="dark"></div>
	<div class="grid__2 place__start-stretch mobile:grid__1 mobile:inner-t__10 mobile:gap__2 relative inner-b__5" >
		<div class="sticky top__0 h__100v grid place__start-space-between gap__1 inner__1 inner-t__2" data-scroll>
			<div class="" data-scroll>
				<h1 class="font__size__default ff__body s upper" data-reveal-text>(<span>Solutions</span>)</h1>
			</div>
			<div class="sticky top__10 grid__stack place__start-start no__overflow img__radius" data-pane-container>
				<?php foreach (collection('Solutions') as $solution) : ?>
					<div class="no__overflow" data-pane="service-<?= $solution->slug() ?>" data-tab-reveal >
					<?php if ($img = $solution->cover()->toFile()) : ?>
						<div class="" data-reveal-image><?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'w__10 radius grid']) ?></div>
					<?php endif ?>
					</div>
				<?php endforeach ?>
			</div>
		</div>
		<ul class="solutions__list grid inner__1 inner-t__2">
			<?php foreach (collection('Solutions') as $solution) : ?>
				<div class="flex align__start gap__05 inner-y__02" data-scroll data-tab="service-<?= $solution->slug() ?>">
					<h3 class="" data-reveal-text data-split-ignore><?= $solution->title() ?></h3>
				</div>
			<?php endforeach ?>
		</ul>
	</div>
</section>