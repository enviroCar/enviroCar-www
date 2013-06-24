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
</div>

<style type="text/css">
  .olControlAttribution{
    bottom:0px;

  }
</style>

<script type="text/javascript">

var popup;
var sensorProperties = Array();
var statistics = null;
var chosensensor = null;

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

  function convertToLocalTime(serverDate) {
      var dt = new Date(Date.parse(serverDate));
      var localDate = dt;


      var gmt = localDate;
          var min = gmt.getTime() / 1000 / 60; // convert gmt date to minutes
          var localNow = new Date().getTimezoneOffset(); // get the timezone
          // offset in minutes
          var localTime = min - localNow; // get the local time

      var dateStr = new Date(localTime * 1000 * 60);
      var d = dateStr.getDate();
      var m = dateStr.getMonth() + 1;
      var y = dateStr.getFullYear();

      var totalSec = dateStr.getTime() / 1000;
      var hours = parseInt( totalSec / 3600 ) % 24;
      var minutes = parseInt( totalSec / 60 ) % 60;


      return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d) + ' ' + hours +':'+ minutes;
    }

  function onFeatureSelect(feature){
    popup = new OpenLayers.Popup("chicken",
                       feature.geometry.getBounds().getCenterLonLat(),
                       new OpenLayers.Size(200,200),
                       getContent(),
                       true);

    map.addPopup(popup);

    function getContent(){
      var output = "";
      output += "<b>Speed: </b>"+feature.attributes.Speed+"Km/h<br>";
      output += "<b>CO2: </b>"+feature.attributes.CO2+"g/s<br>";
      output += "<b>OSM Id: </b>"+feature.attributes.osm_id+"<br>";

      return output;
    }

  }


  function onFeatureUnselect(feature){
      popup.destroy();
      popup = null;
  }


    var map = new OpenLayers.Map('map');

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

    map.setCenter(new OpenLayers.LonLat(7.9,51,9) // Center of the map
      .transform(
        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
        new OpenLayers.Projection("EPSG:900913") // to Spherical Mercator Projection
      ),8
    );
    
  var geojson_layer = new OpenLayers.Layer.Vector("Measurements");
                  
    
  var geojson_format = new OpenLayers.Format.GeoJSON({
      'internalProjection': new OpenLayers.Projection("EPSG:900913"),
      'externalProjection': new OpenLayers.Projection("EPSG:4326")
  });
 

  map.addLayer(geojson_layer);



  selectControl = new OpenLayers.Control.SelectFeature(geojson_layer, {
            onSelect: onFeatureSelect,
            onUnselect: onFeatureUnselect
        });
  map.addControl(selectControl);
  selectControl.activate();
      

  function changeSensor(property){
    for(i = 0; i < statistics.length; i++){
      if(property == statistics[i].phenomenon.name) chosenSensor = statistics[i];
    }

    
    var style = new OpenLayers.StyleMap({ 
      "default": new OpenLayers.Style({ 
          fillColor: "${getColor}",
          strokeWidth: 1,             
          strokeColor: "#000", 
          fillOpacity: 0.6,
          pointRadius: "${getSize}"
          //label: "${getLabel}"                  
      },
      {
          context: {
              getColor : function (feature) {
                  return getPointColor(feature.attributes[chosenSensor.phenomenon.name]);
              },
              getSize: function(feature) {
                return 80 / feature.layer.map.getResolution();
              }
          } 
      })
      }
    );
    geojson_layer.styleMap = style;
    geojson_layer.redraw();
  }

  function getPointColor(property){
    var range = chosenSensor.max - chosenSensor.min;
    var steps = range/5;
    if(property < chosenSensor.min + steps) return "#1BE01B";
    else if(property < chosenSensor.min + steps * 2) return "#B5E01B";
    else if(property < chosenSensor.min + steps * 3) return "#E0C61B";
    else if(property < chosenSensor.min + steps * 4) return "#E08B1B";
    else return "#E01B1B";
  }


  function addGeoJSONToLayer(data){
    geojson_layer.addFeatures(geojson_format.read(data));
    map.zoomToExtent(geojson_layer.getDataExtent());

    data = JSON.parse(data); 
    $('#sensorsDropdown').append('<li><a href="javascript:changeSensor(\'Speed\')">Speed</a></li>');
    $('#sensorsDropdown').append('<li><a href="javascript:changeSensor(\'CO2\')">CO2</a></li>');

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
    if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404 || data == 500){
        console.log('error in getting tracks');
        $('#loadingIndicator').hide();
    }else{
      addGeoJSONToLayer(data);
      $('#loadingIndicator').hide();
    }
  });



</script>



<?
include('footer.php');
?>