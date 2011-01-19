
window.addEvent('domready', function(){

	$$('.item').addEvent('mousedown', function(event){
		event.stop();

		// `this` refers to the element with the .item class
 		var shirt = this;

		var clone = shirt.clone().setStyles(shirt.getCoordinates()).setStyles({
			opacity: 0.7,
			position: 'absolute'
		}).inject(document.body);

		var drag = new Drag.Move(clone, {

			droppables: $('cart'),

			onDrop: function(dragging, cart){

				dragging.destroy();

				if (cart != null){
					shirt.clone().inject(cart);
					cart.highlight('#7389AE', '#FFF');
				}
			},
			onEnter: function(dragging, cart){
				cart.tween('background-color', '#98B5C1');
			},
			onLeave: function(dragging, cart){
				cart.tween('background-color', '#FFF');
			},
			onCancel: function(dragging){
				dragging.destroy();
			}
		});
		drag.start(event);
	});

});
