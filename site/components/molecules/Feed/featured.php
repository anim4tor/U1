<div class="grid__2 gap__2 inner-y__1 border__top wrap">	
	<div class="grid place__space-between-stretch gap__2 wrap-r__5 inner-r__2 " data-scroll>
		<div class="grid">
			<p class="upper font__size__small">(Doporučujeme)</p>
			<span class="op__4 font__size__small"><?= $feed->date()->toDate('Y-m-d') ?></span>
		</div>
		<a href="<?= $feed->url() ?>" ><h3 class="" data-reveal-text><?= $feed->title() ?></h3></a>
		<div class="flex justify__start">
			<?= snippet('atoms/Button', [ 'url' => $feed->url(), 'label' => 'Číst více', 'theme' => 'light', 'icon' => 'arrow-right']) ?>
		</div>
	</div>
	<?php if ($cover = $feed->cover()->toFile()) : ?>
	<a href="<?= $feed->url() ?>" class="grid">
		<div class="item__figure grid img__radius no__overflow aspect__1/1 -wrap-l__5"><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 1, 'reveal' => true, 'css' => 'aspect__1/1 grid ' ]) ?></div>
	</a>
	<?php endif ?>
	<!-- <div class="grid ">
		<p class="font__size__small upper"><?= $feed->intro()->inline() ?></p>
	</div> -->
</div>