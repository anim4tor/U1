

function setHeader(color,bgcolor) {
  console.log('Header bg: ' + bgcolor + ', col: ' + color)
  document.body.style.setProperty('--header-col', color);
  document.body.style.setProperty('--header-bg', bgcolor);
}

function rgbToHex(rgb) {
  var regExp = /\(([^)]+)\)/;
  var rgb = regExp.exec(rgb);

  //matches[1] contains the value between the parentheses
  // console.log(rgb[1]);
  let [r, g, b]  = rgb[1].split(',')
  // console.log(r,g,b)
  return "#" + (1 << 24 | r << 16 | g << 8 | b).toString(16).slice(1);
  return rgb
}

function initHeader() {

  console.log('Init Header scroll ...')
  window.addEventListener("header", scrollHeader);
  const headerRatio = document.querySelector('[data-header]').getBoundingClientRect().height/window.innerHeight*100

  document.querySelectorAll('section').forEach(el => {
    el.setAttribute('data-scroll', '')
    el.setAttribute('data-scroll-repeat', '')
    el.setAttribute('data-scroll-ignore-fold', '')
    el.setAttribute('data-scroll-position','enter')
    el.setAttribute('data-scroll-offset', 100 - headerRatio + '%, '+ headerRatio +'%')
    el.setAttribute('data-scroll-call','header')
  })

  document.querySelectorAll('[data-section]').forEach(el => {
    el.setAttribute('data-scroll', '')
    el.setAttribute('data-scroll-progress', '')
  })
  // var config = {
  //   rootMargin: '100% 0% -93% 0%',
  //   // threshold: [0,1]
  // }

  // var sections = document.querySelectorAll('[data-section],[data-scroll-section]');
  // var headerObserver = new IntersectionObserver(function (entries, self) {

  //     entries.forEach(function (entry) {
  //       if (entry.isIntersecting) {
  //         // console.log(entry.intersectionRatio)
  //         var color = getComputedStyle(entry.target).color
  //         var bgcolor = getComputedStyle(entry.target).backgroundColor
  //         setHeader(color,bgcolor);
  //       }
  //     });

  // }, config);

  // sections.forEach((el) => {
  //   headerObserver.observe(el);
  // });
}



function scrollHeader(e) {
  const { target, way, from } = e.detail;
  if (way === "enter") {
    const regex = /(?<=\().*?(?=\))/;
    var color = regex.exec(getComputedStyle(target).color)[0]
    var bgcolor = regex.exec(getComputedStyle(target).backgroundColor)[0]
    setHeader(color,bgcolor);
    // document.querySelectorAll('[data-header],[data-aside],[data-cursor-text]').forEach(h => { h.style.setProperty('--col', getStyle(e.detail.target, "color").match(/\d+/g).toString())});
    // document.querySelectorAll('[data-header],[data-aside],[data-cursor-text]').forEach(h => { h.style.setProperty('--bg', getStyle(e.detail.target, "background-color").match(/\d+/g).toString())});
  } else {
    //
  }
}

/*

  NAVBAR WIDGET
  
*/

class Navbar {
    constructor(el) {
        if (!el) return;

        console.log(' ... init Navbar widget')
        
        this.DOM = {
            html: document.documentElement,
            navbar: el,
            widget: el.querySelector('[navbar-widget]'),
            triggers: document.querySelectorAll('[navbar-toggle]'),
            closeBtns: el.querySelectorAll('[navbar-close]')
        };

        this.state = { isOpen: false };

        this.handleDocumentClick = this.handleDocumentClick.bind(this);
        this.handleKeyDown = this.handleKeyDown.bind(this);
        
        this.init();
    }

    init() {
        this.DOM.triggers.forEach(btn => btn.addEventListener('click', (e) => this.toggle(e)));
        this.DOM.closeBtns.forEach(btn => btn.addEventListener('click', () => this.close()));
    }

    toggle(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        this.state.isOpen ? this.close() : this.open();
    }

    open() {
        if (this.state.isOpen) return;
        this.state.isOpen = true;

        this.DOM.html.style.overflow = 'hidden'; // Body scroll lock
        this.DOM.html.setAttribute('navbar-open', 'true');
        this.DOM.navbar.setAttribute('aria-hidden', 'false');

        document.addEventListener('click', this.handleDocumentClick);
        document.addEventListener('keydown', this.handleKeyDown);
    }

    close() {
        if (!this.state.isOpen) return;
        this.state.isOpen = false;

        this.DOM.html.style.overflow = ''; 
        this.DOM.html.removeAttribute('navbar-open');
        this.DOM.navbar.setAttribute('aria-hidden', 'true');

        document.removeEventListener('click', this.handleDocumentClick);
        document.removeEventListener('keydown', this.handleKeyDown);
    }

    handleKeyDown(e) {
        if (e.key === 'Escape') this.close();
    }

    handleDocumentClick(e) {
        // Close if click is outside the widget
        if (this.DOM.widget && !this.DOM.widget.contains(e.target) && !e.target.closest('[data-aside-toggle]')) {
            this.close();
        }
    }
}

function initNavbar() {
    document.querySelector('[navbar]') ? 
        new Navbar(document.querySelector('[navbar]')) 
    : null
}
