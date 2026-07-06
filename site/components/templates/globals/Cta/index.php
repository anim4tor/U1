<?php if ($site->ctaContact()->isNotEmpty()) : ?>
<section class="cta radius" theme="dark" data-scroll>
	<div class="bg radius absolute inset__stretch" >
		<!-- <?= asset('public/assets/images/cta_bg.png') ?> -->
	</div>
	<div class="relative grid__4 gap__1 mobile:grid__1 inner__1 inner-y__2">
		<div class="span__4 grid gap__6 color__invert">
			<?= snippet('molecules/Header', ['header' => $site->ctaContact(), 'type' => ['heading']]) ?>
			<div class="flex justify__end">
				<?= snippet('molecules/Header', ['header' => $site->ctaContact(), 'type' => ['button']]) ?>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	let targetX = 0, targetY = 0;
	let currentX = 0, currentY = 0;
	const ease = 0.05; // Lower is slower/smoother, higher is snappier

	const element = document.querySelector('.cta');

	// Update targets on mouse move
	element.addEventListener('mousemove', (e) => {
	  const rect = element.getBoundingClientRect();
	  targetX = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
	  targetY = Math.max(0, Math.min(1, (e.clientY - rect.top) / rect.height));
	});

	// Animation loop for smooth movement
	function animate() {
	  // Lerp formula: current + (target - current) * easing
	  currentX += (targetX - currentX) * ease;
	  currentY += (targetY - currentY) * ease;
	  
	  element.style.setProperty('--x', currentX);
	  element.style.setProperty('--y', currentY);
	  
	  requestAnimationFrame(animate);
	}

	animate();
</script>
<?php endif ?>
