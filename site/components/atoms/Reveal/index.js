class Reveal {
    constructor(selector = '[data-scroll]') {
        this.selector = selector;
        this.progressElements = [];
        this.observer = null;
    	this.preCalculate()
        this.init();
    }

    init() {
        this.observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const el = entry.target;
                const shouldRepeat = el.hasAttribute('data-scroll-repeat');
                const isProgress = el.hasAttribute('data-scroll-progress');
                const hasText = el.matches('[data-reveal-text]') || el.querySelector('[data-reveal-text]');

                if (entry.isIntersecting) {

                    if (hasText && !el.classList.contains('is-split')) {
                        this._splitText(el);
                    } else {
                        el.classList.add('is-inview');
                    }

                    if (isProgress && !this.progressElements.includes(el)) {
                        this.progressElements.push(el);
                        this._calculateElementProgress(el);
                    }

                    if (!shouldRepeat && !isProgress && !hasText) {
                        this.observer.unobserve(el);
                    }
                } else {
				    // Pokud prvek NENÍ nastaven jako "repeat", revertujeme text při odchodu
				    if (!shouldRepeat) {
				        if (hasText) {
				            this._revertText(el);
				        }
				        // Poznámka: is-inview NEMAŽEME, protože jsi chtěl, aby tam zůstala
				    } else {
				        // Pokud má data-scroll-repeat, uklidíme úplně všechno včetně is-inview
				        el.classList.remove('is-inview');
				        // if (hasText) {
				        //     this._revertText(el);
				        // }
				    }
				    
				    // Progress čistíme vždy
				    if (isProgress) {
				        this.progressElements = this.progressElements.filter(item => item !== el);
				    }
				}
            });
        }, { rootMargin: '99% 0% 0% 0%', threshold: [0,1] });

        window.addEventListener('scroll', () => {
            if (this.progressElements.length > 0) {
                window.requestAnimationFrame(() => this._updateProgress());
            }
        }, { passive: true });
    }

    preCalculate() {
	    document.querySelectorAll(this.selector).forEach(el => {
	        // 1. Logika pro Progress (stávající)
	        if (el.hasAttribute('data-scroll-progress')) {
	            this._calculateElementProgress(el);
	        }

	        // 2. Logika POUZE pro obrázky s reveal animací
	        const imageTargets = el.matches('[data-reveal-image]') 
	            ? [el, ...el.querySelectorAll('[data-reveal-image]')] 
	            : el.querySelectorAll('[data-reveal-image]');

	        if (imageTargets.length > 0) {
	            imageTargets.forEach(img => {
	                const rect = img.getBoundingClientRect();
	                const isVisible = rect.top < window.innerHeight && rect.bottom > 0;

	                if (isVisible) {
	                    // Je ve viewportu při načtení -> rovnou inview, bez animace
	                    img.classList.add('is-inview');
	                } else {
	                    // Není vidět -> přidáme třídu pro aktivaci animace při scrollu
	                    img.classList.add('is-animated');
	                }
	            });
	        }
	    });
	}

    enable() {
    	document.documentElement.classList.add('reveal-enabled');
        this.refresh();
    }

    _splitText(parentEl) {
        const targets = parentEl.matches('[data-reveal-text]') 
            ? [parentEl, ...parentEl.querySelectorAll('[data-reveal-text]')] 
            : parentEl.querySelectorAll('[data-reveal-text]');

        targets.forEach(target => {
            if (!target.dataset.originalText) target.dataset.originalText = target.innerHTML;
            
            const splitType = target.getAttribute('data-reveal-text') || 'chars';
            Splitting({ target: target, by: splitType });
            
            target.querySelectorAll('[data-reveal-text]:not(.chars) [data-word]').forEach(item => {
                item.innerHTML = `<span class="inner-wrap">${item.textContent}</span>`;
            });
            target.classList.add('is-split');
        });

        requestAnimationFrame(() => {
            parentEl.classList.add('is-inview');
        });
    }

    _revertText(parentEl) {
	    // Najdi všechny prvky k revertování (včetně parenta samotného)
	    const targets = parentEl.matches('[data-reveal-text]') 
	        ? [parentEl, ...parentEl.querySelectorAll('[data-reveal-text]')] 
	        : Array.from(parentEl.querySelectorAll('[data-reveal-text]'));

	    targets.forEach(target => {

	    	if (target.hasAttribute('data-split-ignore')) {
	            return;
	        }

	        // Vrať původní obsah
	        if (target.dataset.originalText) {
	            target.innerHTML = target.dataset.originalText;
	        }
	        
	        // Odstraň třídu split, aby CSS animace přestaly běžet
	        target.classList.remove('is-split');
	    });

	    // parentEl.classList.remove('is-split');
	}

    // --- Progress Engine ---

    _calculateElementProgress(el) {
        const rect = el.getBoundingClientRect();
        const progress = Math.max(0, Math.min(1, (window.innerHeight - rect.top) / (window.innerHeight + rect.height)));
        el.style.setProperty('--progress', progress.toFixed(3));
    }

    _updateProgress() {
        this.progressElements.forEach(el => this._calculateElementProgress(el));
    }

    refresh() {
        document.querySelectorAll(this.selector).forEach(el => this.observer.observe(el));
    }
}

var REVEAL;
function initReveals() {
	console.log(' ... init Reveal animations')
	REVEAL = new Reveal();

	// document.querySelectorAll('[data-reveal-text],.button').forEach(el => {
	//   var split = Splitting({ target: el, by: el.getAttribute('data-reveal-text') });
	// })
	// document.querySelectorAll('[data-reveal-text]:not(.chars) [data-word]').forEach(word => {
	//     word.innerHTML = `<span>${word.textContent}</span>`;
	// });
}

