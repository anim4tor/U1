<section class="intro radius" theme="invert" style="--in-delay: 500ms">
	<div data-scroll class="z__1 intro__header inner-b__3 place__stretch-stretch grid__4 mobile:grid__1 mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative">
		<div class="h__10"></div>
		<div class="span__4 grid place__stretch-stretch">
			<div class="span__4 border__top inner-t__05 grid__4 place__space-between-stretch">
				<p class="grid place__start-start font__size__large">
					<span class="upper ">(Blog post)</span>
					<span class="op__4"><?= $page->date()->toDate('Y-m-d') ?></span>
				</p>
				<div></div>
				<div class="span__2 -wrap-l__5">
					<h1 class="font__size__2 xs">
						<div data-reveal-text=""><?= $page->title() ?></div>
					</h1>
				</div>
			</div>
		</div>
	</div>
	<div class="inner-x__1 inner-b__5">
		<?php if ($cover = $page->cover()->toFile()) : ?>
		<div class="intro__cover radius grid" data-scroll ><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
		<?php endif ?>
	</div>
</section>

<section class="about" theme="invert">
	<div data-scroll class="grid__3 gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2">
		<div class="span__2 grid place__start-start gap__3 mobile:inner-x__0">
			<h2 data-reveal-text="lines" class="font__size__4"><?= $page->intro()->inline() ?></h2>
		</div>
		
	</div>
	<div data-scroll class="grid__3 gap__2 mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2">
		<div></div>
		<div class=" grid place__start-start gap__3 mobile:inner-x__0">
			<p data-reveal-text="lines" class=""><?= $page->details()->inline() ?></p>
		</div>
		
	</div>
</section>

<section class="others" theme="light">
	<div class="relative grid__2 gap__2 inner-x__1 inner-y__1 inner-t__5">
		<div class="" data-scroll>
			<h3 class="l" data-reveal-text>Explore related articles</h3>
		</div>
		<div class="flex justify__end align__end">
			<?= snippet('atoms/Button', [ 'url' => $page->parent(), 'label' => 'See all articles', 'theme' => 'light', 'icon' => 'arrow-right']) ?>
		</div>
	</div>
	<div class="inner-b__5" >
		<ul class="grid__3 justify__start align__start no__wrap gap__1 inner-x__1 ">	
		<?php foreach (collection('News')->limit(3) as $feed) : ?>
			<?= snippet('molecules/Feed', compact('feed')) ?>
		<?php endforeach ?>
		</ul>
	</div>
</section>

<?= snippet('templates/globals/Cta') ?>