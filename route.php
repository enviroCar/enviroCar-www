<?
include('header.php');
?>

<div id="loadingIndicator" class="loadingIndicator">
  <div style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
</div>

<script src="./assets/OpenLayers/OpenLayers.light.js"></script>
<script src="./assets/js/geojsontools.js"></script>
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

    .olPopup{
      font-size: 16px;
      padding: 5px 0;
      margin: 2px 0 0;
      border: 1px solid #ccc;
      border: 1px solid rgba(0, 0, 0, 0.2);
      -webkit-border-radius: 6px;
      -moz-border-radius: 6px;
      border-radius: 6px;
      -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
      -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
      -webkit-background-clip: padding-box;
      -moz-background-clip: padding;
      background-clip: padding-box;
    }
    

</style>

<div class="container">

  <div class="span5">
  <div id="loadingIndicator_route" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
    <div style="max-height:400px; overflow:auto;">
      <div id="routeInformation"></div>
      <div id="routeStatistics"></div>
    </div>
    <div id="furtherInformation"></div>

          
  </div>
    <div class="span7 mapContainer">
      <div id="map" style="height: 100%; width:100%;">
      </div>
    </div>  
  </div>

  
<script type="text/javascript">

  var popup;
  var lengthOfTrack;
  var duration;
  var fuelConsumptionPerHour;
  var fuelConsumptionPer100KM;
  var gramsCO2PerKM;

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


      return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d) + ' ' + hours +':'+ (minutes <= 9 ? '0' + minutes : minutes);
    }

  function addRouteInformation(name, start, end){
      $('#routeInformation').append('<h2>'+name+'</h2>');
      $('#furtherInformation').append('<p><a class="btn" href="graph.php?id='+$_GET(['id'])+'"><? echo $graphs ?></a><a class="btn" href="thematic_map.php?id='+$_GET(['id'])+'"><? echo $thematicmaps ?></a><a class="btn" target="_blank" href="https://giv-car.uni-muenster.de/stable/rest/tracks/'+$_GET(['id'])+'" download="enviroCar_track_'+$_GET(['id'])+'.geojson">Download (GeoJSON)</a></p>');
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
  var geojson_layer = new OpenLayers.Layer.Vector("Measurements");
  var geojson_line = new OpenLayers.Layer.Vector("lines");
                  
    
    var geojson_format = new OpenLayers.Format.GeoJSON({
                'internalProjection': new OpenLayers.Projection("EPSG:900913"),
                'externalProjection': new OpenLayers.Projection("EPSG:4326")
            });
 

  map.addLayer(geojson_line);
  map.addLayer(geojson_layer);



    selectControl = new OpenLayers.Control.SelectFeature(geojson_layer, {
            onSelect: onFeatureSelect,
            onUnselect: onFeatureUnselect
        });
    map.addControl(selectControl);
    selectControl.activate();
      


  //GET the information about the specific track
  $.get('assets/includes/users.php?track='+$_GET(['id']), function(data) {
    if(data >= 400){
      console.log(data);
      if(data == 400){
          error_msg("<? echo $routeError ?>");
      }else if(data == 401 || data == 403){
        error_msg("<? echo $routeNotAllowed ?>")
      }else if(data == 404){
        error_msg("<? echo $routeNotFound ?>")
      }
      $('#loadingIndicator').hide();
    }else{
      geojson_layer.addFeatures(geojson_format.read(data));
      map.zoomToExtent(geojson_layer.getDataExtent());

      geojson_line.addFeatures(geojson_format.read(JSON.stringify(GeoJSONTools.points_to_lineString(data).features)));
	
      data = JSON.parse(data);
      
      var fuelType = data.properties.sensor.properties.fuelType;		
      addRouteInformation(data.properties.name, convertToLocalTime(data.features[0].properties.time), convertToLocalTime(data.features[data.features.length - 1].properties.time));

		var distance = 0.0;
		var startTime;
		var endTime;		
		fuelConsumptionPerHour = 0.0;
		
		if (data.features.length > 1) {
			for (var i = 0; i < data.features.length - 1; i++) {
				if(i == 0){
					startTime = new Date(data.features[i].properties.time);
				}else if(i == data.features.length - 2){
					endTime = new Date(data.features[i + 1].properties.time);	
				}
				var lat1 = data.features[i].geometry.coordinates[0];
				var lng1 = data.features[i].geometry.coordinates[1];
				var lat2 = data.features[i+1].geometry.coordinates[0];
				var lng2 = data.features[i+1].geometry.coordinates[1];
				
				distance = distance + getDistance(lat1, lng1, lat2, lng2);
				
				var tmpFuelConsumption = getFuelConsumptionOfMeasurement(data.features[i], fuelType);				
				
				fuelConsumptionPerHour = fuelConsumptionPerHour + tmpFuelConsumption;
				
			}
		}
		
		fuelConsumptionPerHour = fuelConsumptionPerHour / data.features.length;		
		
		duration = endTime.getTime() - startTime.getTime();
		
		lengthOfTrack = distance;
		
		fuelConsumptionPer100KM = fuelConsumptionPerHour * duration / (1000 * 60 * 60) / lengthOfTrack * 100;
		
		if (fuelType == "gasoline") {
			gramsCO2PerKM = fuelConsumptionPer100KM * 23.3;
		} else if (fuelType == "diesel") {
			gramsCO2PerKM = fuelConsumptionPer100KM * 26.4;
		} 
		
		$('#routeInformation').append('<p>' + Math.round(lengthOfTrack*100)/100 + ' km in ' + convertMilisecondsToTime(duration) + '<br>');
		
		if(data.properties.sensor.properties != null){
        if(data.properties.sensor.properties.model)$('#routeInformation').append('<p>Model: '+data.properties.sensor.properties.model+'<br>');
        if(fuelType)$('#routeInformation').append('<p><? echo $fuelType ?>: '+fuelType+'<br>');
        if(data.properties.sensor.properties.constructionYear)$('#routeInformation').append('<p><? echo $constructionYear ?>: '+data.properties.sensor.properties.constructionYear+'<br>');
        if(data.properties.sensor.properties.manufacturer)$('#routeInformation').append('<p><? echo $manufacturer ?>: '+data.properties.sensor.properties.manufacturer+'</p><br>');
      }
		
      $('#loadingIndicator').hide();
      
      fillStatistics();
    }
    
  });
	
	function fillStatistics(){
	
    $.get('assets/includes/users.php?trackStatistics='+$_GET(['id']), function(data) {
      if(data >= 400){
        console.log(data);
        if(data == 400){
            error_msg("<? echo $statisticsError ?>");
        }else if(data == 401 || data == 403){
          error_msg("<? echo $statisticsNotAllowed ?>")
        }else if(data == 404){
          error_msg("<? echo $statisticsNotFound ?>")
        }
        $('#loadingIndicator_route').hide();
      }else{
      data = JSON.parse(data);

      for(i = 0; i < data.statistics.length; i++){
      	var phenoName = data.statistics[i].phenomenon.name;
      	if(phenoName == 'Speed' || phenoName == 'Consumption' || phenoName == 'Rpm' || phenoName == 'CO2'){
				var phenoValue = data.statistics[i].avg;
				var phenoUnit = data.statistics[i].phenomenon.unit;     		
      		if(phenoName == 'Consumption'){
					 phenoValue = fuelConsumptionPer100KM;
					 phenoUnit = 'l/100km';
      		}else if(phenoName == 'CO2'){
					 phenoValue = gramsCO2PerKM;
					 phenoUnit = 'g/km';      			
      		}
      		console.log(phenoValue + ' ' + phenoUnit);
      		phenoValue = Math.round(phenoValue*100)/100;
      		
        		$('#routeStatistics').append('<p>&Oslash;  '+phenoName+': '+phenoValue+'  '+phenoUnit+'</p>');
        	}
      }
      
    }
   $('#loadingIndicator_route').hide(); 
  });
  }
  function getDistance(lat1, lng1, lat2, lng2){
  		var earthRadius = 6369;
		var dLat = (lat2 - lat1) / 180 * Math.PI;
		var dLng = (lng2 - lng1) / 180 * Math.PI;
		var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(lat1 / 180 * Math.PI) * Math.cos(lat2 / 180 * Math.PI) * Math.sin(dLng / 2) * Math.sin(dLng / 2);
		var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
		var dist = earthRadius * c;

		return dist;
  	}
	
	function getFuelConsumptionOfMeasurement(feature, fuelType){

		var maf = feature.properties.phenomenons["MAF"];
		var calculatedMaf = feature.properties.phenomenons["Calculated MAF"];

		if (maf > 0) {
			if (fuelType == "gasoline") {
				return (maf.value / 14.7) / 747 * 3600;
			} else if (fuelType == "diesel") {
				return (maf.value / 14.5) / 832 * 3600;
			}
		} else {
			if (fuelType == "gasoline") {
				return (calculatedMaf.value / 14.7) / 747 * 3600;
			} else if (fuelType == "diesel") {
				return (calculatedMaf.value / 14.5) / 832 * 3600;
			} 
		}

	}
	
	function convertMilisecondsToTime(miliseconds) {

      var totalSec = miliseconds / 1000;
      var hours = parseInt( totalSec / 3600 ) % 24;
      var minutes = parseInt( totalSec / 60 ) % 60;
	
		totalSec = totalSec %  60;

      return (hours > 0 ? hours + ' h' : '') + ' ' + (minutes > 0 ? minutes + " m" : "") + ' ' + (totalSec > 0 ? totalSec + " s" : "");
    }

</script>   

<?
include('footer.php');
?>
