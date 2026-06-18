// Reliable & Modern Device Detection
const isMobile = window.matchMedia("(max-width: 768px)").matches || 
                 ('ontouchstart' in window) || 
                 (navigator.maxTouchPoints > 0);

const isWindow = navigator.platform.toUpperCase().indexOf('WIN') > -1;

document.addEventListener('click', (e) => {
    const link = e.target.closest('a');
    
    // Ignoruj, pokud to není validní interní odkaz
    if (!link || link.target === '_blank' || link.dataset.asyncTab || link.dataset.tab || link.dataset.tabPrev) return;

    const url = new URL(link.href, window.location.origin);
    const isInternal = url.hostname === window.location.hostname;
    const isSpecialClick = e.metaKey || e.ctrlKey || e.shiftKey || e.which === 2; // Middle click

    if (isInternal && !isSpecialClick) {
        // Pokud je URL stejná jako aktuální (anchor link), neřeš animaci
        if (url.pathname === window.location.pathname && url.hash !== '') return;
        
        e.preventDefault();
        
        document.documentElement.setAttribute('data-transition-out', 'true');

        setTimeout(() => {
            window.location.href = link.href;
        }, 600);
    }
});

window.addEventListener('pageshow', (event) => {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === 'back_forward') {
        // Okamžitě odstraníme loading stav, aby web nebyl "zamrzlý"
        document.documentElement.removeAttribute('data-loading');
        document.documentElement.removeAttribute('data-transition-out');
    }
});

// 1. Definuj init jako běžnou (async) funkci
const init = async () => {
    console.log('Init components: ');

    const components = [
        initScroll, 
        initReveals,
        initAside, 
        initTabs, 
        initCollapsibles, 
        initCarousels
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
//@prepros-prepend ../../components/organisms/Loader/index.js
//@prepros-prepend ../../components/organisms/Aside/index.js
//@prepros-prepend ../../components/organisms/Carousel/index.js