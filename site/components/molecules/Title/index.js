function initTitles() {
	var smallchars = ["i", "j", "í", "l", "t", "I"];
	
	var target = document.querySelectorAll('[data-reveal-path]');
	Splitting({ target: target, by: 'chars', whitespace: true });

	target.forEach(split => {
	  var chars = split.querySelectorAll('[data-char], .whitespace');
	  var length = 0
	  // console.log(chars)
	  chars.forEach(char => {
	    var scale = smallchars.includes(char.innerHTML) ? 0.6 : 1
	    var char_width = char.getBoundingClientRect().width*scale*0.65
	    char.style.setProperty('--char-width', char_width + 'px')
	    char.style.setProperty('--char-length', length + 'px' )
	    length = length + char_width
	  })

	})

}