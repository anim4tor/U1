/**
 * demo.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2019, Codrops
 * http://www.codrops.com
 */


class Cursor {
  constructor() {
    // initPageTransitions();
    if(!isMobile) {
      this.initCursor();
      // this.initCanvas();
      // this.initHovers();
    }
  }

  initCursor() {
    console.log('Initialize custom cursor ...')
    this.clientX = -50;
    this.clientY = -50;
    this.cursor = document.querySelector("[data-cursor]");
    this.cursorCircle = document.querySelector(".cursor__circle");
    // this.cursorSpinner = document.querySelector(".cursor__spinner");
    this.cursorSpeed = 0.4;
    this.lastX = 0;
    this.lastY = 0;
    this.acc = 0;
    this.direction = 0;
    this.lastDirection = 0;
    this.size = 0.2;
    this.isLoading = false;

    document.addEventListener("mousemove", e => {
      this.clientX = e.clientX;
      this.clientY = e.clientY;
    });

    const render = () => {
      this.acc = (Math.abs(this.lastX - this.clientX) + Math.abs(this.lastY - this.clientY))/75
      // this.accX = Math.abs((this.lastX - this.clientX))/75
      // this.accY = Math.abs((this.lastY - this.clientY))/75
      if(this.acc>0.1) {
        this.direction = this.getDirection(this.lastX, this.lastY, this.clientX, this.clientY)
      }
      this.lastX = Util.lerp(this.lastX, this.clientX, this.cursorSpeed)
      this.lastY = Util.lerp(this.lastY, this.clientY, this.cursorSpeed)
      // console.log(this.lastDirection)
      
      gsap.timeline()
      // .to(this.cursorSpinner, {
      //   x: this.lastX,
      //   y: this.lastY,
      // },0)
      .to(this.cursorCircle, {
        duration: this.cursorSpeed,
        x: this.lastX,
        y: this.lastY,
      },0)
      .to(this.cursorCircle, {
        duration: this.cursorSpeed,
        scaleY: this.size ,
        scaleX: this.size ,
      },0)
      // .to(this.cursorCircle, {
      //   duration: 0,
      //   rotate: -this.direction,
      //   transformOrigin: 'center center'
      // },0);
      requestAnimationFrame(render);
    };
    requestAnimationFrame(render);

    this.initHovers()

  }

  getDirection(x1, y1, x2, y2) {
    var dx = x2 - x1;
    var dy = y2 - y1;

    return Math.atan2(dx,  dy)*(180/Math.PI)
  }

  reveal() {
    gsap.to(this.cursor, {
      duration: 1.5,
      scale: 1,
      ease: Elastic.easeOut.config(2, 1)
    })
  }

  reset() {
    this.isLoading = false
    this.size = 0.2
    gsap.timeline()
    // .to(this.cursorSpinner, {
    //   duration: 0.5,
    //   scale: 0,
    //   opacity: 0,
    //   ease: Power2.easeInOut
    // },0)
    .to(this.cursorCircle, {
      duration: 0.5,
      opacity: 1,
      ease: Power3.easeInOut
    },0)
    this.initHovers()
  }

  hide() {
    gsap.to(this.cursor, {
      duration: 1,
      scale: 0,
      ease: Power2.easeInOut
    })
  }

  loading() {
    this.isLoading = true
    this.size = 0
    gsap.timeline()
    .to(this.cursorCircle, {
      duration: 0.5,
      opacity: 0,
      ease: Power3.easeInOut
    },0)
    // .to(this.cursorSpinner, {
    //   duration: 0.5,
    //   scale: 1,
    //   opacity: 1,
    //   ease: Power2.easeInOut
    // },0)
  }

  initHovers() {

    const handleLinkEnter = e => { 
      if (this.isLoading != true) {  
        this.size = 0.1
        gsap.timeline()
        .to(this.cursorCircle, {
          duration: 0.5,
          // scale: 2,
          // backgroundColor: 'FFFFFF',
          ease: Power3.easeInOut
        },0)
      }
    };

    const handleLinkLeave = () => {
      if (this.isLoading != true) {
        this.size = 0.2
        gsap.timeline()
        .to(this.cursorCircle, {
          duration: 0.5,
          // backgroundColor: '#FB4E23',
          ease: Power3.easeInOut
        },0)
      } 
    };

    const handlePlayEnter = e => { 

      if (this.isLoading != true) {  
        this.size = 1.4
        gsap.timeline()
        .to(this.cursorCircle, {
          duration: 0.5,
          // scale: 2,
          // backgroundColor: 'FFFFFF',
          ease: Power3.easeInOut
        },0)
        this.cursor.classList.add('--play')
      }
    };

    const handlePlayLeave = () => {
      if (this.isLoading != true) {
        this.size = 0.2
        gsap.timeline()
        .to(this.cursorCircle, {
          duration: 0.5,
          // backgroundColor: '#FB4E23',
          ease: Power3.easeInOut
        },0)
        this.cursor.classList.remove('--play')

      } 
    };

    var linkItems = document.querySelectorAll("a, button");
    linkItems.forEach(item => {
      item.addEventListener("mouseenter", handleLinkEnter);
      item.addEventListener("mouseleave", handleLinkLeave);
    });

    var playItems = document.querySelectorAll("[data-play]");
    playItems.forEach(item => {
      item.addEventListener("mouseenter", handlePlayEnter);
      item.addEventListener("mouseleave", handlePlayLeave);
    });

  }
}

var CURSOR = new Cursor
CURSOR.loading()


function initCursor() {
    console.log('Init custom cursor ...')
    // document.querySelectorAll('[data-cursor]').forEach(el => {

    //     new Cursor()

    // })
}
