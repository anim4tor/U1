<section id="news" class="intro" theme="light" style="--in-delay: 500ms">
	<div data-scroll class="z__1 intro__header grid__4 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative ">
		<div class="span__4 border__bottom h__8"></div>
		<div class="span__4 inner-t__05 grid__4 place__start-start">
			<div class="span__2">
				<div class="flex align__start gap__02 inner-y__02 no__wrap" data-scroll>
					<h1 class="" data-reveal-text>Blog</h1>
				</div>
			</div>
			<a data-scroll-to href="#socials" class="font__size__3 ff__heading s op__4" data-reveal-text>Socials</a>
			<a data-scroll-to href="#media" class="font__size__3 ff__heading s op__4" data-reveal-text>Media</a>
		</div>
	</div>
</section>

<section class="blog" theme="light" >
	
	<div class="inner-t__5" >
		<ol class="grid inner-x__1 ">	
			<?php $feed = collection('Blog')->first(); ?>
			<li class="" data-scroll>
				<?= snippet('molecules/Feed/featured', compact('feed')) ?>
			</li>
			<?php foreach (collection('Blog') as $feed) : ?>
				<li class="item" data-scroll>
					<?= snippet('molecules/Feed/post', compact('feed')) ?>
				</li>
			<?php endforeach ?>
		</ol>
	</div>
</section>

<section id="socials" class="intro" theme="light" style="--in-delay: 500ms">
	<div data-scroll class="z__1 inner-b__5 intro__header grid__4 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative ">
		<div class="span__4 border__bottom h__8"></div>
		<div class="span__4 inner-t__05 grid__4 place__start-start">
			<a data-scroll-to href="#news" class="font__size__3 ff__heading s op__4" data-reveal-text>Blog</a>
			<div class="span__2">
				<div class="flex align__start gap__02 inner-y__02 no__wrap" data-scroll>
					<h1 class="" data-reveal-text>Socials</h1>
				</div>
			</div>
			<a data-scroll-to href="#media" class="font__size__3 ff__heading s op__4" data-reveal-text>Media</a>
		</div>
	</div>
</section>

<section class="events" theme="light" data-carousel>
	<div class="relative grid gap__2 inner-x__1 ">
		<div class="flex justify__end inner-y__1 border__bottom">
			<div class="flex gap__02 justify__end align__end m">
				<button data-carousel-prev class="button upper" theme="ghost" ><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
				<button data-carousel-next class="button upper" theme="ghost" ><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>

				<!-- <?= snippet('atoms/Link', ['url' => 'projects', 'label' => 'All projects']) ?> -->
			</div>
		</div>
	</div>
	<div class="inner-y__1 " data-carousel-scroll>
		<ol class="flex justify__start align__start no__wrap gap__1 inner-x__1 " data-carousel-slides >	
		<?php foreach (collection('Projects') as $feed) : ?>
			<div data-slide data-scroll class="vw__5 aspect__1/1">	
				<?= snippet('molecules/Feed/social', compact('feed')) ?>
			</div>
		<?php endforeach ?>
		<?php foreach (collection('Projects') as $feed) : ?>
			<div data-slide data-scroll class="vw__5 aspect__1/1">	
				<?= snippet('molecules/Feed/social', compact('feed')) ?>
			</div>
		<?php endforeach ?>
		<?php foreach (collection('Projects') as $feed) : ?>
			<div data-slide data-scroll class="vw__5 aspect__1/1">	
				<?= snippet('molecules/Feed/social', compact('feed')) ?>
			</div>
		<?php endforeach ?>
		<?php foreach (collection('Projects') as $feed) : ?>
			<div data-slide data-scroll class="vw__5 aspect__1/1">	
				<?= snippet('molecules/Feed/social', compact('feed')) ?>
			</div>
		<?php endforeach ?>
		<?php foreach (collection('Projects') as $feed) : ?>
			<div data-slide data-scroll class="vw__5 aspect__1/1">	
				<?= snippet('molecules/Feed/social', compact('feed')) ?>
			</div>
		<?php endforeach ?>
		</ol>
	</div>
</section>

<section id="media" class="intro" theme="light" style="--in-delay: 500ms">
	<div data-scroll class="z__1 intro__header grid__4 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative ">
		<div class="span__4 border__bottom h__8"></div>
		<div class="span__4 inner-t__05 grid__4 place__start-start">
			<a data-scroll-to href="#news" class="font__size__3 ff__heading s op__4" data-reveal-text>Blog</a>
			<a data-scroll-to href="#socials" class="font__size__3 ff__heading s op__4" data-reveal-text>Socials</a>
			<div class="span__2">
				<div class="flex align__start gap__02 inner-y__02 no__wrap" data-scroll>
					<h1 class="" data-reveal-text>Media</h1>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="events" theme="light" >
	<div class="inner-t__5 inner-b__5" >
		<ol class="grid inner-x__1 ">	
			<?php foreach (collection('Blog') as $feed) : ?>
				<li class="item vw__7" data-scroll>
					<?= snippet('molecules/Feed/post', compact('feed')) ?>
				</li>
			<?php endforeach ?>
		</ol>
	</div>
</section>

<?= snippet('templates/globals/Cta') ?>