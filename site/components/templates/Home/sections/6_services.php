<?php if ($page->services()->isNotEmpty()) : ?>
<section class="solutions radius" theme="dark" data-tabs="hoverable">
	<div class="grid__4 gap__2 mobile:grid__1 inner__4 mobile:inner-x__1">
		<div class="grid span__2 gap__4 place__space-between-start mobile:inner-x__0">
			<div class="grid gap__1">
				<?= snippet('molecules/Header', ['header' => $page->services(), 'type' => ['label']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->services(), 'type' => ['heading']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->services(), 'type' => ['text']]) ?>
				<div class="grid__stack place__start-start " data-pane-container data-scroll data-reveal-image >
					<?php foreach (collection('Solutions') as $solution) : ?>
						<div data-pane="service-<?= $solution->slug() ?>" class="" data-scroll data-scroll-ignore data-tab-reveal>
							<div class="op__7">
								<p data-reveal-text="lines" data-split-ignore ><?= $solution->intro()->inline() ?></p>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>
			<div class="grid">
				<ol class="grid__2 place__start-stretch gap-y__0 gap-x__1" data-scroll >
					<?php foreach (collection('Solutions') as $solution) : ?>
						<a href="<?= $solution->url() ?>" class="flex align__start border__top inner-y__05" data-tab="service-<?= $solution->slug() ?>">
							<h3 data-reveal-text data-split-ignore class="font__size__4"><?= $solution->title() ?></h3>
						</a>
					<?php endforeach ?>
				</ol>
			</div>
		</div>
		<div class="span__2 grid">
			<div class="grid__stack place__stretch-stretch no__overflow img__radius" data-pane-container data-scroll data-reveal-image >
				<?php foreach (collection('Solutions') as $solution) : ?>
					<div data-pane="service-<?= $solution->slug() ?>" class="grid place__stretch-stretch" data-scroll data-scroll-ignore data-tab-reveal>
						<?php if ($img = $solution->cover()->toFile()) : ?>
							<div class="grid place__stretch-stretch" data-reveal-image><?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'img__radius']) ?></div>
						<?php endif ?>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>