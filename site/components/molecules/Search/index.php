<?php
/**
 * Molecule: Project Search with Fullscreen Bar and Autocomplete
 */
$query         = get('search') ?? get('q') ?? '';
$placeholder   = $placeholder ?? t('search-projects', 'Hledat prostor, odvětví...');
$targetUrl     = $url ?? (isset($page) ? $page->url() : url('projects'));
$theme         = $theme ?? 'ghost';
?>
<div class="project-search" 
     data-project-search 
     data-api-url="<?= url('ajax/projects/search') ?>"
     data-i18n-no-results="<?= esc(t('search-no-results', 'Žádné tagy ani fotografie nenalezeny')) ?>"
     data-i18n-all-results="<?= esc(t('search-all-results', 'Zobrazit fotografie pro')) ?>"
>
	<!-- Circle button trigger -->
	<button 
		type="button" 
		class="button circle project-search__trigger <?= !empty($query) ? 'is-active' : '' ?>" 
		theme="<?= $theme ?>" 
		hover="dark"
		data-search-trigger 
		aria-label="<?= esc($placeholder) ?>" 
		aria-expanded="false" 
		title="<?= esc($placeholder) ?>"
	>
		<span class="icon">
			<?= svg('public/assets/images/ui/ui_search.svg') ?>
		</span>
	</button>

	<!-- Fullscreen Search Overlay / Bar -->
	<div class="project-search__overlay" data-search-overlay role="dialog" aria-modal="true" aria-hidden="true" data-lenis-prevent>
		<div class="project-search__backdrop" data-search-close></div>
		
		<div class="project-search__container" theme="dark">
			<div class="project-search__header flex justify__space-between align__center inner-b__3">
				<div class="flex align__center gap__05">
					<span class="upper font__size__small op__5"><?= esc(t('search', 'Hledání')) ?></span>
					<span class="w__03 h__03 bg__text op__4"></span>
					<span class="upper font__size__small op__5">Prostory & Odvětví</span>
				</div>
				<div class="flex align__center gap__1">
					<span class="upper font__size__small op__4 mobile:hidden">ESC pro zavření</span>
					<button type="button" class="button circle --small" theme="ghost" hover="dark" data-search-close aria-label="Zavřít">
						<span class="icon"><?= svg('public/assets/images/ui/ui_close.svg') ?></span>
					</button>
				</div>
			</div>

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
						aria-expanded="false"
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

			<div id="project-search-results" class="project-search__results-container inner-t__3">
				<div class="project-search__results-list grid__3 gap__1 mobile:grid__1" data-search-list></div>
				<div class="project-search__footer" data-search-footer></div>
			</div>
		</div>
	</div>
</div>
