<?php
	$theme   = (!isset($theme)   || trim($theme)   === '') ? 'invert' : $theme;
?>

<?php if (collection('Process')->isNotEmpty()) : ?>
<section class="process" <?= $theme ? 'theme="'.$theme.'"' : null ?> >
	<div class="grid content-end items-stretch pb-0 relative" >
		
		<div class="sticky top-1 grid place-content-center items-stretch h-screen gap-2 px-1 py-2">
			<div class="max-w-[45rem] mx-auto pb-3" data-scroll>
				<h2 class="font-size-1 flex justify-center text-center" data-reveal-text><span>Overview of our 5-step process</span></h2>
			</div>
		</div>

		<div class="grid sticky top-0 -mt-10" data-scroll data-scroll-ignore data-scroll-progress style="--total: <?= collection('Process')->count() ?>">
		<?php foreach (collection('Process') as $step) : ?>
			<div class="card__wrapper grid place-items-center h-screen sticky top-0" style="--index: <?= $step->step() ?> ">
				<div card class="grid gap-1 p-1 pt-1 w-[min(50vw,40rem)] rounded-radius" theme="light" data-scroll>
					<?php if ($img = $step->figure()->toFile()) : ?>
						<div class="item__figure grid"><?= snippet('atoms/Image', ['img' => $img, 'parallax' => 2, 'reveal' => false, 'css' => 'h-[35vh]']) ?></div>
					<?php endif ?>
					<div class="grid gap-2 content-between items-stretch">
						<div class="grid items-start flex-nowrap">
							<!-- <div class="font-size-1" data-reveal-text><?= $step->step() ?></div> -->
							<h3 class=" flex justify-start gap-1" data-reveal-text data-split-ignore>(<?= $step->step() ?>) <?= $step->label() ?></h3>
						</div>
						<div class="grid">
							<p class="col-span-2" data-reveal="simple"><?= $step->detail()->inline() ?></p>
							<div></div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach ?>
		</div>
	
	</div>
	<!-- <div class=vh__15></div> -->
</section>
<?php endif ?>