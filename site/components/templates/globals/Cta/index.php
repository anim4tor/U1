<?php if ($site->ctaContact()->isNotEmpty()) : ?>
<section class="cta rounded-radius" theme="dark" data-scroll>
	<div class="" data-contact-toggle="inquiry">
		<div class="bg rounded-radius absolute inset-0" >
			<!-- <?= asset('public/assets/images/cta_bg.png') ?> -->
		</div>
		<div class="relative grid grid-cols-1 md:grid-cols-4 gap-1 px-1 py-2 pt-5">
			<div class="col-span-1 md:col-span-4 flex justify-between items-end gap-3 text-invert">
				<div class="pb-0">
					<?= snippet('molecules/Header', ['header' => $site->ctaContact(), 'type' => ['heading']]) ?>
				</div>
				<div class="flex justify-end">
					<?= snippet('molecules/Header', ['header' => $site->ctaContact(), 'type' => ['button']]) ?>
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	let targetX = 1, targetY = 1;
	let currentX = 1, currentY = 1;
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
