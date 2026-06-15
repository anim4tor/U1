/*

    SCROLL

*/

// class Scroll {
//     constructor(container) {
//        	this.engine = null;
//        	this.container = container;
//         this.init();
//     }

//     init() {
//       console.log(' ... init Smooth scrolling')
//     	this.engine = new LocomotiveScroll({
//     	  lenisOptions: {
//     	    // content: this.container,
//           wrapper: document.querySelector('body'),
//           content: document.querySelector('[data-scroll-content]'),
//     	    orientation: 'vertical',
//     	    smoothWheel: true,
//     	    lerp: 0.5,
//     	    duration: 1,
//     	    normalizeWheel: true,
//     	  },
//     	  scrollCallback: this.onScroll
//     	});
//     	// console.log(this.engine)
//     }

//   	destroy() {
//   		// console.log('Destroy Smooth scroll ...')
// 	  	this.engine.destroy()
// 	  	this.engine = null;
//   		console.log(this.engine)
//   	}

//   	stop() {
//   		// console.log('Stop Smooth scroll ...')
//   		requestAnimationFrame(() => {
//   			this.engine.stop()
//   		})
//   	}

//   	start() {
//   		// console.log('Start Smooth scroll ...')
//   		requestAnimationFrame(() => {
//   			this.engine.start()
//   		})
//   	}

//   	resize() {
//   		// console.log('Update Smooth scroll ...')
//   		this.engine.resize()
//   	}

//     onScroll({ scroll, limit, velocity, direction, progress }) {
//   	    // console.log(scroll, limit, velocity, direction, progress);
//   			if (direction > 0) {
//   				if(scroll > 100) {
//   					document.querySelector('[data-header]').setAttribute('hide',true)
//   					document.querySelector('[data-header]').setAttribute('collapsed',true)
//   				}
//   			} else {
//   				document.querySelector('[data-header]').removeAttribute('hide')
//   				if(scroll < 100) {
//   					document.querySelector('[data-header]').removeAttribute('collapsed',true)
//   				}

//   			}
//   	}

//   	scrollTo(params) {
//   	    const { target, options } = params;
//   	    this.engine.scrollTo(target, options);
//   	}
// }

// document.querySelectorAll('[data-scroll-call]').forEach( el => {
//     el.setAttribute('data-back',el.getAttribute('theme'))
// })
// window.addEventListener('theme', (e) => {
//     const { target, way, from } = e.detail;
//     console.log(`target: ${target}`, `way: ${way}`, `from: ${from}`);
//     var theme = target.getAttribute('data-theme');
//     var back = target.getAttribute('data-back');
//     if (way == "enter") {
//        target.setAttribute('theme',theme);
//     } else {
//        target.setAttribute('theme',back);
//     }
// });

// var SCROLL;
// function initScroll() {
// 	SCROLL = new Scroll(document.querySelector('[data-scroll-container]'));
// }

/*
    SCROLL - LENIS NATIVE
*/

class Scroll {
    constructor(container) {
        this.engine = null;
        this.container = container;
        this.init();
    }

    init() {
        console.log(' ... init Smooth scrolling')
        
        // Lenis inicializace
        this.engine = new Lenis({
            wrapper: window,
            content: document.querySelector('[data-scroll-content]'),
            orientation: 'vertical',
            smoothWheel: true,
            smoothTouch: false,
            lerp: 0.5,
            duration: 1,
            normalizeWheel: true,
        });

        // history.scrollRestoration = 'manual'

        // Event listener pro onScroll (nahrazuje scrollCallback)
        this.engine.on('scroll', (e) => this.onScroll(e));

        // RAF smyčka pro plynulý scroll
        const raf = (time) => {
            this.engine.raf(time);
            requestAnimationFrame(raf);
        };
        requestAnimationFrame(raf);
    }

    destroy() {
        this.engine.destroy();
        this.engine = null;
    }

    stop() {
        this.engine.stop();
    }

    start() {
        this.engine.start();
    }

    resize() {
        // Lenis se většinou resizeuje sám, ale pokud potřebuješ:
        // window.dispatchEvent(new Event('resize'));
    }

    onScroll({ scroll, velocity, direction }) {
        const header = document.querySelector('[data-header]');

        direction = e.direction === 1 ? 'down' : 'up';
        document.documentElement.setAttribute('data-scroll-direction', direction);

        if (!header) return;

        // Logika pro header
        if (direction === 'down' && scroll > 100) {
            header.setAttribute('hide', 'true');
            header.setAttribute('collapsed', 'true');
        } else if (direction === 'up') {
            header.removeAttribute('hide');
            if (scroll < 100) {
                header.removeAttribute('collapsed');
            }
        }
    }

    onScroll(e) {
        // e.direction: 1 = down, -1 = up
        const direction = e.direction === 1 ? 'down' : 'up';

        // 1. Nastavení atributu na html element
        document.documentElement.setAttribute('data-scroll-direction', direction);

        // 2. Logika pro header (stávající)
        const header = document.querySelector('[data-header]');
        if (header) {
            if (direction === 'down' && e.scroll > 100) {
                header.setAttribute('hide', 'true');
                header.setAttribute('collapsed', 'true');
            } else if (direction === 'up') {
                header.removeAttribute('hide');
                if (e.scroll < 100) {
                    header.removeAttribute('collapsed');
                }
            }
        }
    }

    scrollTo(target, options = {}) {
        this.engine.scrollTo(target, options);
    }
}

// Inicializace
var SCROLL;
function initScroll() {
    SCROLL = new Scroll(document.querySelector('[data-scroll-container]'));
}