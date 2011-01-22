MooTools Demos
==============

This is the new MooTools Demo runner and the new MooTools Demos.
The demos can be opened in [jsFiddle](http://www.jsfiddle.net) for editing.

## Creating new Demos

We're always looking for new demos that can be great additions to the docs or give the wow-effect for new users.
With the demos we want to show what MooTools is capable of. The demos is a great way to contribute to MooTools
in a easy way, by adding new demos and improving existing ones.

You can submit new demos by forking this repository and send us a [pull request](https://github.com/mootools/mootools-demos/pulls).

The *demos* directory contains all the demos. You can start creating a new demo by copying the directory of an existing
demo. The name of the directory is the same as used in the URL after `?demo=`.

Each demo contains at least four files:

- **demo.css** - Contains the CSS for the demo, shows up in the CSS tab
- **demo.details** - This is a YAML file which contains extra info, like a desription and links to the docs
- **demo.html** - Contains the HTML of the demo, shows up in the HTML tab
- **demo.js** - Contains the JavaScript of the demo, shows up in the JS tab

### demo.js

demo.js is probably the most important file of the demo because it contains the MooTools code.

It is important to wrap the code in a *domready* event. This is important so it works in this demo runner as well as on jsfiddle.

	window.addEvent('domready', function(){
		// code here
	});

#### Code guidelines

We try to use the MooTools code guidelines. Those can be found in the [MooTools Core Wiki](https://github.com/mootools/mootools-core/wiki/Syntax-and-Coding-Style-Conventions)

### Used Color Scheme

In order to give the demos a consistent look, we use this [Color Scheme](http://jsfiddle.net/Z5u5s/3/)
