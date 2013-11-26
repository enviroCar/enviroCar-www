<?
include('header.php');
?>

<script type="text/javascript" src="./assets/OpenLayers/OpenLayers.light.js"></script>  
<script src="./assets/js/geojsontools.js"></script>
<script src="./assets/js/canvasjs.js" type="text/javascript"></script>
<link href="./assets/css/jquery.share.css" rel="stylesheet">


<div class="container leftband" id="route-information-container">
  <div class="row-fluid" >
    <div class="span10">
      <div id="routeInformation" style="margin-left: 30px;">
      </div>
      <ul class="inline-stats" id="statistics">
        <li><p id="dist"></p><p id="time"></p><span class="muted"><?php echo $route_distance; ?></span></li>
        <li><p id="avg-consum"></p><p id="total-consum"></p><span class="muted"><?php echo $route_fuelConsumption; ?></span></li>
        <li><p id="avg-co2"></p><p id="total-co2"></p><span class="muted"><?php echo $route_CO2; ?></span></li>
        <li><p><br></p><p id="idle-time"></p><span class="muted"><?php echo $route_idleTime; ?></span></li>
        <li><p><br></p><p id="avg-speed"></p><span class="muted"><?php echo $route_avgSpeed; ?></span></li>   
      </ul>
    </div>
    <div class="onoffswitch">
      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="share-switch" onclick="toggleSharing()">
      <label class="onoffswitch-label" for="share-switch">
        <div class="onoffswitch-inner">
          <div class="onoffswitch-active"><div class="onoffswitch-switch"><?php echo $route_sharing_on; ?></div></div>
          <div class="onoffswitch-inactive"><div class="onoffswitch-switch"><?php echo $route_sharing_off; ?></div></div>
        </div>
      </label>
    </div>
    <div id="share-buttons" class="share-buttons">
      <a class='pop share-square share-square-googleplus-disabled'></a><a class='pop share-square share-square-facebook-disabled'></a><a class='pop share-square share-square-twitter-disabled'></a>
    </div>
  </div>
</div>

<div id="loadingIndicator_route" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>


<div class="row-fluid" id="full-map-span">
</div>

<div class="container leftband" id="map-and-chart-container">
<div class="row-fluid" id="mapAndChart">
<div class="span6" id="small-map-span">
    <div class="simple-map" id="map">
      <p id="enviroCar-license">Tracks ODbL by <a href="https://envirocar.org/terms.php">enviroCar</a></p>
      <div class="btn-group sensorswitch">
        <a class="btn btn-primary btn-full-screen" id="btn-full-screen"><?php echo $route_fullscreen ?></a>
        <div class="btn btn-group dropup">
          <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#" id="sensorswitch">
            Download
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
              <li id="download-geojson">
              </li>
              <li>
                <a id="download-shape">Shape (*.shp)</a>
              </li>
          </ul>
        </div>
        <div class="btn btn-group dropup">
          <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#" id="sensorswitch">
            Sensor
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
              <li>
                <a id="change-sensor-consumption" ><?php echo $route_dropup_fuelConsumption; ?></a>
              </li>
              <li>
                <a id="change-sensor-rpm"><?php echo $route_dropup_rpm; ?></a>
              </li>
              <li>
                <a id="change-sensor-speed"><?php echo $route_dropup_speed; ?></a>
              </li>
              <li>
                <a id="change-sensor-intake-temp"><?php echo $route_dropup_intake_temp; ?></a>
              </li>
              <li>
                <a id="change-sensor-intake-pressure"><?php echo $route_dropup_intake_pressure; ?></a>
              </li>
              <li>
                <a id="change-sensor-co2"><?php echo $route_dropup_co2; ?></a>
              </li>
              <li>
                <a id="change-sensor-maf"><?php echo $route_dropup_maf; ?></a>
              </li>
          </ul>
        </div>
      </div>
      <div class="well" id="legend"  style="display:inline">
        <p><strong><?php echo $route_legend ?></strong></p>
        <p id="legend-title"><?php echo $route_legend_title.$route_dropup_speed ?></p>
        <table>
          <tr>
            <td><img src="./assets/img/legend_green.png" class="legend"></img></td>
            <td id="legend1"></td>
          </tr>
          <tr>
            <td><img src="./assets/img/legend_dark_green.png" class="legend"></img></td>
            <td id="legend2"></td>
          </tr>
          <tr>
            <td><img src="./assets/img/legend_orange.png" class="legend"></img></td>
            <td id="legend3"></td>
          </tr>
          <tr>
            <td><img src="./assets/img/legend_light_red.png" class="legend"></img></td>
            <td id="legend4"></td>
          </tr>
          <tr>
            <td><img src="./assets/img/legend_red.png" class="legend"></img></td>
            <td id="legend5"></td>
          </td>
        </table>
      </div>
  </div>
    </div>
  <div class="span6 graph-span">
    <div id="chartContainer" style="position: relative, height: 100%; width: 100%;"></div>
    <div class="dropdown" id="graph-dropdown">
      <a class="dropdown-toggle btn btn-primary" data-toggle="dropdown" href="#">
          Select Data
          <b class="caret"></b>
      </a>
      <div class="dropdown-menu graph-selection pull-right">
        <div class="span6">
        <p><strong>Primary Axis</strong></p>
              <label class="radio">
                  <input type="radio" name="primary" checked onclick="addSeries($.extend({},chartSeries[0]), 'primary')">
                  <?php echo $route_dropup_speed; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="primary" onclick="addSeries($.extend({},chartSeries[1]), 'primary')">
                  <?php echo $route_dropup_fuelConsumption; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="primary" onclick="addSeries($.extend({},chartSeries[2]), 'primary')">
                  <?php echo $route_dropup_intake_temp; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="primary" onclick="addSeries($.extend({},chartSeries[3]), 'primary')">
                  <?php echo $route_dropup_intake_pressure; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="primary" onclick="addSeries($.extend({},chartSeries[4]), 'primary')">
                  <?php echo $route_dropup_co2; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="primary" onclick="addSeries($.extend({},chartSeries[5]), 'primary')">
                  <?php echo $route_dropup_maf ?>
              </label>
        </div>
        <div class="span6">
        <p><strong>Secondary Axis</strong></p>
              <label class="radio">
                  <input type="radio" name="secondary" onclick="addSeries($.extend({},chartSeries[0]), 'secondary')">
                  <?php echo $route_dropup_speed; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="secondary" checked onclick="addSeries($.extend({},chartSeries[1]), 'secondary')">
                  <?php echo $route_dropup_fuelConsumption; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="secondary" onclick="addSeries($.extend({},chartSeries[2]), 'secondary')">
                  <?php echo $route_dropup_intake_temp; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="secondary" onclick="addSeries($.extend({},chartSeries[3]), 'secondary')">
                  <?php echo $route_dropup_intake_pressure; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="secondary" onclick="addSeries($.extend({},chartSeries[4]), 'secondary')">
                  <?php echo $route_dropup_co2; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="secondary" onclick="addSeries($.extend({},chartSeries[5]), 'secondary')">
                  <?php echo $route_dropup_maf ?>
              </label>
        </div>
        
        
      </div>
    </div>
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

  function addRouteInformation(name){
      $('#routeInformation').append('<h2>'+name+'</h2>');
      $('#download-geojson').append('<a href="https://envirocar.org/api/stable/tracks/'+$_GET(['id'])+'" download="enviroCar_track_'+$_GET(['id'])+'.geojson">GeoJSON (*.json)</a>');
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
      addRouteInformation(data.properties.name);
      var fuelType = data.properties.sensor.properties.fuelType;	
		
		var measurements = [];
		
		//speed = 0 counts as idle time
		var idleTime = 0;
		
		var distance = 0;		
		
		// total fuel consumption in liter per hour
		var totalFuelConsumptionLiterPerHour = 0;		
		
		if (data.features.length > 1) {
			for (var i = 0; i < data.features.length; i++) {
				
				var feature = data.features[i];		
				
				if(i == 0){
					startTime = new Date(data.features[i].properties.time);
				}else if(i == data.features.length - 2){
					endTime = new Date(data.features[i + 1].properties.time);	
				}
				var lat1 = feature.geometry.coordinates[1];
				var lng1 = feature.geometry.coordinates[0];
 				
 				var trackPartDistance = 0;				
				
				if(i < data.features.length-1){				
				var lat2 = data.features[i+1].geometry.coordinates[1];
				var lng2 = data.features[i+1].geometry.coordinates[0];
				
				trackPartDistance = getDistance(lat1, lng1, lat2, lng2);				
				
				distance = distance + trackPartDistance;
				}
				var coords = "POINT (" + feature.geometry.coordinates[0] + " " + feature.geometry.coordinates[1]+ ")";
        		
        		var rpm = checkPhenomenonValue('Rpm', feature).value;
        		var iat = checkPhenomenonValue('Intake Temperature', feature);
        		var map = checkPhenomenonValue('Intake Pressure', feature);
        		var speed = checkPhenomenonValue('Speed', feature);
				
				if(speed == 0){
					//add five thousand miliseconds of idle time for each measurement with speed = 0
					idleTime = idleTime + 5000;	
				}	
				
				var maf = feature.properties.phenomenons["MAF"];

				if(maf){
					 maf = checkPhenomenonValue("MAF", feature);
				}else if (!maf || maf <= 0) {
					maf = checkPhenomenonValue("Calculated MAF", feature);		
				}	
				
				var secondsBtwnMeasurements = 0;				

				if(i == (data.features.length - 1)){				
					secondsBtwnMeasurements = 1;
					
				}else{				
					//multiply with seconds between measurements
					secondsBtwnMeasurements = (new Date(data.features[i+1].properties.time).getTime() - new Date(feature.properties.time).getTime()) / 1000;		
									
				}		
				
				var consumption = 0;				
				var co2 = 0;
				var fuelConsumptionOfMeasurement = checkPhenomenonValue('Consumption', feature);       		

        		if (speed > 0){
          		//consumption = (maf * 3355) / (speed * 100);
          		consumption = (fuelConsumptionOfMeasurement / speed) * 100;
        		}else{
          		//consumption = (maf * 3355) / 10000;
          		consumption = fuelConsumptionOfMeasurement / 10000;//??
        		}
        
				if (consumption > 50){
          		consumption = 50;
       		}
       		
				//this does not work as the distance between measurment points can be 0 sometimes
				//if(trackPartDistance != 0){
				//	consumption = fuelConsumptionOfMeasurement * secondsBtwnMeasurements / 3600 / trackPartDistance * 100;
				//}
				totalFuelConsumptionLiterPerHour += fuelConsumptionOfMeasurement;			
				
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
			
			duration = endTime.getTime() - startTime.getTime();
		
			lengthOfTrack = distance;
			
			// in liter per 100 km
			var avgFuelConsumption = (totalFuelConsumptionLiterPerHour / data.features.length) * duration / (1000 * 60 * 60) / distance * 100;			
						
			//calculate grams of CO2 per km
			var co2inGramsPerKm	= 0;
			
			if(fuelType == "gasoline"){
				co2inGramsPerKm = avgFuelConsumption * 23.3;
			}else if(fuelType == "diesel"){
				co2inGramsPerKm = avgFuelConsumption * 26.4;
			}
			
			var totalCO2 = co2inGramsPerKm * distance / 1000;
			
			$('#routeInformation').append('<h2>'+name+'</h2>');
			$('#idle-time').append('<p><i class="icon-pause"></i>' + convertMilisecondsToTime(idleTime) + '</p>');
			$('#dist').append('<p><i class="icon-globe"> </i>' + Math.round(lengthOfTrack*100)/100 + ' km</p>');
			$('#time').append('<p><i class="icon-time"> </i>' + convertMilisecondsToTime(duration) + '</p>');
			$('#avg-consum').append('<p><img src="./assets/img/icon_durchschnitt.gif"/>' + Math.round(avgFuelConsumption*100)/100 + ' l/100 km </p>');
			$('#avg-co2').append('<p><img src="./assets/img/icon_durchschnitt.gif"/>' + Math.round(co2inGramsPerKm*100)/100 + ' g/km</p>');
			$('#total-co2').append('<p><i class="icon-leaf"></i>' + Math.round(totalCO2*100)/100 + ' kg</p>');
			
			var totalFuelConsumptionInLiter = (avgFuelConsumption / 100) * distance;		
			
			getFuelPrice(totalFuelConsumptionInLiter, fuelType);	
			
		}    	
		
    	fillStatistics()     
      
    }
  });
	
	function checkPhenomenonValue(phenomenomName, feature){
		
		var phenomenom = feature.properties.phenomenons[phenomenomName];
		
		if(phenomenom){
			return phenomenom.value;		
		}else{
			return 0;		
		}
		
	}	
	
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
    var maxIat = 0;
    var maxMap = 0;
    var maxCo2 = 0;
    var maxMaf = 0;

      for(i = 0; i < data.statistics.length; i++){
      	var phenoName = data.statistics[i].phenomenon.name;
      	if(phenoName == 'Speed'){
      		maxSpeed = data.statistics[i].max;
      		$('#avg-speed').append(' <p><img src="./assets/img/icon_durchschnitt.gif">' + Math.round(data.statistics[i].avg) + ' km/h</p>');				
        	}else if(phenoName == 'Consumption'){
        		maxConsumption = data.statistics[i].max;
        	}else if(phenoName == 'Rpm'){
        		maxRPM = data.statistics[i].max;
        	}else if(phenoName == 'Intake Temperature'){
            maxIat = data.statistics[i].max;
          }else if(phenoName == 'Intake Pressure'){
            maxMap = data.statistics[i].max;
          }else if(phenoName == 'CO2'){
            maxCo2 = data.statistics[i].max;
          }else if(phenoName == 'Calculated MAF' || phenoName == 'MAF'){
            maxMaf = data.statistics[i].max;
          }
      }
      gon.statistics = {max_speed : maxSpeed, 
      						max_rpm : maxRPM, 
     							 max_consumption : maxConsumption,
                   max_iat : maxIat,
                   max_map : maxMap,
                   max_co2 : maxCo2,
                   max_maf : maxMaf
      						};

    }
    initShowTrack();
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
	
	function getTotalCO2(){
		var sum = 0;
		for(var i = 0; i < gon.measurements.length-1; i++) {
			var m = gon.measurements[i];
			var m2 = gon.measurements[i + 1];
			var seconds = new Date(m2.recorded_at).getTime() - new Date(m.recorded_at).getTime();
			seconds = seconds / 1000;
			if(seconds <= 10){
				var co2 = (((m.maf / 14.7) / 730 )) * 2.35;
				sum += seconds * co2;
			}			
		}
		return sum;		
	}	
	
	function getFuelPrice(totalFuelConsumption, fuelType){
		$.get('assets/includes/fuelprices.php?fuelType='+fuelType, function(data) {
			$('#total-consum').append('<p><i class="icon-fire"> </i>' + Math.round(totalFuelConsumption*100)/100 + ' l, circa ' + Math.round(totalFuelConsumption * data*100)/100 + ' €</p>');
		});
	}
			
	function getTotalFuelConsumption(){
		var sum = 0;
		for(var i = 0; i < gon.measurements.length-1; i++) {
			var m = gon.measurements[i];
			var m2 = gon.measurements[i + 1];
			var seconds = new Date(m2.recorded_at).getTime() - new Date(m.recorded_at).getTime();
			seconds = seconds / 1000;			
			if(seconds <= 10){
				var consumption = m.maf / 10731;
				sum += seconds * consumption;
			}			
		}
		return sum;
	}	
	
	function convertMilisecondsToTime(miliseconds) {

      var totalSec = miliseconds / 1000;
      var hours = parseInt( totalSec / 3600 ) % 24;
      var minutes = parseInt( totalSec / 60 ) % 60;
	
		totalSec = totalSec % 60;

      return (hours > 0 ? hours + ' h' : '') + ' ' + (minutes > 0 ? minutes + " m" : "") + ' ' + (totalSec > 0 ? totalSec + " s" : "");
    }

var map = new OpenLayers.Map("map");//, {controls:[]});
var marker;
//style for selected measurement
highlightStyle = {
  pointRadius: 10,
  'fillColor': '#0066FF',
  'strokeColor': '#0000CC',
  'strokeOpacity': 1.0,
  'strokeWidth': 2
};
//route line style
var style = {
  strokeColor: '#0000ff',
  strokeOpacity: 0.8,
  strokeWidth: 5
};
var style2 = {
  strokeColor: '#00ff00',
  strokeOpacity: 0.8,
  strokeWidth: 5
};
var gonPoints = [];
var epsg4326;
var projectTo;
var feature;
var vectorLayer;
var heatmap;


function initShowTrack(){
 initMap();
 initChart();

}

var chart;
var data;
function initChart(){
  
  //defining data and setting up the hash for lookup
  var seriesData = [[],[],[],[],[],[]];
  epsg4326 =  new OpenLayers.Projection("EPSG:4326"); //WGS 1984 projection
  projectTo = map.getProjectionObject();

  for(var i = 0; i < gon.measurements.length; i++) {
    var coords = gon.measurements[i].latlon.replace("(", "").replace(")","").split(" ")
    var date = new Date(gon.measurements[i].recorded_at).getTime();
    //speed
    seriesData[0][i] = {
      x: date,
      y: gon.measurements[i].speed,
      label: "km/h"
    }
    //consumption
    seriesData[1][i] = {
      x: date,
      y: gon.measurements[i].consumption,
      label: "l/100 km"
    }
    //iat
    seriesData[2][i] = {
      x: date,
      y: gon.measurements[i].iat,
      label: "&deg;C"
    }
    //map
    seriesData[3][i] = {
      x: date,
      y: gon.measurements[i].map,
      label: "kPa"
    }
    //co2
    seriesData[4][i] = {
      x: date,
      y: gon.measurements[i].co2,
      label: "g/sec"
    }
    //maf
    seriesData[5][i] = {
      x: date,
      y: gon.measurements[i].maf,
      label: "g/sec"
    }
    dataHash[date] = new OpenLayers.Geometry.Point( coords[1], coords[2] ).transform(epsg4326, projectTo);
  }
  
  
  chart = new CanvasJS.Chart("chartContainer", {
    zoomEnabled: true,
    panEnabled: true,
    legend: {
      fontFamily: "Droid Sans",
      horizontalAlign: "left", // left, center ,right 
      verticalAlign: "top",  // top, center, bottom
    },
    axisX:{
        valueFormatString: "hh:mm",
        labelFontFamily: "Droid Sans",
        includeZero: false
    },
    axisY: {
        title: '<?php echo $route_dropup_speed." in Km/h"; ?>',
        titleFontSize: 15,
        labelFontFamily: "Droid Sans"
    },
    axisY2: {
        title: "<?php echo $route_dropup_fuelConsumption.' in l/100 km'; ?>",
        titleFontSize: 15
        //valueFormatString: " "
    },
    data: [//array of dataSeries
    { //dataSeries object

      /*** Change type "column" to "bar", "area", "line" or "pie"***/
      
      type: "spline",
      axisYType: "primary",
      name: "<?php echo $route_dropup_speed; ?> in km/h",
      showInLegend: true,
      xValueType: "dateTime",
      dataPoints: seriesData[0]
    },
    { //dataSeries object

      /*** Change type "column" to "bar", "area", "line" or "pie"***/
      axisYType: "secondary",
      type: "spline",
      name: "<?php echo $route_dropup_fuelConsumption; ?> in l/100 km",
      showInLegend: true,
      xValueType: "dateTime",
      dataPoints: seriesData[1]
    },
    { //dataSeries object

      /*** Change type "column" to "bar", "area", "line" or "pie"***/
      axisYType: "secondary",
      type: "spline",
      name: "<?php echo $route_dropup_intake_temp; ?> in Celsius",
      showInLegend: true,
      xValueType: "dateTime",
      dataPoints: seriesData[2]
    },
    { //dataSeries object

      /*** Change type "column" to "bar", "area", "line" or "pie"***/
      axisYType: "secondary",
      type: "spline",
      name: "<?php echo $route_dropup_intake_pressure; ?> in kPa",
      showInLegend: true,
      xValueType: "dateTime",
      dataPoints: seriesData[3]
    },
    { //dataSeries object

      /*** Change type "column" to "bar", "area", "line" or "pie"***/
      axisYType: "secondary",
      type: "spline",
      name: "CO2 in g/sec",
      showInLegend: true,
      xValueType: "dateTime",
      dataPoints: seriesData[4]
    },
    { //dataSeries object

      /*** Change type "column" to "bar", "area", "line" or "pie"***/
      axisYType: "secondary",
      type: "spline",
      name: "<?php echo $route_dropup_maf ?> in g/sec",
      showInLegend: true,
      xValueType: "dateTime",
      dataPoints: seriesData[5]
    }
    ]
  });

  
  chartSeries = $.extend({},chart.options.data);
  chart.options.data.splice(2,4);
  chart.render();
}

function addSeries(series, axis){
  series.axisYType = axis;
  //remove series from specified axis
  for(var i=0; i<chart.options.data.length; i++){
    if(chart.options.data[i].axisYType == axis){
      chart.options.data.splice(i,1);
    }
  }
  //add new series to specified axis
  chart.options.data.push(series);
  if(series.axisYType == "primary"){
    chart.options.axisY.title = series.name;
  }else{
    chart.options.axisY2.title = series.name;
  }
  chart.render();
}

function initMap() {
	
  var osm = new OpenLayers.Layer.OSM('<?php echo $route_baseLayer; ?>', null, {
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
  map.addLayer(osm);
  vectorLayer = new OpenLayers.Layer.Vector('<?php echo $route_drivenRoute; ?>');
  map.addLayer(vectorLayer);

  //map.addControl(new OpenLayers.Control.PanZoomBar());
  //map.addControl(new OpenLayers.Control.LayerSwitcher());
  //map.addControl(new OpenLayers.Control.MousePosition());
  //map.addControl(new OpenLayers.Control.OverviewMap());
  //map.addControl(new OpenLayers.Control.KeyboardDefaults());
  //map.addControl(new OpenLayers.Control.DragPan());

  epsg4326 =  new OpenLayers.Projection("EPSG:4326"); //WGS 1984 projection
  projectTo = map.getProjectionObject();

  var lonLat = new OpenLayers.LonLat(-0.12, 51.503 ).transform(epsg4326, projectTo);

  //Get the coordinates from the gon measurements
  for(var i=0; i<gon.measurements.length-1; i++) {
    var coords = gon.measurements[i].latlon.replace("(", "").replace(")","").split(" ")
    var coords2 = gon.measurements[i+1].latlon.replace("(", "").replace(")","").split(" ")
    gonPoints.push(
      new OpenLayers.Feature.Vector(
        new OpenLayers.Geometry.LineString([
          new OpenLayers.Geometry.Point( coords[1], coords[2] ).transform(epsg4326, projectTo),
          new OpenLayers.Geometry.Point( coords2[1], coords2[2] ).transform(epsg4326, projectTo)
          ]),
        null, style
      )
    )
  }

  vectorLayer.addFeatures(gonPoints);

  var bounds = new OpenLayers.Bounds();

  if(gonPoints) {
    if(gonPoints.constructor != Array) {
      gonPoints = [gonPoints];
    }

    // Iterate over the features and extend the bounds to the bounds of the geometries
    for(var i=0; i<gonPoints.length; i++) {
      if (!bounds) {
        bounds = vectorLayer.features[i].geometry.getBounds();
      } else {
        bounds.extend(vectorLayer.features[i].geometry.getBounds());
      }
    }
  }
  map.zoomToExtent(bounds);
  changeSensor("speed");
}

function addHeatmapLayer(){
  features = [];
  for(var i=0; i<gon.measurements.length; i++) {
    var measurement = gon.measurements[i];
    var coords = gon.measurements[i].latlon.replace("(", "").replace(")","").split(" ")
    var g = new OpenLayers.Geometry.Point( coords[1], coords[2] ).transform(epsg4326, projectTo)
    //insert what has to be shown here, e.g. speed/CO2
    features.push(
      new OpenLayers.Feature.Vector(g, {count: measurement.speed})
    )
  }

  //create our vectorial layer using heatmap renderer
  heatmap = new OpenLayers.Layer.Vector("Heatmap Layer", {
    opacity: 0.3,
    renderers: ['Heatmap'],
    rendererOptions: {
      weight: 'count',
      heatmapConfig: {
        radius: 15
      }
    }
  });
  //heatmap.addFeatures(features);
  //map.addLayers([heatmap]);
}


function selectPoint(point){
  //postAnalytics();
  if(map.getLayersByName("Marker").length > 0){
    map.removeLayer(marker);
  }

  marker = new OpenLayers.Layer.Vector("Marker", {
    'displayInLayerSwitcher': false
  });
  var markers = [new OpenLayers.Feature.Vector(point, null, highlightStyle)];
  marker.addFeatures(markers);
  map.addLayers([marker]);

}

var lastPost = new Date().getTime();
function postAnalytics(){
  if(lastPost != 0 && (new Date().getTime() - lastPost) > 3000){
    console.log("interaction");
    $.post("http://giv-dueren.uni-muenster.de/analytics/create", { user_id: gon.user, group: gon.user_group, action_name: gon.params.action, url: "/" + gon.params.controller + "/" + gon.params.action + "/", category: "interaction", description: JSON.stringify(gon.params) } );

    lastPost = new Date().getTime();
  }
}

function changeSensor(sensor){
    var unit = "";
    switch (sensor) {
      case "iat":
          unit = " &deg;C";
          break;
      case "map":
          unit = " kPa";
          break;
      case "co2":
          unit = " g/sec";
          break;
      case "maf":
          unit = " g/sec";
          break;
      case "speed":
          unit = " km/h";
          break;
      case "rpm":
          unit = " rpm";
          break;
      case "consumption":
          unit = " l/100km";

          for(i = 0; i < vectorLayer.features.length; i++){
            var color;
            if(gon.measurements[i][sensor] < 5){
              color = "#1BE01B";
            }else if(gon.measurements[i][sensor] < 9){
              color = "#B5E01B";
            }else if(gon.measurements[i][sensor] < 13){
              color = "#E0C61B";
            }else if(gon.measurements[i][sensor] < 20){
              color = "#E08B1B";
            }else if(gon.measurements[i][sensor] >= 20){
              color = "#E01B1B";
            }
            var style = {
              strokeColor: color, 
              strokeOpacity: 0.8,
              strokeWidth: 5
            };
            vectorLayer.features[i].style = style;
          }
          vectorLayer.redraw();          

          document.getElementById("legend1").innerHTML = "0-5 l/100km"
          document.getElementById("legend2").innerHTML = "5-9 l/100km"
          document.getElementById("legend3").innerHTML = "9-13 l/100km"
          document.getElementById("legend4").innerHTML = "13-20 l/100km"
          document.getElementById("legend5").innerHTML = ">20 l/100km"

          return;
    }

    for(i = 0; i < vectorLayer.features.length; i++){
        var style = {
          strokeColor: getColor(sensor, gon.measurements[i][sensor]), 
          strokeOpacity: 0.8,
          strokeWidth: 5
        };
        vectorLayer.features[i].style = style;
    }
    vectorLayer.redraw();

    var steps = gon.statistics["max_" + sensor]/5;
  
    document.getElementById("legend1").innerHTML = "0" + "-" + Math.round(steps) + unit
    document.getElementById("legend2").innerHTML = Math.round(steps) + "-" + Math.round(2*steps) + unit
    document.getElementById("legend3").innerHTML = Math.round(2*steps) + "-" + Math.round(3*steps) + unit
    document.getElementById("legend4").innerHTML = Math.round(3*steps) + "-" + Math.round(4*steps) + unit
    document.getElementById("legend5").innerHTML = Math.round(4*steps) + "-" + Math.round(5*steps) + unit
}

function getColor(sensor, value){
    var steps = gon.statistics["max_" + sensor]/5;
    if(value < steps) return "#1BE01B";
    else if(value < steps * 2) return "#B5E01B";
    else if(value < steps * 3) return "#E0C61B";
    else if(value < steps * 4) return "#E08B1B";
    else return "#E01B1B";
}


$('a#change-sensor-speed').click(function(){ 
  changeSensor("speed");
  $('#legend-title').text("<?php echo $route_legend_title.$route_dropup_speed ?>");
});
$('a#change-sensor-rpm').click(function(){ 
  changeSensor("rpm");
  $('#legend-title').text("<?php echo $route_legend_title.$route_dropup_speed ?>");
});
$('a#change-sensor-consumption').click(function(){ 
  changeSensor("consumption");
  $('#legend-title').text("<?php echo $route_legend_title.$route_dropup_fuelconsumption ?>");
});
$('a#change-sensor-intake-temp').click(function(){ 
  changeSensor("iat");
  $('#legend-title').text("<?php echo $route_legend_title.$route_dropup_intake_temp ?>");
});
$('a#change-sensor-intake-pressure').click(function(){ 
  changeSensor("map");
  $('#legend-title').text("<?php echo $route_legend_title.$route_dropup_intake_pressure ?>");
});
$('a#change-sensor-co2').click(function(){ 
  changeSensor("co2");
  $('#legend-title').text("<?php echo $route_legend_title.'CO2' ?>");
});
$('a#change-sensor-maf').click(function(){ 
  changeSensor("maf");
  $('#legend-title').text("<?php echo $route_legend_title.$route_dropup_maf ?>");
});

var scroll = 0;
$(document).ready(function () {
            $("#btn-full-screen").click(function () {

                if ($("#btn-full-screen").hasClass("btn-full-screen")) {
                    scroll = $(window).scrollTop();
                    window.scrollTo(0,0);
                    
                    $("#route-information-container").hide();
                    $("#map-and-chart-container").hide();
                    $("footer").hide();
                    $('html, body').css({
                        'overflow': 'hidden',
                        'height': '100%'
                    });

                    $("#map").appendTo("#full-map-span");
                    $("#map").height($(window).height());
                    $("#map").removeClass("simple-map");
                    $("#map").addClass("full-map");
                    $("#btn-full-screen").removeClass("btn-full-screen");
                    $("#btn-full-screen").addClass("btn-partial-screen");
                    $("#btn-full-screen").text("Minimize")
                }
                else {
                    $("#route-information-container").show();
                    $("#map-and-chart-container").show();
                    $("footer").show();
                    $('html, body').css({
                        'overflow': 'visible'
                    });

                    

                    $("#map").height("");
                    $("#map").appendTo("#small-map-span");
                    $("#map").removeClass("full-map");
                    $("#map").addClass("simple-map");
                    $("#btn-full-screen").removeClass("btn-partial-screen");
                    $("#btn-full-screen").addClass("btn-full-screen");
                    $("#btn-full-screen").text('Fullscreen');                    
                    $(window).scrollTop(scroll);
                }
                map.updateSize();
            });
        });


</script>

<?
include('footer.php');
?>
