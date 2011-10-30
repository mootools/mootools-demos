<?php
$demo = false;
if (isset($_GET['demo'])){

	$demo = $_GET['demo'];

	// check if the demo is valid
	if (strpos($demo, '/') !== false || !is_dir(dirname(__FILE__) . '/demos/' . $demo)){
		$demo = false;
	} else {

		include dirname(__FILE__) . '/libs/yaml.php';

		$path = dirname(__FILE__) . '/demos/' . $_GET['demo'] . '/';
		$details = file_get_contents($path . 'demo.details');

		preg_match('/\/\*\s*^---(.*?)^\.\.\.\s*\*\/(.*)/ms', $details, $matches);

		$descriptor = array();

		if (!empty($matches)){
			$descriptor = YAML::decode($matches[1]);
			$description = $matches[2];
		}

		$html = file_get_contents($path . 'demo.html');
		$css = file_get_contents($path . 'demo.css');
		$js = file_get_contents($path . 'demo.js');

		// Fix links for Request, so they both work here and on jsfiddle
		$html_demo = preg_replace('/\/echo\/(html|json)\//', 'Request.php', $html);
		$js_demo = preg_replace('/\/echo\/(html|json)\//', 'Request.php', $js);

	}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>MooTools Demos<?php if (!empty($descriptor['name'])): echo ' - ' . $descriptor['name']; endif; ?></title>
	<link href="assets/css/main.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/demos.css" rel="stylesheet" type="text/css" />
<?php if ($demo && !empty($css)): ?>
<style>
<?php echo $css; ?>
</style>
<?php endif; ?>
</head>

<body>

	<div id="header">
		<div>
			<h1>MooTools</h1>
		</div>
	</div>

	<div id="wrapper">

		<div id="content">
			<div id="leftcolumn">
				<ul>
					<li><h4><a href="?">Demos</a></h4></li>
					<li><a href="?demo=Chaining">Chaining</a></li>
					<li><a href="?demo=Native">Native</a></li>
					<li><a href="?demo=Periodical">Periodical</a></li>
					<li><h4>Slick</h4></li>
					<li><a href="?demo=Slick.Finder">Slick.Finder</a></li>
					<li><h4>Drag and Drop</h4></li>
					<li><a href="?demo=Drag.Cart">Drag.Cart</a></li>
					<li><a href="?demo=Drag.Drop">Drag.Drop</a></li>
					<li><a href="?demo=Drag.Move">Drag.Move</a></li>
					<li><a href="?demo=Drag.Scroll">Drag.Scroll</a></li>
					<li><h4>Effects</h4></li>
					<li><a href="?demo=Effects">Effects</a></li>
					<li><a href="?demo=Fx.Morph">Fx.Morph</a></li>
					<li><a href="?demo=Fx.Slide">Fx.Slide</a></li>
					<li><a href="?demo=Fx.Sort">Fx.Sort</a></li>
					<li><a href="?demo=Transitions">Transitions</a></li>
					<li><h4>Events</h4></li>
					<li><a href="?demo=Element.Event">Element.Event</a></li>
					<li><a href="?demo=MouseEnter">MouseEnter</a></li>
					<li><a href="?demo=MouseWheel">MouseWheel</a></li>
					<li><a href="?demo=Element.Delegation">Element.Delegation</a></li>
					<li><a href="?demo=Element.Event.Pseudos">Element.Event.Pseudos</a></li>
					<li><h4>Request</h4></li>
					<li><a href="?demo=Request">Request</a></li>
					<li><a href="?demo=Request.HTML">Request.HTML</a></li>
					<li><a href="?demo=Request.JSON">Request.JSON</a></li>
					<li><h4>Plugins</h4></li>
					<li><a href="?demo=Accordion">Accordion</a></li>
					<li><a href="?demo=Slider">Slider</a></li>
					<li><a href="?demo=Sortables">Sortables</a></li>
					<li><a href="?demo=Enhanced-Form">Enhanced Forms</a></li>
				</ul>
			</div>
			<div id="rightcolumn">
				<?php if ($demo): ?>

				<div id="description">
					<?php if (!empty($descriptor['name'])): echo '<h2>' . $descriptor['name'] . '</h2>'; endif; ?>
					<?php if (!empty($description)): echo $description; endif; ?>
				</div>


				<form action="http://jsfiddle.net/api/post/mootools/1.4/dependencies/more/" method="post">

					<div id="jsfiddle_data">
						<textarea id="css" name="css"><?php echo $css; ?></textarea>
						<textarea id="html" name="html"><?php echo htmlspecialchars($html); ?></textarea>
						<textarea id="js" name="js"><?php echo $js; ?></textarea>
					</div>

					<ul class="tabs">
						<li class="selected first tab">Demo</li>
						<li class="jsfiddle"><button type="submit">Edit with jsFiddle</button></li>
						<?php if (!empty($descriptor['docs'])): ?>
						<li class="tab">Docs</li>
						<?php endif; ?>
						<li class="code tab">CSS</li>
						<li class="code tab">HTML</li>
						<li class="code tab">JavaScript</li>
					</ul>

				</form>

				<div class="tabcontent selected">
					<?php echo $html_demo; ?>
				</div>

				<?php if (!empty($descriptor['docs'])): ?>
				<div class="tabcontent">
					<h3>Documentation References:</h3>
					<ul class="doc_references">
					<?php foreach ($descriptor['docs'] as $doc): ?>
						<li><a href="<?php echo $doc['url']; ?>"><?php echo $doc['name']; ?></a></li>
					<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>

				<div class="tabcontent">
					<textarea id="css_tab" name="css_tab"><?php echo $css; ?></textarea>
				</div>

				<div class="tabcontent">
					<textarea id="html_tab" name="html_tab"><?php echo htmlspecialchars($html); ?></textarea>
				</div>

				<div class="tabcontent">
					<textarea id="js_tab" name="js_tab"><?php echo $js; ?></textarea>
				</div>

				<script src="assets/codemirror/js/codemirror.js" type="text/javascript"></script>
				<script src="Source/mootools-core-1.4-full.js" type="text/javascript"></script>
				<script src="Source/mootools-more-1.4-full.js" type="text/javascript"></script>
				<script src="assets/js/demos.js" type="text/javascript"></script>

				<script type="text/javascript">
					<?php echo $js_demo; ?>
				</script>

				<?php else: ?>
				<h2>MooTools Demos</h2>

				<p>The demos are here to give you some examples of how MooTools works. Demos can be opened in <a href="http://jsfiddle.net">jsFiddle</a> for editing, and you can <a href="https://github.com/mootools/mootools-demos">download the entire demo runner here</a>.</p>

				<p>We hope you enjoy our demos.</p>
				<p>The MooTools Development Team.</p>
				<?php endif; ?>
			</div>
		</div>

	</div>

</body>
</html>
