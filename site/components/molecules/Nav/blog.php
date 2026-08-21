<nav class="flex justify-start items-center gap-05 border-b p-1">
	<a href="<?= $page->url() ?>#browse" class="button" <?= e(!$filterBy || $filterBy == t('filter-all'), 'data-active') ?>><?= t('filter-all') ?></a>
	<?php foreach ($items as $filter): ?>
		<a href="<?= $page->url() ?>?filter=<?= $filter ?>#browse" class="button" <?= e($filterBy == $filter, 'data-active') ?> ><?= $filter ?></a>
	<?php endforeach ?>
</nav>