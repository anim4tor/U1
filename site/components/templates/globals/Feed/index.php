<section class="events" data-tabs="default">
	<div class="bg radius absolute inset__stretch" theme="light"></div>

	<div data-pane-container class="relative z__1">
		<div class="grid__stack place__start-start inner__4 mobile:inner-x__1">
			<div data-pane="blog" data-scroll data-scroll-ignore data-tab-reveal class="w__full">
				<div data-carousel class="grid__3 gap-x__1 gap-y__2 mobile:grid__1">
					<div data-scroll class="flex align__start gap__05 span__2">
						<div class="w__03 h__03 bg__acc"></div>
						<div class="flex gap__2 align__center" data-scroll>
							<h2 data-tab="blog" class="" data-reveal-text>Články</h2>
							<h2 data-tab="socials" class="" data-reveal-text>Sítě</h2>
							<h2 data-tab="media" class="" data-reveal-text>Média</h2>
						</div>
					</div>
					
					<div class="flex gap__02 justify__end align__end">
						<button data-carousel-prev class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
						<button data-carousel-next class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
					</div>
					<div class="span__3" data-carousel-scroll theme="light">
						<ol class="flex justify__start align__start no__wrap gap__1 " data-carousel-slides >	
						<?php foreach (collection('Blog') as $feed) : ?>
							<li data-slide class="vw__5">	
								<?= snippet('molecules/Feed', compact('feed')) ?>
							</li>
						<?php endforeach ?>
						</ol>
					</div>
				</div>
			</div>
			<div data-pane="socials" data-scroll data-scroll-ignore data-tab-reveal class="w__full">
				<div data-carousel class="grid__3 gap-x__1 gap-y__2 mobile:grid__1">
					<div data-scroll class="flex align__start gap__05 span__2">
						<div class="w__03 h__03 bg__acc"></div>
						<div class="flex gap__2 align__center" data-scroll>
							<h2 data-tab="blog" class="" data-reveal-text>Články</h2>
							<h2 data-tab="socials" class="" data-reveal-text>Sítě</h2>
							<h2 data-tab="media" class="" data-reveal-text>Média</h2>
						</div>
					</div>
					<div class="flex gap__02 justify__end align__end">
						<button data-carousel-prev class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
						<button data-carousel-next class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
					</div>
					<div class="span__3" data-carousel-scroll theme="light">
						<ol class="flex justify__start align__start no__wrap gap__1 " data-carousel-slides >	
						<?php foreach (collection('Socials') as $post) : ?>
							<li data-slide class="vw__5 aspect__1/1">	
								<?= snippet('molecules/Feed/social', compact('post')) ?>
							</li>
						<?php endforeach ?>
						</ol>
					</div>
				</div>
			</div>
			<div data-pane="media" data-scroll data-scroll-ignore data-tab-reveal class="w__full">
				<div data-carousel class="grid__3 gap-x__1 gap-y__2 mobile:grid__1">
					<div data-scroll class="flex align__start gap__05 span__2">
						<div class="w__03 h__03 bg__acc"></div>
						<div class="flex gap__2 align__center" data-scroll>
							<h2 data-tab="blog" class="" data-reveal-text>Články</h2>
							<h2 data-tab="socials" class="" data-reveal-text>Sítě</h2>
							<h2 data-tab="media" class="" data-reveal-text>Média</h2>
						</div>
					</div>
					<div class="flex gap__02 justify__end align__end">
						<button data-carousel-prev class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
						<button data-carousel-next class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
					</div>
					<div class="span__3" data-carousel-scroll theme="light">
						<ol class="flex justify__start align__start no__wrap gap__1 " data-carousel-slides >	
						<?php foreach (collection('Projects') as $feed) : ?>
							<li data-slide class="vw__5 aspect__1/1">	
								<?= snippet('molecules/Feed/media', compact('feed')) ?>
							</li>
						<?php endforeach ?>
						</ol>
					</div>
				</div>
			</div>
		</div>

	</div>
</section>