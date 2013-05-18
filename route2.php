<?
include('header.php');
?>

<script src="./assets/OpenLayers/OpenLayers.js"></script>
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
    

</style>

<div class="container">
  <div class="span5">
      <h2>Route 1</h2>
      <p>Start: 28.04.2013 14:45</p>
      <p>End: 28.04.2013 15:00</p>
      <p>Duration: 0:15 h</p>
      <p>Length: 5.3 km</p>
      <p>Fuel consumption: 0,265 l</p>
      <p>Average consumption: 5 l per 100 km</p>
      <p>Average speed: 21.2 km/h</p>
          <p><a class="btn" href="graph2.php">Graphs</a><a class="btn" href="heatmap.php">Thematic maps</a></p>
    </div>

    <div class="span7 mapContainer">
      <div id="map" style="height: 100%; width:100%;">
      </div>
    </div>  
  </div>

	
<script type="text/javascript">

  function onFeatureSelect(feature){
    console.log(feature);
  }

  function onFeatureUnselect(feature){
      
  }


    var map = new OpenLayers.Map('map');
    var mapnik = new OpenLayers.Layer.OSM();
    map.addLayer(mapnik);
    map.setCenter(new OpenLayers.LonLat(7.63,17.96) // Center of the map
      .transform(
        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
        new OpenLayers.Projection("EPSG:900913") // to Spherical Mercator Projection
      ),12
    );
		
/*
    var co2_style = new OpenLayers.StyleMap({ 
            "default": new OpenLayers.Style({ 
                fillColor: "#FF0066",//"${getColor}",
                strokeWidth: 1,             
                strokeColor: "#000", 
                fillOpacity: 1,
				pointRadius: 20
                //label: "${getLabel}"                  
            },
            {
                context: {
                    getColor : function (feature) {
                        console.log('jow');
                        return '#FF0066';
                        /* 
                        return feature.attributes.phenomenons[0].value > 20 ? '#FF0066' :
                               feature.attributes.phenomenons[0].value > 10 ? '#FF5A08' :
                                                                  '#08FF41' ;
                                                                  *//*
                    }
                } 
            })
    }); 
	*/
	
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
	var geojson_layer = new OpenLayers.Layer.Vector("Measurements",{styleMap: co2_style});
									
		
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
			

  $.get('http://giv-cario.uni-muenster.de/working-folder/assets/includes/get.php?url=http://giv-car.uni-muenster.de:8080/dev/rest/tracks/51944e28e4b017df94de8e2d&auth=true', function(data) {
    geojson_layer.addFeatures(geojson_format.read(data));
  });


</script>	  

<?
include('footer.php');
?>
