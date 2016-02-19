<?php 
/*
* This file is part of enviroCar.
* 
* enviroCar is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* enviroCar is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with enviroCar.  If not, see <http://www.gnu.org/licenses/>.
*/

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
		<div style="float:right; display:inline;">
		  	<input type="text" 	id="radius" placeholder="Radius" value=""/>
		  	<input type="text" 	id="valMin" placeholder="Min Value" value=""/>
		  	<input type="text" 	id="valMax" placeholder="Max Value" value=""/>
		</div>

		<div class="btn-group" style="float:right">
		  <button class="btn btn-small">Choose Sensor</button>
		  <button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
		  </button>
		  <ul id="sensorsDropdown" class="dropdown-menu">

		  </ul>
		</div>
	</div>

	<div id="map" style="width: 100%; height: 512px; padding-top:20px !important" class="smallmap">
	</div>
	<p style="float:right; z-index:5000;"><a class="btn" href="routes.php">Route overview</a></p>
</div>

<style type="text/css">
	.olControlAttribution{
		bottom:0px;

	}
</style>

<script type="text/javascript">

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

	var valMin = 0;
	var valMax = 1;
	var sensors = null;
	var sensor = null;
	var radius = 20;

	var raster = new OpenLayers.Layer.OSM("osm");



	var vector = new OpenLayers.Layer.Vector("heatmap", {
	// use the heatmap renderer instead of the default one (SVG, VML or Canvas)
	    renderers: ['Heatmap'],
	    protocol: new OpenLayers.Protocol.HTTP({
	        url: 'assets/includes/users.php?track='+$_GET(['id']),
	        format: new OpenLayers.Format.GeoJSON()

	    }),
	    styleMap: new OpenLayers.StyleMap({
	        "default": new OpenLayers.Style({
	            pointRadius: 20,
	            weight: "${weight}"
	        }, {
	            context: {
					// the 'weight' of the point (between 0.0 and 1.0), used by the heatmap renderer
	                weight: function(f) {
	                    return mapValue(f.attributes.phenomenons, valMin, valMax);
	                }
	            }
	        })
	    }),
	    strategies: [new OpenLayers.Strategy.Fixed()],
	    eventListeners: {
	        featuresadded: function(evt) {
	            this.map.zoomToExtent(this.getDataExtent());
	        }
	    }
	});
	var map = new OpenLayers.Map("map", {
	    layers: [raster, vector]
	});

	var heatmapStyle = null;

	function newHeatmap(){
		heatmapStyle = new OpenLayers.StyleMap({
	        "default": new OpenLayers.Style({
	            pointRadius: radius,
	            weight: "${weight}"
	        }, {
	            context: {
	// the 'weight' of the point (between 0.0 and 1.0), used by the heatmap renderer
	                weight: function(f) {
	                    return mapValue(f.attributes.phenomenons, valMin, valMax);
	                }
	            }
	        })
		});
	}



	function mapValue(x, in_min, in_max) {
		for(property in x){
			if(x[property].name === sensor.name){
				x = x[property].value;
				break;
			}
		}
        return (x - in_min) * (1 - 0) / (in_max - in_min) + 0;
    }

	function changeHeatmapStyle(style){
		vector.styleMap = style;
		map.getLayersByName("heatmap")[0].refresh();

	}

	function changeSensor(chosenSensor){
		for(property in sensors){
			if($('#radius').val()!= "") radius = $('#radius').val();
			if($('#valMin').val()!= "") valMin = $('#valMin').val();
			if($('#valMax').val()!= "") valMax = $('#valMax').val();

			if(sensors[property].name === chosenSensor){
				sensor = sensors[property];
				newHeatmap();
				changeHeatmapStyle(heatmapStyle);
				break;
			}
		}
	}

	$.get('assets/includes/users.php?track='+$_GET(['id']), function(data) {
    if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404){
        console.log('error while receiving track');
    }else{
      
      data = JSON.parse(data);
      sensors = data.features[0].properties.phenomenons;
      for (property in sensors) { 
      	sensor = sensors[property];
      	$('#sensorsDropdown').append('<li><a href="javascript:changeSensor(\''+sensors[property].name+'\')">'+sensors[property].name+'</a></li>');
      }


    }

   	$('#loadingIndicator').hide(); 
    
  });



</script>



<?php 
include('footer.php');