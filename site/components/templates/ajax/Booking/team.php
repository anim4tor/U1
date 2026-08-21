<div class="event__item --small">
	<div class="grid__3 gap__1 inner-x__2 inner-y__2 relative">
		<div class="event__figure grid">
			<?php if ($cover = $book->photo()->toFile()) : ?>
				<figure class="aspect__square grid"><?= snippet('atoms/Image', [ 'img' => $cover ]) ?></figure>
			<?php endif ?>
		</div>
		<div class="event__body span__2 grid gap__05 place__center-start">
			<div class="icon absolute inset__top-right"><?= svg('public/assets/images/ui/ui_arrow-top-right.svg') ?></div>
			
			<h3 class=" inner-r__2"><?= $book->title() ?></h2>
			<?= snippet('atoms/Button', ['url' => $book->url(), 'label' => 'Instructor detail', 'theme' => 'ghost']) ?>
			<!-- <p class=""><?= $book->excerpt() ?></p> -->
		</div>
		
	</div>
</div>
<a data-tab="team" aria-controls="detail" tabindex="-1" aria-selected="false" role="tab" class="inner-y__05 inner-x__2 flex justify__start op__5"><div class="button upper -wrap-l__04">Back</div></a>
<nav class="inner-b__1">
	<?php foreach ($terms = array_fill(0, 10, null) as $term) : ?>
		<a href class="grid__4 inner-x__2 place__center-stretch inner-y__05 border__top">
			<p class="span__2 flex gap__02 align__center upper text-xs bolder">March 30, 2026 <span class="icon --circle"></span> Ashtanga</p>
			<div class="grid">
				<p class="flex gap__02 align__center text-xs">
					<span>5 places left</span>
					<span class="text-xs">•</span> 
					<span>120,- Kč</span>
				</p>
			</div>
			<div class="flex justify__end">
				<?= snippet('atoms/Button', ['url' => '', 'label' => 'Book', 'theme' => 'dark']) ?>
			</div>
		</a>
	<?php endforeach ?>

</nav>
