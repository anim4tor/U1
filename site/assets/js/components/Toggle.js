
/*

    TOGGLE

*/

function initToggles() {
    console.log('Init Toggle controls ...')
    document.querySelectorAll('[data-toggle]').forEach(el => {
        el.addEventListener('click',function(e) {
            e.preventDefault()
            el.classList.toggle('--active')
            el.nextElementSibling.classList.toggle('--active')
        })
      
    })
}

function initFAQ() {
    console.log('Init F&Q controls ...')

    var faq = document.querySelectorAll('[data-question]');
    if(faq) {

        faq.forEach(el => {
          el.style.setProperty('--height', el.getBoundingClientRect().height + 'px' )
          el.setAttribute('closed','')
          el.addEventListener('click', e => { el.toggleAttribute('closed')})
        })
        
    }
}


