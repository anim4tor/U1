/*

    TABS

*/
/*
    ULTIMATE - NO HASH VERSION
*/

class Tabs {
    constructor(el) {
        if (!el) return;

        console.log(' ... init Tabs widgets')

        this.DOM = {
            widget: el,
            container: el.querySelector('[data-pane-container]'),
            tabs: Array.from(el.querySelectorAll('[data-tab]')),
            asynctabs: Array.from(el.querySelectorAll('[data-async-tab]')),
            panes: Array.from(el.querySelectorAll('[data-pane]')),
            nav: {
                prev: el.querySelectorAll('[data-tab-prev]'),
                next: el.querySelectorAll('[data-tab-next]')
            }
        };

        this.data = {
            active: 0,
            next: 0,
            cache: {} // Caches async HTML content
        };

        this.is_changing = false;
        this.init();
    }

    init() {


        this.DOM.widget.classList.add('--init');
        
        // Use data-tabs attribute for initial index, default to 0
        this.data.active = parseInt(this.DOM.widget.dataset.tabs) || 0;

        // Setup Accessibility (ARIA roles/ids)
        this.setupA11y();
        
        // Bind all click and keyboard events
        this.initEvents();

        // Set Initial State (false tells it not to animate/trigger changes)
        this.setActive(this.data.active);
    }

    setupA11y() {
        const tabList = this.DOM.tabs[0]?.parentNode;
        if (tabList) tabList.setAttribute('role', 'tablist');

        this.DOM.tabs.forEach((tab, i) => {
            const paneId = this.DOM.panes[i]?.dataset.pane || `pane-${i}`;
            const tabId = `tab-${i}`;
            
            tab.setAttribute('role', 'tab');
            tab.setAttribute('id', tabId);
            tab.setAttribute('aria-controls', paneId);
            tab.setAttribute('tabindex', '-1');

            if (this.DOM.panes[i]) {
                this.DOM.panes[i].setAttribute('role', 'tabpanel');
                this.DOM.panes[i].setAttribute('aria-labelledby', tabId);
                this.DOM.panes[i].setAttribute('id', paneId);
            }
        });
        this.DOM.asynctabs.forEach((tab, i) => {
            const paneId = this.DOM.panes[i]?.dataset.pane || `pane-${i}`;
            const tabId = `tab-${i}`;
            
            tab.setAttribute('role', 'tab');
            tab.setAttribute('id', tabId);
            tab.setAttribute('aria-controls', paneId);
            tab.setAttribute('tabindex', '-1');

            if (this.DOM.panes[i]) {
                this.DOM.panes[i].setAttribute('role', 'tabpanel');
                this.DOM.panes[i].setAttribute('aria-labelledby', tabId);
                this.DOM.panes[i].setAttribute('id', paneId);
            }
        });
    }

    setActive(index) {
        // Prevent action if already transitioning or index is invalid
        if (this.is_changing || index < 0 || index >= this.DOM.tabs.length) return;
        
        this.data.next = index;
        this.change();
    }

    change() {
        const nextTab = this.DOM.tabs[this.data.next];
        const nextPane = this.DOM.panes[this.data.next];

        this.is_changing = true;

        // Visual/ARIA State Update
        this.DOM.tabs.forEach((t, i) => {
            const isActive = i === this.data.next;
            t.toggleAttribute('data-active', isActive);
            t.setAttribute('aria-selected', isActive);
            t.setAttribute('tabindex', isActive ? '0' : '-1');
        });

        this.DOM.panes.forEach((p, i) => {
            p.toggleAttribute('data-active', i === this.data.next);
        });

        // Dynamic Height adjustment for the container
        if (nextPane && this.DOM.container) {
            this.DOM.container.style.width = `${nextPane.scrollWidth}px`;
            this.DOM.container.style.height = `${nextPane.scrollHeight}px`;
        }

        this.data.active = this.data.next;
        this.is_changing = false;
        
        this.onTabChange();
    }

    async loadAsync(index, url) {
        // Check cache first to save bandwidth/time
        if (this.data.cache[url]) {
            this.injectAsyncContent(index, this.data.cache[url]);
            this.setActive(index);
            return;
        }

        this.DOM.widget.classList.add('--loading-async');
        
        try {
            const response = await fetch(url);
            const json = await response.json();
            
            this.data.cache[url] = json.html; 
            this.injectAsyncContent(index, json.html);
            this.setActive(index);
        } catch (err) {
            console.error("Async Tab Error:", err);
        } finally {
            this.DOM.widget.classList.remove('--loading-async');
        }
    }

    injectAsyncContent(index, html) {
        const pane = this.DOM.panes[index];
        if (pane) {
            const loader = pane.querySelector('[data-load]') || pane;
            loader.innerHTML = html;
        }
    }

    handleKeydown(e) {
        let index = this.data.active;
        const lastIndex = this.DOM.tabs.length - 1;

        switch (e.key) {
            case 'ArrowRight': index = index === lastIndex ? 0 : index + 1; break;
            case 'ArrowLeft': index = index === 0 ? lastIndex : index - 1; break;
            case 'Home': index = 0; break;
            case 'End': index = lastIndex; break;
            default: return; // Exit if not a navigation key
        }

        e.preventDefault();
        this.setActive(index);
        this.DOM.tabs[index].focus();
    }

    initEvents() {
        // We delegate all clicks to the root widget element
        this.DOM.widget.addEventListener("click", e => {
            if (this.is_changing) return;

            // 1. Handle Standard Tabs
            const tab = e.target.closest('[data-tab]');
            if (tab && this.DOM.widget.contains(tab)) {
                e.preventDefault();
                const value = tab.dataset.tab;
                const index = (value === "" || !value) 
                    ? Array.from(tab.parentNode.children).indexOf(tab)
                    : Array.from(this.DOM.panes).findIndex(p => p.dataset.pane === value);
                
                if (index !== -1) this.setActive(index);
                return;
            }

            // 2. Handle Async Tabs (Dynamically fetched)
            const asyncTab = e.target.closest('[data-async-tab]');
            if (asyncTab && this.DOM.widget.contains(asyncTab)) {
                e.preventDefault();
                const url = asyncTab.getAttribute('href');
                const paneVal = asyncTab.dataset.asyncTab;
                const index = this.DOM.panes.findIndex(p => p.dataset.pane === paneVal);
                if (index !== -1) this.loadAsync(index, url);
                return;
            }

            // 3. Handle Navigation Buttons
            if (e.target.closest('[data-tab-prev]')) {
                const prevIndex = this.data.active > 0 ? this.data.active - 1 : this.DOM.tabs.length - 1;
                this.setActive(prevIndex);
            } else if (e.target.closest('[data-tab-next]')) {
                const nextIndex = this.data.active < (this.DOM.tabs.length - 1) ? this.data.active + 1 : 0;
                this.setActive(nextIndex);
            }
        });

        // Keyboard support remains fine as-is on the tabs themselves 
        // or you can also delegate this to the widget if you focus-trap
        this.DOM.tabs.forEach(el => el.addEventListener('keydown', (e) => this.handleKeydown(e)));

        // Scroll event is fine as is
        window.addEventListener("scrollTabEvent", e => {
            const { target, way } = e.detail;
            if (way === "enter") {
                const index = this.DOM.panes.indexOf(target);
                if (index !== -1) this.setActive(index);
            }
        });
    }

    onTabChange() {
        // Notify external layout engines
        window.SCROLL?.resize();
        window.Locomotion?.update();
    }
}

/**
 * Global Initialization
 */
function initTabs() {
    document.querySelectorAll('[data-tabs]').forEach(el => new Tabs(el));
}

