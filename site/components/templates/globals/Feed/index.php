<section class="events" data-tabs="default">
	<div class="bg radius absolute inset__stretch" theme="light"></div>

	<div class="relative grid__4 gap__2 inner__4 inner-b__0">
		<div class="span__2 flex justify__start z__1">
			<div class="flex gap__1 inner-b__1" data-scroll>
				<h2 data-tab="blog" class="" data-reveal-text>Blog</h2>
				<h2 data-tab="socials" class="" data-reveal-text>Socials</h2>
				<h2 data-tab="media" class="" data-reveal-text>Media</h2>
			</div>
		</div>
	</div>
	<div data-pane-container class="">
		<div class="grid__stack place__start-start inner-x__4 ">
			<div data-pane="blog" data-scroll data-scroll-ignore data-tab-reveal>
				<div data-carousel class="grid gap__1">
					<div class="flex gap__02 justify__end align__end">
						<button data-carousel-prev class="button upper" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
						<button data-carousel-next class="button upper" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
						<!-- <?= snippet('atoms/Link', ['url' => 'projects', 'label' => 'All projects']) ?> -->
					</div>
					<div data-carousel-scroll theme="light">
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
			<div data-pane="socials" data-scroll data-scroll-ignore data-tab-reveal>
				<div data-carousel class="grid gap__1">
					<div class="flex gap__02 justify__end align__end">
						<button data-carousel-prev class="button upper" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
						<button data-carousel-next class="button upper" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
						<!-- <?= snippet('atoms/Link', ['url' => 'projects', 'label' => 'All projects']) ?> -->
					</div>
					<div data-carousel-scroll theme="light">
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
			<div data-pane="media" data-scroll data-scroll-ignore data-tab-reveal>
				<div data-carousel class="grid gap__1">
					<div class="flex gap__02 justify__end align__end">
						<button data-carousel-prev class="button upper" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
						<button data-carousel-next class="button upper" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
						<!-- <?= snippet('atoms/Link', ['url' => 'projects', 'label' => 'All projects']) ?> -->
					</div>
					<div data-carousel-scroll theme="light">
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