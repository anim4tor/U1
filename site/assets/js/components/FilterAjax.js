/**
 * Component: Async Filter Engine with Morphing and History State
 */

class FilterAjax {
  constructor() {
    this.heroSelector = '[data-ajax-filter-hero]';
    this.listSelector = '[data-ajax-filter-list]';
    this.abortController = null;

    this.init();
  }

  init() {
    // 1. Intercept clicks on filter links & reset buttons
    document.addEventListener('click', (e) => {
      const resetBtn = e.target.closest('[data-ajax-filter-reset]');
      if (resetBtn) {
        e.preventDefault();
        e.stopImmediatePropagation();
        const url = resetBtn.getAttribute('href') || window.location.pathname;
        this.navigate(url);
        return;
      }

      const filterLink = e.target.closest('[data-ajax-filter]');
      if (filterLink) {
        e.preventDefault();
        e.stopImmediatePropagation();
        const url = filterLink.getAttribute('href');
        if (url) {
          // Close parent dropdown menu
          const dropdown = filterLink.closest('.custom-dropdown');
          if (dropdown) {
            dropdown.querySelector('.dropdown-menu')?.classList.remove('is-open');
            dropdown.querySelector('.dropdown-toggle')?.setAttribute('aria-expanded', 'false');
          }
          this.navigate(url);
        }
        return;
      }
    }, true);

    // 2. Intercept popstate (browser back/forward)
    window.addEventListener('popstate', () => {
      if (document.querySelector(this.heroSelector) || document.querySelector(this.listSelector)) {
        this.navigate(window.location.href, false);
      }
    });

    // Expose globally
    window.filterAjaxNavigate = (url) => this.navigate(url);
  }

  async navigate(url, pushState = true) {
    const heroEl = document.querySelector(this.heroSelector);
    const listEl = document.querySelector(this.listSelector);

    if (!heroEl && !listEl) {
      window.location.href = url;
      return;
    }

    if (this.abortController) {
      this.abortController.abort();
    }
    this.abortController = new AbortController();

    if (listEl) {
      listEl.style.transition = 'opacity 0.2s ease';
      listEl.style.opacity = '0.5';
      listEl.style.pointerEvents = 'none';
    }

    try {
      const res = await fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        signal: this.abortController.signal
      });

      if (!res.ok) throw new Error('Fetch failed with status ' + res.status);

      const html = await res.text();
      const parser = new DOMParser();
      const newDoc = parser.parseFromString(html, 'text/html');

      // Update history state & title
      if (pushState) {
        window.history.pushState(null, '', url);
      }
      if (newDoc.title) {
        document.title = newDoc.title;
      }

      // Morph or replace hero and list
      const newHero = newDoc.querySelector(this.heroSelector);
      const currentHero = document.querySelector(this.heroSelector);
      if (newHero && currentHero) {
        if (window.Idiomorph) {
          Idiomorph.morph(currentHero, newHero, {
            morphStyle: 'outerHTML',
            ignoreActiveValue: true
          });
        } else {
          currentHero.replaceWith(newHero);
        }
      }

      const newList = newDoc.querySelector(this.listSelector);
      const currentList = document.querySelector(this.listSelector);
      if (newList && currentList) {
        if (window.Idiomorph) {
          Idiomorph.morph(currentList, newList, {
            morphStyle: 'outerHTML'
          });
        } else {
          currentList.replaceWith(newList);
        }
      }

      // Re-initialize interactive components on the morphed DOM
      if (typeof initDropdowns === 'function') {
        initDropdowns();
      }
      if (typeof initProjectSearch === 'function') {
        initProjectSearch();
      }
      if (typeof initReveals === 'function') {
        initReveals();
      }
      if (typeof REVEAL !== 'undefined' && REVEAL && typeof REVEAL.init === 'function') {
        try {
          REVEAL.init();
        } catch (e) {}
      }
      if (window.SCROLL && typeof window.SCROLL.resize === 'function') {
        window.SCROLL.resize();
      }
    } catch (err) {
      if (err.name === 'AbortError') return;
      console.warn('[FilterAjax] AJAX navigation fallback to reload', err);
      window.location.href = url;
    } finally {
      const finalList = document.querySelector(this.listSelector);
      if (finalList) {
        finalList.style.opacity = '1';
        finalList.style.pointerEvents = '';
      }
    }
  }
}

function initFilterAjax() {
  if (window._filterAjax) return;
  window._filterAjax = new FilterAjax();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initFilterAjax);
} else {
  initFilterAjax();
}
