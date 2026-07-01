/*

  CONTACT WIDGET
  
*/

class Contact {
    constructor(el) {
        if (!el) return;

        console.log(' ... init Contact widget')
        
        this.DOM = {
            html: document.documentElement,
            dialog: el.querySelector('[data-contact]'),
            widget: el.querySelector('[data-contact-widget]'),
            triggers: document.querySelectorAll('[data-contact-toggle]'),
            closeBtns: el.querySelectorAll('[data-contact-close]'),
            tabsWidget: el.querySelector('[data-tabs]')
        };

        this.state = { 
            isOpen: false,
            isScrollPop: false 
        };
        
        this.tabs = null; 
        this.scrollObserver = null; 

        this.handleDocumentClick = this.handleDocumentClick.bind(this);
        this.handleKeyDown = this.handleKeyDown.bind(this);
        
        this.init();
    }

    init() {
        if (this.DOM.tabsWidget && typeof Tabs === 'function') {
            this.tabs = new Tabs(this.DOM.tabsWidget);
        }

        // 1. Click Triggers
        this.DOM.triggers.forEach(btn => btn.addEventListener('click', (e) => {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            const targetTab = btn.getAttribute('data-contact-toggle');
            
            if (this.state.isOpen) {
                // Upgrade from passive pop to a focused modal state if a direct trigger is fired
                if (this.state.isScrollPop) {
                    this.upgradeToFullOpen(targetTab);
                } else if (targetTab && targetTab !== "true" && this.tabs) {
                    const index = this.tabs.getTabIndexByPaneValue(targetTab);
                    if (index !== -1) this.tabs.setActive(index);
                } else {
                    this.close();
                }
            } else {
                this.open(targetTab, false);
            }
        }));
        
        this.DOM.closeBtns.forEach(btn => btn.addEventListener('click', () => this.close()));

        this.initScrollTriggers();
    }

    initScrollTriggers() {
        const scrollElements = document.querySelectorAll('[data-contact-scroll-toggle]');
        if (scrollElements.length === 0) return;

        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.2
        };

        this.scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !this.state.isOpen) {
                    const targetTab = entry.target.getAttribute('data-contact-scroll-toggle');
                    
                    this.open(targetTab === "true" ? null : targetTab, true);
                    this.scrollObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        scrollElements.forEach(el => this.scrollObserver.observe(el));
    }

    open(targetTab, isScrollPop = false) {
        if (this.state.isOpen) return;
        this.state.isOpen = true;
        this.state.isScrollPop = isScrollPop;

        if (isScrollPop) {
            // Set contact-open="pop" to allow background interaction
            this.DOM.html.setAttribute('contact-open', 'pop');
        } else {
            // Set contact-open="true" and completely freeze layout scrolling
            this.DOM.html.setAttribute('contact-open', 'true');
            this.DOM.html.style.overflow = 'hidden'; 
        }

        this.DOM.dialog.setAttribute('aria-hidden', 'false');

        if (this.tabs && targetTab) {
            const index = this.tabs.getTabIndexByPaneValue(targetTab);
            if (index !== -1) {
                this.tabs.setActive(index);
            }
        }

        if (this.tabs && this.tabs.is_fluid) {
            const activeTab = this.tabs.DOM.tabs[this.tabs.data.active];
            const activePaneValue = activeTab ? (activeTab.dataset.tab || activeTab.dataset.asyncTab) : null;
            const currentPane = this.tabs.DOM.panes.find(p => p.dataset.pane === activePaneValue);
            if (currentPane) {
                setTimeout(() => this.tabs.updateFluidBounds(currentPane), 0);
            }
        }

        document.addEventListener('click', this.handleDocumentClick);
        document.addEventListener('keydown', this.handleKeyDown);
    }

    upgradeToFullOpen(targetTab) {
        this.state.isScrollPop = false;
        this.DOM.html.setAttribute('contact-open', 'true');
        this.DOM.html.style.overflow = 'hidden';

        if (this.tabs && targetTab && targetTab !== "true") {
            const index = this.tabs.getTabIndexByPaneValue(targetTab);
            if (index !== -1) this.tabs.setActive(index);
        }
    }

    close() {
        if (!this.state.isOpen) return;
        this.state.isOpen = false;
        this.state.isScrollPop = false;

        this.DOM.html.removeAttribute('contact-open');
        this.DOM.html.style.overflow = ''; 
        
        this.DOM.dialog.setAttribute('aria-hidden', 'true');

        document.removeEventListener('click', this.handleDocumentClick);
        document.removeEventListener('keydown', this.handleKeyDown);
    }

    handleKeyDown(e) {
        if (e.key === 'Escape') this.close();
    }

    handleDocumentClick(e) {
        if (this.DOM.widget && !this.DOM.widget.contains(e.target) && !e.target.closest('[data-contact-toggle]')) {
            this.close();
        }
    }

    destroy() {
        if (this.tabs) this.tabs.destroy();
        if (this.scrollObserver) this.scrollObserver.disconnect();
        document.removeEventListener('click', this.handleDocumentClick);
        document.removeEventListener('keydown', this.handleKeyDown);
    }
}

function initContact() {
    document.querySelector('[data-contact]') ? 
        new Contact(document.documentElement) 
    : null
}
