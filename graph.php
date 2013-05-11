<?
include('../header.php');
?>

<script type="text/javascript" src="../assets/Graph.js/graph.min.js"></script>

<div class="container">
	<div class="span5">
		<h1>Speed</h1>
	</div>

	<canvas id="canvas_object" width="700" height="350">
		Your browser does not support the HTML Canvas object; No graph for you!
	</canvas>
</div>
	
<?
include('../website/footer.php');
?>

	<script>
		var graph, canvas;	// Make the graph object available globally.
		
		function init() {
			
			// Get the Canvas element.
			canvas		= document.getElementById( "canvas_object" );
			
			// Create a Graph with data.
			// First argument: Canvas HTML Node
			// Second argument: Optional: Array of data points
			// Third argument: Optional: Immediately draw the graph
			graph		= new Graph( canvas );
			
			
			// Overwrite styles in the options array for the graph object. 
			// These are ALL options, default style is visible in 'sample1_basic.html'.
			graph.options['minValue']	= "auto"; // Will automatically get the lowest number from your data array.
			graph.options['maxValue']	= "auto"; // Will automatically get the highest number from your data array.
			graph.options['padding']	= 50; // The padding from the canvas border to where the grid/graph begins.
			graph.options['spacing']	= 5; // This helps prevent lines from being EXACTLY ON the top/bottom axis line of the graph.
			graph.options['background']	= ["#fff","#fff","#fff"]; // Background, either string ('#fff', or 'red') or array with strings representing colors for a gradient.
			graph.options['grid']		= false; // Enable the background lines/grid.
			graph.options['bullets']	= true; // Show bullets for the data points from your data array.
			graph.options['bulletSize']	= 2; // The radius of the bullet points.
			graph.options['bulletColor']	= "#0065A0"; // The inside color of the bullet, only visible if you have 'bulletFill' enabled.
			graph.options['bulletFill']	= true; // Enable or disable the inside color for the bullet.
			graph.options['fill']		= true; // Do you want to fill the data from line to bottom (nice effect if you use an alpha color)
			graph.options['fillColor']	= "rgba(4, 138, 191,0.2)"; // The color, only visible if you enable 'fill'.
			graph.options['lineSize']	= 2; // The size of the line.
			graph.options['lineCurve']	= true; // Do you want the line to curve, or not?
			graph.options['lineColor']	= "#048ABF"; // Which color is the line (and bullets/bullet outside)
			graph.options['border']		= 15; // This border is 'inside' the canvas restrictions, same idea as padding except padding leaves the background
							      // and border will not let the background start at 0,0 but at borderSize,borderSize.
			graph.options['borderColor']	= "white"; // By default the border will be just plain white, but maybe you prefer it to be some other color.
			
			// Add a line of data points to the graph.
			graph.addLine( [14.3,93.3,59.5,56.3,12.2,25.7,53.1,62.8,51.5,19.3,17.7,24.1,1.1,14.2,33.8,46.7,13.0,24.1,46.7,
							12.6,19.3,19.3,0.5,20.9,45.1,56.3,12.7,0.9,0.5,0.1,4.2,33.8,46.7,51.5,49.9,41.8,16.1,43.5,53.1,
							59.5,53.1,56.3,62.8,45.1,3.4,29.0,53.1,49.9,20.9,45.1,57.9,54.7,6.6,3.4,1.9,2.3,7.6,5.6,78.9,
							48.3,57.9,59.5,48.3,30.6,51.5,57.9,53.1,53.1,53.1,57.9,57.9,59.5,56.3,46.7,7.4,1.1,1.8,0.4,0.8,
							0.6,40.2,70.8,78.9,67.6,72.4,69.2,70.8,59.5,64.4,70.8,64.4,17.7,0.4,0.9,5.3,41.8,62.8,69.2,57.9,
							25.7,1.9,0.8,0.6,3.7,4.5] );
			
			// Draw the graph.
			graph.draw();
		};
	</script>
