/**
 * Component: Async Filter Engine with Morphing and History State
 */

class FilterAjax {
  constructor() {
    this.heroSelector  = '[data-ajax-filter-hero]';
    this.panelSelector = '[data-ajax-filter-panel]';
    this.listSelector  = '[data-ajax-filter-list]';
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
    const heroEl  = document.querySelector(this.heroSelector);
    const panelEl = document.querySelector(this.panelSelector);
    const listEl  = document.querySelector(this.listSelector);

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

      // Preserve filter panel open state
      const wasPanelOpen = panelEl && panelEl.classList.contains('is-open');

      // Morph or replace hero
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

      // Morph or replace filter panel
      const newPanel = newDoc.querySelector(this.panelSelector);
      const currentPanel = document.querySelector(this.panelSelector);
      if (newPanel && currentPanel) {
        if (wasPanelOpen) {
          newPanel.classList.add('is-open');
        }
        if (window.Idiomorph) {
          Idiomorph.morph(currentPanel, newPanel, {
            morphStyle: 'outerHTML',
            ignoreActiveValue: true
          });
        } else {
          currentPanel.replaceWith(newPanel);
        }
      }

      // Morph or replace list
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
      if (typeof initProjectFilter === 'function') {
        initProjectFilter();
      }
      if (typeof initProjectSearch === 'function') {
        initProjectSearch();
      }
      if (typeof initReveals === 'function') {
        initReveals();
      }
      if (typeof REVEAL !== 'undefined' && REVEAL) {
        try {
          if (typeof REVEAL.init === 'function') REVEAL.init();
          if (typeof REVEAL.refresh === 'function') REVEAL.refresh();
          if (typeof REVEAL.initImages === 'function') REVEAL.initImages();
          if (typeof REVEAL.enable === 'function') REVEAL.enable();
        } catch (e) {
          console.warn('[FilterAjax] REVEAL refresh error', e);
        }
      }

      // Ensure newly morphed text and images are split and visible
      document.querySelectorAll('[data-reveal-text]').forEach((el) => {
        if (!el.classList.contains('is-split')) {
          if (typeof REVEAL !== 'undefined' && REVEAL && typeof REVEAL._splitText === 'function') {
            REVEAL._splitText(el);
          } else if (typeof Splitting === 'function') {
            Splitting({ target: el, by: el.getAttribute('data-reveal-text') || 'chars' });
            el.classList.add('is-split', 'is-inview');
          }
        }
        el.classList.add('is-inview');
      });

      document.querySelectorAll('[data-ajax-filter-list] [data-reveal-image], [data-ajax-filter-list] [data-scroll]').forEach((el) => {
        el.classList.add('is-inview');
      });

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
