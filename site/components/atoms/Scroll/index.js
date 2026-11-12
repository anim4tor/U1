class Scroll {
    constructor(container) {
        this.engine = null;
        this.container = container;
        this.init();
    }

    init() {
        console.log(' ... init Smooth scrolling')
        
        // Lenis initialization
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

        // Event listener for onScroll
        this.engine.on('scroll', (e) => this.onScroll(e));

        // RAF loop for smooth scroll
        const raf = (time) => {
            this.engine.raf(time);
            requestAnimationFrame(raf);
        };
        requestAnimationFrame(raf);
    }

    destroy() {
        if (this.engine) {
            this.engine.destroy();
            this.engine = null;
        }
    }

    stop() {
        if (this.engine) this.engine.stop();
    }

    start() {
        if (this.engine) this.engine.start();
    }

    resize() {
        if (this.engine) this.engine.dimensions.resize();
    }

    onScroll(e) {
        const header = document.querySelector('[data-header]');
        const fab = document.querySelector('[fab]');
        
        if (!header) return;

        if (e.direction === 1) {
            document.documentElement.setAttribute('data-scroll-direction', 'down');
        } else if (e.direction === -1) {
            document.documentElement.setAttribute('data-scroll-direction', 'up');
        }

        const top = typeof e.scroll === 'number' ? e.scroll : (window.scrollY || 0);
        if (top > 60) {
            header.setAttribute('collapsed', 'true');
            if (fab) fab.setAttribute('collapsed', 'true');
            document.documentElement.setAttribute('header-collapsed', 'true');
        } else {
            header.removeAttribute('collapsed');
            if (fab) fab.removeAttribute('collapsed');
            document.documentElement.removeAttribute('header-collapsed');
        }
    }

    scrollTo(target, options = {}) {
        if (this.engine) this.engine.scrollTo(target, options);
    }
}

// Initialization
var SCROLL;
function initScroll() {
    window.SCROLL = new Scroll(document.querySelector('[data-scroll-container]'));
    SCROLL = window.SCROLL; // Keeps your local variable working too
}