class Reveal {
    constructor(selector = '[data-scroll]') {
        this.selector = selector;
        this.progressElements = [];
        this.observer = null;
        this.preCalculate();
        this.init();
        
        // Sledujeme resize okna, abychom přepočítali cache pozic, když uživatel změní velikost prohlížeče
        window.addEventListener('resize', () => this._cacheProgressElementsDimensions());
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
                        // Před přidáním prvku si nacachujeme jeho rozměry
                        this._cacheSingleElementDimensions(el);
                        this.progressElements.push(el);
                        this._calculateElementProgress(el);
                    }

                    if (!shouldRepeat && !isProgress && !hasText) {
                        this.observer.unobserve(el);
                    }
                } else {
                    if (!shouldRepeat) {
                        if (hasText) {
                            this._revertText(el);
                        }
                    } else {
                        el.classList.remove('is-inview');
                    }
                    
                    if (isProgress) {
                        this.progressElements = this.progressElements.filter(item => item !== el);
                    }
                }
            });
        }, { rootMargin: '99% 0% 0% 0%', threshold: [0, 1] });

        // Tady je tvůj scroll listener, ošetřený přes passive validation
        window.addEventListener('scroll', () => {
            if (this.progressElements.length > 0) {
                window.requestAnimationFrame(() => this._updateProgress());
            }
        }, { passive: true });
    }

    preCalculate() {
        document.querySelectorAll(this.selector).forEach(el => {
            if (el.hasAttribute('data-scroll-progress')) {
                // Nacachujeme pozici hned na začátku
                this._cacheSingleElementDimensions(el);
                this._calculateElementProgress(el);
            }

            const imageTargets = el.matches('[data-reveal-image]') 
                ? [el, ...el.querySelectorAll('[data-reveal-image]')] 
                : el.querySelectorAll('[data-reveal-image]');

            if (imageTargets.length > 0) {
                imageTargets.forEach(img => {
                    const rect = img.getBoundingClientRect();
                    const isVisible = rect.top < window.innerHeight && rect.bottom > 0;

                    if (isVisible) {
                        img.classList.add('is-inview');
                    } else {
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
        const targets = parentEl.matches('[data-reveal-text]') 
            ? [parentEl, ...parentEl.querySelectorAll('[data-reveal-text]')] 
            : Array.from(parentEl.querySelectorAll('[data-reveal-text]'));

        targets.forEach(target => {
            if (target.hasAttribute('data-split-ignore')) {
                return;
            }

            if (target.dataset.originalText) {
                target.innerHTML = target.dataset.originalText;
            }
            target.classList.remove('is-split');
        });
    }

    // --- Progress Engine (Optimalizovaný) ---

    // Pomocná metoda pro uložení rozměrů jednoho prvku bez zatížení scrollu
    _cacheSingleElementDimensions(el) {
        const rect = el.getBoundingClientRect();
        const scrollTop = window.scrollY || window.pageYOffset;
        
        // Uložíme si absolutní top pozici vůči celému dokumentu a výšku elementu
        el._absoluteTop = rect.top + scrollTop;
        el._cachedHeight = rect.height;
    }

    // Přepočítá všechny aktivní i neaktivní progress elementy (volá se na resize okna)
    _cacheProgressElementsDimensions() {
        document.querySelectorAll(`${this.selector}[data-scroll-progress]`).forEach(el => {
            this._cacheSingleElementDimensions(el);
        });
    }

    _calculateElementProgress(el) {
        // Pokud z nějakého důvodu ještě nemá cache (bezpečnostní pojistka)
        if (el._absoluteTop === undefined) {
            this._cacheSingleElementDimensions(el);
        }

        const scrollTop = window.scrollY || window.pageYOffset;
        const windowHeight = window.innerHeight;

        // Simulujeme rect.top odečtením scrollu od absolutní pozice z cache
        const simulatedRectTop = el._absoluteTop - scrollTop;

        // Výpočet progressu s využitím nacachované výšky (el._cachedHeight)
        const progress = Math.max(0, Math.min(1, (windowHeight - simulatedRectTop) / (windowHeight + el._cachedHeight)));
        
        // Posíláme čisté číslo (odstraněno .toFixed(3)) pro dokonale hladký subpixelový posun
        el.style.setProperty('--progress', progress);
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

