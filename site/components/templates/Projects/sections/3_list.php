<?php if (!empty($isFiltered) && isset($images)) : ?>
	<section class="list radius" theme="invert" data-ajax-filter-list>
		<?php if ($images->isNotEmpty()) : ?>
			<ol class="grid__3 gap__1 gap-y__2 inner__4 inner-t__2">
				<?php foreach ($images as $image) : ?>
					<?php $project = $image->parent(); ?>
					<div data-slide class="">	
						<?= snippet('molecules/Project/list', ['project' => $project, 'img' => $image]) ?>
					</div>
				<?php endforeach ?>
			</ol>
		<?php else : ?>
			<div class="inner__4 inner-y__5 text__center justify__center gap__1">
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
	<section class="list radius" theme="invert" data-ajax-filter-list>
		<?php if ($projects && $projects->isNotEmpty()) : ?>
			<ol class="grid__3 gap__1 gap-y__2 inner__4 inner-t__2">
				<?php foreach ($projects as $project) : ?>
					<div data-slide class="">	
						<?= snippet('molecules/Project/list', compact('project')) ?>
					</div>
				<?php endforeach ?>
			</ol>
		<?php elseif (!empty($isFiltered)) : ?>
			<div class="inner__4 inner-y__5 text__center justify__center gap__1">
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
