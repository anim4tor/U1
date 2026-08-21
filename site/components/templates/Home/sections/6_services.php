<?php if (collection('Solutions')->isNotEmpty()) : ?>
<section class="solutions text-invert" data-tabs="hoverable">
	<div class="bg rounded-radius absolute inset-0" theme="dark"></div>
	<div class="grid grid-cols-1 md:grid-cols-4 pt-10 md:pt-0 gap-2 md:gap-0 relative px-1 pb-3" >
		<div class="col-span-1 md:col-span-3 py-2" data-scroll>
			<?= snippet('molecules/Header', ['header' => $page->services(), 'type' => ['heading']]) ?>
		</div>
		<div class="col-span-1"></div>
		<div class="grid justify-between items-start gap-1">
			
			<div class="sticky top-1 grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] content-start justify-start" data-pane-container data-scroll data-reveal-image >
				<?php foreach (collection('Solutions') as $solution) : ?>
					<div data-pane="service-<?= $solution->slug() ?>" class="" data-scroll data-scroll-ignore data-tab-reveal>
						<div class="grid content-start justify-start gap-05">
							<?php if ($img = $solution->cover()->toFile()) : ?>
								<div class="" data-reveal-image><?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'aspect-[6/4] rounded-img grid']) ?></div>
							<?php endif ?>

							<p class="" data-reveal-text="lines" data-split-ignore ><?= $solution->intro()->inline() ?></p>

						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
		<div></div>
		<ol class="col-span-1 md:col-span-1 solutions__list grid px-1" data-scroll >
			<?php foreach (collection('Solutions') as $solution) : ?>
				<a href="<?= $solution->url() ?>" class="flex items-start gap-05 py-02" data-tab="service-<?= $solution->slug() ?>">
					<h3 class="" data-reveal-text data-split-ignore><?= $solution->title() ?></h3>
				</a>
			<?php endforeach ?>
		</ol>
	</div>
</section>
<?php endif ?>
