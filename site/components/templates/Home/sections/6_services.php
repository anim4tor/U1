<?php if (collection('Solutions')->isNotEmpty()) : ?>
<section class="solutions color__invert" data-tabs="hoverable">
	<div class="bg radius absolute inset__stretch" theme="dark"></div>
	<div class="grid__3 gap__2 mobile:grid__1 mobile:inner-t__10 mobile:gap__2 relative inner__4" >
		<div data-scroll class="flex align__start gap__01 span__3">
			<?= snippet('molecules/Header', ['header' => $page->services(), 'type' => ['label']]) ?>
			<?= snippet('molecules/Header', ['header' => $page->services(), 'type' => ['heading']]) ?>
		</div>
		<ol class="span__2 grid__2 place__start-start gap__05 grid " data-scroll >
			<?php foreach (collection('Solutions') as $solution) : ?>
				<a href="<?= $solution->url() ?>" class="flex align__start gap__05" data-tab="service-<?= $solution->slug() ?>">
					<h3 data-reveal-text data-split-ignore class="s"><?= $solution->title() ?></h3>
				</a>
			<?php endforeach ?>
		</ol>
		<div class="span__1 grid place__start-space-between gap__1 ">
			
			<div class="sticky top__1 grid__stack place__start-start " data-pane-container data-scroll data-reveal-image >
				<?php foreach (collection('Solutions') as $solution) : ?>
					<div data-pane="service-<?= $solution->slug() ?>" class="" data-scroll data-scroll-ignore data-tab-reveal>
						<div class="grid place__start-start gap__05">
							<?php if ($img = $solution->cover()->toFile()) : ?>
								<div class="" data-reveal-image><?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'aspect__6/4 img__radius grid']) ?></div>
							<?php endif ?>
							<div class="op__7">
								<p data-reveal-text="lines" data-split-ignore ><?= $solution->intro()->inline() ?></p>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>
