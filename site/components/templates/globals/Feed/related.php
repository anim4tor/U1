<section class="events" >

	<div class="grid grid-cols-1 md:grid-cols-3 gap-1 pb-3 md:px-1 relative z-10" data-carousel>
		<div data-scroll class="col-span-1 md:col-span-2 px-1 pt-2">
			<h2 class="">Related articles</h2>
		</div>
		<div class="flex gap-02 justify-end items-end px-1 text-m">
			<button data-carousel-prev class="button uppercase" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
			<button data-carousel-next class="button uppercase" theme="ghost" hover="dark"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
		</div>
		<div class="col-span-1 md:col-span-3 relative z-10" data-carousel-scroll data-scroll>
			<ol class="flex justify-start items-start flex-nowrap gap-1 px-1" data-carousel-slides >	
			<?php foreach (collection('Blog') as $feed) : ?>
				<li data-slide class="w-[25vw]" >	
					<?= snippet('molecules/Feed', compact('feed')) ?>
				</li>
			<?php endforeach ?>
			</ol>
		</div>
		
	</div>
	<div class="bg rounded-radius absolute inset-0" theme="light"></div>

</section>