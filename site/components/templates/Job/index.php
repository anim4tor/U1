<section class="intro radius" theme="invert" style="--in-delay: 500ms">
	<div data-scroll class="z__1 intro__header inner-b__3 place__stretch-stretch grid__4 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative">
		<div class="h__10"></div>
		<div class="span__4 grid place__stretch-stretch">
			<div class="span__4 border__top inner-t__05 inner-x__3 grid__2 gap__2 ">
				<div class="grid__2 gap__2">	
					<span data-reveal-text="lines" class="upper font__size__small"><?= $page->duration() ?></span>
					<span data-reveal-text="lines" class="upper font__size__small"><?= $page->location() ?></span>
				</div>
				<div class="">
					<h1 class="font__size__2">
						<div data-reveal-text=""><?= $page->title() ?></div>
					</h1>
				</div>
			</div>
		</div>
	</div>
	<div class="inner-x__1 grid">
		<?php if ($cover = $page->cover()->toFile()) : ?>
		<div class="intro__cover h__100v radius grid" data-scroll ><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
		<?php endif ?>
	</div>
</section>

<section class="about radius" theme="invert">
	<div data-scroll class="grid__4 gap__2 mobile:grid__1 inner__4 mobile:inner-x__1 ">
		<div class="span__2">
			<div class="flex gap__05 align__center upper font__size__small no__wrap" data-scroll ><div class="w__03 h__03 bg__acc"></div><div data-reveal-text>O pozici</div></div>	
		</div>
		<div class="span__2 grid place__start-start gap__3 mobile:inner-x__0">
			<h4 data-reveal-text="lines" class="font__size__4"><?= $page->excerpt()->inline() ?></h4>
		</div>
		<div></div>
		<div></div>
		<ul class="span__2 grid__2 place__start-start gap__1 mobile:inner-x__0">
			<?php foreach ($page->description()->toStructure() as $item) : ?>
				
				<li class="flex align__start gap__05">
					<div class="inner-t__01"><?= svg('site/assets/images/ui/list-checkmark.svg') ?></div>
					<span class="font__size__default"><?= $item->text() ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
		
	</div>
</section>

<section class="benefits radius border__top" theme="invert">
	<div data-scroll class="grid__4 gap__2 mobile:grid__1 inner__4 mobile:inner-x__1 " data-tabs="default">
		<div class="span__2 grid gap__05 place__start-start">
			<h2 data-tab="benefits">Benefity</h2>
			<h2 data-tab="requirements">Požadujeme</h2>
		</div>
		<div data-pane-container class="span__2">
			<div class="grid__stack">
				<ul data-pane="benefits" class="grid__2 place__start-start gap__1 mobile:inner-x__0">
					<?php foreach ($page->benefits()->toStructure() as $item) : ?>
						<li class="flex align__start gap__05">
							<div class="inner-t__01"><?= svg('site/assets/images/ui/list-checkmark.svg') ?></div>
							<span class="font__size__default"><?= $item->text() ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
				<ul data-pane="requirements" class="grid__2 place__start-start gap__1 mobile:inner-x__0">
					<?php foreach ($page->requirements()->toStructure() as $item) : ?>
						<li class="flex align__start gap__05">
							<div class="inner-t__01"><?= svg('site/assets/images/ui/list-checkmark.svg') ?></div>
							<span class="font__size__default"><?= $item->text() ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>

<?php 
$whyItems = null;
try { $whyItems = $page->whyus()->toStructure(); } catch (\Throwable $e) {}
?>
<?php if ($whyItems && $whyItems->isNotEmpty()) : ?>
<section class="why-us radius" theme="light">
	<style>
		.why-us svg { width: 36px; height: 36px; display: block; flex-shrink: 0; }
	</style>
	<div class="grid__4 gap__2 place__stretch-stretch inner__4 mobile:grid__1 mobile:inner__2" data-scroll>
		<div class="span__2">
			<div data-scroll class="flex align__start gap__01 span__2">
				<?= snippet('molecules/Header', ['header' => $page->whyusHeader(), 'type' => ['label']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->whyusHeader(), 'type' => ['heading']]) ?>
			</div>

		</div>
		<div class="span__2">
			<div class="grid__2 gap__1 mobile:grid__1">
				<?php foreach ($whyItems as $why) : ?>
					<?php
					$iconName = $why->icon()->value();
					$svgPath  = 'site/assets/images/benefits/small/' . $iconName . '.svg';
					$hasSvg   = $iconName && file_exists(kirby()->root('index') . '/' . $svgPath);
					?>
					<div class="flex align__center gap__1 inner-y__02">
						<div class="flex align__center justify__center flex-shrink__0" style="width: 36px; height: 36px; min-width: 36px;">
							<?php if ($hasSvg) : ?>
								<?= svg($svgPath) ?>
							<?php elseif ($img = $why->image()->toFile()) : ?>
								<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false]) ?>
							<?php endif ?>
						</div>
						<span class="font__size__default ff__body"><?= $why->text() ?></span>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>
<?php endif ?>

<?php 
$processSteps = null;
try { $processSteps = $page->process()->toStructure(); } catch (\Throwable $e) {}
?>
<?php if ($processSteps && $processSteps->isNotEmpty()) : ?>
<section class="hiring-process radius border__bottom" theme="dark">
	<div class="grid gap__3 inner__4 mobile:inner__2" data-scroll>
		<div>
			<?php if ($page->processHeader()->isNotEmpty() && $page->processHeader()->toBlocks()->isNotEmpty()) : ?>
				<div data-scroll class="flex align__start gap__01 span__2">
					<?= snippet('molecules/Header', ['header' => $page->processHeader(), 'type' => ['label']]) ?>
					<?= snippet('molecules/Header', ['header' => $page->processHeader(), 'type' => ['heading']]) ?>
				</div>
			<?php else : ?>

				<div data-scroll class="flex align__start gap__01 span__2">
					<div class="w__03 h__03 bg__acc"></div>
					<h2 class="font__size__2 ff__heading wrap" data-reveal-text="lines">
						Každá spolupráce<br>začíná kontaktem
					</h2>
				</div>
				
			<?php endif ?>
		</div>

		<div class="grid__3 gap__1 mobile:grid__1 place__stretch-stretch">
			<?php $idx = 1; ?>
			<?php foreach ($processSteps as $step) : ?>
				<?php 
				$num = $step->step()->isNotEmpty() ? $step->step()->value() : $idx;
				$img = $step->image()->toFile();
				$fallbackImg = 'site/assets/images/job/step_0' . $idx . '.png';
				?>
				<div class="grid inner__1 border radius gap__1 place__start-stretch" data-scroll>
					<div class="img__radius overflow__hidden aspect__16/9">
						<?php if ($img) : ?>
							<?= snippet('atoms/Image', ['img' => $img, 'reveal' => true, 'css' => 'aspect__16/9']) ?>
						<?php elseif (file_exists(kirby()->root('index') . '/' . $fallbackImg)) : ?>
							<img src="<?= url($fallbackImg) ?>" alt="<?= $step->title() ?>" class="is-loaded w__full h__full" style="object-fit: cover; aspect-ratio: 16/9;">
						<?php endif ?>
					</div>
					<div class="flex justify__space-between align__start gap__1">
						<span class="color__acc font__size__1 ff__heading leading__none"><?= $num ?></span>
						<h3 class="font__size__3 ff__heading"><?= $step->title() ?></h3>
					</div>
					<p class="wrap-t__2"><?= $step->text() ?></p>
				</div>
				<?php $idx++; ?>
			<?php endforeach ?>
		</div>
	</div>
</section>
<?php endif ?>

<?= snippet('templates/globals/Cta/career') ?>

<?php
$ctaImage = null;
$ctaHeading = 'Máš o pozici zájem? Dej nám vědět!';
$ctaSub = 'Zuzana Lucková , HR Partner';
$positionsPage = page('career/positions') ?? page('career')->find('positions');
$positionsUrl = $positionsPage ? $positionsPage->url() : url('career/positions');

if ($cta = $site->ctaCareer()) {
	foreach ($cta->toBlocks() as $block) {
		if ($block->type() === 'image' && $img = $block->image()->toFile()) {
			$ctaImage = $img;
		}
		if ($block->type() === 'heading' && $block->text()->isNotEmpty()) {
			$ctaHeading = strip_tags(str_replace('<br>', ' ', $block->text()->value()));
		}
		if ($block->type() === 'text' && $block->text()->isNotEmpty()) {
			$ctaSub = strip_tags(html_entity_decode($block->text()->value()));
		}
		if ($block->type() === 'button' && $block->href()->isNotEmpty()) {
			if ($targetPage = $block->href()->toPage()) {
				$positionsUrl = $targetPage->url();
			}
		}
	}
}
?>
<div class="job-sticky-cta" data-job-sticky-cta>
	<div class="job-sticky-cta__card" theme="dark">
		<div class="job-sticky-cta__left">
			<?php if ($ctaImage) : ?>
				<div class="job-sticky-cta__avatar">
					<img src="<?= $ctaImage->url() ?>" alt="<?= html($ctaSub) ?>">
				</div>
			<?php endif ?>
			<div class="job-sticky-cta__content">
				<span class="job-sticky-cta__title"><?= $ctaHeading ?></span>
				<span class="job-sticky-cta__sub"><?= $ctaSub ?></span>
			</div>
		</div>
		<div class="job-sticky-cta__actions">
			<a href="<?= $positionsUrl ?>" class="button job-sticky-cta__btn-back" theme="invert-ghost" hover="invert">
				<label class="upper"><span>ZPĚT NA VOLNÉ POZICE</span></label>
			</a>
			<button type="button" class="button job-sticky-cta__btn-apply bg__acc" theme="acc" hover="dark" data-contact-toggle="inquiry">
				<span class="job-sticky-cta__btn-icon"><?= svg('public/assets/images/ui/ui_contact.svg') ?></span>
				<label class="upper color__invert font__size__small"><span>(MÁM ZÁJEM O POZICI)</span></label>
			</button>
		</div>
	</div>
</div>

<script>
	(function() {
		const initStickyCta = () => {
			const bigCta = document.querySelector('section.cta');
			const stickyCta = document.querySelector('[data-job-sticky-cta]');
			if (!bigCta || !stickyCta) return;

			const observer = new IntersectionObserver((entries) => {
				entries.forEach(entry => {
					if (entry.isIntersecting) {
						stickyCta.classList.add('is-hidden');
					} else {
						stickyCta.classList.remove('is-hidden');
					}
				});
			}, {
				root: null,
				rootMargin: '0px 0px 80px 0px',
				threshold: 0
			});

			observer.observe(bigCta);
		};

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', initStickyCta);
		} else {
			initStickyCta();
		}
	})();
</script>