<section class="solutions color__invert" data-tabs="hoverable">
	<div class="bg radius absolute inset__stretch" theme="dark"></div>
	<div class="grid__2 place__start-stretch mobile:grid__1 mobile:inner-t__10 mobile:gap__2 relative inner-b__5" >
		<div class="span__2 inner__1 inner-y__2" data-scroll>
			<h2 class="l" data-reveal-text><span>Services</span></h2>
		</div>
		<div class="sticky top__0 h__100v grid place__start-space-between gap__1 inner__1 inner-t__2" data-scroll>
			
			<div class="sticky top__10 grid__stack place__start-start no__overflow img__radius" data-pane-container>
				<?php foreach (collection('Solutions') as $solution) : ?>
					<div class="no__overflow" data-pane="service-<?= $solution->slug() ?>" data-tab-reveal >
						<a href="<?= $solution->url() ?>">
							<?php if ($img = $solution->cover()->toFile()) : ?>
								<div class="" data-reveal-image><?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'w__12 aspect__6/4 radius grid']) ?></div>
							<?php endif ?>
						</a>
					</div>
				<?php endforeach ?>
			</div>
		</div>
		<ul class="solutions__list grid inner__1 inner-t__2">
			<?php foreach (collection('Solutions') as $solution) : ?>
				<a href="<?= $solution->url() ?>" class="flex align__start gap__05 inner-y__02" data-scroll data-tab="service-<?= $solution->slug() ?>">
					<h3 class="" data-reveal-text data-split-ignore><?= $solution->title() ?></h3>
				</a>
			<?php endforeach ?>
		</ul>
	</div>
</section>