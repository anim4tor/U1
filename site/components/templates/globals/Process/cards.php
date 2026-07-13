<?php
	$theme   = (!isset($theme)   || trim($theme)   === '') ? 'invert' : $theme;
?>

<?php if (collection('Process')->isNotEmpty()) : ?>
<section class="process" <?= $theme ? 'theme="'.$theme.'"' : null ?> >
	<div class="grid place__end-stretch inner-b__0 relative" >
		
		<div class="sticky top__1 grid place__center-stretch gap__2 inner-x__5 inner-y__2">
			<div class="" data-scroll>
				<h2 class="font__size__1 flex justify__space-between" data-reveal-text><span>The</span><span>Process</span></h2>
			</div>
		</div>

		<div class="grid sticky top__0 -wrap-b__3" data-scroll data-scroll-ignore data-scroll-progress style="--total: <?= collection('Process')->count() ?>">
		<?php foreach (collection('Process') as $step) : ?>
			<div class="card__wrapper grid -wrap-t__11 place__center-center vh__20 sticky top__0" style="--index: <?= $step->step() ?> ">
				<div card class="grid gap__1 inner__1 inner-t__1 vw__6 radius" theme="light" data-scroll>
					<div class="grid gap__3 place__space-between-stretch">
						<div class="grid align__start no__wrap">
							<!-- <div class="font__size__1" data-reveal-text><?= $step->step() ?></div> -->
							<h3 class="m flex justify__space-between" data-reveal-text data-split-ignore>(<?= $step->step() ?>) <?= $step->label() ?></h3>
						</div>
						<div class="grid">
							<p class="span__2" data-reveal="simple"><?= $step->detail()->inline() ?></p>
							<div></div>
						</div>
					</div>
					<?php if ($img = $step->figure()->toFile()) : ?>
						<div class="item__figure img__radius grid"><?= snippet('atoms/Image', ['img' => $img, 'parallax' => 2, 'reveal' => false, 'css' => 'vh__7']) ?></div>
					<?php endif ?>
				</div>
			</div>
		<?php endforeach ?>
		</div>
	
	</div>
	<!-- <div class=vh__15></div> -->
</section>
<?php endif ?>