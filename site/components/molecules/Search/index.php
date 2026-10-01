<?php
/**
 * Molecule: Project Search with Full-width H2 Input and Autocomplete
 */
$query         = $query ?? get('search') ?? get('q') ?? '';
$placeholder   = $placeholder ?? t('search-projects', 'Hledat prostor, odvětví...');
$targetUrl     = $url ?? (isset($page) ? $page->url() : url('projects'));
$theme         = $theme ?? 'dark';
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

		<div class="project-search__bar relative flex align__center justify__space-between border__bottom inner-b__1">
			<input 
				type="text" 
				name="search" 
				value="<?= esc($query) ?>" 
				placeholder="<?= esc($placeholder) ?>" 
				autocomplete="off" 
				spellcheck="false"
				class="project-search__input font__size__2 ff__heading"
				aria-label="<?= esc($placeholder) ?>"
				aria-autocomplete="list"
				aria-controls="project-search-results"
			>
			<div class="project-search__actions flex align__center gap__05">
				<button 
					type="button" 
					class="project-search__clear <?= !empty($query) ? 'is-visible' : '' ?>" 
					aria-label="Vymazat hledání"
					tabindex="-1"
				>
					&times;
				</button>
				<div class="project-search__spinner" aria-hidden="true"></div>
				<button type="submit" class="button circle --small" theme="acc" hover="invert" aria-label="Hledat">
					<span class="icon">&rarr;</span>
				</button>
			</div>
		</div>
	</form>

	<div id="project-search-results" class="project-search__results-container inner-t__2">
		<div class="project-search__results-list grid__3 gap__1 mobile:grid__1" data-search-list></div>
		<div class="project-search__footer" data-search-footer></div>
	</div>
</div>
