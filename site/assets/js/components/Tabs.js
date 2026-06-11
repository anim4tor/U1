/*

    TABS

*/

class Tabs {
    constructor(el) {
        console.log('Init Tabs controls ...')
        this.DOM = {
            widget: el,
            // ( document.querySelectorAll('[data-tab]') )
            tabs: el.querySelectorAll('[data-tab]') ? el.querySelectorAll('[data-tab]') : null ,
            panes: el.querySelectorAll('[data-pane]') ? el.querySelectorAll('[data-pane]') : null ,
            sync: el.querySelectorAll('[data-pane-sync]') ? el.querySelectorAll('[data-pane-sync]') : null ,
            nav: {}
            // loader: event.target.closest('[data-loader-control]')
        };

        this.DOM.nav = {
            prev: typeof this.DOM.widget.querySelectorAll('[data-tab-prev]') !== undefined ? this.DOM.widget.querySelectorAll('[data-tab-prev]') : null,
            next: typeof this.DOM.widget.querySelectorAll('[data-tab-next]') !== undefined ? this.DOM.widget.querySelectorAll('[data-tab-next]') : null,
        }

        this.data = {
            init: 0,
            active: 0,
            next: 0
        };

        // console.log('data-tab-widget = ' + this.DOM.widget.getAttribute('data-tab-widget'))
        // this.data.init = this.DOM.widget.getAttribute('data-tabs').length > 0 ? (this.DOM.widget.getAttribute('data-tabs') - 1) : 0
        
        this.async = null,
        this.is_changing = false

        this.init()
        
    }

    init() {

        // console.log('First index: ' + this.data.init)

        this.DOM.widget.classList.add('--init')
        this.data.active = this.data.init

        // this.DOM.panes[this.data.active].setAttribute('data-active', true)
        // this.DOM.tabs[this.data.active].setAttribute('data-active', true)

        this.initEvents()

        this.change()

    }

    setActive(index) {

        // if(!this.is_changing) {
            this.data.next = index
            this.change()
        // }

    }

    next() {
        console.log('Next')
        // if(!this.is_changing) {
            this.DOM.nav.next.forEach(function(el) { el.classList.add('--loading') })
            this.data.next = this.data.active < (this.DOM.panes.length - 1) ? this.data.active + 1 : 0 
            this.change()
        // }

    }

    previous() {
        console.log('Prev')
        // if(!this.is_changing) {
            this.DOM.nav.prev.forEach(function(el) { el.classList.add('--loading') })
            this.data.next = this.data.active > 0 ? this.data.active - 1 : (this.DOM.panes.length - 1)
            this.change()
        // }

    }

    change() {

        this.is_changing = true

        // animate
        this.DOM.tabs[this.data.active] ? this.DOM.tabs[this.data.active].removeAttribute('data-active') : null
        if (this.DOM.panes.length > 0) {
            this.DOM.panes[this.data.active].removeAttribute('data-active')
            this.DOM.sync[this.data.active] ? this.DOM.sync[this.data.active].removeAttribute('data-active'): null
        }
        // this.DOM.panes[this.data.active].classList.add('is-inactive')

        // this.DOM.panes[this.data.next].classList.remove('is-inactive')
        this.DOM.tabs[this.data.next] ? this.DOM.tabs[this.data.next].setAttribute('data-active', true) : null
        if (this.DOM.panes.length > 0) {
            this.DOM.panes[this.data.next].setAttribute('data-active', true)
            this.DOM.sync[this.data.next] ? this.DOM.sync[this.data.next].setAttribute('data-active', true): null
        }


        // hide loading
        this.DOM.nav.prev.forEach(function(el) { el.classList.remove('--loading') })
        this.DOM.nav.next.forEach(function(el) { el.classList.remove('--loading') }) 

        //
        this.is_changing = false;

        // remove previous content after animation complete
        let prev = this.data.active;

        // reindex data
        this.data.active = this.data.next

        // Locomotion.update()

        //
        this.onTabChange()
    }

    handleScrollTabEvent(e) {
        const { target, way, from } = e.detail;
        // console.log(e.detail)
        if (way === "enter") {
            var parent = target.parentNode;
            var index = [].indexOf.call(parent.children, target);
            // console.log('Tab scrolled: ', index)
            this.setActive(index)
        } else {
          // target.style.backgroundColor = "";
        }
    }

    initEvents() {
        var _this = this

        this.DOM.tabs.forEach(function(el) {
                el.addEventListener("click", e => {
                    if(!el.hasAttribute('data-scroll-tab')) {
                        e.preventDefault()
                    }
                    var target = e.target.closest('[data-tab]');
                    var parent = target.parentNode;
                    var index = [].indexOf.call(parent.children, target);
                    !_this.is_changing ? _this.setActive(index) : null

                });

        })
        this.DOM.nav.prev.forEach(function(el) {
            el.addEventListener("click", e => {
                e.preventDefault()
                !_this.is_changing ? _this.previous(e) : null
            });
        })
        this.DOM.nav.next.forEach(function(el) {
            el.addEventListener("click", e => {
                e.preventDefault()
                !_this.is_changing ? _this.next(e) : null
            });
        })

        this.after()

        window.addEventListener("scrollTabEvent", e => {
            _this.handleScrollTabEvent(e);
        })

       
    
    }

    after() {

        // dispatch tabs event
        var detail = {
            tabs: this,
            context: this.DOM.widget.getAttribute('data-context') ? this.DOM.widget.getAttribute('data-context') : null,
            data: {
                league: this.DOM.widget.getAttribute('data-league') ? this.DOM.widget.getAttribute('data-league') : null,   
            }

        }
        var event = new CustomEvent('tabsReady', { detail: detail });
        window.dispatchEvent(event);

    }

    onTabChange() {

        // console.log('Change active index: ' + this.data.next)

    }
  
}

class AsyncTabs extends Tabs {
   
    change() {

        // console.log('Change active tab. Index: ' + this.data.next)

        this.is_changing = true

        // fetch content
        this.async(this.data.next)
            .then((response) => {
                // console.log(response)
                const doc = new DOMParser().parseFromString(response, 'text/html')
                var node = document.createElement("div")
                node.innerHTML = doc.querySelector('body').innerHTML

                // return node
                return node

            })
            .then( node => {

                // append next content
                this.DOM.panes[this.data.next].append(node)

            })
            .then(() => {

                // animate in next pane
                this.DOM.tabs[this.data.active].classList.remove('is-active')
                this.DOM.panes[this.data.active].classList.remove('is-active')
                this.DOM.panes[this.data.active].classList.add('is-inactive')

                this.DOM.panes[this.data.next].classList.remove('is-inactive')
                this.DOM.panes[this.data.next].classList.add('is-active')
                this.DOM.tabs[this.data.next].classList.add('is-active')

            })
            .then(() => {

                // hide loading
                this.DOM.nav.prev.forEach(function(el) { el.classList.remove('--loading') })
                this.DOM.nav.next.forEach(function(el) { el.classList.remove('--loading') }) 
                //
                this.is_changing = false

                // remove previous content after animation complete
                let prev = this.data.active;
                setTimeout(() => {
                    this.DOM.panes[prev].classList.remove('is-inactive')
                    this.DOM.panes[prev].innerHTML = ''
                },400)

                // reindex data
                this.data.active = this.data.next

                //
                this.onTabChange()


            })
    }
}


function initAsyncTabs(context) {
    var widget = context.querySelectorAll('[data-async-tabs]')

    widget ? widget.forEach(tabs => {
        tabs.querySelectorAll('[data-tab-widget]').forEach(el => {
            console.log('Init Async Tabs controls ...')
            var modalTabs = new AsyncTabs(el)
        })
    }) : null
   

}

function initTabs() {
    document.querySelectorAll('[data-tabs]').forEach(el => {
        new Tabs(el)
    })
}

