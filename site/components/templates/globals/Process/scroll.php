<?php
	$theme   = (!isset($theme)   || trim($theme)   === '') ? 'invert' : $theme;
?>

<?php if (collection('Process')->isNotEmpty()) : ?>
<section class="process" <?= $theme ? 'theme="'.$theme.'"' : null ?> >
	<div class="relative grid gap-2 px-1 py-2">
		<div class="" data-scroll>
			<h2 class="text-xl flex justify-between" data-reveal-text><span>The</span><span>Process</span></h2>
		</div>
	</div>
	<div >
		<div class="grid grid-cols-1 md:grid-cols-3 gap-2 p-1 pb-5" >
			<div></div>
			<ol class="grid gap-2 place-items-center" >	
			<?php foreach (collection('Process') as $step) : ?>
				<a href="" class="grid place-items-center gap-05 pb-1" data-scroll data-scroll-progress data-scroll-ignore data-hoverable >
					<div class="flex items-start gap-02 py-02 flex-nowrap" data-scroll>
						<h3 class="text-m " data-reveal-text><?= $step->label() ?></h3>
						<div data-reveal-text="" class="-mt-03" data-split-ignore style="--in-delay: 800ms">(<?= $step->step() ?>)</div>
					</div>
					<?php if ($img = $step->figure()->toFile()) : ?>
						<div class="item__figure rounded-img"><?= snippet('atoms/Image', ['img' => $img, 'parallax' => 2, 'reveal' => false, 'css' => 'h-[40vh] w-[40vw]']) ?></div>
					<?php endif ?>
					<p class="text-s text-center" data-hover-reveal data-split-ignore data-reveal-text="words"><?= $step->detail()->inline() ?></p>
				</a>
			<?php endforeach ?>
			</ol>
			<div></div>
		</div>
	
	</div>
	<!-- <div class=vh__15></div> -->
</section>
<?php endif ?>