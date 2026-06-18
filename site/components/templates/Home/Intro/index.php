<section class="intro radius" theme="dark">
	<div class="intro__header grid__4 mobile:grid__1 h__100v mobile:h__auto inner__1 mobile:inner-t__10 mobile:gap__2 relative color__invert" data-scroll>
		<?php if ($cover = $page->cover()->toFile()) : ?>
			<div data-reveal-cover class="intro__cover absolute inset__stretch grid "><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 5, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
		<?php endif ?>
		<div class="span__4 grid__4 relative flex justify__space-between align__end" data-reveal-text="words">
			<div class="upper s">Featured project</div>
			<div class="upper s ">Myrtle Pool House</div>
			<div class="upper s flex justify__end">2024</div>
			<div class="upper s flex justify__end">Next</div>
		</div>
		<div class="intro__title relative place__end-stretch span__4 mobile:span__1 inner-y__1" data-scroll data-scroll-speed="-0.5">
			<h1 class="xl">
				<div data-reveal-text="">We deliver <br> workspaces <br>that works</div>
				
				<!-- <?php 
					$title = explode(' ', $page->customTitle()->inline());
				?>
				<div class="flex justify__space-between">
					<div data-reveal-text="chars" ><?= $title[0] ?></div>
					<div data-reveal-text="chars" ><?= $title[1] ?></div>
				</div>
				<div class="flex justify__center">
					<div data-reveal-text="chars" class="wrap-l__20"><?= $title[2] ?></div>
				</div> -->
			</h1>
		</div>
	</div>
</section>