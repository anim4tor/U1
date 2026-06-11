/*

	FEEDBACK

*/
var debug = false

class Feedback {
	constructor() {

		this.inbox = []

	    this.DOM = {
	        inbox: document.querySelector('[data-feedback-load]')
	    };

	    this.response
	
	}

	async load(url = '', data = {}) {
	  	// read our JSON
	  	console.log(url, data)

	  	// preprocess data
	  	var sendData = new FormData()
	  	sendData.append('data',JSON.stringify(data))

	  	// fetch
		let response = await fetch(url, {
		    method: 'POST', // *GET, POST, PUT, DELETE, etc.
		    // mode: 'cors', // no-cors, *cors, same-origin
		    // cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
		    // credentials: 'same-origin', // include, *same-origin, omit
		    // headers: {
		    //   'Content-Type': 'text/html; charset=UTF-8'
		    //   // 'Content-Type': 'application/x-www-form-urlencoded',
		    // },
		    // redirect: 'follow', // manual, *follow, error
		    // referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
		    // body: JSON.stringify(data) // body data type must match "Content-Type" header
		    body: sendData // body data type must match "Content-Type" header
		    // body: data // body data type must match "Content-Type" header
		});
		return response
	}

	message(template, timeout, data) {
		console.log(template)
		this.load('/templates/feedback/feedback_' + template + '.php', data)
			.then(response => response.text())
		    .then((text) => {
		      	const doc = new DOMParser().parseFromString(text, 'text/html')
	          	var el = document.createElement("div")
	          	el.innerHTML = doc.querySelector('body').innerHTML
	          	const node = el
	          	return node
	      		this.render(el, timeout)
		    })
		    .then((node) => {
		    	this.DOM.inbox.append(node)
		    	return node
		    })
		    .then((node) => this.render(node, timeout))
	}

    inline(template, timeout, data) {
        console.log(template)
        var inline_container = document.querySelector('[data-feedback-inline]')
        this.load('/templates/feedback/feedback_' + template + '.php', data)
            .then(response => response.text())
            .then((text) => {
                const doc = new DOMParser().parseFromString(text, 'text/html')
                var el = document.createElement("div")
                el.innerHTML = doc.querySelector('body').innerHTML
                const node = el
                return node
                this.render(el, timeout)
            })
            .then((node) => {
                inline_container.innerHTML = ''
                inline_container.append(node)
                return node
            })
            .then((node) => this.render(node, timeout))
    }

	render(el,t) {	
		new Message(el,t)
	}
}


class Message {
    constructor(el, t, loader) {
        this.DOM = {
            control: el,
            loader: typeof loader !== undefined ? loader : document.querySelector('[data-feedback-load]')
        };

        this.timeout = typeof t !== 'undefined' ? t : 4000;

        this.touch = {
            start: 0,
            end: 0,
            distance: 0,
            threshold: 100
        };

        this.initEvents()

        this.open()

        if (this.timeout != '-1') {
            this.delayedClose()
        }

    }

    async load() {
    	
    }

    open() {
    	gsap
    	.from(this.DOM.control, .5, {
    	    xPercent: 110, 
    	    ease: Power3.easeOut
    	})
    }

    close(el) {
    	gsap
    	.to(el, .5, {
    	    xPercent: 110, 
    	    ease: Power3.easeOut,
        	onComplete: function() {
    	      	el.remove()
    	    }
    	})
    }

    delayedClose() {
    	gsap.delayedCall(this.timeout/1000, this.close.bind(null, this.DOM.control));
    }

    grab(e) {
    	this.touch.start = e.touches[0].clientX;
    }

    drag(e) {
		this.touch.end = e.changedTouches[0].clientX;
	    this.touch.distance = this.touch.end - this.touch.start
	    if(this.touch.distance > 0) {
	    	this.follow(e)
	    }
    }

    release(e) {
	    if(this.touch.distance > this.touch.threshold) { 
	    	this.close(this.DOM.control)
	    } else {
      		this.retreat()
	    }
    }

    initEvents() {
        this.DOM.control.addEventListener("click", e => {
            this.close(this.DOM.control)
        });
        this.DOM.control.addEventListener("touchstart", e => {
            this.grab(e)
        });
        this.DOM.control.addEventListener("touchmove", e => {
            this.drag(e)
        });
        this.DOM.control.addEventListener("touchend", e => {
            this.release(e)
        });
    }

    follow() {
        gsap.to(this.DOM.control, 0, {
            x: this.touch.distance, 
            ease: 'none'
        });
    }

    retreat() {
        gsap.to(this.DOM.control, .5, {
            x: 0, 
            ease: Expo.easeOut
        });
    }

}

const FEEDBACK = new Feedback;