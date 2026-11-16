/**
 * Component: Async Filter Engine with Morphing and History State
 */

class FilterAjax {
  constructor() {
    this.heroSelector  = '[data-ajax-filter-hero]';
    this.panelSelector = '[data-ajax-filter-panel]';
    this.listSelector  = '[data-ajax-filter-list]';
    this.abortController = null;
    this.activeDropdownParam = null;

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
          const dropdown = filterLink.closest('.custom-dropdown');
          if (dropdown) {
            this.activeDropdownParam = dropdown.dataset.filterParam || null;
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
    const listEl = document.querySelector(this.listSelector);

    if (this.abortController) {
      this.abortController.abort();
    }
    this.abortController = new AbortController();

    if (listEl) {
      listEl.style.transition = 'opacity 0.2s ease';
      listEl.style.opacity = '0.5';
      listEl.style.pointerEvents = 'none';
    }

    // Preserve open dropdown param
    const openDropdownParam = this.activeDropdownParam || 
      document.querySelector('.project-header__dropdowns .custom-dropdown .dropdown-menu.is-open')
        ?.closest('.custom-dropdown')?.dataset.filterParam || null;

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

      // 1. Update Projects Count
      const newCount = newDoc.querySelector('[data-projects-count]');
      const currentCount = document.querySelector('[data-projects-count]');
      if (newCount && currentCount) {
        currentCount.textContent = newCount.textContent;
      }

      // 2. Morph Dropdowns in top bar with innerHTML
      const newDropdowns = newDoc.querySelector('.project-header__dropdowns');
      const currentDropdowns = document.querySelector('.project-header__dropdowns');
      if (newDropdowns && currentDropdowns && window.Idiomorph) {
        Idiomorph.morph(currentDropdowns, newDropdowns, {
          morphStyle: 'innerHTML',
          ignoreActiveValue: true,
          callbacks: {
            beforeNodeMorphed: (fromEl, toEl) => {
              if (fromEl.classList && fromEl.classList.contains('dropdown-menu') && fromEl.classList.contains('is-open')) {
                toEl.classList.add('is-open');
              }
              if (fromEl.classList && fromEl.classList.contains('dropdown-toggle') && fromEl.getAttribute('aria-expanded') === 'true') {
                toEl.setAttribute('aria-expanded', 'true');
              }
            }
          }
        });
      }

      // 3. Sync Reset Button
      const newReset = newDoc.querySelector('.project-filter__reset');
      const currentReset = document.querySelector('.project-filter__reset');
      if (newReset && !currentReset) {
        const trigger = document.querySelector('.project-search__trigger');
        if (trigger) trigger.insertAdjacentElement('beforebegin', newReset.cloneNode(true));
      } else if (!newReset && currentReset) {
        currentReset.remove();
      }

      // 4. Morph Filter Drawer Panel with innerHTML
      const newPanel = newDoc.querySelector(this.panelSelector);
      const currentPanel = document.querySelector(this.panelSelector);
      if (newPanel && currentPanel && window.Idiomorph) {
        Idiomorph.morph(currentPanel, newPanel, {
          morphStyle: 'innerHTML',
          ignoreActiveValue: true
        });
      }

      // 5. Keep the open dropdown open
      if (openDropdownParam) {
        const matchingDropdown = document.querySelector(`.project-header__dropdowns .custom-dropdown[data-filter-param="${openDropdownParam}"]`);
        if (matchingDropdown) {
          matchingDropdown.querySelector('.dropdown-menu')?.classList.add('is-open');
          matchingDropdown.querySelector('.dropdown-toggle')?.setAttribute('aria-expanded', 'true');
        }
      }
      this.activeDropdownParam = null;

      // 6. Morph Project Cards List
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

      // 7. Make newly loaded cards visible
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
