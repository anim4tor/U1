<section class="process" theme="invert" >
	<div class="relative grid gap__2 inner-x__1 inner-y__2">
		<div class="" data-scroll>
			<h1 class="xl flex justify__space-between" data-reveal-text><span>The</span><span>Process</span></h1>
		</div>
	</div>
	<div >
		<div class="grid__3 gap__2 inner__1 inner-b__5" >
			<div></div>
			<ul class="grid gap__2 place__center-center" >	
			<?php foreach (collection('Process') as $step) : ?>
				<a href="" class="grid place__center-center gap__05 inner-b__1" data-scroll data-scroll-progress data-scroll-ignore data-hoverable >
					<div class="flex align__start gap__02 inner-y__02" data-scroll>
						<h3 class="font__size__1" data-reveal-text><?= $step->label() ?></h3>
						<span data-reveal-text="lines" class="-wrap-t__03" data-split-ignore style="--in-delay: 1200ms">(<?= $step->step() ?>)</span>
					</div>
					<?php if ($img = $step->figure()->toFile()) : ?>
						<div class="item__figure"><?= snippet('atoms/Image', ['img' => $img, 'parallax' => 2, 'reveal' => false, 'css' => 'vh__8 vw__8 radius']) ?></div>
					<?php endif ?>
					<p class="upper s text__center" data-hover-reveal data-split-ignore data-reveal-text="lines"><?= $step->detail()->inline() ?></p>
				</a>
			<?php endforeach ?>
			</ul>
			<div></div>
		</div>
	
	</div>
	<!-- <div class=vh__15></div> -->
</section>