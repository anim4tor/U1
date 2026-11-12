/*

  NAVBAR WIDGET
  
*/

class Navbar {
    constructor(el) {
        if (!el) return;

        console.log(' ... init Navbar widget')
        
        this.DOM = {
            html: document.documentElement,
            navbar: el,
            widget: el.querySelector('[navbar-widget]'),
            triggers: document.querySelectorAll('[navbar-toggle]'),
            closeBtns: el.querySelectorAll('[navbar-close]')
        };

        this.state = { isOpen: false };

        this.handleDocumentClick = this.handleDocumentClick.bind(this);
        this.handleKeyDown = this.handleKeyDown.bind(this);
        
        this.init();
    }

    init() {
        this.DOM.triggers.forEach(btn => btn.addEventListener('click', (e) => this.toggle(e)));
        this.DOM.closeBtns.forEach(btn => btn.addEventListener('click', () => this.close()));

        if (typeof Splitting === 'function') {
            const menuTargets = this.DOM.navbar.querySelectorAll('[navbar-menu] [data-reveal-text]');
            if (menuTargets.length) {
                Splitting({ target: menuTargets, by: 'chars' });
            }
        }
    }

    toggle(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        this.state.isOpen ? this.close() : this.open();
    }

    open() {
        if (this.state.isOpen) return;
        this.state.isOpen = true;

        this.DOM.html.style.overflow = 'hidden'; // Body scroll lock
        this.DOM.html.setAttribute('navbar-open', 'true');
        this.DOM.navbar.setAttribute('aria-hidden', 'false');

        document.addEventListener('click', this.handleDocumentClick);
        document.addEventListener('keydown', this.handleKeyDown);
    }

    close() {
        if (!this.state.isOpen) return;
        this.state.isOpen = false;

        this.DOM.html.style.overflow = ''; 
        this.DOM.html.removeAttribute('navbar-open');
        this.DOM.navbar.setAttribute('aria-hidden', 'true');

        document.removeEventListener('click', this.handleDocumentClick);
        document.removeEventListener('keydown', this.handleKeyDown);
    }

    handleKeyDown(e) {
        if (e.key === 'Escape') this.close();
    }

    handleDocumentClick(e) {
        // Close if click is outside the widget
        if (this.DOM.widget && !this.DOM.widget.contains(e.target) && !e.target.closest('[data-aside-toggle]')) {
            this.close();
        }
    }
}

function initHeaderCollapse() {
    const header = document.querySelector('[data-header]');
    const fab = document.querySelector('[fab]');
    if (!header && !fab) return;

    const checkCollapse = () => {
        const y = window.scrollY || document.documentElement.scrollTop || 0;
        if (y > 60) {
            if (header) header.setAttribute('collapsed', 'true');
            if (fab) fab.setAttribute('collapsed', 'true');
            document.documentElement.setAttribute('header-collapsed', 'true');
        } else {
            if (header) header.removeAttribute('collapsed');
            if (fab) fab.removeAttribute('collapsed');
            document.documentElement.removeAttribute('header-collapsed');
        }
    };

    window.addEventListener('scroll', checkCollapse, { passive: true });
    checkCollapse();
}

function initNavbar() {
    document.querySelector('[navbar]') ? 
        new Navbar(document.querySelector('[navbar]')) 
    : null;
    initHeaderCollapse();
}
