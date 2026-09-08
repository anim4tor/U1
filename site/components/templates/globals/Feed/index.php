<section class="events" data-tabs="default">
	<div class="bg radius absolute inset__stretch" theme="light"></div>

	<div class="relative grid__2 gap__2 inner-x__1 inner-y__1">
		<div class="" data-scroll>
			<h2 class="l" data-reveal-text>Studio</h2>
		</div>
		<div class="flex justify__space-between">
			<div class="grid gap__02 inner-b__3" data-scroll>
				<h3 data-tab="blog" class="" data-reveal-text>Blog</h3>
				<h3 data-tab="socials" class="" data-reveal-text>Socials</h3>
				<h3 data-tab="media" class="" data-reveal-text>Media</h3>
			</div>
		</div>
	</div>
	<div data-pane-container >
		<div class="grid__stack place__start-start">
			<div data-pane="blog" data-scroll data-scroll-ignore data-tab-reveal>
				<div data-carousel class="grid gap__1">
					<div class="flex inner-x__1 gap__02 w__100v justify__end align__end m">
						<button data-carousel-prev data-reveal-image class="button upper" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
						<button data-carousel-next data-reveal-image class="button upper" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
						<!-- <?= snippet('atoms/Link', ['url' => 'projects', 'label' => 'All projects']) ?> -->
					</div>
					<div class="inner-b__5 w__100v" data-carousel-scroll>
						<ol class="flex justify__start align__start no__wrap gap__1 inner-x__1 " data-carousel-slides >	
						<?php foreach (collection('Blog') as $feed) : ?>
							<li data-slide class="vw__7">	
								<?= snippet('molecules/Feed', compact('feed')) ?>
							</li>
						<?php endforeach ?>
						</ol>
					</div>
				</div>
			</div>
			<div data-pane="socials" data-scroll data-scroll-ignore data-tab-reveal>
				<div data-carousel class="grid gap__1">
					<div class="flex inner-x__1  w__100v gap__02 justify__end align__end m">
						<button data-carousel-prev data-reveal-image class="button upper" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
						<button data-carousel-next data-reveal-image class="button upper" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
						<!-- <?= snippet('atoms/Link', ['url' => 'projects', 'label' => 'All projects']) ?> -->
					</div>
					<div class="inner-b__5 w__100v " data-carousel-scroll>
						<ol class="flex justify__start align__start no__wrap gap__1 inner-x__1 " data-carousel-slides >	
						<?php 
						$socialItems = collection('Socials');
						if ($socialItems->isEmpty()) {
							$socialItems = collection('Projects');
						}
						?>
						<?php foreach ($socialItems as $post) : ?>
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
					<div class="flex w__100v inner-x__1 gap__02 justify__end align__end m">
						<button data-carousel-prev data-reveal-image class="button upper" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
						<button data-carousel-next data-reveal-image class="button upper" theme="ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
						<!-- <?= snippet('atoms/Link', ['url' => 'projects', 'label' => 'All projects']) ?> -->
					</div>
					<div class="inner-b__5 w__100v" data-carousel-scroll>
						<ol class="flex justify__start align__start no__wrap gap__1 inner-x__1 " data-carousel-slides >	
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