// Reliable & Modern Device Detection
const isMobile = window.matchMedia("(max-width: 768px)").matches || 
                 ('ontouchstart' in window) || 
                 (navigator.maxTouchPoints > 0);

const isWindow = navigator.platform.toUpperCase().indexOf('WIN') > -1;

window.addEventListener('popstate', () => {
    // 1. Apply the transition attribute
    document.documentElement.setAttribute('data-transition-out', 'true');

    // 2. We don't need to manually change window.location 
    // because popstate is triggered by the browser's own history movement.
    
    // Note: If your site has a long "loading" or "transition" time, 
    // you might want to clear the attribute after a timeout or 
    // leave it until the next page load.
});
document.addEventListener('click', (e) => {
    // FIX: If the user clicked inside a dragged component layout area, cancel transitions immediately
    if (e.target.closest('.is-dragged') || e.target.closest('[data-carousel-scroll]')?.classList.contains('is-dragged')) {
        e.preventDefault();
        e.stopImmediatePropagation();
        return;
    }

    const link = e.target.closest('a');
    
    // Ignoruj, pokud to není validní odkaz nebo má specifické odkazové datasety
    if (!link || link.target === '_blank' || link.dataset.asyncTab || link.dataset.tabPrev) return;

    const url = new URL(link.href, window.location.origin);
    const isInternal = url.hostname === window.location.hostname;
    const isSpecialClick = e.metaKey || e.ctrlKey || e.shiftKey || e.which === 2; // Middle click

    // --- STRATEGIC FIX: DETECT SAME-PAGE ANCHORS FIRST ---
    if (isInternal && (link.hasAttribute('data-scroll-to') || link.hash !== '')) {
        if (url.pathname === window.location.pathname) {
            
            // Získej čisté ID cíle (např. "#opened-positions")
            const targetSelector = link.hash || link.getAttribute('data-scroll-to') || link.getAttribute('href');
            if (targetSelector && targetSelector.startsWith('#')) {
                const targetElement = document.querySelector(targetSelector);
                console.log(targetSelector)

                if (targetElement) {
                    // STOP EVERYTHING IMMEDIATELY — No transitions allowed for local IDs
                    e.preventDefault();
                    e.stopImmediatePropagation();

                    // Aktualizujeme URL hash v adresním řádku bez reloadu
                    history.pushState(null, null, targetSelector);

                    // Bezpečné vyhledání SCROLL enginu (i kdyby se inicializoval se zpožděním)
                    const scrollInstance = window.SCROLL || (typeof SCROLL !== 'undefined' ? SCROLL : null);

                    if (scrollInstance && typeof scrollInstance.scrollTo === 'function') {
                        scrollInstance.scrollTo(targetElement, {
                            offset: 0,
                            duration: 1.2
                        });
                    } else {
                        // Fallback, pokud se Lenis ještě nestihl plně načíst do window scope
                        targetElement.scrollIntoView({ behavior: 'smooth' });
                    }

                    return; // Zastaví zbytek kódu, data-transition-out se NIKDY nespustí
                }
            }
        }
    }
    // ------------------------------------

    // --- PAGE TRANSITIONS FOR DIFFERENT PAGES ---
    if (isInternal && !isSpecialClick) {
        // Double-check: Pokud je to stejná cesta a má hash, vyskoč (ochrana)
        if (url.pathname === window.location.pathname && url.hash !== '') return;
        
        e.preventDefault();
        
        document.documentElement.setAttribute('data-transition-out', 'true');

        setTimeout(() => {
            window.location.href = link.href;
        }, 800);
    }
}, true); // "true" zachytí kliknutí dříve než jakýkoliv jiný skript na webu

window.addEventListener('pageshow', (event) => {
    // event.persisted triggers if the page was restored from the browser's bfcache (Back-Forward Cache)
    // The performance check acts as a reliable fallback for classic history steps
    const isBackForward = event.persisted || 
                          (window.performance && window.performance.getEntriesByType("navigation")[0]?.type === 'back_forward') ||
                          (window.performance && window.performance.navigation?.type === 2); // Legacy fallback

    if (isBackForward) {
        // Force-remove all attributes that hide components or show loaders
        document.documentElement.removeAttribute('data-loading');
        document.documentElement.removeAttribute('data-transition-out');
        
        // Re-apply the initial entry transition state so the elements can fade back in naturally
        document.documentElement.setAttribute('data-transition', 'true');

        // Safety check: Restart the Lenis scroll engine if it was stopped when leaving the page
        if (window.SCROLL && typeof window.SCROLL.start === 'function') {
            window.SCROLL.start();
        }

        console.log('Page restored from back/forward history. Loader cleared.');
    }
});

// 1. Definuj init jako běžnou (async) funkci
const init = async () => {
    console.log('Init components: ');

    const components = [
        initScroll, 
        initReveals,
        initNavbar, 
        initTabs, 
        initCollapsibles, 
        initCarousels,
        initContact
    ];
    
    // Spustíme komponenty (await počká na ty, které vrací Promise)
    await Promise.all(components.map(fn => typeof fn === 'function' && fn()));

    // 2. Aktivujeme Reveal engine těsně předtím, než zmizí loader
    REVEAL.enable(); 

    // 3. Sequence transition classes pro odhalení obsahu
    requestAnimationFrame(() => {
        document.documentElement.setAttribute('data-transition', 'true');
        
        setTimeout(() => {
            document.documentElement.removeAttribute('data-loading');
            console.log('App fully initialized.');
        }, 600);
    });
};

// 2. Tvůj stávající startApp zůstává téměř beze změny
const startApp = async () => {
    document.documentElement.setAttribute('data-loading', 'true');

    const PAGE = new Promise((resolve) => {
        const loader = new Loader(
            (percent) => {
                document.querySelector('[data-loader]').style.setProperty('--progress', percent);
            },
            () => {
                resolve();
            }
        );
        loader.init();
    });

    try {
        await PAGE;
    } catch (err) {
        console.warn("Preload failed, initializing anyway", err);
    }
    
    // Tady zavoláš inicializaci komponent
    await init();    
};

// Start the engine
document.addEventListener('DOMContentLoaded', async () => {
  startApp();
});

//@prepros-prepend vendor/lenis.min.js
//@prepros-prepend vendor/splitting.min.js
//@prepros-prepend vendor/gsap.min.js
//@prepros-prepend ../../components/atoms/Scroll/index.js
//@prepros-prepend ../../components/atoms/Reveal/index.js
//@prepros-prepend ../../components/molecules/Collapsible/index.js
//@prepros-prepend ../../components/molecules/Tabs/index.js
//@prepros-prepend ../../components/molecules/Dropdown/index.js
//@prepros-prepend ../../components/organisms/Loader/index.js
//@prepros-prepend ../../components/organisms/Header/index.js
//@prepros-prepend ../../components/organisms/Carousel/index.js
//@prepros-prepend ../../components/organisms/Contact/index.js

