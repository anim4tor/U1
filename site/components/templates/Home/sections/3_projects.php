<?php if ($page->featuredProjects()->isNotEmpty()) : ?>
<section class="projects radius" theme="dark" >
	
	
	<div class="grid__3 gap__1 mobile:grid__1 inner-b__0  mobile:inner-x__1 " data-carousel>
		<div data-scroll class="span__2 inner-x__1 inner-t__2">
			<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['heading']]) ?>
		</div>
		<div class="flex gap__02 justify__end align__end inner-x__1 m">
			<button data-carousel-prev class="button upper" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
			<button data-carousel-next class="button upper" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
		</div>
		<div class="span__3" data-carousel-scroll>
			<ol class="flex justify__start align__center no__wrap gap__0 inner-x__1 " data-carousel-slides >	
			<?php foreach ($page->featuredProjects()->toPages() as $project) : ?>
				<li data-slide class="project__wrapper vw__5">	
					<?= snippet('molecules/Project', compact('project')) ?>
				</li>
			<?php endforeach ?>
				<li data-slide class="vw__6 flex justify__end">	
					<div class="span__3 flex justify__center">
						<?= snippet('molecules/Header', ['header' => $page->projects(), 'type' => ['button']]) ?>
					</div>
				</li>
			</ol>
		</div>
		
	</div>
	<div class="flex align__center gap__2 inner-x__1 no__overflow">
		<div class="inner-x__1 no__wrap">
			<div class="upper op__6">Trusted by</div>
		</div>
		<div class="logo-ticker-container">
			<div class="logo-ticker-track">
				<div class="logo-ticker-group flex gap__2 innex-x__3 inner-y__1">
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_1.svg') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_2.svg') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_3.svg') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_4.svg') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_1.svg') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_2.svg') ?></figure>

				</div>
				<div class="logo-ticker-group flex gap__2 innex-x__3 inner-y__1" aria-hidden="true">
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_1.svg') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_2.svg') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_3.svg') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_4.svg') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_1.svg') ?></figure>
					<figure class="grid place__center-center inner-y__1 op__3"><?= asset('public/assets/images/logo_2.svg') ?></figure>

			</div>
		</div>
	</div>
</section>
<?php endif ?>