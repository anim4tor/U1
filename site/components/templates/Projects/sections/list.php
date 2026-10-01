<?php if (!empty($isFiltered) && isset($images)) : ?>
	<section class="list radius" theme="invert" data-ajax-filter-list>
		<?php if ($images->isNotEmpty()) : ?>
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
						<?= snippet('molecules/Project/list', compact('project')) ?>
					</div>
				<?php endforeach ?>
			</ol>
		<?php else : ?>
			<div class="inner__4 inner-y__5 text__center flex-centered gap__1">
				<p class="font__size__3 op__6"><?= t('search-no-results', 'Žádné projekty nebyly nalezeny') ?></p>
				<?= snippet('atoms/Button', [
					'url'   => $page->url(),
					'label' => t('reset-filters', 'Zrušit filtry'),
					'theme' => 'light',
					'node'  => 'data-ajax-filter-reset'
				]) ?>
			</div>
		<?php endif ?>
	</section>
<?php else : ?>
	<section class="list" theme="invert" data-ajax-filter-list>
		<?php if ($projects && $projects->isNotEmpty()) : ?>
			<ol class="grid__3 gap__1 inner__4 inner-t__2">
				<?php foreach ($projects as $project) : ?>
					<div data-slide class="inner-b__3">	
						<?= snippet('molecules/Project/list', compact('project')) ?>
					</div>
				<?php endforeach ?>
			</ol>
		<?php elseif (!empty($isFiltered)) : ?>
			<div class="inner__4 inner-y__5 text__center flex-centered gap__1">
				<p class="font__size__3 op__6"><?= t('search-no-results', 'Žádné projekty nebyly nalezeny') ?></p>
				<?= snippet('atoms/Button', [
					'url'   => $page->url(),
					'label' => t('reset-filters', 'Zrušit filtry'),
					'theme' => 'light',
					'node'  => 'data-ajax-filter-reset'
				]) ?>
			</div>
		<?php endif ?>
	</section>
<?php endif ?>
