<?
include('header.php');
?>
<link rel="stylesheet" href="./assets/css/bootstrap-tour.css" type="text/css">
<link rel="stylesheet" href="./assets/css/trip_single.css" type="text/css">
<link rel="stylesheet" href="./assets/css/trip_show.css" type="text/css">
<link rel="stylesheet" href="./assets/css/trip_static.css" type="text/css">
<link rel="stylesheet" href="./assets/css/layout.css" type="text/css">
<script type="text/javascript" src="http://openlayers.org/api/OpenLayers.js"></script>
<!--<script src="./assets/OpenLayers/OpenLayers.light.js"></script>-->
<!--<script src="./assets/js/OpenLayers.js"></script>-->
<!--<script src="./assets/js/openlayers_custom.js"></script>-->
<div class="container">
<div class="row">
  <div class="span6">
    <div class="map" id="map">
      <div class="btn-group sensorswitch dropup">
        <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#" id="sensorswitch">
          Sensor
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li>
              <a id="change-sensor-consumption" href="#">Verbrauch</a>
            </li>
            <li>
              <a id="change-sensor-rpm" href="#">U/min</a>
            </li>
            <li>
              <a id="change-sensor-speed" href="#">Geschwindigkeit</a>
            </li>
        </ul>
      </div>
    </div>
    <img src="./assets/img/legend_green.png" class="legend"><p style="display:inline" id="legend1"></p></img>
    <img src="./assets/img/legend_dark_green.png" class="legend"><p style="display:inline" id="legend2"></p></img>
    <img src="./assets/img/legend_orange.png" class="legend"><p style="display:inline" id="legend3"></p></img>
    <img src="./assets/img/legend_light_red.png" class="legend"><p style="display:inline" id="legend4"></p></img>
    <img src="./assets/img/legend_red.png" class="legend"><p style="display:inline" id="legend5"></p></img>
  </div>
  <div class="span6">
    <div id="chartContainer" style="height: 100%; width: 100%;"></div>
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
  var track;
  var gon = {};

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
	
      data = JSON.parse(data);
      
      var fuelType = data.properties.sensor.properties.fuelType;	
		
		var measurements = [];
		
		if (data.features.length > 1) {
			for (var i = 0; i < data.features.length - 1; i++) {
				
				var feature = data.features[i];		
				
				if(i == 0){
					startTime = new Date(data.features[i].properties.time);
				}else if(i == data.features.length - 2){
					endTime = new Date(data.features[i + 1].properties.time);	
				}
				
				var coords = "POINT (" + feature.geometry.coordinates[0] + " " + feature.geometry.coordinates[1]+ ")";
        		var rpm = feature.properties.phenomenons['Rpm'].value;
        		var iat = feature.properties.phenomenons['Intake Temperature'].value;
        		var map = feature.properties.phenomenons['Intake Pressure'].value;
        		var speed = feature.properties.phenomenons['Speed'].value;

				var maf = feature.properties.phenomenons["MAF"];

				if(maf){
					 maf = feature.properties.phenomenons["MAF"].value;
				}else if (!maf || maf <= 0) {
					maf = feature.properties.phenomenons["Calculated MAF"].value;		
				}		
				
				var consumption = 0;				
				var co2 = 0;
        		
        		if (speed > 0){
          		consumption = (maf * 3355) / (speed * 100);
        		}else{
          		consumption = (maf * 3355) / 10000;
        		}
        
				if (consumption > 50){
          		consumption = 50;
       		}

        		co2 = consumption * 2.35 //gets kg/100 km        
        
				var recorded_at = feature.properties.time;				
				
        		var m = {
          		recorded_at : recorded_at,
          		speed : speed,
          		rpm : rpm,
          		maf : maf,
          		iat : iat,
          		map : map,
          		consumption : consumption,
          		co2 : co2,
          		latlon : coords
          	};
				
				measurements.push(m);
				
			}
			
			gon.measurements = measurements;					
			
		}     
    	fillStatistics()
      
      
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

		
		var maxSpeed = 0;
		var maxConsumption = 0;
		var maxRPM = 0;

      for(i = 0; i < data.statistics.length; i++){
      	var phenoName = data.statistics[i].phenomenon.name;
      	if(phenoName == 'Speed'){
      		maxSpeed = data.statistics[i].max;				
        	}else if(phenoName == 'Consumption'){
        		maxConsumption = data.statistics[i].max;
        	}else if(phenoName == 'Rpm'){
        		maxRPM = data.statistics[i].max;
        	}
      }
      gon.statistics = {max_speed : maxSpeed, 
      						max_rpm : maxRPM, 
     							 max_consumption : maxConsumption
      						};

    }
   //$('#loadingIndicator_route').hide(); 
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
<script src="./assets/js/jquery.cookie.js"></script>
<!--<script type="text/javascript" src="http://openlayers.org/api/OpenLayers.js"></script>
<!--<script src="./assets/OpenLayers/OpenLayers.light.js"></script>-->
<!--<script src="./assets/js/OpenLayers.js"></script>
<script src="./assets/js/openlayers_custom.js"></script>-->
<script src="./assets/js/bootstrap-tour.js"></script>
<!--<script src="./assets/js/builder.js"></script>
<script src="./assets/js/calendarview.js"></script>
<script src="./assets/js/cropper.js"></script>
<script src="./assets/js/forum.js"></script>
<script src="./assets/js/lightbox.js"></script>
<script src="./assets/js/prototip-min.js"></script>
<script src="./assets/js/rails.js"></script>-->
<script src="./assets/js/community_engine.js" type="text/javascript"></script>
<script src="./assets/js/geojsontools.js"></script>
<!--<script src="./assets/js/heatmap.js" type="text/javascript"></script>
<script src="./assets/js/heatmap-openlayers-renderer.js" type="text/javascript"></script>-->
<script src="./assets/js/canvasjs.js" type="text/javascript"></script>
<!--<script src="./assets/js/show_abstract_trip.js"></script>-->
<script src="./assets/js/show_single_trip.js" type="text/javascript"></script>

<?
include('footer.php');
?>
