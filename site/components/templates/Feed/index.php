<?= snippet('templates/globals/Hero/list', [
	'id'    => 'news',
	'theme' => 'light',
	'title' => 'Články',
	'nav'   => [
		['label' => 'Sítě', 'url' => '#socials'],
		['label' => 'Média', 'url' => '#media'],
	]
]) ?>

<section class="blog" theme="light" >
	<div class="inner-t__5" >
		<ol class="grid inner-x__4 ">	
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

<?= snippet('templates/globals/Hero/list', [
	'id'    => 'socials',
	'theme' => 'light',
	'title' => 'Sítě',
	'nav'   => [
		['label' => 'Články', 'url' => '#news'],
		['label' => 'Média', 'url' => '#media'],
	]
]) ?>

<section class="events" theme="light" data-carousel>
	<div class="relative grid gap__2 inner-x__4 ">
		<div class="flex justify__end inner-y__1 border__bottom">
			<div class="flex gap__02 justify__end align__end">
				<button data-carousel-prev class="button upper" theme="ghost" ><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
				<button data-carousel-next class="button upper" theme="ghost" ><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
			</div>
		</div>
	</div>
	<div class="inner-y__1 " data-carousel-scroll>
		<ol class="flex justify__start align__start no__wrap gap__1 inner-x__4 " data-carousel-slides >	
		<?php foreach (collection('Socials') as $post) : ?>
			<div data-slide data-scroll class="vw__5 aspect__1/1">	
				<?= snippet('molecules/Feed/social', compact('post')) ?>
			</div>
		<?php endforeach ?>
		</ol>
	</div>
</section>

<?= snippet('templates/globals/Hero/list', [
	'id'    => 'media',
	'theme' => 'light',
	'title' => 'Média',
	'nav'   => [
		['label' => 'Články', 'url' => '#news'],
		['label' => 'Sítě', 'url' => '#socials'],
	]
]) ?>

<section class="events" theme="light" >
	<div class="inner-t__5 inner-b__5" >
		<ol class="grid inner-x__4 ">	
			<?php foreach (collection('Blog') as $feed) : ?>
				<li class="item vw__7" data-scroll>
					<?= snippet('molecules/Feed/post', compact('feed')) ?>
				</li>
			<?php endforeach ?>
		</ol>
	</div>
</section>

<?= snippet('templates/globals/Cta') ?>