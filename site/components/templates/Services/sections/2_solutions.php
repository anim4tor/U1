<?php if (collection('Solutions')->isNotEmpty()) : ?>
<section class="solutions" data-tabs="hoverable" theme="invert" >
	<div class="bg rounded-radius absolute inset-0" ></div>
	<div class="grid grid-cols-1 md:grid-cols-4 content-end items-stretch pt-10 md:pt-0 gap-2 md:gap-0 relative pb-5">
		<ul class="col-span-1 md:col-span-3 solutions__list grid p-1 pt-2" data-scroll>
			<?php foreach (collection('Solutions') as $solution) : ?>
				<a href="<?= $solution->url() ?>" class="flex items-start gap-05 py-02" data-tab="service-<?= $solution->slug() ?>">
					<?= snippet('atoms/Heading', [ 'level' => 'h2', 'text' => $solution->title(), 'reveal' => true, 'css' => 'text-s', 'node' => 'data-split-ignore data-scroll-ignore' ]) ?>
				</a>
			<?php endforeach ?>
		</ul>
		<div class="sticky bottom-0 p-1 ">
			<div class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] content-end justify-end overflow-hidden rounded-img" data-scroll data-reveal-image data-pane-container>
				<?php foreach (collection('Solutions') as $solution) : ?>
					<div class="" data-pane="service-<?= $solution->slug() ?>" data-tab-reveal >
						<a href="<?= $solution->url() ?>">
							<?php if ($img = $solution->cover()->toFile()) : ?>
								<?= snippet('atoms/Image', ['img' => $img, 'parallax' => false, 'reveal' => false, 'css' => 'aspect-[4/3]', 'node' => 'data-reveal-image']) ?>
							<?php endif ?>
						</a>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>