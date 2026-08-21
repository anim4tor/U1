<?php if (collection('Team')->isNotEmpty()) : ?>
<section class="recognition rounded-radius" theme="light" >
	<div class="flex items-center px-1 gap-2">
		<div class="flex-nowrap whitespace-nowrap">
			<div class="uppercase opacity-6">Featured in</div>
		</div>
		<div class="logo-ticker-container">
			<div class="logo-ticker-track">
				<div class="logo-ticker-group flex gap-1 px-1 py-1">
					<figure class="grid place-items-center py-1 opacity-4"><?= asset('public/assets/images/logo_featured_1.png') ?></figure>
					<figure class="grid place-items-center py-1 opacity-4"><?= asset('public/assets/images/logo_featured_2.png') ?></figure>
					<figure class="grid place-items-center py-1 opacity-4"><?= asset('public/assets/images/logo_featured_3.png') ?></figure>
					<figure class="grid place-items-center py-1 opacity-4"><?= asset('public/assets/images/logo_featured_4.png') ?></figure>
					<figure class="grid place-items-center py-1 opacity-4"><?= asset('public/assets/images/logo_featured_5.png') ?></figure>
				</div>
				<div class="logo-ticker-group flex gap-2 px-1 py-1" aria-hidden="true">
					<figure class="grid place-items-center py-1 opacity-4"><?= asset('public/assets/images/logo_featured_1.png') ?></figure>
					<figure class="grid place-items-center py-1 opacity-4"><?= asset('public/assets/images/logo_featured_2.png') ?></figure>
					<figure class="grid place-items-center py-1 opacity-4"><?= asset('public/assets/images/logo_featured_3.png') ?></figure>
					<figure class="grid place-items-center py-1 opacity-4"><?= asset('public/assets/images/logo_featured_4.png') ?></figure>
					<figure class="grid place-items-center py-1 opacity-4"><?= asset('public/assets/images/logo_featured_5.png') ?></figure>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif ?>
