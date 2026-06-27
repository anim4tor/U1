<section class="intro radius" theme="invert" style="--in-delay: 500ms">
	<div data-scroll class="z__1 intro__header inner-b__3 place__stretch-stretch grid__4 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative ">
		<div class="span__4 h__8"></div>
		<div class="span__4 inner-t__05 border__top grid__4 place__space-between-stretch">
			<!-- <div data-reveal-text="lines" class="upper s">(<?= $page->title() ?>)</div> -->
			<div class="span__3">
				<div class="flex align__start gap__02 inner-y__02 no__wrap" data-scroll>
					<h1 class="s" data-reveal-text><?= $page->menuTitle() ?></h1>
				</div>
			</div>
			<div data-reveal-text="lines" class="upper flex justify__end">(<?= collection('Solutions')->count() ?>)</div>
		</div>
	</div>
</section>

<section class="solutions" data-tabs="hoverable" theme="invert" style="--in-delay: 500ms">
	<div class="bg radius absolute inset__stretch" ></div>
	<div class="grid__4  place__end-stretch mobile:grid__1 mobile:inner-t__10 mobile:gap__2 relative inner-b__5" data-scroll >
		<ul class="span__3 solutions__list grid inner__1 inner-t__2">
			<?php foreach (collection('Solutions') as $solution) : ?>
				<a href="<?= $solution->url() ?>" class="flex align__start gap__05 inner-y__02" data-tab="service-<?= $solution->slug() ?>">
					<h2 class="s" data-reveal-text data-split-ignore><?= $solution->title() ?></h3>
				</a>
			<?php endforeach ?>
		</ul>
		<div class="sticky bottom__0 inner__1 " data-scroll>
			<div class="grid__stack place__end-end no__overflow img__radius" data-reveal-image data-pane-container>
				<?php foreach (collection('Solutions') as $solution) : ?>
					<div class="" data-pane="service-<?= $solution->slug() ?>" data-tab-reveal >
						<a href="<?= $solution->url() ?>">
							<?php if ($img = $solution->cover()->toFile()) : ?>
								<div class="" data-reveal-image><?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'aspect__6/4 radius grid']) ?></div>
							<?php endif ?>
						</a>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>

<?= snippet('templates/globals/Feed') ?>
<?= snippet('templates/globals/Cta') ?>