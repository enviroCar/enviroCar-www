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
		  <button class="btn btn-small dropdown-toggle" data-toggle="dropdown">Choose Sensor
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

  function addRouteInformation(name, start, end){
      $('#routeInformation').append('<h2>'+name+'</h2><p>Start: '+start+'</p><p>End: '+end+'</p><p><a class="btn" href="graph.php?id='+$_GET(['id'])+'">Graphs</a><a class="btn" href="heatmap.php?id='+$_GET(['id'])+'">Thematic maps</a></p>');
  }

  function onFeatureSelect(feature){
    popup = new OpenLayers.Popup("chicken",
                       feature.geometry.getBounds().getCenterLonLat(),
                       new OpenLayers.Size(200,200),
                       getContent(),
                       true);

    map.addPopup(popup);

    function getContent(){
      var output = "<b>"+convertToLocalTime(feature.attributes.time)+"</b><br>";
      for(property in feature.attributes.phenomenons){
        output += property+": "+feature.attributes.phenomenons[property].value+"<br>";
      }
      return output;
    }

  }


  function onFeatureUnselect(feature){
      popup.destroy();
      popup = null;
  }


    var map = new OpenLayers.Map('map');
    var mapnik = new OpenLayers.Layer.OSM();
    map.addLayer(mapnik);
    map.setCenter(new OpenLayers.LonLat(7.9,51,9) // Center of the map
      .transform(
        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
        new OpenLayers.Projection("EPSG:900913") // to Spherical Mercator Projection
      ),8
    );
    
  
  //var styleMap = new OpenLayers.StyleMap({pointRadius: 10});
  var co2_style = new OpenLayers.StyleMap(
    { 
            "default": new OpenLayers.Style({ 
                fillColor: "${getColor}",
                strokeWidth: 1,             
                strokeColor: "#000", 
                fillOpacity: 1,
                pointRadius: 10//"${getSize}"
                //label: "${getLabel}"                  
            },
            {
                context: {
                    getColor : function (feature) {
                        return feature.attributes.phenomenons.testphenomenon1.value > 20 ? '#FF0000' :
                               feature.attributes.phenomenons.testphenomenon1.value > 10 ? '#FF5A08' :
                                                                  '#08FF41' ;
                    },
          getSize: function(feature) {
            console.log(100 / feature.layer.map.getResolution());
            return 100 / feature.layer.map.getResolution();
          }
                } 
            })
    }
  );

    var testphenomenon1 = new OpenLayers.StyleMap(
    { 
            "default": new OpenLayers.Style({ 
                fillColor: "${getColor}",
                strokeWidth: 1,             
                strokeColor: "#000", 
                fillOpacity: 1,
                pointRadius: 10//"${getSize}"
                //label: "${getLabel}"                  
            },
            {
                context: {
                    getColor : function (feature) {
                        return feature.attributes.phenomenons.testphenomenon1.value > 40 ? '#FF0000' :
                               feature.attributes.phenomenons.testphenomenon1.value > 20 ? '#FF5A08' :
                                                                  '#08FF41' ;
                    },
          getSize: function(feature) {
            console.log(100 / feature.layer.map.getResolution());
            return 100 / feature.layer.map.getResolution();
          }
                } 
            })
    }
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
  		geojson_layer.styleMap = co2_style;
  		geojson_layer.redraw();
  }


  function addGeoJSONToLayer(data){
    geojson_layer.addFeatures(geojson_format.read(data));
    map.zoomToExtent(geojson_layer.getDataExtent());


    //TODO: append only new properties!
    data = JSON.parse(data);
    sensors = data.features[0].properties.phenomenons;
    for (property in sensors) {
      if($.inArray(property, sensorProperties) == -1){ 
        sensor = sensors[property];
        sensorProperties.push(property);
        $('#sensorsDropdown').append('<li><a href="javascript:changeSensor(\''+property+'\')">'+property+'</a></li>');
      }
    }


  }

  //GET the information about the specific track
  $.get('assets/includes/get.php?url=http://giv-car.uni-muenster.de:8080/stable/rest/tracks', function(data) {
    if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404){
        console.log('error in getting tracks');
        $('#loadingIndicator').hide();
    }else{
      data = JSON.parse(data);
      for(i = 0; data.tracks.length; i++){
        $.get('assets/includes/get.php?url='+data.tracks[i].href, function(trackResponse){
          if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404){
            console.log("error in receiving track");
          }else{
            addGeoJSONToLayer(trackResponse);
          }
        });

      $('#loadingIndicator').hide();
     }
    }
  });


</script>



<?
include('footer.php');
?>