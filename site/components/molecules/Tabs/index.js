/*

    TABS

*/
/*
    TABS - ULTIMATE (NO HASH VERSION)
*/

// class Tabs {
//     constructor(el) {
//         if (!el) return;

//         console.log(' ... init Tabs widgets');

//         this.DOM = {
//             widget: el,
//             container: el.querySelector('[data-pane-container]'),
//             // Sloučíme taby do jednoho pole, aby správně fungovaly indexy a klávesnice
//             tabs: Array.from(el.querySelectorAll('[data-tab], [data-async-tab]')),
//             panes: Array.from(el.querySelectorAll('[data-pane]')),
//             nav: {
//                 prev: el.querySelectorAll('[data-tab-prev]'),
//                 next: el.querySelectorAll('[data-tab-next]')
//             }
//         };

//         this.data = {
//             active: 0,
//             next: 0,
//             cache: {} // Caches async HTML content
//         };

//         this.is_changing = false;
//         this.init();
//     }

//     init() {
//         this.DOM.widget.classList.add('--init');
        
//         // Použijeme hodnotu z data-tabs jako výchozí index, jinak 0
//         this.data.active = parseInt(this.DOM.widget.dataset.tabs) || 0;

//         // Setup Accessibility
//         this.setupA11y();
        
//         // Bind událostí
//         this.initEvents();

//         // Nastavení výchozího stavu
//         this.setActive(this.data.active);
//     }

//     setupA11y() {
//         const tabList = this.DOM.tabs[0]?.parentNode;
//         if (tabList) tabList.setAttribute('role', 'tablist');

//         this.DOM.tabs.forEach((tab, i) => {
//             const paneId = this.DOM.panes[i]?.dataset.pane || `pane-${i}`;
//             const tabId = `tab-${i}`;
            
//             tab.setAttribute('role', 'tab');
//             tab.setAttribute('id', tabId);
//             tab.setAttribute('aria-controls', paneId);
//             tab.setAttribute('tabindex', '-1');

//             if (this.DOM.panes[i]) {
//                 this.DOM.panes[i].setAttribute('role', 'tabpanel');
//                 this.DOM.panes[i].setAttribute('aria-labelledby', tabId);
//                 this.DOM.panes[i].setAttribute('id', paneId);
//             }
//         });
//     }

//     setActive(index) {
//         // Kontrola mezí (nyní bezpečné, protože asynctabs jsou v jednom poli)
//         if (index < 0 || index >= this.DOM.tabs.length) return;
        
//         this.data.next = index;
//         this.change();
//     }

//     change() {
//         if (this.is_changing) return;
//         this.is_changing = true;

//         const nextPane = this.DOM.panes[this.data.next];

//         // Vizuální a ARIA update stavů
//         this.DOM.tabs.forEach((t, i) => {
//             const isActive = i === this.data.next;
//             t.toggleAttribute('data-active', isActive);
//             t.setAttribute('aria-selected', isActive);
//             t.setAttribute('tabindex', isActive ? '0' : '-1');
//         });

//         this.DOM.panes.forEach((p, i) => {
//             p.toggleAttribute('data-active', i === this.data.next);
//         });

//         // Flexibilní úprava výšky kontejneru (šířku necháváme na CSS - fluidní)
//         if (nextPane && this.DOM.container) {
//             this.DOM.container.style.height = `${nextPane.scrollHeight}px`;
//         }

//         this.data.active = this.data.next;
//         this.is_changing = false;
        
//         this.onTabChange();
//     }

//     async loadAsync(index, url) {
//         // Pokud už data máme v keši
//         if (this.data.cache[url]) {
//             this.injectAsyncContent(index, this.data.cache[url]);
//             this.setActive(index);
//             return;
//         }

//         // Zamezíme dalším klikancům během stahování
//         this.is_changing = true;
//         this.DOM.widget.classList.add('--loading-async');
        
//         try {
//             const response = await fetch(url);
//             const json = await response.json();
            
//             this.data.cache[url] = json.html; 
//             this.injectAsyncContent(index, json.html);
            
//             // Teprve teď uvolníme zámek a přepneme tab
//             this.is_changing = false;
//             this.setActive(index);
//         } catch (err) {
//             console.error("Async Tab Error:", err);
//             this.is_changing = false;
//         } finally {
//             this.DOM.widget.classList.remove('--loading-async');
//         }
//     }

//     injectAsyncContent(index, html) {
//         const pane = this.DOM.panes[index];
//         if (pane) {
//             const loader = pane.querySelector('[data-load]') || pane;
//             loader.innerHTML = html;
//         }
//     }

//     handleKeydown(e) {
//         let index = this.data.active;
//         const lastIndex = this.DOM.tabs.length - 1;

//         switch (e.key) {
//             case 'ArrowRight': index = index === lastIndex ? 0 : index + 1; break;
//             case 'ArrowLeft': index = index === 0 ? lastIndex : index - 1; break;
//             case 'Home': index = 0; break;
//             case 'End': index = lastIndex; break;
//             default: return;
//         }

//         e.preventDefault();
//         this.setActive(index);
//         this.DOM.tabs[index].focus();
//     }

//     initEvents() {
//         this.DOM.widget.addEventListener("click", e => {
//             if (this.is_changing) return;

//             // 1. Standardní taby
//             const tab = e.target.closest('[data-tab]');
//             if (tab && this.DOM.widget.contains(tab)) {
//                 e.preventDefault();
//                 const value = tab.dataset.tab;
                
//                 const index = (value === "" || !value) 
//                     ? this.DOM.tabs.indexOf(tab)
//                     : this.DOM.panes.findIndex(p => p.dataset.pane === value);
                
//                 if (index !== -1) this.setActive(index);
//                 return;
//             }

//             // 2. Asynchronní taby
//             const asyncTab = e.target.closest('[data-async-tab]');
//             if (asyncTab && this.DOM.widget.contains(asyncTab)) {
//                 e.preventDefault();
//                 const url = asyncTab.getAttribute('href');
//                 const paneVal = asyncTab.dataset.asyncTab;
//                 const index = this.DOM.panes.findIndex(p => p.dataset.pane === paneVal);
                
//                 if (index !== -1) this.loadAsync(index, url);
//                 return;
//             }

//             // 3. Navigační tlačítka (prev / next)
//             if (e.target.closest('[data-tab-prev]')) {
//                 const prevIndex = this.data.active > 0 ? this.data.active - 1 : this.DOM.tabs.length - 1;
//                 this.setActive(prevIndex);
//             } else if (e.target.closest('[data-tab-next]')) {
//                 const nextIndex = this.data.active < (this.DOM.tabs.length - 1) ? this.data.active + 1 : 0;
//                 this.setActive(nextIndex);
//             }

//             // 4. Scroll To funkce
//             const scrollTab = e.target.closest('[data-scroll-to]');
//             if (scrollTab && this.DOM.widget.contains(scrollTab)) {
//                 const targetId = scrollTab.getAttribute('href');
//                 const targetEl = document.getElementById(targetId);
//                 if (targetEl && window.SCROLL) {
//                     window.SCROLL.scrollTo(targetEl.scrollTop);
//                 }
//             }
//         });

//         // Posluchače pro klávesnici navěsíme na sjednocené pole tabů
//         this.DOM.tabs.forEach(el => el.addEventListener('keydown', (e) => this.handleKeydown(e)));

//         // Scroll event zvenčí
//         window.addEventListener("scrollTabEvent", e => {
//             const { target, way } = e.detail;
//             if (way === "enter") {
//                 const index = this.DOM.panes.indexOf(target);
//                 if (index !== -1) this.setActive(index);
//             }
//         });
//     }

//     onTabChange() {
//         window.SCROLL?.resize();
//         window.Locomotion?.update();
//     }
// }

// function initTabs() {
//     document.querySelectorAll('[data-tabs]').forEach(el => new Tabs(el));
// }

/*
    TABS - ULTIMATE (NO HASH VERSION) WITH SCROLL TRIGGERS
*/

class Tabs {
    constructor(el) {
        if (!el) return;

        console.log('... init Tabs widgets');

        this.DOM = {
            widget: el,
            container: el.querySelector('[data-pane-container]'),
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
            cache: {} // Caches async HTML content
        };

        this.is_changing = false;
        this.is_scrolling_via_click = false; // Ochrana proti zacyklení scrollu
        this.scroll_timeout = null;

        // Propojení scroll triggerů s taby
        this.scrollTriggers = [];
        this.observer = null;
        
        // Bindování metod pro bezpečné odebírání eventů
        this._boundHandleKeydown = this.handleKeydown.bind(this);
        this._boundScrollEvent = this.handleScrollEvent.bind(this);

        this.init();
    }

    init() {
        this.DOM.widget.classList.add('--init');
        this.data.active = parseInt(this.DOM.widget.dataset.tabs) || 0;

        this.setupA11y();
        this.initEvents();
        this.initScrollTriggers(); // <- Nová inicializace pro scroll
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
    }

    /**
     * Inicializace Scrollspy pomocí IntersectionObserveru
     */
    initScrollTriggers() {
        // Najdeme všechny triggery na stránce, které odpovídají našim panes
        this.DOM.panes.forEach(pane => {
            const paneName = pane.dataset.pane;
            if (!paneName) return;

            const trigger = document.querySelector(`[data-pane-trigger="${paneName}"]`);
            if (trigger) {
                this.scrollTriggers.push({ trigger, paneName });
            }
        });

        if (this.scrollTriggers.length === 0) return;

        // Konfigurace observeru. 
        // rootMargin "-20% 0px -80% 0px" vytvoří virtuální detekční linku cca v horní pětině obrazovky
        const observerOptions = {
            root: null, 
            rootMargin: '-20% 0px -79% 0px',
            threshold: 0
        };

        this.observer = new IntersectionObserver((entries) => {
            // Pokud zrovna scrollujeme mechanicky po kliknutí na tab, ignorujeme scroll triggery
            if (this.is_scrolling_via_click) return;

            entries.forEach(entry => {
                // Hledáme element, který právě protnul naši aktivní zónu (přichází shora nebo zdola)
                if (entry.isIntersecting) {
                    const paneName = entry.target.dataset.paneTrigger;
                    const index = this.DOM.panes.findIndex(p => p.dataset.pane === paneName);
                    
                    if (index !== -1 && index !== this.data.active) {
                        // Přepneme tab, ale bez vyvolání dalšího nuceného scrollu
                        this.data.next = index;
                        this.change();
                    }
                }
            });
        }, observerOptions);

        // Začneme sledovat všechny spárované elementy
        this.scrollTriggers.forEach(item => this.observer.observe(item.trigger));
    }

    setActive(index) {
        if (index < 0 || index >= this.DOM.tabs.length) return;
        
        const tab = this.DOM.tabs[index];
        if (tab && tab.hasAttribute('data-async-tab') && !this.is_changing) {
            const url = tab.getAttribute('href');
            if (url && !this.data.cache[url]) {
                this.loadAsync(index, url);
                return;
            }
        }

        this.data.next = index;
        this.change();
    }

    change() {
        if (this.is_changing) return;
        this.is_changing = true;

        const nextPane = this.DOM.panes[this.data.next];

        // Vizuální a ARIA update stavů
        this.DOM.tabs.forEach((t, i) => {
            const isActive = i === this.data.next;
            t.toggleAttribute('data-active', isActive);
            t.setAttribute('aria-selected', isActive);
            t.setAttribute('tabindex', isActive ? '0' : '-1');
        });

        this.DOM.panes.forEach((p, i) => {
            p.toggleAttribute('data-active', i === this.data.next);
        });

        if (nextPane && this.DOM.container) {
            // this.DOM.container.style.height = `${nextPane.scrollHeight}px`;
        }

        this.data.active = this.data.next;
        this.is_changing = false;
        
        this.onTabChange();
    }

    async loadAsync(index, url) {
        if (this.data.cache[url]) {
            this.injectAsyncContent(index, this.data.cache[url]);
            this.data.next = index;
            this.change();
            return;
        }

        this.is_changing = true;
        this.DOM.widget.classList.add('--loading-async');
        
        try {
            const response = await fetch(url);
            const json = await response.json();
            
            this.data.cache[url] = json.html; 
            this.injectAsyncContent(index, json.html);
            
            this.is_changing = false;
            this.data.next = index;
            this.change();

            this.DOM.tabs[index]?.focus();
        } catch (err) {
            console.error("Async Tab Error:", err);
            this.is_changing = false;
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

    /**
     * Pomocná funkce pro bezpečné odscrollování na trigger při kliku na tab
     */
    scrollToTrigger(index) {
        const paneName = this.DOM.panes[index]?.dataset.pane;
        const trigger = this.scrollTriggers.find(t => t.paneName === paneName)?.trigger;

        if (trigger) {
            // Aktivujeme zámek pro scroll detekci
            this.is_scrolling_via_click = true;
            clearTimeout(this.scroll_timeout);

            // Výpočet pozice (přizpůsob si podle výšky fixního menu, pokud nějaké máš)
            const yOffset = 0; 
            const y = trigger.getBoundingClientRect().top + window.pageYOffset + yOffset;
            console.log('Scroll to: ', index, trigger, y)

            SCROLL.scrollTo(y);

            // Zámek uvolníme až po dojezdu animace (cca 800ms)
            this.scroll_timeout = setTimeout(() => {
                this.is_scrolling_via_click = false;
            }, 800);
        }
    }

    initEvents() {
        this.DOM.widget.addEventListener("click", e => {
            if (this.is_changing) return;

            // 1. Standardní taby
            const tab = e.target.closest('[data-tab]');
            if (tab && this.DOM.widget.contains(tab)) {
                e.preventDefault();
                const value = tab.dataset.tab;
                
                const index = (!value) 
                    ? this.DOM.tabs.indexOf(tab)
                    : this.DOM.panes.findIndex(p => p.dataset.pane === value);
                
                if (index !== -1) {
                    this.setActive(index);
                    this.scrollToTrigger(index); // <- Po kliknutí odskrolujeme na obsah
                }
                return;
            }

            // 2. Asynchronní taby
            const asyncTab = e.target.closest('[data-async-tab]');
            if (asyncTab && this.DOM.widget.contains(asyncTab)) {
                e.preventDefault();
                const index = this.DOM.tabs.indexOf(asyncTab);
                if (index !== -1) {
                    this.setActive(index);
                    this.scrollToTrigger(index); // <- Po kliknutí odskrolujeme na obsah
                }
                return;
            }

            // 3. Navigační tlačítka
            if (e.target.closest('[data-tab-prev]')) {
                const prevIndex = this.data.active > 0 ? this.data.active - 1 : this.DOM.tabs.length - 1;
                this.setActive(prevIndex);
                this.scrollToTrigger(prevIndex);
            } else if (e.target.closest('[data-tab-next]')) {
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
        
        // Vypnutí a vyčištění observeru pro scroll
        if (this.observer) {
            this.observer.disconnect();
        }
        clearTimeout(this.scroll_timeout);
    }
}

function initTabs() {
    document.querySelectorAll('[data-tabs]').forEach(el => new Tabs(el));
}