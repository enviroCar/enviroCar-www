<?
include('header.php');
?>
<link rel="stylesheet" href="./assets/OpenLayers/theme/default/style.css" type="text/css">


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
  <div class="row-fluid" id="legend"></div>
</div>



<style type="text/css">
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
    drawLegend(property, chosenSensor.phenomenon.unit);

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
        lineFeature.attributes['Speed'] = (features[i].properties.Speed+features[i+1].properties.Speed)/2;
        lineFeature.attributes['CO2'] = (features[i].properties.CO2+features[i+1].properties.CO2)/2;

        routes.addFeatures([lineFeature]);    
      }
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

  function drawLegend(property, unit){
    var range = chosenSensor.max - chosenSensor.min;
      var steps = range/5;
    var step1 = Math.round(chosenSensor.min + steps);
    var step2 = Math.round(chosenSensor.min + steps * 2);
    var step3 = Math.round(chosenSensor.min + steps * 3);
    var step4 = Math.round(chosenSensor.min + steps * 4);
    
    document.getElementById('legend').innerHTML='<div class="span2"><img src="assets/img/legend/legend1.png">'+' 0 - ' + step1 + ' ' + unit +'</div>'+ 
      '<div class="span2"><img src="assets/img/legend/legend2.png">'+ ' ' + step1 + ' - '+ step2 + ' ' + unit +'</div>'+
      '<div class="span2"><img src="assets/img/legend/legend3.png">'+ ' ' + step2 + ' - '+ step3 + ' ' + unit +'</div>'+
      '<div class="span2"><img src="assets/img/legend/legend4.png">'+ ' ' + step3 + ' - '+ step4 + ' ' + unit +'</div>'+
      '<div class="span2"><img src="assets/img/legend/legend5.png">'+ ' ' + step4 + ' - '+ Math.round(chosenSensor.max) + ' ' + unit +'</div>';
  }

  $.get('../data-aggregation/statistics.php', function(data) {
    if(data >= 400){
        console.log('error in getting statistics');
        error_msg("Route couldn't be loaded successfully.");
    }else{
      data = JSON.parse(data);
      statistics = data.statistics;  
    }
    
  });

  //GET the information about the specific track
  $.get('../data-aggregation/tracks.php', function(data) {
    if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404){
        console.log('error in getting tracks');
        error_msg("Route couldn't be loaded successfully.");
        $('#loadingIndicator').hide();
    }else{
      
      data = JSON.parse(data);
      createThematicRoutes(data);
      $('#sensorsDropdown').append('<li><a href="javascript:changeSensor(\'Speed\')">Speed</a></li>');
      $('#sensorsDropdown').append('<li><a href="javascript:changeSensor(\'CO2\')">CO2</a></li>');
      
      $('#loadingIndicator').hide();
    }
    
  });


</script>



<?
include('footer.php');
?>