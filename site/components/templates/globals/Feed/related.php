<section class="events" >

	<div class="grid__3 gap__1 mobile:grid__1 inner__4 mobile:inner-x__1 relative z__1" data-carousel>
		<div data-scroll class="flex align__start gap__05 span__2">
			<div class="w__05 h__05 bg__acc"></div>
			<h2 class=""><?= t('related-articles') ?></h2>
		</div>
		<div class="flex gap__02 justify__end align__end ">
			<button data-carousel-prev class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
			<button data-carousel-next class="button upper" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
		</div>
		<div class="span__3 relative z__1" data-carousel-scroll data-scroll>
			<ol class="flex justify__start align__start no__wrap gap__1 " data-carousel-slides >	
			<?php foreach (collection('Blog') as $feed) : ?>
				<li data-slide class="vw__5" >	
					<?= snippet('molecules/Feed', compact('feed')) ?>
				</li>
			<?php endforeach ?>
			</ol>
		</div>
		
	</div>
	<div class="bg radius absolute inset__stretch" theme="light"></div>

</section>