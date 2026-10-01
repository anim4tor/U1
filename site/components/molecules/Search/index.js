/**
 * Molecule: Project Search with Minimal Autocomplete Tags
 */

class ProjectSearch {
	constructor(container) {
		this.container   = container;
		this.wrapper     = container.closest('[data-search-panel-wrapper]') || container;
		const section    = container.closest('section') || document;
		this.trigger     = section.querySelector('[data-search-trigger]');
		this.form        = container.querySelector('form');
		this.input       = container.querySelector('.project-search__input');
		this.clearBtn    = container.querySelector('.project-search__clear');
		this.list        = container.querySelector('[data-search-list]');
		this.apiUrl      = container.dataset.apiUrl || '/ajax/projects/search';

		this.debounceTimer = null;
		this.cache         = {};
		this.selectedIndex = -1;
		this.currentItems  = [];
		this.isOpen        = this.wrapper.classList.contains('is-open');

		this.init();
	}

	init() {
		if (!this.input || !this.form) return;

		// 1. Toggle Trigger
		if (this.trigger) {
			this.trigger.addEventListener('click', (e) => {
				e.preventDefault();
				this.toggle();
			});
		}

		// 2. Input typing with debounce
		this.input.addEventListener('input', () => {
			const query = this.input.value.trim();
			this.toggleClearBtn(query.length > 0);

			clearTimeout(this.debounceTimer);
			this.debounceTimer = setTimeout(() => {
				this.fetchResults(query);
			}, 150);
		});

		// 3. Clear button
		if (this.clearBtn) {
			this.clearBtn.addEventListener('click', (e) => {
				e.preventDefault();
				this.input.value = '';
				this.toggleClearBtn(false);
				this.input.focus();
				this.fetchResults('');
			});
		}

		// 4. Keyboard Navigation
		this.input.addEventListener('keydown', (e) => {
			if (!this.isOpen) return;

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
						this.toggleClearBtn(true);
						this.form.submit();
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

	toggle() {
		if (this.isOpen) {
			this.close();
		} else {
			this.open();
		}
	}

	open() {
		this.isOpen = true;
		this.wrapper.classList.add('is-open');
		if (this.trigger) {
			this.trigger.classList.add('is-active');
			this.trigger.setAttribute('aria-expanded', 'true');
		}

		setTimeout(() => {
			this.input.focus();
			if (this.input.value) {
				this.input.select();
			}
		}, 80);

		const currentVal = this.input.value.trim();
		this.toggleClearBtn(currentVal.length > 0);
		if (currentVal.length > 0) {
			this.fetchResults(currentVal);
		} else if (this.list) {
			this.list.innerHTML = '';
		}
	}

	close() {
		this.isOpen = false;
		this.wrapper.classList.remove('is-open');
		if (this.trigger) {
			this.trigger.classList.remove('is-active');
			this.trigger.setAttribute('aria-expanded', 'false');
			this.trigger.focus();
		}
		this.selectedIndex = -1;
		if (this.list) {
			this.list.innerHTML = '';
		}
	}

	toggleClearBtn(show) {
		if (this.clearBtn) {
			this.clearBtn.classList.toggle('is-visible', show);
		}
	}

	async fetchResults(query) {
		if (!query || !query.trim()) {
			this.currentItems = [];
			this.selectedIndex = -1;
			if (this.list) this.list.innerHTML = '';
			return;
		}

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

		if (!query || !query.trim()) {
			if (this.list) this.list.innerHTML = '';
			return;
		}

		const noResultsText = this.container.dataset.i18nNoResults || 'Žádné tagy nenalezeny';

		if (!this.currentItems.length) {
			if (query) {
				this.list.innerHTML = `
					<div class="project-search__empty op__5 font__size__small">
						${this.escapeHtml(noResultsText)} pro „<strong>${this.escapeHtml(query)}</strong>“
					</div>
				`;
			} else {
				this.list.innerHTML = '';
			}
			return;
		}

		const html = this.currentItems.map((item, index) => {
			const highlightedTitle = this.highlightMatch(item.title, query);

			return `
				<button type="button" class="button --small project-search__tag-pill" theme="ghost" hover="dark" role="option" data-index="${index}" data-word="${this.escapeHtml(item.title)}">
					<span>${highlightedTitle}</span>
				</button>
			`;
		}).join('');

		this.list.innerHTML = html;

		// Attach click and mouse hover handlers to tag pills
		this.list.querySelectorAll('.project-search__tag-pill').forEach((btn, idx) => {
			btn.addEventListener('click', (e) => {
				e.preventDefault();
				const word = btn.dataset.word;
				if (word) {
					this.input.value = word;
					this.toggleClearBtn(true);
					this.form.submit();
				}
			});

			btn.addEventListener('mouseenter', () => {
				this.selectedIndex = idx;
				this.updateSelection();
			});
		});
	}

	updateSelection() {
		const items = this.list.querySelectorAll('.project-search__tag-pill');
		items.forEach((item, idx) => {
			const isSelected = idx === this.selectedIndex;
			item.classList.toggle('is-selected', isSelected);
			item.setAttribute('aria-selected', isSelected ? 'true' : 'false');
			if (isSelected) {
				item.setAttribute('theme', 'dark');
			} else {
				item.setAttribute('theme', 'ghost');
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
