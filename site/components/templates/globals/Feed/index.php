<section class="events" data-tabs="default">
	<div class="bg rounded-radius absolute inset-0" theme="light"></div>

	<div class="relative grid grid-cols-1 md:grid-cols-3 gap-2 px-1 py-1">
		<div class="" data-scroll>
			<h2 class="text-lg" data-reveal-text>Studio</h2>
		</div>
		<div></div>
		<div class="flex justify-between">
			<div class="grid gap-02 pb-1" data-scroll>
				<h3 data-tab="blog" class="" data-reveal-text>Blog</h3>
				<h3 data-tab="socials" class="" data-reveal-text>Socials</h3>
				<h3 data-tab="media" class="" data-reveal-text>Media</h3>
			</div>
		</div>
	</div>
	<div data-pane-container >
		<div class="grid [grid-template-areas:'stack'] [&>*]:[grid-area:stack] content-start justify-start pb-2">
			<div data-pane="blog" data-scroll data-scroll-ignore data-tab-reveal>
				<div data-carousel class="grid gap-1">
					<div class="flex px-1 gap-02 justify-end items-end text-base">
						<button data-carousel-prev data-reveal-image class="button uppercase" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
						<button data-carousel-next data-reveal-image class="button uppercase" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
					</div>
					<div class="w-screen" data-carousel-scroll theme="light">
						<ol class="flex justify-start items-start flex-nowrap gap-1 px-1" data-carousel-slides >	
						<?php foreach (collection('Blog') as $feed) : ?>
							<li data-slide class="w-[30vw] flex-shrink-0">	
								<?= snippet('molecules/Feed', compact('feed')) ?>
							</li>
						<?php endforeach ?>
						</ol>
					</div>
				</div>
			</div>
			<div data-pane="socials" data-scroll data-scroll-ignore data-tab-reveal>
				<div data-carousel class="grid gap-1">
					<div class="flex px-1 w-screen gap-02 justify-end items-end text-base">
						<button data-carousel-prev data-reveal-image class="button uppercase" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
						<button data-carousel-next data-reveal-image class="button uppercase" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
					</div>
					<div class="w-screen" data-carousel-scroll theme="light">
						<ol class="flex justify-start items-start flex-nowrap gap-1 px-1" data-carousel-slides >	
						<?php foreach (collection('Instagram') as $post) : ?>
							<li data-slide class="w-[20vw] flex-shrink-0">	
								<?= snippet('molecules/Feed/social', compact('post')) ?>
							</li>
						<?php endforeach ?>
						</ol>
					</div>
				</div>
			</div>
			<div data-pane="media" data-scroll data-scroll-ignore data-tab-reveal>
				<div data-carousel class="grid gap-1">
					<div class="flex w-screen px-1 gap-02 justify-end items-end text-base">
						<button data-carousel-prev data-reveal-image class="button uppercase" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
						<button data-carousel-next data-reveal-image class="button uppercase" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
					</div>
					<div class="w-screen" data-carousel-scroll theme="light">
						<ol class="flex justify-start items-start flex-nowrap gap-1 px-1" data-carousel-slides >	
						<?php foreach (collection('Projects') as $feed) : ?>
							<li data-slide class="w-[30vw] flex-shrink-0">	
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