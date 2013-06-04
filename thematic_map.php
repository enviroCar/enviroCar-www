<?
include('header.php');
?>
<link rel="stylesheet" href="http://openlayers.org/dev/theme/default/style.css" type="text/css">


<script src="./assets/OpenLayers/OpenLayers.js"></script>
<script src="assets/OpenLayers/Renderer/Heatmap.js"></script>

<div id="loadingIndicator" class="loadingIndicator">
  <div style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
</div>

<div class="container rightband" style="padding-right: 0px">
  <div id="sensor_headline" style="float:left"></div>
	<div>
		<div class="btn-group" style="float:right">
		  <button class="btn btn-small dropdown-toggle" data-toggle="dropdown"><? echo $choosesensor ?>
			<span class="caret"></span>
		  </button>
		  <ul id="sensorsDropdown" class="dropdown-menu">

		  </ul>
		</div>
	</div>

	<div id="map" style="width: 100%; height: 512px; padding-top:20px !important" class="smallmap">
	</div>
	<p style="float:right; z-index:5000;"><a class="btn" href="routes.php"><? echo $routeoverview ?></a></p>
</div>

<style type="text/css">
	.olControlAttribution{
		bottom:0px;

	}
</style>

<script type="text/javascript">

var statistics = null;
var chosenSensor = null;

  (function(){
    var s = window.location.search.substring(1).split('&');
      if(!s.length) return;
        var c = {};
        for(var i  = 0; i < s.length; i++)  {
          var parts = s[i].split('=');
          c[unescape(parts[0])] = unescape(parts[1]);
        }
      window.$_GET = function(name){return name ? c[name] : c;}
  }())

  function onFeatureUnselect(feature){
      popup.destroy();
      popup = null;
  }


    var map = new OpenLayers.Map('map');
    var mapnik = new OpenLayers.Layer.OSM();
    map.addLayer(mapnik);
    map.setCenter(new OpenLayers.LonLat(7.9,51,9),8);
    
    var routes = new OpenLayers.Layer.Vector("Routes");
    map.addLayer(routes);

      

  function changeSensor(property){
    for(i = 0; i < statistics.length; i++){
      if(property == statistics[i].phenomenon.name) chosenSensor = statistics[i];
    }
  	for(i = 0; i < routes.features.length; i++){
        var style = {
          strokeColor: getColor(routes.features[i].attributes[chosenSensor.phenomenon.name]), 
          strokeOpacity: 0.8,
          strokeWidth: 5
        };
        routes.features[i].style = style;
    }
    routes.redraw();
    $('#sensor_headline').html(property);

  }


  function createThematicRoutes(track){
    features = track.features;
    for(i = 0; i < features.length-1; i++){
      var points = new Array(
         new OpenLayers.Geometry.Point(features[i].geometry.coordinates[0], features[i].geometry.coordinates[1]).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject()),
         new OpenLayers.Geometry.Point(features[i+1].geometry.coordinates[0],features[i+1].geometry.coordinates[1]).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject())
      );
      var line = new OpenLayers.Geometry.LineString(points);

        var style = { 
          strokeColor: '#000000', 
          strokeOpacity: 0.5,
          strokeWidth: 5
        };
      //}
      var lineFeature = new OpenLayers.Feature.Vector(line, null, style);

      for(property in features[i].properties.phenomenons){
        lineFeature.attributes[property] = (features[i].properties.phenomenons[property].value+features[i+1].properties.phenomenons[property].value)/2;

      }
      routes.addFeatures([lineFeature]);
      
    }
    map.zoomToExtent(routes.getDataExtent());
  }


  function getColor(property){
    var range = chosenSensor.max - chosenSensor.min;
    var steps = range/5;
    if(property < chosenSensor.min + steps) return "#1BE01B";
    else if(property < chosenSensor.min + steps * 2) return "#B5E01B";
    else if(property < chosenSensor.min + steps * 3) return "#E0C61B";
    else if(property < chosenSensor.min + steps * 4) return "#E08B1B";
    else return "#E01B1B";
  }

  $.get('assets/includes/users.php?trackStatistics='+$_GET(['id']), function(data) {
    if(data >= 400){
        console.log('error in getting statistics');
        error_msg("Route couldn't be loaded successfully.");
    }else{
      data = JSON.parse(data);
      statistics = data.statistics;  
    }
    
  });

  //GET the information about the specific track
  $.get('assets/includes/users.php?track='+$_GET(['id']), function(data) {
    if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404){
        console.log('error in getting tracks');
        error_msg("Route couldn't be loaded successfully.");
        $('#loadingIndicator').hide();
    }else{
      
 	    data = JSON.parse(data);
      createThematicRoutes(data);
      sensors = data.features[0].properties.phenomenons;
      for (property in sensors) { 
      	sensor = sensors[property];
      	$('#sensorsDropdown').append('<li><a href="javascript:changeSensor(\''+property+'\')">'+property+'</a></li>');
      }
      $('#loadingIndicator').hide();
    }
    
  });


</script>



<?
include('footer.php');
?>