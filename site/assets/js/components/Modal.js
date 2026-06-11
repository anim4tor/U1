
/*

    MODAL

*/

const modalToken = {
    mkl: 'mkl',
    vysledky: 'round',
    zapas: 'game',
    tabulky: 'table',
    tabulka: 'table',
    soutez: 'league',
    souteze: 'league',
    vcp: 'vcp',
    vcs: 'vcs'
}

class Modal {
    constructor() {

        this.DOM = {
            widget: document.querySelector('[data-modal-widget]'),
            container: document.querySelector('[data-modal-container]'),
            inner: document.querySelector('[data-modal-scroll]'),
            loader: {}
        };

        this.modal = {
            template: null,
            loader: {},
            card: {},
            data: {},
            draggable: false,
        }
        
        is_open: false
    }

    async load(url = '', data = {}) {
        // read our JSON
        // console.log(url, data)
        console.log('Fetching modal ...')

        
        // preprocess data
        var sendData = new FormData()
        sendData.append('data',JSON.stringify(data))

        // fetch
        let response = await ajax(url, sendData)

        return response
    }

    parseURL(url) {

        var urlArray = url.split('/')

        this.modal.url = {
            id: urlArray.shift()
        }

        return this.modal.url
    }

    add(event, url, data) {

        this.modal.data = this.parseURL(url)
        this.modal.template = event.target.closest('[data-modal-open]').getAttribute('data-modal-open') ? event.target.closest('[data-modal-open]').getAttribute('data-modal-open') : null
        console.log(this.modal.data)
        // show loader
        // this.modal.loader = event.target.closest('[data-loader-control]')
        // this.modal.loader.classList.add('--loading')
        

        // load modal content
        this.load('template/ajax/modal_' + this.modal.template + '.php', this.modal.data)

            // .then(response => response.text())
            .then((text) => {
                console.log(text)
                const doc = new DOMParser().parseFromString(text, 'text/html')
                var el = document.createElement("div")
                el.innerHTML = doc.querySelector('body').innerHTML
                const node = el.firstChild
                return node
            })
            .then((node) => {

                // if card open
                this.closeNext()

                // replace modal
                this.modal.card = node
                this.append(this.modal.card)

            })
            .then(() => {
                this.initEvents()

                if(this.is_open) {
                    this.openNext()
                } else {
                    this.open(this.modal.card)
                }

                // ModalScroll.resize()
            })
    }

    append(el) {
        el.setAttribute('data-modal', null);
        this.DOM.container.append(el);
        this.DOM.close = el.querySelectorAll('[data-modal-close]')

        // var scalable = document.querySelector('[data-scalable-viewport]')
        // var scrollCenter = {
        //     x: window.innerWidth/2,
        //     y: Locomotion.scroll.instance.delta.y + window.innerHeight/2
        // }
        // scalable.style.setProperty('--originX', scrollCenter.x);
        // scalable.style.setProperty('--originY', scrollCenter.y);

    }

    open(card) {

        // hide loading
        // this.modal.loader.classList.remove('--loading')
        this.modal.card.classList.add('--active')
 
        // ModalScroll.resize()
        // Locomotion.destroy()


        document.documentElement.classList.add('no-scroll');
        document.documentElement.classList.add('has-modal');
        // gsap
        // .from(target, 0.8, {
        //     xPercent: 110, 
        //     ease: Expo.easeOut,
        //     onComplete: function() {

        //         // initTabs()
                
        //         // hide loading
        //     }
        // })

        this.is_open = true

    }

    close() {

        document.documentElement.classList.remove('has-modal');
        var target = this.modal.card
        gsap
        .to(target, 1.2, {
            // xPercent: 0, 
            // ease: Expo.easeOut,
            onComplete: function() {
                target.remove()
                // requestAnimationFrame(() => {
                //     Locomotion.start();
                // });
                // Locomotion = initLocomotion(document.documentElement)
                document.documentElement.classList.remove('no-scroll');
                // document.documentElement.style.setProperty('--image-size', 2);


            }
        })
        this.is_open = false

    }

    closeNext() {

        if(this.is_open) {

            // toggle animations
            this.modal.card.classList.add('--next-out')
            this.modal.card.classList.remove('--active')

            // fake delayed call
            var target = this.modal.card

        }

    }

    openNext() {

        this.DOM.inner.scrollTop = 0
        this.modal.card.classList.add('--next-in','--active')

    }

    initEvents() {
        var _this = this

        this.DOM.close.forEach(function(el) {
            el.addEventListener("click", e => {
                // console.log(e.target)
                e.preventDefault()
                _this.close()
            });
        })

        // click outside modal content
        this.DOM.widget.addEventListener("click", e => {
            // console.log(e.target.closest('[data-modal]'))
            e.target.closest('[data-modal]') === null ? _this.close() : null
        });

        this.after()
    }


    after() {

        initForms()
        // dispatch modal event
        // var event = new CustomEvent('modalReady', { detail: { modal: this, context: this.modal.template, data: this.modal.data } });
        // window.dispatchEvent(event);
    }

}

// bind modal events
var MODAL = new Modal()

function initModals() {
    console.log('Init Modal controls ...')

    document.addEventListener('click', e => {
        e.stopPropagation()
        var el = e.target.closest('[data-modal-open]')
        // console.log(el)
        if (el !== null) {
            e.preventDefault();
            var data = el.getAttribute('data-modal-post'),
                url = typeof url !== 'undefined' ? url : el.getAttribute('href');
            MODAL.add(e, url, JSON.parse(data))  
        }
    })
}
