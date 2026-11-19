<?php
/**
 * Komponenta Figures / Carousel Counters
 * Zobrazuje animovaná čísla s rotujícími pásy (carousel counters)
 */
$items = [];

if (isset($figures) && !empty($figures)) {
    $items = $figures;
} elseif ($page->aboutFigures()->isNotEmpty()) {
    $items = $page->aboutFigures()->toStructure();
} elseif ($page->figures()->isNotEmpty()) {
    $items = $page->figures()->toStructure();
} elseif ($page->storyMilestones()->isNotEmpty()) {
    $items = $page->storyMilestones()->toStructure();
} elseif ($home = page('home')) {
    $items = $home->aboutFigures()->toStructure();
}
?>

<?php
$grid = $grid ?? null;
$isColumns = ($grid && str_contains($grid, 'grid__3'));
$containerClass = $grid ? ($grid . ' mobile:grid__1 mobile:gap__1') : 'grid place__stretch-stretch mobile:grid__1 mobile:gap__1';
$totalCount = is_countable($items) ? count($items) : 0;
$itemIndex  = 0;
?>
<div class="<?= esc($containerClass) ?>">
	<?php foreach ($items as $figure) : ?>
		<?php 
		$itemIndex++;
		$isLast = ($itemIndex === $totalCount);
		if (is_array($figure)) {
			$rawNum = $figure['feature'] ?? $figure['number'] ?? '';
			$label = $figure['label'] ?? '';
		} else {
			$rawNum = $figure->feature()->isNotEmpty() ? $figure->feature()->value() : $figure->number()->value();
			$label = $figure->label()->value();
		}
		$targetNumber = preg_replace('/[^0-9]/', '', (string)$rawNum);
		?>
		<?php if ($isColumns) : ?>
			<div class="grid gap__05 align__start border__top inner-t__1 mobile:inner-t__05" data-scroll>
				<?php if (!empty($targetNumber)) : ?>
					<div class="font__size__1 color__acc font__weight__600 carousel-counter" data-target="<?= esc($targetNumber) ?>"></div>
				<?php else : ?>
					<div class="font__size__1 color__acc font__weight__600"><?= esc($rawNum) ?></div>
				<?php endif ?>
				<?php if (!empty($label)) : ?>
					<p class="op__7 font__size__small"><?= esc($label) ?></p>
				<?php endif ?>
			</div>
		<?php else : ?>
			<div class="grid__3 gap__0 inner-y__05 align__start border__top<?= $isLast ? ' border__bottom' : '' ?> mobile:gap__05" data-scroll>
				<?php if (!empty($targetNumber)) : ?>
					<div class="font__size__1 color__acc font__weight__600 carousel-counter" data-target="<?= esc($targetNumber) ?>"></div>
				<?php else : ?>
					<div class="font__size__1 color__acc font__weight__600"><?= esc($rawNum) ?></div>
				<?php endif ?>
				<?php if (!empty($label)) : ?>
					<p class="span__2 op__7"><?= esc($label) ?></p>
				<?php endif ?>
			</div>
		<?php endif ?>
	<?php endforeach ?>
</div>

<style>
	.carousel-counter,
	.is-inview .carousel-counter {
		color: var(--color-acc) !important;
	}
</style>

<script type="text/javascript">
	(function() {
		function initCarouselCounters() {
			var counters = document.querySelectorAll('.carousel-counter:not([data-initialized])');
			if (!counters.length) return;

			counters.forEach(function(counter) {
				counter.setAttribute('data-initialized', 'true');
				var targetStr = counter.getAttribute('data-target') || '';
				counter.innerHTML = '';

				for (var i = 0; i < targetStr.length; i++) {
					var ribbon = document.createElement('div');
					ribbon.classList.add('counter-ribbon');

					for (var d = 0; d < 10; d++) {
						var digit = document.createElement('div');
						digit.classList.add('counter-digit');
						digit.textContent = d;
						ribbon.appendChild(digit);
					}
					counter.appendChild(ribbon);
				}
			});

			var animateCarousel = function(counter) {
				var targetStr = counter.getAttribute('data-target') || '';
				var ribbons = counter.querySelectorAll('.counter-ribbon');

				ribbons.forEach(function(ribbon, index) {
					var targetDigit = parseInt(targetStr[index], 10);
					if (isNaN(targetDigit)) return;
					setTimeout(function() {
						ribbon.style.transform = 'translateY(-' + (targetDigit * 10) + '%)';
					}, index * 50);
				});
			};

			var observer = new IntersectionObserver(function(entries, obs) {
				entries.forEach(function(entry) {
					if (entry.isIntersecting) {
						animateCarousel(entry.target);
						obs.unobserve(entry.target);
					}
				});
			}, { threshold: 0.2 });

			counters.forEach(function(counter) {
				observer.observe(counter);
			});
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', initCarouselCounters);
		} else {
			initCarouselCounters();
		}
	})();
</script>
