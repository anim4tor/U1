/**
 * Molecule: Project Search with Fullscreen Bar and Autocomplete
 */

class ProjectSearch {
	constructor(container) {
		this.container   = container;
		this.trigger     = container.querySelector('[data-search-trigger]');
		this.overlay     = container.querySelector('[data-search-overlay]');
		this.closeBtns   = container.querySelectorAll('[data-search-close]');
		this.form        = container.querySelector('form');
		this.input       = container.querySelector('.project-search__input');
		this.clearBtn    = container.querySelector('.project-search__clear');
		this.list        = container.querySelector('[data-search-list]');
		this.footer      = container.querySelector('[data-search-footer]');
		this.apiUrl      = container.dataset.apiUrl || '/ajax/projects/search';

		this.debounceTimer = null;
		this.cache         = {};
		this.selectedIndex = -1;
		this.currentItems  = [];
		this.isOpen        = false;

		this.init();
	}

	init() {
		if (!this.input || !this.overlay) return;

		// 1. Open Trigger
		if (this.trigger) {
			this.trigger.addEventListener('click', (e) => {
				e.preventDefault();
				this.open();
			});
		}

		// 2. Close Buttons
		this.closeBtns.forEach(btn => {
			btn.addEventListener('click', (e) => {
				e.preventDefault();
				this.close();
			});
		});

		// 3. Input typing with debounce
		this.input.addEventListener('input', () => {
			const query = this.input.value.trim();
			this.toggleClearBtn(query.length > 0);

			clearTimeout(this.debounceTimer);
			this.debounceTimer = setTimeout(() => {
				this.fetchResults(query);
			}, 150);
		});

		// 4. Clear button
		if (this.clearBtn) {
			this.clearBtn.addEventListener('click', (e) => {
				e.preventDefault();
				this.input.value = '';
				this.toggleClearBtn(false);
				this.input.focus();
				this.fetchResults('');
			});
		}

		// 5. Keyboard Navigation
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
			} else if (e.key === 'Escape') {
				e.preventDefault();
				this.close();
			}
		});

		// Global Escape key
		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape' && this.isOpen) {
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
			return;
		}

		this.container.classList.add('is-loading');

		try {
			const res = await fetch(searchUrl);
			if (!res.ok) throw new Error('Network response failed');
			const data = await res.json();
			this.cache[cacheKey] = data;
			this.renderResults(data, query);
		} catch (err) {
			console.warn('Search error:', err);
		} finally {
			this.container.classList.remove('is-loading');
		}
	}

	renderResults(results, query) {
		this.currentItems = results || [];
		this.selectedIndex = -1;

		const noResultsText = this.container.dataset.i18nNoResults || 'Žádné tagy ani fotografie nenalezeny';
		const allResultsText = this.container.dataset.i18nAllResults || 'Zobrazit fotografie pro';

		if (!this.currentItems.length) {
			this.list.innerHTML = `
				<div class="project-search__empty span__3">
					${this.escapeHtml(noResultsText)} pro „<strong>${this.escapeHtml(query)}</strong>“
				</div>
			`;
			if (this.footer) this.footer.innerHTML = '';
			return;
		}

		const html = this.currentItems.map((item, index) => {
			const highlightedTitle = query ? this.highlightMatch(item.title, query) : this.escapeHtml(item.title);
			const category = item.category || (item.type === 'space' ? 'Typ prostoru' : (item.type === 'industry' ? 'Odvětví' : 'Tag'));
			const countLabel = item.count_label || (item.count ? `${item.count} fotek` : '');

			return `
				<a href="${this.escapeHtml(item.url)}" class="project-search__card" role="option" data-index="${index}">
					<div class="project-search__card-thumb">
						${item.cover ? `<img src="${this.escapeHtml(item.cover)}" alt="${this.escapeHtml(item.title)}" loading="lazy">` : `<div class="project-search__thumb-placeholder">U1</div>`}
					</div>
					<div class="project-search__card-body">
						<div class="project-search__card-header">
							<span class="project-search__badge upper">${this.escapeHtml(category)}</span>
							${countLabel ? `<span class="project-search__count">(${this.escapeHtml(countLabel)})</span>` : ''}
						</div>
						<div class="project-search__card-title ff__heading font__size__4">${highlightedTitle}</div>
					</div>
					<div class="project-search__card-arrow" aria-hidden="true">&rarr;</div>
				</a>
			`;
		}).join('');

		this.list.innerHTML = html;

		if (this.footer && query) {
			this.footer.innerHTML = `
				<button type="submit" class="project-search__footer-btn" onclick="this.closest('.project-search').querySelector('form').submit();">
					<span>${this.escapeHtml(allResultsText)} „${this.escapeHtml(query)}“</span>
					<span class="icon">&rarr;</span>
				</button>
			`;
		} else if (this.footer) {
			this.footer.innerHTML = '';
		}

		// Attach mouse hover handlers to items
		this.list.querySelectorAll('.project-search__card').forEach((itemEl, idx) => {
			itemEl.addEventListener('mouseenter', () => {
				this.selectedIndex = idx;
				this.updateSelection();
			});
		});
	}

	updateSelection() {
		const items = this.list.querySelectorAll('.project-search__card');
		items.forEach((item, idx) => {
			const isSelected = idx === this.selectedIndex;
			item.classList.toggle('is-selected', isSelected);
			item.setAttribute('aria-selected', isSelected ? 'true' : 'false');
			if (isSelected) {
				item.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
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
		if (this.isOpen) return;
		this.isOpen = true;

		this.overlay.classList.add('is-open');
		this.overlay.setAttribute('aria-hidden', 'false');
		if (this.trigger) this.trigger.setAttribute('aria-expanded', 'true');
		document.documentElement.style.overflow = 'hidden';

		setTimeout(() => {
			this.input.focus();
			if (this.input.value) {
				this.input.select();
			}
		}, 100);

		const currentVal = this.input.value.trim();
		this.toggleClearBtn(currentVal.length > 0);
		this.fetchResults(currentVal);
	}

	close() {
		if (!this.isOpen) return;
		this.isOpen = false;

		this.overlay.classList.remove('is-open');
		this.overlay.setAttribute('aria-hidden', 'true');
		if (this.trigger) this.trigger.setAttribute('aria-expanded', 'false');
		document.documentElement.style.overflow = '';
		this.selectedIndex = -1;

		if (this.trigger) {
			this.trigger.focus();
		}
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
