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
            closeBtns: el.querySelectorAll('[data-contact-close]')
        };

        this.state = { isOpen: false };

        this.handleDocumentClick = this.handleDocumentClick.bind(this);
        this.handleKeyDown = this.handleKeyDown.bind(this);
        
        this.init();
    }

    init() {
        this.DOM.triggers.forEach(btn => btn.addEventListener('click', (e) => this.toggle(e)));
        this.DOM.closeBtns.forEach(btn => btn.addEventListener('click', () => this.close()));
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

        this.DOM.html.setAttribute('booking-open', 'true');
        this.DOM.html.style.overflow = 'hidden'; // Body scroll lock
        this.DOM.dialog.setAttribute('aria-hidden', 'false');

        document.addEventListener('click', this.handleDocumentClick);
        document.addEventListener('keydown', this.handleKeyDown);
    }

    close() {
        if (!this.state.isOpen) return;
        this.state.isOpen = false;

        this.DOM.html.removeAttribute('booking-open');
        this.DOM.html.style.overflow = ''; 
        this.DOM.dialog.setAttribute('aria-hidden', 'true');

        document.removeEventListener('click', this.handleDocumentClick);
        document.removeEventListener('keydown', this.handleKeyDown);
    }

    handleKeyDown(e) {
        if (e.key === 'Escape') this.close();
    }

    handleDocumentClick(e) {
        // Close if click is outside the widget
        if (this.DOM.widget && !this.DOM.widget.contains(e.target) && !e.target.closest('[data-contact-toggle]')) {
            this.close();
        }
    }
}

function initContact() {
    document.querySelector('[data-contact]') ? 
        new Contact(document.documentElement) 
    : null
}
