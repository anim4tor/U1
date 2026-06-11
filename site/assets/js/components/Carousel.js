function initCarousel() {
console.log('Init Carousel control ...')

document.querySelectorAll('[data-carousel-widget]').forEach(el => {
  var carousel = el
  console.log('Init carousel: ', el)
  if (!carousel) return

  var navnext = carousel.querySelector('[data-carousel-next]')
  var navprev = carousel.querySelector('[data-carousel-prev]')
  var panes = carousel.querySelector('[data-carousel-panes]')
  var items = panes.querySelectorAll('[data-carousel-item]')
  var tabs = carousel.querySelectorAll('[data-carousel-tab]')
  var sync = document.querySelectorAll('[data-carousel-sync]')
  var w = items[0].getBoundingClientRect().width
  var per = carousel.getAttribute('data-per-page') != null ? parseInt(carousel.getAttribute('data-per-page')) : 1;

  var max = (items.length + 1) * w - window.innerWidth 
  var max = (items.length - per) * w
  var active = 0

  // active == items.length - 1 ? navnext.classList.add('disabled') : navnext.classList.remove('disabled')
  // active == 0 ? navprev.classList.add('disabled') : navprev.classList.remove('disabled')

  if(navnext) navnext.addEventListener("click", e => { next(e) });
  if(navprev) navprev.addEventListener("click", e => { prev(e) });

  if(tabs) {  
    tabs.forEach(tab => {
      tab.addEventListener("click", e => { 
        e.preventDefault()
        var target = e.target.closest('[data-carousel-tab]');
        var parent = target.parentNode;
        var index = [].indexOf.call(parent.children, target);
        console.log(index)
        change(index) 
      });
    })
  }
  var scroll
  var isPressed = false
  var isChanging = false

  function next(e) {
      e.preventDefault()
      isChanging = true
      if(active < items.length) {
        active != items.length - per ? active++ : active
        change(active)
      }
  }

  function prev(e) {
    e.preventDefault()
    isChanging = true
    active > 0 ? active-- : active
    change(active)
  }

  function change(active) {
    console.log(active)
    var x = w * active * 1
    scroll = Math.min(Math.max(x, 0), max)
    gsap.to(panes, .5, {
        x: -scroll, 
        ease: Power3.easeOut,
    })
    gsap.to(sync, 1, {
        x: -scroll*0.4, 
        rotate: scroll/100,
        ease: Power3.easeOut,
    })
  
    items.forEach(el => {
      el.removeAttribute('data-active')
    })
    items[active].setAttribute('data-active', true)
  }

  carousel.addEventListener("mousedown", e => {
      isPressed = true
      e.preventDefault()
      grab(e)
      
  });
  carousel.addEventListener("mousemove", e => {
    if (!isPressed) return;
    e.preventDefault();
      panes.classList.add('is-dragged')
    drag(e)

      // e.preventDefault()
      // drag(e)
  });
  carousel.addEventListener("mouseup", e => {
      isPressed = false
    e.preventDefault();
      release(e)
      panes.classList.remove('is-dragged')

  });

  // carousel.addEventListener("touchstart", e => {
  //     isPressed = true
  //     e.preventDefault()
  //     grab(e)
      
  // });
  // carousel.addEventListener("touchmove", e => {
  //   if (!isPressed) return;
  //   e.preventDefault();
  //     panes.classList.add('is-dragged')
  //   drag(e)

  //     // e.preventDefault()
  //     // drag(e)
  // });
  // carousel.addEventListener("touchend", e => {
  //     isPressed = false
  //   e.preventDefault();
  //     release(e)
  //     panes.classList.remove('is-dragged')

  // });


  var touch = {
        start: 0,
        end: 0,
        distance: 0,
        threshold: 100
    };

  function grab(e) {
    // if (isChanging) return;
      touch.distance = 0;
      touch.start = e.clientX;
  }

  function drag(e) {
    // if (isChanging) return;
      touch.end = e.clientX;
      touch.distance = touch.end - touch.start
      carousel.style.cursor = "grab"

      // console.log(touch.distance)

      if(Math.abs(touch.distance) > 0) {
          // this.follow(e)
          touch.distance < 0 ? follow('next') : follow('prev')

      }
      // if(Math.abs(this.touch.distance) > this.touch.threshold) { 
          
      //     // change active tab
      //     this.touch.distance < 0 ? this.next() : this.previous()
      //     console.log('change')

      // }
  }

  function release(e) {
    // if (isChanging) return;
        if(Math.abs(touch.distance) / w > 1.2) {
          if (touch.distance < 0) {
            next(e)
            next(e)
      // console.log('Change: ', active)
          } else {
            prev(e)
            prev(e)
      // console.log('Change: ', active)
          }
          
        } else if(Math.abs(touch.distance) > 100) {
          touch.distance < 0 ? next(e) : prev(e)
          // console.log('Change: ', active)
        } else {

        }
        // console.log(Math.abs(touch.distance), w, Math.abs(touch.distance) / w)
  }

  function follow(dir) {
      // console.log(dir)
      // if (!this.is_changing) {

          if (dir == 'next') {
              // this.to = this.data.active < (this.DOM.panes.length - 1) ? this.data.active + 1 : null 
              gsap.to(panes, 
            
              {
                  x: - scroll - Math.abs(touch.distance),
                  duration: 0,
                  ease: 'none'
              });

          } else {
              // this.to = this.data.active > 0 ? this.data.active - 1 : null
              gsap.to(panes, 
             
              {

                  x: - scroll + Math.abs(touch.distance),
                  duration: 0, 
                  ease: 'none'
              });
          }
          // console.log(this.touch.distance)
      // }
  }

  change(active)

})

// function retreat(dir) {
//     var _this = this

//     gsap.to(this.DOM.panes[this.data.active], .5, {
//         x: 0, 
//         scale: 1,
//         opacity: 1,
//         ease: Expo.easeOut,
//         onComplete() {
//           gsap.set(_this.DOM.panes[_this.data.active], { clearProps: 'all' });

//         }
//     });
//     if (dir == 'next') {
//         gsap.to(this.DOM.panes[this.data.active + 1], .5, {
//             xPercent: 110, 
//             ease: Expo.easeOut,
//             onComplete() {
//                  gsap.set(_this.DOM.panes[_this.data.active + 1], { clearProps: 'all' });

//             }
//         });
//     } else {
//         gsap.to(this.DOM.panes[this.data.active - 1], .5, {
//             xPercent: -110, 
//             ease: Expo.easeOut,
//             onComplete() {
//                 gsap.set(_this.DOM.panes[_this.data.active - 1], { clearProps: 'all' });

//             }
//         });
//     }
// }

}