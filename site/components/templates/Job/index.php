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
			<div class="flex gap__05 align__center upper font__size__small no__wrap" data-scroll ><div data-reveal-text>O pozici</div></div>	
		</div>
		<div class="span__2 grid place__start-start gap__3 mobile:inner-x__0">
			<h3 data-reveal-text="lines" class=""><?= $page->excerpt()->inline() ?></h3>
		</div>
		<div></div>
		<div></div>
		<ul class="span__2 grid__2 place__start-start gap__1 mobile:inner-x__0">
			<?php foreach ($page->description()->toStructure() as $item) : ?>
				
				<li class="flex align__start gap__05">
					<div class=""><?= svg('site/assets/images/ui/list-checkmark.svg') ?></div>
					<span class="font__size__default"><?= $item->text() ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
		
	</div>
</section>

<section class="benefits u1-block border__top" theme="invert">
	<div data-scroll class="u1-type-2" data-tabs="default">
		<div class="u1-type-2__header">
			<div class="u1-label"><?= t('benefits-requirements', 'BENEFITY / POŽADUJEME') ?></div>
			<div class="flex gap__1 align__baseline">
				<h2 data-tab="benefits" class="u1-h2 cursor__pointer">Benefity</h2>
				<span class="op__4 font__size__3 ff__heading">/</span>
				<h2 data-tab="requirements" class="u1-h2 cursor__pointer op__5">Požadujeme</h2>
			</div>
		</div>
		<div data-pane-container class="u1-type-2__items">
			<div class="grid__stack span__2">
				<ul data-pane="benefits" class="grid grid__2 gap__1 mobile:grid__1">
					<?php foreach ($page->benefits()->toStructure() as $item) : ?>
						<li class="flex align__start gap__05 u1-type-2__item">
							<div class="flex-shrink__0 w__1 h__1 op__7"><?= svg('site/assets/images/ui/list-checkmark.svg') ?></div>
							<span class="u1-type-2__item-text"><?= $item->text() ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
				<ul data-pane="requirements" class="grid grid__2 gap__1 mobile:grid__1">
					<?php foreach ($page->requirements()->toStructure() as $item) : ?>
						<li class="flex align__start gap__05 u1-type-2__item">
							<div class="flex-shrink__0 w__1 h__1 op__7"><?= svg('site/assets/images/ui/list-checkmark.svg') ?></div>
							<span class="u1-type-2__item-text"><?= $item->text() ?></span>
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
<section class="why-us u1-block" theme="light">
	<div class="u1-type-2" data-scroll>
		<div class="u1-type-2__header">
			<div class="u1-header">
				<?= snippet('molecules/Header', ['header' => $page->whyusHeader(), 'type' => ['label']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->whyusHeader(), 'type' => ['heading']]) ?>
			</div>
		</div>
		<div class="u1-type-2__items">
			<?php foreach ($whyItems as $why) : ?>
				<?php
				$iconName = $why->icon()->value();
				$svgPath  = 'site/assets/images/benefits/small/' . $iconName . '.svg';
				$hasSvg   = $iconName && file_exists(kirby()->root('index') . '/' . $svgPath);
				?>
				<div class="u1-type-2__item flex flex-row align__start gap__05">
					<div class="u1-type-2__item-icon">
						<?php if ($hasSvg) : ?>
							<?= svg($svgPath) ?>
						<?php elseif ($img = $why->image()->toFile()) : ?>
							<?= snippet('atoms/Image', ['img' => $img, 'reveal' => false]) ?>
						<?php endif ?>
					</div>
					<div class="u1-type-2__item-text"><?= $why->text() ?></div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</section>
<?php endif ?>

<?php 
$processSteps = null;
try { $processSteps = $page->process()->toStructure(); } catch (\Throwable $e) {}
?>
<?php if ($processSteps && $processSteps->isNotEmpty()) : ?>
<section class="hiring-process u1-block border__bottom" theme="dark">
	<div class="u1-type-3" data-scroll>
		<div class="u1-header">
			<?php if ($page->processHeader()->isNotEmpty() && $page->processHeader()->toBlocks()->isNotEmpty()) : ?>
				<?= snippet('molecules/Header', ['header' => $page->processHeader(), 'type' => ['label']]) ?>
				<?= snippet('molecules/Header', ['header' => $page->processHeader(), 'type' => ['heading']]) ?>
			<?php else : ?>
				<div class="u1-label"><?= t('recruitment-process', 'PRŮBĚH NÁBORU') ?></div>
				<h2 class="u1-h2" data-reveal-text="lines">Každá spolupráce začíná kontaktem</h2>
			<?php endif ?>
		</div>

		<div class="u1-type-3__cards u1-type-3__cards--3col">
			<?php $idx = 1; ?>
			<?php foreach ($processSteps as $step) : ?>
				<?php 
				$num = $step->step()->isNotEmpty() ? $step->step()->value() : $idx;
				$img = $step->image()->toFile();
				$fallbackImg = 'site/assets/images/job/step_0' . $idx . '.png';
				?>
				<div class="u1-card" data-scroll>
					<div class="u1-card__figure">
						<?php if ($img) : ?>
							<?= snippet('atoms/Image', ['img' => $img, 'reveal' => true, 'css' => 'w__full h__full']) ?>
						<?php elseif (file_exists(kirby()->root('index') . '/' . $fallbackImg)) : ?>
							<img src="<?= url($fallbackImg) ?>" alt="<?= $step->title() ?>" class="is-loaded w__full h__full" style="object-fit: cover;">
						<?php endif ?>
					</div>
					<div class="u1-card__number color__acc"><?= $num ?></div>
					<h3 class="u1-card__title"><?= $step->title() ?></h3>
					<p class="u1-card__text op__7"><?= $step->text() ?></p>
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
		<div class="flex gap__02 align__center">
			<?= snippet('atoms/Button', [
				'url'   => $positionsUrl,
				'label' => 'Volné pozice (' . collection('Jobs')->count() . ')',
				'theme' => 'invert-ghost',
				'hover' => 'invert',
			]) ?>
			<?= snippet('atoms/Button', [
				'label' => 'Mám zájem o pozici',
				'icon'  => 'arrow-right',
				'theme' => 'acc',
				'hover' => 'dark',
				'node'  => 'data-contact-toggle="inquiry"'
			]) ?>
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