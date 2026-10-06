<?php
$servicesHeader = isset($page) && $page->services()->isNotEmpty() ? $page->services() : null;
?>
<?php if (collection('Solutions')->isNotEmpty()) : ?>
<section class="solutions u1-block" theme="dark" data-tabs="hoverable">
	<div class="u1-type-1">
		<!-- Left: Text (6 cols) -->
		<div class="u1-type-1__col-text">
			<div class="u1-type-1__top" data-scroll>
				<?php if ($servicesHeader) : ?>
					<div class="u1-header">
						<?= snippet('molecules/Header', ['header' => $servicesHeader, 'type' => ['label']]) ?>
						<?= snippet('molecules/Header', ['header' => $servicesHeader, 'type' => ['heading']]) ?>
						<?= snippet('molecules/Header', ['header' => $servicesHeader, 'type' => ['text']]) ?>
					</div>
				<?php else : ?>
					<div class="u1-header">
						<div class="u1-label"><?= t('our-solutions', 'Naše řešení') ?></div>
						<h2 class="u1-h2"><?= t('our-solutions-headline', 'Komplexní služby a řešení') ?></h2>
					</div>
				<?php endif ?>
			</div>

			<div class="u1-type-1__bottom">
				<ol class="grid grid__2 gap__05" data-scroll>
					<?php foreach (collection('Solutions') as $solution) : ?>
						<a href="<?= $solution->url() ?>" class="flex align__start gap__05" data-tab="service-<?= $solution->slug() ?>">
							<span class="font__size__default ff__body hover:op__7" data-reveal-text data-split-ignore><?= $solution->title() ?></span>
						</a>
					<?php endforeach ?>
				</ol>
			</div>
		</div>

		<!-- Right: Photo 4:3 (6 cols) -->
		<div class="u1-type-1__col-media" data-pane-container>
			<div class="grid__stack no__overflow w__full" data-scroll data-reveal-image>
				<?php foreach (collection('Solutions') as $solution) : ?>
					<div data-pane="service-<?= $solution->slug() ?>" class="w__full h__full" data-scroll data-scroll-ignore data-tab-reveal>
						<div class="grid gap__1 w__full h__full">
							<?php if ($img = $solution->cover()->toFile()) : ?>
								<div class="u1-photo">
									<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false, 'css' => 'w__full h__full', 'node' => 'data-reveal-image']) ?>
								</div>
							<?php endif ?>
							<?php if ($solution->intro()->isNotEmpty()) : ?>
								<div class="op__7 font__size__default">
									<p data-reveal-text="lines" data-split-ignore><?= $solution->intro()->inline() ?></p>
								</div>
							<?php endif ?>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>
