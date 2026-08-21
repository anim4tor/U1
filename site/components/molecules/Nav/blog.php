<nav class="flex flex__start flex__middle gap__05 border__bottom inner__1">
	<a href="<?= $page->url() ?>#browse" class="button" <?= e(!$filterBy || $filterBy == t('filter-all'), 'data-active') ?>><?= t('filter-all') ?></a>
	<?php foreach ($items as $filter): ?>
		<a href="<?= $page->url() ?>?filter=<?= $filter ?>#browse" class="button" <?= e($filterBy == $filter, 'data-active') ?> ><?= $filter ?></a>
	<?php endforeach ?>
</nav>