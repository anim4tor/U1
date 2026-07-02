<?php if (collection('Solutions')->isNotEmpty()) : ?>
<section class="solutions" data-tabs="hoverable" theme="invert" style="--in-delay: 500ms">
	<div class="bg radius absolute inset__stretch" ></div>
	<div class="grid__4  place__end-stretch mobile:grid__1 mobile:inner-t__10 mobile:gap__2 relative inner-b__5" data-scroll >
		<ul class="span__3 solutions__list grid inner__1 inner-t__2">
			<?php foreach (collection('Solutions') as $solution) : ?>
				<a href="<?= $solution->url() ?>" class="flex align__start gap__05 inner-y__02" data-tab="service-<?= $solution->slug() ?>">
					<?= snippet('atoms/Heading', [ 'level' => 'h2', 'text' => $solution->title(), 'reveal' => true, 'css' => 's', 'node' => 'data-split-ignore' ]) ?>
				</a>
			<?php endforeach ?>
		</ul>
		<div class="sticky bottom__0 inner__1 " data-scroll>
			<div class="grid__stack place__end-end no__overflow img__radius" data-reveal-image data-pane-container>
				<?php foreach (collection('Solutions') as $solution) : ?>
					<div class="" data-pane="service-<?= $solution->slug() ?>" data-tab-reveal >
						<a href="<?= $solution->url() ?>">
							<?php if ($img = $solution->cover()->toFile()) : ?>
								<?= snippet('atoms/Image', ['img' => $img, 'parallax' => false, 'reveal' => false, 'css' => 'aspect__4/3', 'node' => 'data-reveal-image']) ?>
							<?php endif ?>
						</a>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>