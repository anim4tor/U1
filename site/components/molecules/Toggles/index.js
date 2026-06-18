class Toggles {
    constructor(el) {
        if (!el) return;

        console.log('... init Toggles controls');

        this.DOM = {
            widget: el,
            hovers: Array.from(el.querySelectorAll('[data-hover-toggle]')),
            toggles: Array.from(el.querySelectorAll('[data-toggle]')),
            targets: Array.from(el.querySelectorAll('[data-target]')),
        };

        this.zIndexCounter = 10;
        this.activationTimeouts = new Map();
        this.closingTimeouts = new Map();
        this.fallbackTimeouts = new Map();

        this.config = {
            hoverDelay: 0,       
            fallbackDuration: 1000  
        };

        this.init();
    }

    init() {
        this.initEvents();
    }

    initEvents() {
        // 1. Logika pro KLIKACÍ elementy (Toggles)
        this.DOM.toggles.forEach(toggleBtn => {
            toggleBtn.addEventListener('click', (e) => {
                e.preventDefault();
                
                const targetId = toggleBtn.getAttribute('data-toggle');
                const activeTarget = this.DOM.targets.find(target => target.getAttribute('data-target') === targetId);
                if (!activeTarget) return;

                if (toggleBtn.classList.contains('is-active')) {
                    toggleBtn.classList.remove('is-active');
                    this.closeTarget(activeTarget);
                } else {
                    toggleBtn.classList.add('is-active');
                    this.openTarget(activeTarget);
                }
            });
        });

        // 2. Logika pro HOVEROVACÍ elementy (Hovers)
        this.DOM.hovers.forEach(hoverEl => {
            const targetId = hoverEl.getAttribute('data-hover-toggle');
            const activeTarget = this.DOM.targets.find(target => target.getAttribute('data-target') === targetId);
            if (!activeTarget) return;

            // AKTIVACE (Najetí myši)
            hoverEl.addEventListener('mouseenter', () => {
                // Pokud zrovna běžel odpočet pro zavření TOHOTO prvku, stopneme ho a vrátíme do hry
                if (this.closingTimeouts.has(hoverEl)) {
                    clearTimeout(this.closingTimeouts.get(hoverEl));
                    this.closingTimeouts.delete(hoverEl);
                    
                    hoverEl.classList.add('is-active'); 

                    if (activeTarget) {
                        this.clearFallback(activeTarget);
                        activeTarget.classList.remove('is-closing');
                        activeTarget.classList.add('is-opening');

                        const onOpenEnd = (e) => {
                            if (e.target !== activeTarget) return;
                            this.finalizeOpen(activeTarget, onOpenEnd);
                        };
                        activeTarget.addEventListener('transitionend', onOpenEnd);

                        const fallbackId = setTimeout(() => this.finalizeOpen(activeTarget, onOpenEnd), this.config.fallbackDuration);
                        this.fallbackTimeouts.set(activeTarget, fallbackId);
                    }
                    return; 
                }

                // ÚPRAVA ZDE: Pokud přejíždíme z jiného prvku, odložíme jeho zavření o hoverDelay
                this.DOM.hovers.forEach(otherHover => {
                    if (otherHover !== hoverEl && otherHover.classList.contains('is-active')) {
                        
                        const otherTargetId = otherHover.getAttribute('data-hover-toggle');
                        const otherTarget = this.DOM.targets.find(t => t.getAttribute('data-target') === otherTargetId);
                        
                        if (otherTarget && (otherTarget.classList.contains('is-active') || otherTarget.classList.contains('is-opening'))) {
                            // Zhasneme předchozí tlačítko až s targetem
                            const delayCloseId = setTimeout(() => {
                                otherHover.classList.remove('is-active');
                                this.closeTarget(otherTarget);
                                this.closingTimeouts.delete(otherHover);
                            }, this.config.hoverDelay);

                            this.closingTimeouts.set(otherHover, delayCloseId);
                        } else {
                            otherHover.classList.remove('is-active');
                        }
                    }
                });

                // Rozsvítíme nové tlačítko HNED
                hoverEl.classList.add('is-active');

                // Naplánujeme otevření nového targetu po ustálení myši
                const activationId = setTimeout(() => {
                    this.openTarget(activeTarget);
                    this.activationTimeouts.delete(hoverEl);
                }, this.config.hoverDelay);

                this.activationTimeouts.set(hoverEl, activationId);
            });

            // DEAKTIVACE (Odjetí myši)
            hoverEl.addEventListener('mouseleave', (e) => {
                if (this.activationTimeouts.has(hoverEl)) {
                    clearTimeout(this.activationTimeouts.get(hoverEl));
                    this.activationTimeouts.delete(hoverEl);
                    hoverEl.classList.remove('is-active');
                    return;
                }

                const nextElement = e.relatedTarget;
                const isMovingToAnotherHover = nextElement && this.DOM.hovers.some(hover => hover.contains(nextElement));

                if (!isMovingToAnotherHover) {
                    // Myš odešla úplně mimo menu – zachováme aktivní
                    return;
                }

                // Standardní odjezd na jiný hover prvek (ošetřeno přes timeout)
                if (activeTarget.classList.contains('is-active') || activeTarget.classList.contains('is-opening')) {
                    // Pokud už pro toto tlačítko neběží jiný zavírací timeout (např. z mouseenter)
                    if (!this.closingTimeouts.has(hoverEl)) {
                        const closingTimeoutId = setTimeout(() => {
                            hoverEl.classList.remove('is-active');
                            this.closeTarget(activeTarget);
                            this.closingTimeouts.delete(hoverEl);
                        }, this.config.hoverDelay);

                        this.closingTimeouts.set(hoverEl, closingTimeoutId);
                    }
                }
            });
        });
    }

    finalizeOpen(targetEl, listenerToRemove) {
        if (targetEl.classList.contains('is-opening')) {
            targetEl.classList.add('is-active');
            targetEl.classList.remove('is-opening');
        }
        targetEl.removeEventListener('transitionend', listenerToRemove);
        this.clearFallback(targetEl);
    }

    finalizeClose(targetEl, listenerToRemove) {
        if (targetEl.classList.contains('is-closing')) {
            targetEl.classList.remove('is-closing', 'is-active');
            targetEl.style.zIndex = '';
        }
        targetEl.removeEventListener('transitionend', listenerToRemove);
        this.clearFallback(targetEl);
    }

    clearFallback(targetEl) {
        if (this.fallbackTimeouts.has(targetEl)) {
            clearTimeout(this.fallbackTimeouts.get(targetEl));
            this.fallbackTimeouts.delete(targetEl);
        }
    }

    openTarget(targetEl) {
        if (targetEl.classList.contains('is-active') || targetEl.classList.contains('is-opening')) return;

        this.clearFallback(targetEl);

        this.zIndexCounter++;
        targetEl.style.zIndex = this.zIndexCounter;

        targetEl.classList.remove('is-closing');
        targetEl.classList.add('is-opening');

        const onOpenEnd = (e) => {
            if (e.target !== targetEl) return;
            this.finalizeOpen(targetEl, onOpenEnd);
        };
        targetEl.addEventListener('transitionend', onOpenEnd);

        const fallbackId = setTimeout(() => this.finalizeOpen(targetEl, onOpenEnd), this.config.fallbackDuration);
        this.fallbackTimeouts.set(targetEl, fallbackId);
    }

    closeTarget(targetEl) {
        if (targetEl.classList.contains('is-closing') || 
           (!targetEl.classList.contains('is-active') && !targetEl.classList.contains('is-opening'))) return;

        this.clearFallback(targetEl);

        targetEl.classList.remove('is-active', 'is-opening');
        targetEl.classList.add('is-closing');

        const onCloseEnd = (e) => {
            if (e.target !== targetEl) return;
            this.finalizeClose(targetEl, onCloseEnd);
        };
        targetEl.addEventListener('transitionend', onCloseEnd);

        const fallbackId = setTimeout(() => this.finalizeClose(targetEl, onCloseEnd), this.config.fallbackDuration);
        this.fallbackTimeouts.set(targetEl, fallbackId);
    }
}

// Inicializace
function initToggles() {
    document.querySelectorAll('[data-toggles]').forEach(el => new Toggles(el));
}
