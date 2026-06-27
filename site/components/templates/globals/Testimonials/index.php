<section class="testimonials radius" data-tabs theme="dark">
	<div class="hidden">
		<?php foreach (collection('Projects') as $project) : ?>
			<div data-tab="testimonial-<?= $project->indexOf(collection('Projects')) ?>"></div>
		<?php endforeach ?>
	</div>
	<div class="grid__stack relative">
		<div data-pane-container class="grid__stack absolute inset__stretch">
			<?php foreach (collection('Projects') as $project) : ?>
				<?php if ($cover = $project->cover()->toFile()) : ?>
				<div data-tab-reveal data-pane="testimonial-<?= $project->indexOf(collection('Projects')) ?>" >
					<div class="intro__cover grid " data-reveal-cover><?= snippet('atoms/Image', ['img' => $cover, 'parallax' => 2, 'reveal' => false, 'css' => 'overlay__bottom']) ?></div>
				</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
		<div class="relative z__10 grid__3 gap__2 h__100v mobile:grid__1 inner__1 mobile:inner-x__1 inner-y__2" >
			<div data-tab-prev></div>
			<div class="grid place__center-center">
				<div data-pane-container class="grid " data-scroll data-scroll-ignore data-reveal-image>

					<div class="grid__stack inner__1 img__radius" theme="dark">
						<?php foreach (collection('Projects') as $project) : ?>
							<div data-pane="testimonial-<?= $project->indexOf(collection('Projects')) ?>" class="grid gap__4 place__space-between-start" data-tab-reveal>
								<div class="grid place__start-stretch gap__1">
									<div class="flex justify__space-between">
										<div class="no__overflow w__3" >
											<?php if ($image = $project->testimonialImage()->toFile()) : ?>
												<div class="item__figure" data-reveal-image>
													<?= snippet('atoms/Image', ['img' => $image, 'parallax' => 2, 'css' => '']) ?>
												</div>
											<?php endif ?>
										</div>
										<div class="flex gap__02 justify__end align__start">
											<button data-tab-prev class="button upper" theme="invert-ghost" ><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-left.svg') ?></span></button>
											<button data-tab-next class="button upper" theme="invert-ghost" ><span class="icon"><?= svg('public/assets/images/ui/ui_arrow-right.svg') ?></span></button>

											<!-- <?= snippet('atoms/Link', ['url' => 'projects', 'label' => 'All projects']) ?> -->
										</div>
									</div>
									<p class="quote font__size__5 ff__heading upper" data-reveal-text="lines" data-split-ignore>"<?= $project->testimonialQuote()->inline() ?>"</p>
								</div>
								<div class="flex justify__space-between">
									<div class="s upper " >(Testimonials)</div>
									<div class="s" ><span data-reveal-text="lines" data-split-ignore><?= $project->indexOf(collection('Projects')) + 1 ?></span><span>/<?= collection('Projects')->count() ?></span></div>
								</div>
								<!-- <div class="flex justify__space-between">
									<div class="s upper " data-reveal-text="lines">David L.</div>
									<div class="s upper" data-reveal-text="lines">(Operations Manager)</div>
								</div> -->
							</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
			<div data-tab-next></div>
		</div>
	</div>
</section>