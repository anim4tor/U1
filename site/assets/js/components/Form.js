/*

  FORMS

*/

var form = document.getElementById('#contact-form');

class Form {
    constructor(el) {

        this.DOM = {
            form: el,
            id: el.getAttribute('id')
        };

        this.action = this.DOM.form.getAttribute('action')
        this.method = this.DOM.form.getAttribute('method')
        this.forceClose = this.DOM.form.hasAttribute('data-close') ? true : false

        this.data = {}
        this.returndata = []

        this.initEvents()

        console.log(this)

    }

    async load(url = '', data = {}) {

        // fetch
        let response = await ajax(url, data)

        return response
    }

    submit(event) {

        this.data = new FormData(this.DOM.form);

        document.querySelector('[data-form]').classList.remove('valid')
        document.querySelector('[data-form]').classList.remove('invalid')
        document.querySelector('[data-form-error]').innerHTML = ""
        document.querySelectorAll('[data-input]').forEach(input => { input.classList.remove('invalid') })

        document.querySelector('[data-form-submit]').innerHTML = "Odesílám"

        // load modal content
        this.load(this.action, this.data)

            .then((response) => {
              response = response.replace(/<[^>]*>/g, '')
              console.log(response)
              var response = JSON.parse(response);
              this.returndata = response
              return response.error
            })
            .then((error) => {
              if(!error) {
                console.log('No error')
                document.querySelector('[data-form]').classList.add('valid')
                console.log(this.returndata)
                document.querySelector('[data-form-sender]').innerHTML = this.returndata.posted.email
              } else {
                console.log('Has error')
                document.querySelector('[data-form]').classList.add('invalid')

                for (const [input, error] of Object.entries(this.returndata.error_msg)) {
                  // console.log(`${key}: ${value}`);
                  document.querySelector('[data-input][name=' + input + ']').classList.add('invalid')
                  document.querySelector('[data-form-error]').innerHTML += error.feedback + "<br>"
                }         

                document.querySelector('[data-form-submit]').innerHTML = "Odeslat zprávu"

              }
            }).then(() => {
              this.after()
            })
          
    }


    
    initEvents() {
        var _this = this

        // form submit
        this.DOM.form.addEventListener("submit", e => {
            e.preventDefault()
            _this.submit()
        });

    }

    after() {
        // dispatch form event
        var event = new CustomEvent('formSubmit', { detail: { context: this.DOM.id, valid: !this.returndata.error, data: this.returndata } });
        window.dispatchEvent(event);
    }

}

// // bind modal events
// var MODAL = new Modal()

function initForms() {
  console.log('Init Form controls ...')

   var forms = document.querySelectorAll('form')

   forms ? forms.forEach(el => {
       new Form(el)
   }) : null

}
