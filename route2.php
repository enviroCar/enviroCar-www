<?
include('header.php');
?>

<script src="./assets/OpenLayers/OpenLayers.js"></script>
<style>
	  img.olTileImage {
        max-width: none;
      }


    .olControlAttribution{
    bottom:0px;
    }


      .mapContainer{
          height:300px; 
          width:300px;
      }
      @media (min-width: 500px) {
      .mapContainer{
          height:500px; 
          width:500px;
      }
    

</style>



<?php

$route = get_request('http://giv-cario.uni-muenster.de/working-folder/track.json', true);
if($route['status'] == 200){

  echo '<script type="text/javascript">';
  echo 'var routeString = eval( '. $route['response'] .');';
  echo '</script>';  

  $route = json_decode($route['response'], true);


  


?>

<div class="container">
	<div class="span5">
      <h2><?php echo $route['identifier']; ?></h2>
      <p>Created: <? echo $route['created']; ?></p>
      <p>Car: <? echo $route['sensor']['name']; ?></p>
      <p>Measurement points: <? echo sizeof($route['measurements']); ?></p>
          <p><a class="btn" href="graph2.php">Graphs</a><a class="btn" href="heatmap.php">Thematic maps</a></p>
    </div>

    <div class="span7 mapContainer">
      <div id="map" style="height: 100%; width:100%;">
      </div>
    </div>	
  </div>

<?
}
else{
  echo '<h2>Route could not be loaded</h2>';
}
?>
	
<script type="text/javascript">

  function onFeatureSelect(feature){
  
  }

  function onFeatureUnselect(feature){
      
  }


    var map = new OpenLayers.Map('map');
    var mapnik = new OpenLayers.Layer.OSM();
    map.addLayer(mapnik);
    map.setCenter(new OpenLayers.LonLat(7.63,51.96) // Center of the map
      .transform(
        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
        new OpenLayers.Projection("EPSG:900913") // to Spherical Mercator Projection
      ),12
    );
		
		
		// var overlay = new OpenLayers.Layer.Vector("Routes");
		
		var style_blue = OpenLayers.Util.extend();
            style_blue.strokeColor = '#0065A0';
            style_blue.strokeWidth = 3;
		
    var geojson_format = new OpenLayers.Format.GeoJSON({
                'internalProjection': new OpenLayers.Projection("EPSG:900913"),
                'externalProjection': new OpenLayers.Projection("EPSG:4326")
            });

    var geojson_layer = new OpenLayers.Layer.Vector(); 
    map.addLayer(geojson_layer);


    geojson_layer.addFeatures(geojson_format.read(routeString.measurements[0].geometry));
    geojson_layer.addFeatures(geojson_format.read(routeString.measurements[1].geometry));

    selectControl = new OpenLayers.Control.SelectFeature(geojson_layer, {
            onSelect: onFeatureSelect,
            onUnselect: onFeatureUnselect
        });
    map.addControl(selectControl);
    selectControl.activate();
			
</script>	  

<?
include('footer.php');
?>
