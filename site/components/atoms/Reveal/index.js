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
                const isProgress = el.hasAttribute('data-scroll-progress') || el.hasAttribute('data-start') || el.hasAttribute('data-end');
                const hasText = el.matches('[data-reveal-text]') || el.querySelector('[data-reveal-text]');

                if (entry.isIntersecting) {

                    if (hasText && !el.classList.contains('is-split')) {
                        this._splitText(el);
                    } else if (!isProgress) {
                        // Klasické elementy bez progressu/rozsahu aktivujeme ihned
                        el.classList.add('is-inview');
                    }

                    // Pokud je to progress element nebo má nastavený custom rozsah
                    if (isProgress && !this.progressElements.includes(el)) {
                        this._cacheSingleElementDimensions(el);
                        this.progressElements.push(el);
                        this._calculateElementProgress(el);
                    }

                    // Pokud prvek nemá repeat, progress ani text, přestaneme ho úplně sledovat
                    if (!shouldRepeat && !isProgress && !hasText) {
                        this.observer.unobserve(el);
                    }
                } else {
                    if (!shouldRepeat) {
                        if (hasText) {
                            this._revertText(el);
                        }
                    } else {
                        // Klasické prvky bez progressu zhasínáme tady
                        if (!isProgress) {
                            el.classList.remove('is-inview');
                        }
                    }
                    
                    if (isProgress) {
                        // Při odchodu mimo viewport (včetně marginu) vyčistíme progress loop
                        this.progressElements = this.progressElements.filter(item => item !== el);
                        
                        // Pokud má zapnutý repeat, odebereme třídu i progress elementům
                        if (shouldRepeat || el.hasAttribute('data-start') || el.hasAttribute('data-end')) {
                            el.classList.remove('is-inview');
                        }
                    }
                }
            });
        }, { rootMargin: '99% 0% 0% 0%', threshold: [0, 1] });

        // Scroll listener ošetřený přes passive validation
        window.addEventListener('scroll', () => {
            if (this.progressElements.length > 0) {
                window.requestAnimationFrame(() => this._updateProgress());
            }
        }, { passive: true });
    }

    preCalculate() {
        document.querySelectorAll(this.selector).forEach(el => {
            const isProgress = el.hasAttribute('data-scroll-progress') || el.hasAttribute('data-start') || el.hasAttribute('data-end');
            
            if (isProgress) {
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
            const isProgress = parentEl.hasAttribute('data-scroll-progress') || parentEl.hasAttribute('data-start') || parentEl.hasAttribute('data-end');
            if (!isProgress) {
                parentEl.classList.add('is-inview');
            }
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

    _cacheSingleElementDimensions(el) {
        const rect = el.getBoundingClientRect();
        const scrollTop = window.scrollY || window.pageYOffset;
        
        el._absoluteTop = rect.top + scrollTop;
        el._cachedHeight = rect.height;
    }

    _cacheProgressElementsDimensions() {
        document.querySelectorAll(this.selector).forEach(el => {
            const isProgress = el.hasAttribute('data-scroll-progress') || el.hasAttribute('data-start') || el.hasAttribute('data-end');
            if (isProgress) {
                this._cacheSingleElementDimensions(el);
            }
        });
    }

    _calculateElementProgress(el) {
        if (el._absoluteTop === undefined) {
            this._cacheSingleElementDimensions(el);
        }

        const scrollTop = window.scrollY || window.pageYOffset;
        const windowHeight = window.innerHeight;
        const simulatedRectTop = el._absoluteTop - scrollTop;

        // Výpočet progressu (0 = spodek obrazovky, 1 = vršek obrazovky)
        const progress = Math.max(0, Math.min(1, (windowHeight - simulatedRectTop) / (windowHeight + el._cachedHeight)));
        
        el.style.setProperty('--progress', progress);

        // --- Logika pro data-start a data-end rozsahy ---
        const start = el.hasAttribute('data-start') ? parseFloat(el.getAttribute('data-start')) : 0;
        const end = el.hasAttribute('data-end') ? parseFloat(el.getAttribute('data-end')) : 1;
        const shouldRepeat = el.hasAttribute('data-scroll-repeat');

        if (progress >= start && progress <= end) {
            el.classList.add('is-inview');
        } else {
            // Třídu odebereme, pokud má zapnutý repeat, nebo pokud k ní uživatel ještě nedoscrolloval zespodu
            if (shouldRepeat || progress < start) {
                el.classList.remove('is-inview');
            }
        }
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
    console.log(' ... init Reveal animations');
    REVEAL = new Reveal();
}