<?php if ($site->ctaContact()->isNotEmpty()) : ?>
<section class="cta u1-type-4" theme="dark" data-scroll>
	<div class="" data-contact-toggle="inquiry">
		<!-- Background Fullscreen Media -->
		<div class="u1-type-4__bg">
			<?php if ($ctaImg = snippet('molecules/Header', ['header' => $site->ctaContact(), 'type' => ['image']], true)) : ?>
				<div class="w__full h__full"><?= $ctaImg ?></div>
			<?php endif ?>
		</div>

		<!-- Top: Label in Top-Left -->
		<div class="u1-type-4__top" data-scroll>
			<div class="u1-label">
				<?= snippet('molecules/Header', ['header' => $site->ctaContact(), 'type' => ['label']]) ?>
			</div>
		</div>

		<!-- Bottom: Heading & Text bottom-left (cols 1-6), Button bottom-right (cols 7-12) -->
		<div class="u1-type-4__bottom" data-scroll>
			<div class="u1-type-4__content">
				<?= snippet('molecules/Header', ['header' => $site->ctaContact(), 'type' => ['heading']]) ?>
				<?= snippet('molecules/Header', ['header' => $site->ctaContact(), 'type' => ['text']]) ?>
			</div>
			<div class="u1-type-4__action">
				<?= snippet('molecules/Header', ['header' => $site->ctaContact(), 'type' => ['button']]) ?>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	let targetX = 1, targetY = 1;
	let currentX = 1, currentY = 1;
	const ease = 0.05;

	const element = document.querySelector('.cta');
	if (element) {
		element.addEventListener('mousemove', (e) => {
		  const rect = element.getBoundingClientRect();
		  targetX = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
		  targetY = Math.max(0, Math.min(1, (e.clientY - rect.top) / rect.height));
		});

		function animate() {
		  currentX += (targetX - currentX) * ease;
		  currentY += (targetY - currentY) * ease;
		  
		  element.style.setProperty('--x', currentX);
		  element.style.setProperty('--y', currentY);
		  
		  requestAnimationFrame(animate);
		}

		animate();
	}
</script>
<?php endif ?>
