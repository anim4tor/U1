<div class="grid__2 gap__2 inner-y__1 border__top wrap">	
	<div class="grid place__space-between-stretch gap__2 wrap-r__5 inner-r__2 " data-scroll>
		<div class="grid">
			<p class="upper ">(Featured)</p>
			<span class="op__4"><?= $feed->date()->toDate('Y-m-d') ?></span>
		</div>
		<a href="<?= $feed->url() ?>" ><h3 class="" data-reveal-text><?= $feed->title() ?></h3></a>
		<div class="flex justify__start">
			<?= snippet('atoms/Button', [ 'url' => $feed->url(), 'label' => 'Read more', 'theme' => 'light', 'icon' => 'arrow-right']) ?>
		</div>
	</div>
	<?php if ($cover = $feed->cover()->toFile()) : ?>
	<a href="<?= $feed->url() ?>" class="grid">
		<div class="item__figure grid img__radius no__overflow -wrap-l__5"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 1, 'reveal' => true, 'css' => 'vh__10 grid ' ]) ?></div>
	</a>
	<?php endif ?>
	<!-- <div class="grid ">
		<p class="font__size__small upper"><?= $feed->intro()->inline() ?></p>
	</div> -->
</div>