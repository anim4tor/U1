<?php if (collection('Solutions')->isNotEmpty()) : ?>
<section class="solutions color__invert" data-tabs="hoverable">
	<div class="bg radius absolute inset__stretch" theme="dark"></div>
	<div class="grid__4 place__start-stretch mobile:grid__1 mobile:inner-t__10 mobile:gap__2 relative inner-x__1 inner-b__2" >
		<div class="span__2 inner-y__2" data-scroll>
			<?= snippet('molecules/Header', ['header' => $page->services(), 'type' => ['heading']]) ?>
		</div>
		<div class="span__2"></div>
		<div class="sticky top__0 h__100v grid place__start-space-between gap__1 inner-y__2">
			
			<div class="sticky top__10 grid__stack place__start-start " data-pane-container data-scroll data-reveal-image >
				<?php foreach (collection('Solutions') as $solution) : ?>
					<div data-pane="service-<?= $solution->slug() ?>" class="" data-scroll data-scroll-ignore data-tab-reveal>
						<div class="grid place__start-start gap__05">
							<?php if ($img = $solution->cover()->toFile()) : ?>
								<div class="" data-reveal-image><?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'aspect__6/4 img__radius grid']) ?></div>
							<?php endif ?>

							<p class="" data-reveal-text="lines" data-split-ignore ><?= $solution->intro()->inline() ?></p>

						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
		<div></div>
		<ol class="span__2 solutions__list grid inner-x__1 inner-t__2" data-scroll >
			<?php foreach (collection('Solutions') as $solution) : ?>
				<a href="<?= $solution->url() ?>" class="flex align__start gap__05 inner-y__02" data-tab="service-<?= $solution->slug() ?>">
					<h3 class="m" data-reveal-text data-split-ignore><?= $solution->title() ?></h3>
				</a>
			<?php endforeach ?>
		</ol>
	</div>
</section>
<?php endif ?>
