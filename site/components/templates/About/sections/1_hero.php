<?php if ($page->hero()->isNotEmpty()) : ?>
<section class="intro rounded-radius" theme="invert" style="--in-delay: 500ms">
	<div class="z-10 intro__header pb-2 items-stretch justify-stretch grid grid-cols-1 md:grid-cols-4 gap-2 p-1 pt-10 md:pt-1 gap-2 md:gap-2 relative ">
		<div class="col-span-1 md:col-span-4 h-6"></div>
		<div class="col-span-1 md:col-span-4 pt-05 border-t border-white/20 grid grid-cols-1 md:grid-cols-4 justify-between items-stretch">
			<div class="col-span-1 md:col-span-4">
				<div class="flex items-start justify-center gap-02 py-02">
					<div>
						<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['heading']]) ?>
					</div>
				</div>
			</div>
			<div></div>
			<div class="grid gap-1 content-start justify-end">
				<?= snippet('molecules/Header', ['header' => $page->hero(), 'type' => ['button']]) ?>
			</div>
		</div>
	</div>
	<?= snippet('templates/globals/Testimonials/carousel', ['template' => 'about', 'width' => 6, 'theme' => 'invert', 'testimonials' => collection('AboutTestimonials')]) ?>
</section>
<?php endif ?>