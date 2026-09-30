<?php
/**
 * Molecule: Project Search with Autocomplete (Našeptávač)
 */
$query         = get('search') ?? get('q') ?? '';
$placeholder   = $placeholder ?? t('search-projects', 'Hledat prostor, odvětví...');
$targetUrl     = $url ?? (isset($page) ? $page->url() : url('projects'));
$theme         = $theme ?? 'light';
?>
<div class="project-search" 
     data-project-search 
     data-api-url="<?= url('ajax/projects/search') ?>"
     data-i18n-no-results="<?= esc(t('search-no-results', 'Žádné tagy ani fotografie nenalezeny')) ?>"
     data-i18n-all-results="<?= esc(t('search-all-results', 'Zobrazit fotografie pro')) ?>"
>
	<form action="<?= $targetUrl ?>" method="GET" class="project-search__form" role="search">
		<?php if ($ind = get('industry')) : ?>
			<input type="hidden" name="industry" value="<?= esc($ind) ?>">
		<?php endif ?>
		<?php if ($sp = get('space')) : ?>
			<input type="hidden" name="space" value="<?= esc($sp) ?>">
		<?php endif ?>

		<div class="project-search__pill" theme="<?= $theme ?>">
			<span class="project-search__icon" aria-hidden="true">
				<?= svg('public/assets/images/ui/ui_search.svg') ?>
			</span>
			<input 
				type="text" 
				name="search" 
				value="<?= esc($query) ?>" 
				placeholder="<?= esc($placeholder) ?>" 
				autocomplete="off" 
				spellcheck="false"
				class="project-search__input"
				aria-label="<?= esc($placeholder) ?>"
				aria-autocomplete="list"
				aria-controls="project-search-results"
				aria-expanded="false"
			>
			<button 
				type="button" 
				class="project-search__clear <?= !empty($query) ? 'is-visible' : '' ?>" 
				aria-label="Vymazat hledání"
				tabindex="-1"
			>
				&times;
			</button>
			<div class="project-search__spinner" aria-hidden="true"></div>
		</div>
	</form>

	<div id="project-search-results" class="project-search__dropdown" role="listbox" theme="light" data-lenis-prevent>
		<div class="project-search__results-list" data-search-list></div>
		<div class="project-search__footer" data-search-footer></div>
	</div>
</div>
