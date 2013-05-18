<?
include('header.php');
?>
<link rel="stylesheet" href="http://openlayers.org/dev/theme/default/style.css" type="text/css">


<script src="http://openlayers.org/dev/OpenLayers.js"></script>
<script src="assets/OpenLayers/Renderer/Heatmap.js"></script>

<div class="container rightband" style="padding-right: 0px">

	<div class="btn-group" style="float:right">
	  <button class="btn">CO2</button>
	  <button class="btn">Noise</button>
	  <button class="btn">Fuel Consumption</button>
	  <button class="btn">Engine Load</button>
	</div>
	<h2>CO2 Concentration</h2>
	<div id="map" style="width: 100%; height: 512px" class="smallmap">
	</div>
	<p style="float:right"><a class="btn" href="route.php">Route overview</a></p>
    </div>
</div>

<style type="text/css">
	.olControlAttribution{
		bottom:0px;

	}
</style>

<script type="text/javascript">
	var raster = new OpenLayers.Layer.OSM("osm");

	var vector = new OpenLayers.Layer.Vector("heatmap", {
	// use the heatmap renderer instead of the default one (SVG, VML or Canvas)
	    renderers: ['Heatmap'],
	    protocol: new OpenLayers.Protocol.HTTP({
	        url: "http://giv-cario.uni-muenster.de/working-folder/assets/includes/get.php?url=http://giv-car.uni-muenster.de:8080/dev/rest/tracks/51944e28e4b017df94de8e2d&auth=true",
	        format: new OpenLayers.Format.GeoJSON()

	    }),
	    styleMap: new OpenLayers.StyleMap({
	        "default": new OpenLayers.Style({
	            pointRadius: 20,
	            weight: "${weight}"
	        }, {
	            context: {
	// the 'weight' of the point (between 0.0 and 1.0), used by the heatmap renderer
	                weight: function(f) {
	                    return Math.min(Math.max((f.attributes.phenomenons.testphenomenon1.value || 0) / 10, 0.25), 1.0);
	                }
	            }
	        })
	    }),
	    strategies: [new OpenLayers.Strategy.Fixed()],
	    eventListeners: {
	        featuresadded: function(evt) {
	            this.map.zoomToExtent(this.getDataExtent());
	        }
	    }
	});
	var map = new OpenLayers.Map("map", {
	    layers: [raster, vector]
	});

</script>



<?
include('footer.php');
?>