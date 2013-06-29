<?
require_once('./assets/includes/authentification.php');

$logged_in = false; 
if(!is_logged_in()){
  $logged_in = false; 
  include('header-start.php');
}else{
  $logged_in = true;
  include('header.php');
}
?> 
<link rel="stylesheet" href="./assets/OpenLayers/theme/default/style.css" type="text/css">


<script src="./assets/OpenLayers/OpenLayers.js"></script>
<script src="assets/OpenLayers/Renderer/Heatmap.js"></script>

<div id="loadingIndicator" class="loadingIndicator">
  <div style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
</div>

<div class="container rightband" style="padding-right: 0px">
  <div id="sensor_headline" style="float:left"></div>


  <div id="map" style="width: 100%; height: 512px; padding-top:20px !important" class="smallmap">
  </div>
  <p style="float:right; z-index:5000;"><a class="btn" href="informationproduct.php">Back to Products</a></p>
  <div class="row-fluid" id="legend">
    <div class="span2"><div class="legend" style="background-color:#f5f500"></div> 0-5 km/h difference</div>
    <div class="span2"><div class="legend" style="background-color:#f4b600"></div> 6-10 km/h difference</div>
    <div class="span2"><div class="legend" style="background-color:#f57700"></div> 11-20 km/h difference</div>
    <div class="span2"><div class="legend" style="background-color:#f53800"></div> 21-30 km/h difference</div>
    <div class="span2"><div class="legend" style="background-color:#f50000"></div> > 30 km/h difference</div>
  </div>
</div>



<style type="text/css">
  .legend{
    height:10px; 
    width:10px; 
    float:left; 
    margin-top:10px;
    margin-right:5px;
    border-style: solid;
    border-width: 1px;
  }

  .olControlAttribution{
    bottom:0px;

  }
  #map img{max-width:none;}
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
    //var mapnik = new OpenLayers.Layer.OSM();
    //map.addLayer(mapnik);

    var grey = new OpenLayers.Layer.OSM('Simple OSM Map', null, {
    eventListeners: {
        tileloaded: function(evt) {
            var ctx = evt.tile.getCanvasContext();
            if (ctx) {
                var imgd = ctx.getImageData(0, 0, evt.tile.size.w, evt.tile.size.h);
                var pix = imgd.data;
                for (var i = 0, n = pix.length; i < n; i += 4) {
                    pix[i] = pix[i + 1] = pix[i + 2] = (3 * pix[i] + 4 * pix[i + 1] + pix[i + 2]) / 8;
                }
                ctx.putImageData(imgd, 0, 0);
                evt.tile.imgDiv.removeAttribute("crossorigin");
                evt.tile.imgDiv.src = ctx.canvas.toDataURL();
            }
        }
    }
  });

    map.addLayer(grey);


    map.setCenter(new OpenLayers.LonLat(7.9,51,9),8);
    
    var routes = new OpenLayers.Layer.Vector("Routes");
    map.addLayer(routes);

      

  function changeSensor(property){
    for(i = 0; i < routes.features.length; i++){
        var style = {
          strokeColor: getColor(routes.features[i].attributes.speed_difference), 
          strokeOpacity: 0.8,
          strokeWidth: 5
        };
        routes.features[i].style = style;
    }
    routes.redraw();
    $('#sensor_headline').html('Speed difference between OSM max-speed and enviroCar averaged speed');

  }


  function createThematicRoutes(track){
    features = track.features;
    for(i = 0; i < features.length-1; i++){
      if(features[i].properties.osm_id == features[i+1].properties.osm_id){
        var points = new Array(
           new OpenLayers.Geometry.Point(features[i].geometry.coordinates[0], features[i].geometry.coordinates[1]).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject()),
           new OpenLayers.Geometry.Point(features[i+1].geometry.coordinates[0],features[i+1].geometry.coordinates[1]).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject())
        );
        var line = new OpenLayers.Geometry.LineString(points);

          var style = { 
            strokeColor: '#0008FF', 
            strokeOpacity: 0.5,
            strokeWidth: 5
          };
        //}
        var lineFeature = new OpenLayers.Feature.Vector(line, null, style);
        lineFeature.attributes['speed_difference'] = (features[i].properties.speed_difference+features[i+1].properties.speed_difference)/2;

        routes.addFeatures([lineFeature]);    
      }
    }
  map.zoomToExtent(routes.getDataExtent());
  }



  function getColor(property){
    if( Math.abs(property) < 5) return "#f5f500";
    else if(Math.abs(property) < 10) return "#f4b600";
    else if(Math.abs(property) < 20) return "#f57700";
    else if(Math.abs(property) < 30) return "#f53800";
    else return "#f50000";
  }

  //GET the information about the specific track
  $.get('../data-aggregation/speedDifference.php', function(data) {
    if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404){
        console.log('error in getting tracks');
        error_msg("Route couldn't be loaded successfully.");
        $('#loadingIndicator').hide();
    }else{
      
      data = JSON.parse(data);
      createThematicRoutes(data);
      changeSensor('speed_difference');
      $('#loadingIndicator').hide();
    }
    
  });


</script>



<?
include('footer.php');
?>