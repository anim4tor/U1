<?php if (collection('Team')->isNotEmpty()) : ?>
<section class="recognition u1-type-5" theme="light">
	<!-- Label in cols 1-3 -->
	<div class="u1-type-5__label">
		<span class="op__6"><?= t('featured-in', 'NAPSALI O NÁS') ?></span>
	</div>

	<!-- Content in cols 4-12 -->
	<div class="u1-type-5__content">
		<div class="logo-ticker-container w__full">
			<div class="logo-ticker-track">
				<div class="logo-ticker-group flex gap__1 inner-x__1 inner-y__1">
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_1.png') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_2.png') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_3.png') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_4.png') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_5.png') ?></figure>
				</div>
				<div class="logo-ticker-group flex gap__2 inner-x__1 inner-y__1" aria-hidden="true">
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_1.png') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_2.png') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_3.png') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_4.png') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_featured_5.png') ?></figure>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif ?>
