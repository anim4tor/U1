/*

    COLLAPSIBLE

*/

class Collapsibles {
    constructor(el) {
        console.log(' ... init Collapsible widgets')
        this.DOM = {
            widget: el,
            items: el.querySelectorAll('collapsible'),
        };
        this.active = null;
        this.unique = el.getAttribute('data-collapsibles') ? el.getAttribute('data-collapsibles') : false
        this.init();
        // console.log(this.unique)
    }

    init() {
        this.DOM.items.forEach(el => {
            el.querySelector('[collapsible-trigger]').addEventListener('click', e => { 
                this.active = el
                this.toggle()
            })
        })
    }

    toggle() {
        this.active.toggleAttribute('open')
        this.unique ? this.closeSiblings() : null
        setTimeout(() => {
            SCROLL.resize()
        },1000)
    }

    closeSiblings() {
        this.DOM.items.forEach((el) => {
            if(el != this.active) {
                el.removeAttribute('open')
            }
        })
    }
}

function initCollapsibles() {
    var collapsibles = document.querySelectorAll('[data-collapsibles]');
    if(collapsibles) {
        collapsibles.forEach(el => {
            new Collapsibles(el)
        })
    }
}