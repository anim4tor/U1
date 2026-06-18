class Tabs {
    constructor(el) {
        if (!el) return;

        console.log('... init Tabs widgets');

        this.DOM = {
            widget: el,
            containers: Array.from(el.querySelectorAll('[data-pane-container]')),
            tabs: Array.from(el.querySelectorAll('[data-tab], [data-async-tab]')),
            panes: Array.from(el.querySelectorAll('[data-pane]')),
            nav: {
                prev: el.querySelectorAll('[data-tab-prev]'),
                next: el.querySelectorAll('[data-tab-next]')
            }
        };

        this.data = {
            active: 0,
            next: 0,
            cache: {} 
        };

        this.is_changing = false;
        this.is_scrolling_via_click = false; 
        this.scroll_timeout = null;
        this.hover_timeout = null; // Časovač pro ustálení myši
        
        this.closing_timeouts = []; 

        this.scrollTriggers = [];
        this.observer = null;
        
        this.is_hoverable = el.getAttribute('data-tabs') === 'hoverable';

        this._boundHandleKeydown = this.handleKeydown.bind(this);
        this._boundScrollEvent = this.handleScrollEvent.bind(this);

        this.init();
    }

    init() {
        this.DOM.widget.classList.add('--init');
        
        const datasetTabsValue = this.DOM.widget.dataset.tabs;
        this.data.active = (datasetTabsValue === 'hoverable') ? 0 : (parseInt(datasetTabsValue) || 0);

        this.setupA11y();
        this.initEvents();
        this.initScrollTriggers(); 
        this.setActive(this.data.active);
    }

    setupA11y() {
        const tabList = this.DOM.tabs[0]?.parentNode;
        if (tabList) tabList.setAttribute('role', 'tablist');

        this.DOM.tabs.forEach((tab, i) => {
            const paneValue = tab.dataset.tab || tab.dataset.asyncTab || i;
            const tabId = `tab-${i}`;
            
            tab.setAttribute('role', 'tab');
            tab.setAttribute('id', tabId);
            tab.setAttribute('aria-controls', `pane-group-${paneValue}`);
            tab.setAttribute('tabindex', '-1');
        });

        this.DOM.panes.forEach((pane) => {
            const paneValue = pane.dataset.pane;
            if (!paneValue) return;

            const tabIndex = this.DOM.tabs.findIndex(t => (t.dataset.tab === paneValue || t.dataset.asyncTab === paneValue));
            const tabId = tabIndex !== -1 ? `tab-${tabIndex}` : '';

            pane.setAttribute('role', 'tabpanel');
            if (tabId) pane.setAttribute('aria-labelledby', tabId);
        });
    }

    initScrollTriggers() {
        const uniquePaneNames = [...new Set(this.DOM.panes.map(p => p.dataset.pane).filter(Boolean))];

        uniquePaneNames.forEach(paneName => {
            const trigger = document.querySelector(`[data-pane-trigger="${paneName}"]`);
            if (trigger) {
                this.scrollTriggers.push({ trigger, paneName });
            }
        });

        if (this.scrollTriggers.length === 0) return;

        const observerOptions = {
            root: null, 
            rootMargin: '-20% 0px -79% 0px',
            threshold: 0
        };

        this.observer = new IntersectionObserver((entries) => {
            if (this.is_scrolling_via_click) return;

            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const paneName = entry.target.dataset.paneTrigger;
                    const index = this.getTabIndexByPaneValue(paneName);
                    
                    if (index !== -1 && index !== this.data.active) {
                        this.data.next = index;
                        this.change();
                    }
                }
            });
        }, observerOptions);

        this.scrollTriggers.forEach(item => this.observer.observe(item.trigger));
    }

    setActive(index) {
        if (index < 0 || index >= this.DOM.tabs.length) return;
        
        const tab = this.DOM.tabs[index];
        if (tab && tab.hasAttribute('data-async-tab')) {
            const url = tab.getAttribute('href');
            if (url && !this.data.cache[url]) {
                if (this.DOM.widget.classList.contains('--loading-async')) return;
                this.loadAsync(index, url);
                return;
            }
        }

        this.data.next = index;
        this.change();
    }

    change() {
        if (this.data.active === this.data.next && this.DOM.widget.classList.contains('--init-done')) return;
        this.DOM.widget.classList.add('--init-done');

        const animationDuration = 800; 

        // 1. OKAMŽITÁ ZMĚNA PRO TABY
        this.DOM.tabs.forEach((t, i) => {
            const isActive = i === this.data.next;
            t.toggleAttribute('data-active', isActive);
            t.setAttribute('aria-selected', isActive);
            t.setAttribute('tabindex', isActive ? '0' : '-1');
            if (isActive) t.classList.remove('is-closing');
        });

        const lastActiveTab = this.DOM.tabs[this.data.active];
        const lastActivePaneValue = lastActiveTab ? (lastActiveTab.dataset.tab || lastActiveTab.dataset.asyncTab || String(this.data.active)) : null;

        const activeTab = this.DOM.tabs[this.data.next];
        const activePaneValue = activeTab ? (activeTab.dataset.tab || activeTab.dataset.asyncTab || String(this.data.next)) : null;

        // 2. PARALELNÍ ZMĚNA PANELŮ
        this.DOM.panes.forEach((p, i) => {
            const isOldPane = p.dataset.pane ? (p.dataset.pane === lastActivePaneValue) : (i === this.data.active);
            const isNewPane = p.dataset.pane ? (p.dataset.pane === activePaneValue) : (i === this.data.next);

            if (isOldPane && this.data.active !== this.data.next) {
                p.removeAttribute('data-active');
                p.classList.add('is-closing');

                const timeoutId = setTimeout(() => {
                    p.classList.remove('is-closing');
                    this.closing_timeouts = this.closing_timeouts.filter(id => id !== timeoutId);
                }, animationDuration);
                
                this.closing_timeouts.push(timeoutId);
            }

            if (isNewPane) {
                p.toggleAttribute('data-active', true);
                p.classList.remove('is-closing');
            }
        });

        this.DOM.containers.forEach(container => {
            const activePaneInContainer = container.querySelector(`[data-pane="${activePaneValue}"][data-active]`) 
                                         || container.querySelector('[data-pane][data-active]');
        });

        this.data.active = this.data.next;
        this.onTabChange();
    }

    async loadAsync(index, url) {
        if (this.data.cache[url]) {
            this.injectAsyncContent(index, this.data.cache[url]);
            this.data.next = index;
            this.change();
            return;
        }

        this.DOM.widget.classList.add('--loading-async');
        
        try {
            const response = await fetch(url);
            const json = await response.json();
            
            this.data.cache[url] = json.html; 
            this.injectAsyncContent(index, json.html);
            
            this.data.next = index;
            this.change();

            this.DOM.tabs[index]?.focus();
        } catch (err) {
            console.error("Async Tab Error:", err);
        } finally {
            this.DOM.widget.classList.remove('--loading-async');
        }
    }

    injectAsyncContent(index, html) {
        const tab = this.DOM.tabs[index];
        const paneValue = tab ? (tab.dataset.tab || tab.dataset.asyncTab || index) : index;
        
        this.DOM.panes.forEach(pane => {
            if (pane.dataset.pane === paneValue) {
                const loader = pane.querySelector('[data-load]') || pane;
                loader.innerHTML = html;
            }
        });
    }

    handleKeydown(e) {
        const targetTab = e.target.closest('[data-tab], [data-async-tab]');
        if (!targetTab || !this.DOM.widget.contains(targetTab)) return;

        let index = this.DOM.tabs.indexOf(targetTab);
        const lastIndex = this.DOM.tabs.length - 1;

        switch (e.key) {
            case 'ArrowRight': index = index === lastIndex ? 0 : index + 1; break;
            case 'ArrowLeft': index = index === 0 ? lastIndex : index - 1; break;
            case 'Home': index = 0; break;
            case 'End': index = lastIndex; break;
            default: return;
        }

        e.preventDefault();
        this.setActive(index);
        
        if (!this.DOM.tabs[index].hasAttribute('data-async-tab') || this.data.cache[this.DOM.tabs[index].getAttribute('href')]) {
            this.DOM.tabs[index].focus();
        }
    }

    handleScrollEvent(e) {
        const { target, way } = e.detail;
        if (way === "enter") {
            const index = this.DOM.panes.indexOf(target);
            if (index !== -1) this.setActive(index);
        }
    }

    scrollToTrigger(index) {
        const tab = this.DOM.tabs[index];
        const paneName = tab ? (tab.dataset.tab || tab.dataset.asyncTab) : null;
        const trigger = this.scrollTriggers.find(t => t.paneName === paneName)?.trigger;

        if (trigger) {
            this.is_scrolling_via_click = true;
            clearTimeout(this.scroll_timeout);

            const yOffset = 0; 
            const y = trigger.getBoundingClientRect().top + window.pageYOffset + yOffset;

            window.SCROLL?.scrollTo(y);

            this.scroll_timeout = setTimeout(() => {
                this.is_scrolling_via_click = false;
            }, 800);
        }
    }

    getTabIndexByPaneValue(paneValue) {
        return this.DOM.tabs.findIndex(tab => {
            return tab.dataset.tab === paneValue || tab.dataset.asyncTab === paneValue;
        });
    }

    initEvents() {
        // --- HOVER LOGIKA (Taby ihned, panely po ustálení) ---
        if (this.is_hoverable) {
            this.DOM.tabs.forEach(tab => {
                
                const getIndex = () => {
                    const value = tab.dataset.tab || tab.dataset.asyncTab;
                    return (!value) ? this.DOM.tabs.indexOf(tab) : this.getTabIndexByPaneValue(value);
                };

                // Funkce, která se stará o postupné kroky hoveru
                const handleHover = () => {
                    const index = getIndex();
                    if (index === -1) return;

                    // 1. KROK: Okamžitá změna aktivního stavu pro samotné taby
                    this.DOM.tabs.forEach((t, i) => {
                        const isActive = i === index;
                        t.toggleAttribute('data-active', isActive);
                        t.setAttribute('aria-selected', isActive);
                        t.setAttribute('tabindex', isActive ? '0' : '-1');
                    });

                    // 2. KROK: Odložení aktivace panelu, dokud se myš neustálí
                    clearTimeout(this.hover_timeout);
                    this.hover_timeout = setTimeout(() => {
                        if (index !== this.data.active) {
                            this.setActive(index);
                        }
                    }, 200); // 200ms čekání na zastavení myši
                };

                tab.addEventListener('mouseenter', handleHover);
                tab.addEventListener('mousemove', handleHover);

                // Při opuštění menu uklidíme časovač pro panely
                tab.addEventListener('mouseleave', () => {
                    clearTimeout(this.hover_timeout);
                    
                    // Vrátíme vizuální stav tabů zpět na ten panel, který je reálně aktivní
                    this.DOM.tabs.forEach((t, i) => {
                        const isActive = i === this.data.active;
                        t.toggleAttribute('data-active', isActive);
                        t.setAttribute('aria-selected', isActive);
                        t.setAttribute('tabindex', isActive ? '0' : '-1');
                    });
                });
            });
        }

        // --- CLICK LOGIKA (Zůstává stejná, čistí hover timery) ---
        this.DOM.widget.addEventListener("click", e => {
            const clickedLink = e.target.closest('a');
            
            // 1. Standardní taby
            const tab = e.target.closest('[data-tab]');
            if (tab && this.DOM.widget.contains(tab)) {
                if (!clickedLink && !tab.hasAttribute('href')) {
                    e.preventDefault();
                }
                
                const value = tab.dataset.tab;
                const index = (!value) ? this.DOM.tabs.indexOf(tab) : this.getTabIndexByPaneValue(value);
                
                if (index !== -1) {
                    clearTimeout(this.hover_timeout);
                    this.setActive(index);
                    this.scrollToTrigger(index);
                }
                return;
            }

            // 2. Asynchronní taby
            const asyncTab = e.target.closest('[data-async-tab]');
            if (asyncTab && this.DOM.widget.contains(asyncTab)) {
                if (this.DOM.widget.classList.contains('--loading-async')) return;
                
                if (!clickedLink && !asyncTab.hasAttribute('href')) {
                    e.preventDefault();
                }

                const index = this.DOM.tabs.indexOf(asyncTab);
                if (index !== -1) {
                    clearTimeout(this.hover_timeout);
                    this.setActive(index);
                    this.scrollToTrigger(index);
                }
                return;
            }

            // 3. Navigační tlačítka
            if (e.target.closest('[data-tab-prev]')) {
                clearTimeout(this.hover_timeout);
                const prevIndex = this.data.active > 0 ? this.data.active - 1 : this.DOM.tabs.length - 1;
                this.setActive(prevIndex);
                this.scrollToTrigger(prevIndex);
            } else if (e.target.closest('[data-tab-next]')) {
                clearTimeout(this.hover_timeout);
                const nextIndex = this.data.active < (this.DOM.tabs.length - 1) ? this.data.active + 1 : 0;
                this.setActive(nextIndex);
                this.scrollToTrigger(nextIndex);
            }
        });

        this.DOM.widget.addEventListener('keydown', this._boundHandleKeydown);
        window.addEventListener("scrollTabEvent", this._boundScrollEvent);
    }

    onTabChange() {
        window.SCROLL?.resize();
        window.Locomotion?.update();
    }
    
    destroy() {
        this.DOM.widget.removeEventListener('keydown', this._boundHandleKeydown);
        window.removeEventListener("scrollTabEvent", this._boundScrollEvent);
        if (this.observer) this.observer.disconnect();
        
        clearTimeout(this.scroll_timeout);
        clearTimeout(this.hover_timeout);
        this.closing_timeouts.forEach(id => clearTimeout(id));
    }
}

function initTabs() {
    document.querySelectorAll('[data-tabs]').forEach(el => new Tabs(el));
}