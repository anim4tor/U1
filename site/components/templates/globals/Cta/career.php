<?php if ($site->ctaCareer()->isNotEmpty()) : ?>
<section class="cta radius" theme="dark" data-scroll>
	<div class="" >
		<div class="bg radius absolute inset__stretch" >
			<!-- <?= asset('public/assets/images/cta_bg.png') ?> -->
		</div>
		<div class="relative grid__4 gap__1 mobile:grid__1 inner__4">
			
			<div class="absolute w__10 top__2 bottom__1 left__4">
				<?= snippet('molecules/Header', ['header' => $site->ctaCareer(), 'type' => ['image']]) ?>
			</div>
			<div class="span__3 flex align__end gap__2 color__invert relative">
				<div class="span__2 grid gap__05 inner-l__10">
					<div class="inner-b__0 flex align__start gap__01 span__4">
						<?= snippet('molecules/Header', ['header' => $site->ctaCareer(), 'type' => ['label']]) ?>
						<?= snippet('molecules/Header', ['header' => $site->ctaCareer(), 'type' => ['heading']]) ?>
					</div>
					<div class="inner-l__04">
						<?= snippet('molecules/Header', ['header' => $site->ctaCareer(), 'type' => ['text']]) ?>
					</div>
				</div>
			</div>
			<div class="flex gap__0 justify__end align__end">
				<?= snippet('atoms/Button', [ 'type' => 'button', 'theme' => 'invert-ghost', 'hover' => 'dark', 'label' => 'Volné pozice', 'url' => page('career/positions')->url() ]) ?>
				<?= snippet('molecules/Header', ['header' => $site->ctaCareer(), 'type' => ['button']]) ?>

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
