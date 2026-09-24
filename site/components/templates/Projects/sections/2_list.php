<?php if (!empty($isFiltered) && isset($images)) : ?>
	<?php if ($images->isNotEmpty()) : ?>
		<section class="list" theme="invert">
			<ol class="grid__3 gap__1 inner__4 inner-t__2">
				<?php foreach ($images as $image) : ?>
					<?php $project = $image->parent(); ?>
					<div data-slide class="inner-b__3">	
						<div class="item --project" data-scroll>
							<a href="<?= $project ? $project->url() : '#' ?>" class="grid gap__05 relative">	
								<div class="item__figure grid img__radius">
									<?= snippet('atoms/Image', ['img' => $image, 'reveal' => true, 'css' => 'vh__8', 'node' => 'data-reveal-image']) ?>
								</div>
								<div class="item__meta relative flex justify__space-between align__center gap__2">
									<div class="flex gap__05 upper">
										<h3 class="font__size__5 wrap"><?= $project ? $project->title() : '' ?></h3>
										<?php if ($image->caption()->isNotEmpty()) : ?>
											<span class="op__6 font__size__small">(<?= $image->caption() ?>)</span>
										<?php endif ?>
									</div>
									<?php if ($project && $project->date()->isNotEmpty()) : ?>
										<p class="font__size__small">(<?= $project->date()->toDate('Y') ?>)</p>
									<?php endif ?>
								</div>
							</a>
						</div>
					</div>
				<?php endforeach ?>
			</ol>
		</section>
	<?php endif ?>
<?php else : ?>
	<?php if (collection('Projects')->isNotEmpty()) : ?>
		<section class="list" theme="invert">
			<ol class="grid__3 gap__1 inner__4 inner-t__2">
				<?php foreach ($projects as $project) : ?>
					<div data-slide class="inner-b__3">	
						<?= snippet('molecules/Project/large', compact('project')) ?>
					</div>
				<?php endforeach ?>
			</ol>
		</section>
	<?php endif ?>
<?php endif ?>
