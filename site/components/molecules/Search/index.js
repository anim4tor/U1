/**
 * Molecule: Project Search with Autocomplete (Našeptávač)
 */

class ProjectSearch {
	constructor(container) {
		this.container   = container;
		this.form        = container.querySelector('form');
		this.input       = container.querySelector('.project-search__input');
		this.clearBtn    = container.querySelector('.project-search__clear');
		this.dropdown    = container.querySelector('.project-search__dropdown');
		this.list        = container.querySelector('[data-search-list]');
		this.footer      = container.querySelector('[data-search-footer]');
		this.apiUrl      = container.dataset.apiUrl || '/api/projects/search';

		this.debounceTimer = null;
		this.cache         = {};
		this.selectedIndex = -1;
		this.currentItems  = [];
		this.isOpen        = false;

		this.init();
	}

	init() {
		if (!this.input || !this.dropdown) return;

		// 1. Input typing with debounce
		this.input.addEventListener('input', () => {
			const query = this.input.value.trim();
			this.toggleClearBtn(query.length > 0);

			if (query.length < 1) {
				this.close();
				return;
			}

			clearTimeout(this.debounceTimer);
			this.debounceTimer = setTimeout(() => {
				this.fetchResults(query);
			}, 180);
		});

		// 2. Input focus
		this.input.addEventListener('focus', () => {
			const query = this.input.value.trim();
			if (query.length >= 1) {
				if (this.cache[query]) {
					this.renderResults(this.cache[query], query);
					this.open();
				} else {
					this.fetchResults(query);
				}
			}
		});

		// 3. Clear button
		if (this.clearBtn) {
			this.clearBtn.addEventListener('click', (e) => {
				e.preventDefault();
				this.input.value = '';
				this.toggleClearBtn(false);
				this.close();
				this.input.focus();
				
				// If currently filtered on search query, submitting empty search resets filter
				const urlParams = new URLSearchParams(window.location.search);
				if (urlParams.has('search') || urlParams.has('q')) {
					this.form.submit();
				}
			});
		}

		// 4. Keyboard Navigation
		this.input.addEventListener('keydown', (e) => {
			if (!this.isOpen) return;

			const itemsCount = this.currentItems.length;

			if (e.key === 'ArrowDown') {
				e.preventDefault();
				if (itemsCount > 0) {
					this.selectedIndex = (this.selectedIndex + 1) % itemsCount;
					this.updateSelection();
				}
			} else if (e.key === 'ArrowUp') {
				e.preventDefault();
				if (itemsCount > 0) {
					this.selectedIndex = (this.selectedIndex - 1 + itemsCount) % itemsCount;
					this.updateSelection();
				}
			} else if (e.key === 'Enter') {
				if (this.selectedIndex >= 0 && this.currentItems[this.selectedIndex]) {
					e.preventDefault();
					const selectedUrl = this.currentItems[this.selectedIndex].url;
					if (selectedUrl) {
						window.location.href = selectedUrl;
					}
				}
				// Otherwise let the form submit normally
			} else if (e.key === 'Escape') {
				e.preventDefault();
				this.close();
			}
		});

		// 5. Click outside to close
		document.addEventListener('click', (e) => {
			if (!this.container.contains(e.target)) {
				this.close();
			}
		});
	}

	toggleClearBtn(show) {
		if (this.clearBtn) {
			this.clearBtn.classList.toggle('is-visible', show);
		}
	}

	async fetchResults(query) {
		let searchUrl = `${this.apiUrl}?q=${encodeURIComponent(query)}`;
		const ind = this.form.querySelector('input[name="industry"]')?.value;
		const sp  = this.form.querySelector('input[name="space"]')?.value;
		if (ind) searchUrl += `&industry=${encodeURIComponent(ind)}`;
		if (sp)  searchUrl += `&space=${encodeURIComponent(sp)}`;

		const cacheKey = `${query}|${ind || ''}|${sp || ''}`;
		if (this.cache[cacheKey]) {
			this.renderResults(this.cache[cacheKey], query);
			this.open();
			return;
		}

		this.container.classList.add('is-loading');

		try {
			const res = await fetch(searchUrl);
			if (!res.ok) throw new Error('Network response failed');
			const data = await res.json();
			this.cache[cacheKey] = data;
			this.renderResults(data, query);
			this.open();
		} catch (err) {
			console.warn('Search error:', err);
		} finally {
			this.container.classList.remove('is-loading');
		}
	}

	renderResults(results, query) {
		this.currentItems = results || [];
		this.selectedIndex = -1;

		const noResultsText = this.container.dataset.i18nNoResults || 'Žádné tagy nenalezeny';
		const allResultsText = this.container.dataset.i18nAllResults || 'Zobrazit všechny fotografie';

		if (!this.currentItems.length) {
			this.list.innerHTML = `
				<div class="project-search__empty">
					${this.escapeHtml(noResultsText)} pro „<strong>${this.escapeHtml(query)}</strong>“
				</div>
			`;
			if (this.footer) this.footer.innerHTML = '';
			return;
		}

		const html = this.currentItems.map((item, index) => {
			const highlightedTitle = this.highlightMatch(item.title, query);
			const category = item.category || (item.type === 'space' ? 'Typ prostoru' : (item.type === 'industry' ? 'Odvětví' : 'Tag'));
			const countLabel = item.count_label || (item.count ? `${item.count} fotek` : '');

			return `
				<a href="${this.escapeHtml(item.url)}" class="project-search__item" role="option" data-index="${index}">
					<div class="project-search__thumb">
						${item.cover ? `<img src="${this.escapeHtml(item.cover)}" alt="${this.escapeHtml(item.title)}" loading="lazy">` : `<div class="project-search__thumb-placeholder">U1</div>`}
					</div>
					<div class="project-search__info">
						<div class="project-search__row">
							<span class="project-search__title">${highlightedTitle}</span>
							${countLabel ? `<span class="project-search__count">(${this.escapeHtml(countLabel)})</span>` : ''}
						</div>
						<span class="project-search__meta">${this.escapeHtml(category)}</span>
					</div>
					<span class="project-search__arrow" aria-hidden="true">&rarr;</span>
				</a>
			`;
		}).join('');

		this.list.innerHTML = html;

		if (this.footer) {
			this.footer.innerHTML = `
				<button type="submit" onclick="this.closest('.project-search').querySelector('form').submit();">
					<span>${this.escapeHtml(allResultsText)} pro „${this.escapeHtml(query)}“</span>
					<span>&rarr;</span>
				</button>
			`;
		}

		// Attach mouse hover handlers to items
		this.list.querySelectorAll('.project-search__item').forEach((itemEl, idx) => {
			itemEl.addEventListener('mouseenter', () => {
				this.selectedIndex = idx;
				this.updateSelection();
			});
		});
	}

	updateSelection() {
		const items = this.list.querySelectorAll('.project-search__item');
		items.forEach((item, idx) => {
			const isSelected = idx === this.selectedIndex;
			item.classList.toggle('is-selected', isSelected);
			item.setAttribute('aria-selected', isSelected ? 'true' : 'false');
			if (isSelected) {
				item.scrollIntoView({ block: 'nearest' });
			}
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

	open() {
		this.dropdown.classList.add('is-open');
		this.input.setAttribute('aria-expanded', 'true');
		this.isOpen = true;
	}

	close() {
		this.dropdown.classList.remove('is-open');
		this.input.setAttribute('aria-expanded', 'false');
		this.selectedIndex = -1;
		this.isOpen = false;
	}
}

function initProjectSearch() {
	document.querySelectorAll('[data-project-search]').forEach(el => {
		if (el._projectSearch) return;
		el._projectSearch = new ProjectSearch(el);
	});
}

// Auto init on DOMContentLoaded
if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', initProjectSearch);
} else {
	initProjectSearch();
}
