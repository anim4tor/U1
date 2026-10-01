/**
 * Molecule: Project Filter Section, Autocomplete & AJAX Form Handling
 */

class ProjectFilter {
	constructor(panel) {
		this.panel     = panel;
		this.form      = panel.querySelector('form') || panel;
		this.input     = panel.querySelector('input[name="search"]');
		this.list      = panel.querySelector('[data-search-list]');
		this.apiUrl    = panel.querySelector('[data-api-url]')?.dataset.apiUrl || '/ajax/projects/search';
		this.debounceTimer = null;
		this.cache         = {};
		this.selectedIndex = -1;
		this.currentItems  = [];

		this.init();
	}

	init() {
		// 1. Dropdown Form Mode Option Selection (Multiselect)
		this.panel.addEventListener('click', (e) => {
			const optionBtn = e.target.closest('[data-form-filter-option]');
			if (!optionBtn) return;

			e.preventDefault();
			e.stopPropagation();

			const slug      = optionBtn.dataset.formFilterOption;
			const label     = optionBtn.dataset.formFilterLabel || slug;
			const baseLabel = optionBtn.dataset.formFilterBaseLabel || 'Filtr';
			const dropdown  = optionBtn.closest('.custom-dropdown');
			if (!dropdown) return;

			const param     = dropdown.dataset.filterParam;
			const hiddenInp = dropdown.querySelector(`[data-form-filter-input="${param}"]`);
			const toggleBtn = dropdown.querySelector('.dropdown-toggle span[aria-label], .dropdown-toggle');
			const isCurrentlyActive = optionBtn.classList.contains('is-active');

			const checkmark = optionBtn.querySelector('.dropdown-checkmark');
			if (isCurrentlyActive) {
				// Toggle OFF
				optionBtn.classList.remove('is-active');
				optionBtn.setAttribute('theme', 'light');
				if (checkmark) checkmark.classList.add('is-hidden');
			} else {
				// Toggle ON
				optionBtn.classList.add('is-active');
				optionBtn.setAttribute('theme', 'dark');
				if (checkmark) checkmark.classList.remove('is-hidden');
			}

			// Gather all active options in this dropdown
			const activeBtns = Array.from(dropdown.querySelectorAll('[data-form-filter-option].is-active'));
			const activeSlugs = activeBtns.map(b => b.dataset.formFilterOption).filter(Boolean);
			const activeLabels = activeBtns.map(b => b.dataset.formFilterLabel || b.dataset.formFilterOption).filter(Boolean);

			if (hiddenInp) {
				hiddenInp.value = activeSlugs.join(',');
			}

			const toggleAtom = dropdown.querySelector('.dropdown-toggle');
			if (activeSlugs.length === 0) {
				if (toggleBtn) toggleBtn.textContent = baseLabel + ' ▾';
				if (toggleAtom) toggleAtom.setAttribute('theme', 'ghost');
			} else if (activeSlugs.length === 1) {
				if (toggleBtn) toggleBtn.textContent = baseLabel + ' (' + activeLabels[0] + ') ▾';
				if (toggleAtom) toggleAtom.setAttribute('theme', 'dark');
			} else {
				if (toggleBtn) toggleBtn.textContent = baseLabel + ' (' + activeSlugs.length + ') ▾';
				if (toggleAtom) toggleAtom.setAttribute('theme', 'dark');
			}

			// Live reload immediately on option change
			this.submitFilterForm();
		});

		// 2. Form Submit
		if (this.form) {
			this.form.addEventListener('submit', (e) => {
				e.preventDefault();
				this.submitFilterForm();
			});
		}

		// 3. Search Input Autocomplete
		if (this.input) {
			this.input.addEventListener('input', () => {
				const query = this.input.value.trim();

				clearTimeout(this.debounceTimer);
				this.debounceTimer = setTimeout(() => {
					this.fetchResults(query);
				}, 150);
			});

			this.input.addEventListener('keydown', (e) => {
				const itemsCount = this.currentItems.length;

				if (e.key === 'ArrowDown' || e.key === 'ArrowRight') {
					if (itemsCount > 0) {
						e.preventDefault();
						this.selectedIndex = (this.selectedIndex + 1) % itemsCount;
						this.updateSelection();
					}
				} else if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') {
					if (itemsCount > 0) {
						e.preventDefault();
						this.selectedIndex = (this.selectedIndex - 1 + itemsCount) % itemsCount;
						this.updateSelection();
					}
				} else if (e.key === 'Enter') {
					if (this.selectedIndex >= 0 && this.currentItems[this.selectedIndex]) {
						e.preventDefault();
						const selectedWord = this.currentItems[this.selectedIndex].title;
						if (selectedWord) {
							this.input.value = selectedWord;
							if (this.list) this.list.innerHTML = '';
							this.submitFilterForm();
						}
					}
				}
			});
		}
	}

	submitFilterForm() {
		const targetUrl = new URL(this.form.action || window.location.href, window.location.origin);
		const formData = new FormData(this.form);

		// Clear existing search parameters on target
		['industry', 'space', 'solution', 'production', 'hash', 'tag', 'filter', 'search', 'q'].forEach(p => {
			targetUrl.searchParams.delete(p);
		});

		for (const [key, value] of formData.entries()) {
			const trimmed = String(value).trim();
			if (trimmed !== '') {
				targetUrl.searchParams.set(key, trimmed);
			}
		}

		if (window.filterAjaxNavigate) {
			window.filterAjaxNavigate(targetUrl.toString());
		} else {
			window.location.href = targetUrl.toString();
		}
	}

	async fetchResults(query) {
		if (!query || !query.trim()) {
			this.currentItems = [];
			this.selectedIndex = -1;
			if (this.list) this.list.innerHTML = '';
			return;
		}

		const searchUrl = `${this.apiUrl}?q=${encodeURIComponent(query)}`;
		if (this.cache[query]) {
			this.renderResults(this.cache[query], query);
			return;
		}

		this.panel.classList.add('is-loading');

		try {
			const res = await fetch(searchUrl);
			if (!res.ok) throw new Error('Network response failed');
			const data = await res.json();
			this.cache[query] = data;
			this.renderResults(data, query);
		} catch (err) {
			console.warn('Search autocomplete error:', err);
		} finally {
			this.panel.classList.remove('is-loading');
		}
	}

	renderResults(results, query) {
		this.currentItems = results || [];
		this.selectedIndex = -1;

		if (!query || !query.trim() || !this.list) {
			if (this.list) this.list.innerHTML = '';
			return;
		}

		if (!this.currentItems.length) {
			this.list.innerHTML = `
				<div class="project-filter__empty op__5 font__size__small">
					Žádné tagy pro „<strong>${this.escapeHtml(query)}</strong>“
				</div>
			`;
			return;
		}

		const html = this.currentItems.map((item, index) => {
			return `
				<button type="button" class="button --small project-filter__tag-pill" theme="ghost" hover="dark" role="option" data-index="${index}" data-word="${this.escapeHtml(item.title)}">
					<span>${this.escapeHtml(item.title)}</span>
				</button>
			`;
		}).join('');

		this.list.innerHTML = html;

		this.list.querySelectorAll('.project-filter__tag-pill').forEach((btn, idx) => {
			btn.addEventListener('click', (e) => {
				e.preventDefault();
				const word = btn.dataset.word;
				if (word && this.input) {
					this.input.value = word;
					this.toggleClearBtn(true);
					this.list.innerHTML = '';
					this.input.focus();
					this.submitFilterForm();
				}
			});

			btn.addEventListener('mouseenter', () => {
				this.selectedIndex = idx;
				this.updateSelection();
			});
		});
	}

	updateSelection() {
		const items = this.list?.querySelectorAll('.project-filter__tag-pill');
		if (!items) return;
		items.forEach((item, idx) => {
			const isSelected = idx === this.selectedIndex;
			item.classList.toggle('is-selected', isSelected);
			item.setAttribute('aria-selected', isSelected ? 'true' : 'false');
			item.setAttribute('theme', isSelected ? 'dark' : 'ghost');
		});
	}

	highlightMatch(text, query) {
		if (!text || !query) return this.escapeHtml(text || '');
		const escaped = this.escapeHtml(text);
		const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
		const regex = new RegExp(`(${escapedQuery})`, 'gi');
		return escaped.replace(regex, '<mark>$1</mark>');
	}

	escapeHtml(str) {
		return String(str)
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#039;');
	}
}

// Global Filter Trigger setup (persisting across morphs)
function setupFilterTrigger() {
	document.addEventListener('click', (e) => {
		const trigger = e.target.closest('[data-filter-trigger], [data-search-trigger]');
		if (!trigger) return;

		e.preventDefault();
		const panel = document.querySelector('[data-ajax-filter-panel], [data-search-panel-wrapper]');
		if (!panel) return;

		const isOpen = panel.classList.contains('is-open');
		if (isOpen) {
			panel.classList.remove('is-open');
			trigger.classList.remove('is-active');
			trigger.setAttribute('aria-expanded', 'false');
		} else {
			panel.classList.add('is-open');
			trigger.classList.add('is-active');
			trigger.setAttribute('aria-expanded', 'true');
			const input = panel.querySelector('input[name="search"]');
			if (input) {
				setTimeout(() => input.focus(), 80);
			}
		}
	});
}

function initProjectFilter() {
	document.querySelectorAll('[data-ajax-filter-panel]').forEach(panel => {
		if (panel._projectFilter) return;
		panel._projectFilter = new ProjectFilter(panel);
	});
}

// Global initialization
if (typeof window._filterTriggerInitialized === 'undefined') {
	window._filterTriggerInitialized = true;
	setupFilterTrigger();
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', initProjectFilter);
} else {
	initProjectFilter();
}

