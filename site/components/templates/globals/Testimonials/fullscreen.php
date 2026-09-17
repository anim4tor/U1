<?php
	$items = $items ?? $testimonials ?? ((collection('Projects')) 
    ? collection('Projects')->filterBy('testimonialQuote', '!=', '') 
    : new Kirby\Cms\Pages());
	$theme   = $theme ?? 'dark';
	$snippet = $snippet ?? 'molecules/Testimonial/featured';
	$total   = is_countable($items) ? count($items) : $items->count();
?>
<?php if ($total > 0) : ?>
<section class="testimonials radius" data-tabs="" theme="<?= $theme ?>">
	<div class="hidden">
		<?php $i = 0; foreach ($items as $key => $item) : ?>
			<div data-tab="tab-<?= $i ?>"></div>
		<?php $i++; endforeach ?>
	</div>
	<div class="grid__stack relative">
		<div data-pane-container class="grid__stack absolute inset__stretch">
			<?php $i = 0; foreach ($items as $key => $item) : ?>
				<?php 
					$cover = null;
					$coverUrl = null;
					if (is_object($item) && method_exists($item, 'cover')) {
						$cover = $item->cover()->toFile();
					} elseif (is_array($item)) {
						$coverUrl = $item['image'] ?? null;
					}
				?>
				<div data-tab-reveal data-pane="tab-<?= $i ?>" >
					<div class="intro__cover grid " data-reveal-cover>
						<?php if ($cover) : ?>
							<?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?>
						<?php elseif ($coverUrl) : ?>
							<?= snippet('atoms/Image', ['url' => $coverUrl, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?>
						<?php endif ?>
					</div>
				</div>
			<?php $i++; endforeach ?>
		</div>
		<div class="relative z__10 grid__3 gap__2 h__100v mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2" >
			<div data-tab-prev></div>
			<div class="grid place__center-center">
				<div data-pane-container class="grid " data-scroll data-scroll-ignore data-reveal-image>
					<div class="grid__stack inner__1 img__radius" theme="<?= $theme ?>">
						<?php $i = 0; foreach ($items as $key => $item) : ?>
							<div data-pane="tab-<?= $i ?>" class="grid" data-tab-reveal>
								<?= snippet($snippet, [
									'project'      => $item,
									'item'         => $item,
									'showroom'     => $item,
									'testimonial'  => $item,
									'testimonials' => $items,
									'index'        => $i,
									'total'        => $total
								]) ?>
							</div>
						<?php $i++; endforeach ?>
					</div>
				</div>
			</div>
			<div data-tab-next></div>
		</div>
	</div>
</section>
<?php endif ?>