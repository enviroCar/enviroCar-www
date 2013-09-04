<?
include('header.php');
/* Benzinpreis-Aktuell.de PHP API 1.0
by Christoph Drahn (drahn at benzinpreis-aktuell.de) */
$ba_file = fopen("http://export.benzinpreis-aktuell.de/exportdata.txt?code=69T36ft7QDY70L4", "r") or die ("Datei kann nicht gelesen werden!");
$ba_read = fgets($ba_file); 
$ba_data = explode(";",$ba_read);
$ba_datum = $ba_data[0]; // date (z.B. 05.09.2011)
$ba_uhrzeit = $ba_data[1]; // time (z.B. 11:50)
$ba_price_super = $ba_data[2]; // current price 1 l Super gasoline in Euro 
$ba_price_e10 = $ba_data[3]; // current price 1 l Super E10 gasoline in Euro
$ba_price_plus = $ba_data[4]; // current price 1 l Super Plus gasoline in Euro
$ba_price_diesel = $ba_data[5]; // current price 1 l Diesel in Euro
$ba_price_lpg = $ba_data[6]; // current price 1 l LPG-Autogas in Euro 
fclose($ba_file); 
?>
<link rel="stylesheet" href="./assets/css/bootstrap-tour.css" type="text/css">
<link rel="stylesheet" href="./assets/css/trip_single.css" type="text/css">
<link rel="stylesheet" href="./assets/css/trip_show.css" type="text/css">
<link rel="stylesheet" href="./assets/css/trip_static.css" type="text/css">
<link rel="stylesheet" href="./assets/css/layout.css" type="text/css">
<style>
    img.olTileImage {
        max-width: none;
      }
    .olControlAttribution{
    bottom:0px;
    }
</style>
<script type="text/javascript" src="./assets/OpenLayers/OpenLayers.light.js"></script>  
<script src="./assets/js/jquery.cookie.js"></script>
<script src="./assets/js/bootstrap-tour.js"></script>
<script src="./assets/js/community_engine.js" type="text/javascript"></script>
<script src="./assets/js/geojsontools.js"></script>
<script src="./assets/js/canvasjs.js" type="text/javascript"></script>
<div class="container" style="width:1270px">
<div id="routeInformation" style="margin-left: 30px;"></div>
<div class="row" id="statistics">
  <div class="span2" id="distTime" style="margin-left: 30px;">
    <h4 class="muted" ><?php echo $route_distance; ?></h4>
  </div>
  <div class="span2" id="fuelConsum">
    <h4 class="muted"><?php echo $route_fuelConsumption; ?></h4>
  </div>
  <div class="span2" id="co2">
    <h4 class="muted"><?php echo $route_CO2; ?></h4><br>
  </div>
  <div class="span2" id="idleTime">
    <h4 class="muted"><?php echo $route_idleTime; ?></h4><br>    
  </div>
  <div class="span2" id="avgSpeed">
    <h4 class="muted"><?php echo $route_avgSpeed; ?></h4>   
  </div>
</div>
<div class="row" id="mapAndChart">
<div id="loadingIndicator_route" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
 <div class="span6">
    <div class="map" id="map">
      <div class="btn-group sensorswitch dropup">
        <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#" id="sensorswitch">
          Sensor
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li>
              <a id="change-sensor-consumption" href="#"><?php echo $route_dropup_fuelConsumption; ?></a>
            </li>
            <li>
              <a id="change-sensor-rpm" href="#">U/min</a>
            </li>
            <li>
              <a id="change-sensor-speed" href="#"><?php echo $route_dropup_speed; ?></a>
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
<div id="furtherInformation" style="margin-left: 30px;"></div>
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
      addRouteInformation(data.properties.name);
      var fuelType = data.properties.sensor.properties.fuelType;	
		
		var measurements = [];
		
		//speed = 0 counts as idle time
		var idleTime = 0;
		
		var distance = 0;		
		
		if (data.features.length > 1) {
			for (var i = 0; i < data.features.length - 1; i++) {
				
				var feature = data.features[i];		
				
				if(i == 0){
					startTime = new Date(data.features[i].properties.time);
				}else if(i == data.features.length - 2){
					endTime = new Date(data.features[i + 1].properties.time);	
				}
				var lat1 = feature.geometry.coordinates[1];
				var lng1 = feature.geometry.coordinates[0];
				var lat2 = data.features[i+1].geometry.coordinates[1];
				var lng2 = data.features[i+1].geometry.coordinates[0];
				
				distance = distance + getDistance(lat1, lng1, lat2, lng2);
				
				var coords = "POINT (" + feature.geometry.coordinates[0] + " " + feature.geometry.coordinates[1]+ ")";
        		var rpm = feature.properties.phenomenons['Rpm'].value;
        		var iat = feature.properties.phenomenons['Intake Temperature'].value;
        		var map = feature.properties.phenomenons['Intake Pressure'].value;
        		var speed = feature.properties.phenomenons['Speed'].value;
				
				if(speed == 0){
					//add five thousand miliseconds of idle time for each measurement with speed = 0
					idleTime = idleTime + 5000;	
				}				
				
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
			
			duration = endTime.getTime() - startTime.getTime();
		
			lengthOfTrack = distance;
			
			var totalCO2 = getTotalCO2(); 			
			
			var totalFuelConsumption = getTotalFuelConsumption();	
			
			var currentFuelPrice = 0;		
			
			if (fuelType == "gasoline") {
				currentFuelPrice = currentFuelPrice  + '<?php echo $ba_price_super; ?>';
			} else if (fuelType == "diesel") {	
				currentFuelPrice = currentFuelPrice  + '<?php echo $ba_price_diesel; ?>';			
			}		
			
			var fuelPrice = Math.round(totalFuelConsumption * currentFuelPrice*100)/100;
			
			var avgFuelConsumption = totalFuelConsumption / (lengthOfTrack / 100);
			
			$('#routeInformation').append('<h2>'+name+'</h2>');
			$('#idleTime').append('<p><i class="icon-pause"></i>' + convertMilisecondsToTime(idleTime) + '</p>');
			$('#distTime').append('<p><i class="icon-globe"> </i>' + Math.round(lengthOfTrack*100)/100 + ' km</p>');
			$('#distTime').append('<p><i class="icon-time"> </i>' + convertMilisecondsToTime(duration) + '</p>');
			$('#fuelConsum').append('<p><img src="./assets/img/icon_durchschnitt.gif">' + Math.round(avgFuelConsumption*100)/100 + ' liter ' + (fuelType == 'diesel' ? '<?php echo $route_fuelDiesel; ?>' : '<?php echo $route_fuelGas; ?>') + '</p>');
			$('#fuelConsum').append('<p><i class="icon-fire"> </i>' + Math.round(totalFuelConsumption*100)/100 + ' liter ' + fuelPrice + ' €</p>');
			$('#co2').append('<p><i class="icon-leaf"></i>' + Math.round(totalCO2*100)/100 + ' kg</p>');
			
			
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
      		$('#avgSpeed').append(' <p><img src="./assets/img/icon_durchschnitt.gif">' + Math.round(data.statistics[i].avg) + ' km/h</p>');				
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
	
	function getFuelPrice(){	
	
		var url = 'http://export.benzinpreis-aktuell.de/exportdata.txt?';		
		
		$.get(
    		url,
    		{code : '69T36ft7QDY70L4'},
    		function(data) {
      	 	alert('page content: ' + data);
  		  	}
		);
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

var tour = new Tour();

function initShowTrack(){
 initMap();
 initChart();
 //addHeatmapLayer();
 //heatmap.setVisibility(false);

 

 tour.addSteps([
    {
        element: "#map", // string (jQuery selector) - html element next to which the step popover should be shown
        title: "Title of my popover", // string - title of the popover
        content: "Content of my popover" // string - content of the popover
    },
    {
        element: "#sensorswitch",
        title: "Title of my popover",
        content: "Content of my popover"
    },
    {
        element: "#chartContainer",
        title: "Title of my popover",
        content: "Content of my popover"
    }
  ]);

 //tour.start();

}

function initChart(){
  
  //defining data and setting up the hash for lookup
  var seriesData = [[],[],[]];
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
    //rpm
    seriesData[1][i] = {
      x: date,
      y: gon.measurements[i].rpm,
      label: "U/min"
    }
    //consumption
    seriesData[2][i] = {
      x: date,
      y: gon.measurements[i].consumption,
      label: "l/100 km"
    }
    dataHash[date] = new OpenLayers.Geometry.Point( coords[1], coords[2] ).transform(epsg4326, projectTo);
  }
  
  
  var chart = new CanvasJS.Chart("chartContainer", {
    zoomEnabled: true,
    panEnabled: true,
    legend: {
      horizontalAlign: "left", // left, center ,right 
      verticalAlign: "top",  // top, center, bottom
    },
    axisX:{
        valueFormatString: "hh:mm",
        includeZero: false
    },
    axisY: {
        title: '<?php echo $route_dropup_speed; ?>',
        titleFontSize: 15
    },
    axisY2: {
        title: "U/min",
        titleFontSize: 15
        //valueFormatString: " "
    },
    data: [//array of dataSeries
    { //dataSeries object

      /*** Change type "column" to "bar", "area", "line" or "pie"***/
      
      type: "spline",
      name: "<?php echo $route_dropup_speed; ?> in km/h",
      showInLegend: true,
      xValueType: "dateTime",
      dataPoints: seriesData[0]
    },
    { //dataSeries object

      /*** Change type "column" to "bar", "area", "line" or "pie"***/
      axisYType: "primary",
      type: "spline",
      name: "<?php echo $route_dropup_fuelConsumption; ?> in l/100 km",
      showInLegend: true,
      xValueType: "dateTime",
      dataPoints: seriesData[2]
    },
    { //dataSeries object

      /*** Change type "column" to "bar", "area", "line" or "pie"***/
      axisYType: "secondary",
      type: "spline",
      name: "U/min",
      showInLegend: true,
      xValueType: "dateTime",
      dataPoints: seriesData[1]
    }
    ]
  });

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
  map.addControl(new OpenLayers.Control.LayerSwitcher());
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


$('a#change-sensor-speed').click(function(){ changeSensor("speed");});
$('a#change-sensor-rpm').click(function(){ changeSensor("rpm");});
$('a#change-sensor-consumption').click(function(){ changeSensor("consumption");});

</script>

<?
include('footer.php');
?>
