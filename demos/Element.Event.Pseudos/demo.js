
window.addEvent('domready', function() {

	// `:once` psuedo event provided by mootools-more
	$('clickOnce').addEvent('click:once', function(event){
		event.stop();

		this.set('tween', {
			transition: 'bounce:out',
			duration: 'long'
		}).tween('margin-left', 300);
	});

	// we can define our own pseudo events as well, for example to check for the alt key
	DOMEvent.definePseudo('alt', function(split, fn, args){
		// args[0] is the Event instance
		if(args[0].alt) fn.apply(this, args);
	});

	// apply the psuedo event to some elements
	$$('.item').addEvent('click:alt', function(){
		this.toggleClass('active');
	});

	// use multiple pseudos
	$('multiplePseudoText').addEvent('keydown:relay(textarea):keys(enter):once', function(event, el){
		el.set('value', 'MooTools!!').highlight();
	});

	// pause pseudo event, you can define the pause, otherwise it will use the default (250)
	var spinner = $('spinner').setStyle('opacity', 0).set('tween', {
		link: 'chain'
	});
	$('pauseEvent').addEvent('keydown:pause(200)', function(){
		spinner.get('tween').cancel();
		spinner.fade(1).pauseFx(400).fade(0);
	});

});
