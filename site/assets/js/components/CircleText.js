class CircleText {

  constructor() {
    this.DOM = {el: document.querySelectorAll('[data-circle-text]')};

    this.DOM.el.forEach(function(el) {
        var value = el.textContent.split('')
        el.textContent = ''
        value.forEach(function(l) {
            if(l == ' ') l = '&nbsp;'
            $(el).append('<span class="radial-char"><span>' + l + '</span></span>')
        })
    })

    // init/bind events
    this.initEvents();
  }

  initEvents() {
     this.DOM.el.forEach(function(el) {
        el.style.visibility = 'visible'
     })
  }
  
}

new CircleText()