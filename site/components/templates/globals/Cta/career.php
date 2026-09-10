<?php if ($site->ctaCareer()->isNotEmpty()) : ?>
<section class="cta radius" theme="dark" data-scroll>
	<div class="" data-contact-toggle>
		<div class="bg radius absolute inset__stretch" >
			<!-- <?= asset('public/assets/images/cta_bg.png') ?> -->
		</div>
		<div class="relative grid__4 gap__1 mobile:grid__1 inner__4 inner-y__2 ">
			<div class="w__12">
				<?= snippet('molecules/Header', ['header' => $site->ctaCareer(), 'type' => ['image']]) ?>
			</div>
			<div class="span__3 grid__3 justify__space-between align__center gap__2 color__invert">
				<div class="span__2 grid gap__1">
					<?= snippet('molecules/Header', ['header' => $site->ctaCareer(), 'type' => ['heading']]) ?>
					<div class="op__5">
						<?= snippet('molecules/Header', ['header' => $site->ctaCareer(), 'type' => ['text']]) ?>
					</div>
				</div>
				<div class="flex gap__05 justify__end align__end">
					<?= snippet('molecules/Header', ['header' => $site->ctaCareer(), 'type' => ['button']]) ?>
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
