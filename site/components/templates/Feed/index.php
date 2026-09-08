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

<section class="events" theme="light" data-carousel>
	<div class="relative grid gap__2 inner-x__1 ">
		<div class="flex justify__end inner-y__1 border__bottom">
			<div class="flex gap__02 justify__end align__end m">
				<button data-carousel-prev class="button upper" theme="ghost" ><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
				<button data-carousel-next class="button upper" theme="ghost" ><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>

			</div>
		</div>
	</div>
	<div class="inner-y__1 " data-carousel-scroll>
		<ol class="flex justify__start align__start no__wrap gap__1 inner-x__1 " data-carousel-slides >	
		<?php foreach (collection('Blog') as $feed) : ?>
			<li data-slide data-scroll class="vw__7">	
				<?= snippet('molecules/Feed', compact('feed')) ?>
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

			</div>
		</div>
	</div>
	<div class="inner-y__1 " data-carousel-scroll>
		<ol class="flex justify__start align__start no__wrap gap__1 inner-x__1 " data-carousel-slides >	
		<?php 
		$socialPosts = collection('Socials');
		if ($socialPosts->isEmpty()) {
			$socialPosts = collection('Projects');
		}
		?>
		<?php foreach ($socialPosts as $post) : ?>
			<div data-slide data-scroll class="vw__5 aspect__1/1">	
				<?= snippet('molecules/Feed/social', compact('post')) ?>
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

<section class="events" theme="light" data-carousel>
	<div class="relative grid gap__2 inner-x__1 ">
		<div class="flex justify__end inner-y__1 border__bottom">
			<div class="flex gap__02 justify__end align__end m">
				<button data-carousel-prev class="button upper" theme="ghost" ><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
				<button data-carousel-next class="button upper" theme="ghost" ><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>

			</div>
		</div>
	</div>
	<div class="inner-y__1 " data-carousel-scroll>
		<ol class="flex justify__start align__start no__wrap gap__1 inner-x__1 " data-carousel-slides >	
		<?php foreach (collection('Projects') as $feed) : ?>
			<div data-slide data-scroll class="vw__5 aspect__1/1">	
				<?= snippet('molecules/Feed/media', compact('feed')) ?>
			</div>
		<?php endforeach ?>
		</ol>
	</div>
</section>