
/*

    COLLAPSIBLE

*/

function initCollapsibles() {
    var collapsibles = document.querySelectorAll('collapsible-item');
    if(collapsibles) {
        console.log('Init Collapsible controls ...')
        collapsibles.forEach(el => {
            el.querySelectorAll('[data-collapsible-trigger').forEach(trigger => {
                trigger.addEventListener('click', e => { 
                    // collapsibles.forEach(c => {
                    //     c.removeAttribute('open')
                    // })
                    SCROLL.resize()
                    el.toggleAttribute('open')
                })
            })
        })
        
    }
}