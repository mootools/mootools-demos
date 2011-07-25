
(function(){

Drag.Scroll = new Class({

	// We'd like to use the Options Class Mixin
	Implements: [Options],

	// Default options
	options: {
		friction: 5,
		axis: {x: true, y: true}
	},

	initialize: function(element, options){
		element = this.element = document.id(element);
		this.content = element.getFirst();
		this.setOptions(options);

		// Drag speed
		var prevTime, prevScroll, speed, scroll, timer;
		var timerFn = function(){
			var now = Date.now();
			scroll = [element.scrollLeft, element.scrollTop];
			if (prevTime){
				var dt = now - prevTime + 1;
				speed = [
					1000 * (scroll[0] - prevScroll[0]) / dt,
					1000 * (scroll[1] - prevScroll[1]) / dt
				];
			}
			prevScroll = scroll;
			prevTime = now;
		};

		// Use Fx.Scroll for scrolling to the right position after the dragging
		var fx = this.fx = new Fx.Scroll(element, {
			transition: Fx.Transitions.Expo.easeOut
		});

		// Set initial scroll
		fx.set.apply(fx, this.limit(element.scrollLeft, element.scrollTop));

		var self = this;
			friction = this.options.friction,
			axis = this.options.axis;

		// Make the element draggable
		var drag = this.drag = new Drag(element, {
			style: false,
			invert: true,
			modifiers: {x: axis.x && 'scrollLeft', y: axis.y && 'scrollTop'},
			onStart: function(){
				// Start the speed measuring
				timerFn();
				timer = setInterval(timerFn, 1000 / 60);
				// cancel any fx if they are still running
				fx.cancel();
			},
			onComplete: function(){
				// Stop the speed measuring
				prevTime = false;
				clearInterval(timer);
				// Scroll to the new location
				fx.start.apply(fx, self.limit(
					scroll[0] + (speed[0] || 0) / friction,
					scroll[1] + (speed[1] || 0) / friction
				));
			}
		});

	},

	// Calculate the limits
	getLimit: function(){
		var limit = [[0, 0], [0, 0]], element = this.element;
		var styles = Object.values(this.content.getStyles(
			'padding-left', 'border-left-width', 'margin-left',
			'padding-top', 'border-top-width', 'margin-top',
			'width', 'height'
		)).invoke('toInt');
		limit[0][0] = sum(styles.slice(0, 3));
		limit[0][1] = styles[6] + limit[0][0] - element.clientWidth;
		limit[1][0] = sum(styles.slice(3, 6));
		limit[1][1] = styles[7] + limit[1][0] - element.clientHeight;
		return limit;
	},

	// Apply the limits to the x and y values
	limit: function(x, y){
		var limit = this.getLimit();
		return [
			x.limit(limit[0][0], limit[0][1]),
			y.limit(limit[1][0], limit[1][1])
		];
	}

});

var sum = function(array){
	var result = 0;
	for (var l = array.length; l--;) result += array[l];
	return result;
};

})();


window.addEvent('domready', function(){

	var elements = $$('.scrollarea');

	new Drag.Scroll(elements[0], {
		axis: {x: true, y: true}		
	});

	new Drag.Scroll(elements[1], {
		friction: 5
	});

});
