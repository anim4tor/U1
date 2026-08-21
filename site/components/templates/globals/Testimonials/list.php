<?php if ($testimonials->isNotEmpty()) : ?>
<div class="testimonials rounded-radius" theme="dark" data-carousel>
	<div class="grid grid-cols-1 md:grid-cols-3 gap-1 py-2 pb-3 md:px-1">
		<div class="col-span-1 md:col-span-3 px-1">
			<div class="flex justify-between border-t py-1">
				<div data-scroll class="col-span-2">
					<span class="uppercase" data-reveal-text="lines">(Testimonials)</span>
				</div>
				<div class="flex gap-02 justify-end items-end text-m">
					<button data-carousel-prev class="button uppercase" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
					<button data-carousel-next class="button uppercase" theme="invert-ghost" hover="invert"><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>
				</div>
			</div>
		</div>
		<div class="col-span-1 md:col-span-3" data-carousel-scroll>
			<ol class="flex justify-start items-stretch flex-nowrap gap-1 px-1" data-carousel-slides >	
			<?php foreach ($testimonials as $project) : ?>
				<li data-slide class="grid w-[60vw]">	
					<?= snippet('molecules/Testimonial', compact('project','testimonials')) ?>
				</li>
			<?php endforeach ?>
			<?php foreach ($testimonials as $project) : ?>
				<li data-slide class="grid w-[60vw]">	
					<?= snippet('molecules/Testimonial', compact('project','testimonials')) ?>
				</li>
			<?php endforeach ?>
			</ol>
		</div>
	</div>
</div>
<?php endif ?>