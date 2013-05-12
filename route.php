<?
include('header.php');
?>

<script src="./assets/OpenLayers/OpenLayers.js"></script>
<style>
	  img.olTileImage {
        max-width: none;
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
      <p>Start: 28.04.2013 00:47</p>
		  <p>End: 28.04.2013 01:05</p>
		  <p>Duration: 0:18 h</p>
		  <p>Length: 10.4 km</p>
		  <p>Fuel consumption: 0,52 l</p>
		  <p>Average consumption: 5 l per 100 km</p>
		  <p>Average speed: 35.4 km/h</p>
          <p><a class="btn" href="graph.php">Graphs</a><a class="btn" href="heatmap.php">Thematic maps</a></p>
    </div>

    <div class="span7 mapContainer">
      <div id="map" style="height: 100%; width:100%;">
      </div>
    </div>	
  </div>
	
	  <script type="text/javascript">
        var map = new OpenLayers.Map('map');
        var mapnik = new OpenLayers.Layer.OSM();
        map.addLayer(mapnik);
        map.setCenter(new OpenLayers.LonLat(7.63,51.96) // Center of the map
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            new OpenLayers.Projection("EPSG:900913") // to Spherical Mercator Projection
          ),12
        );
		
		
		// var overlay = new OpenLayers.Layer.Vector("Routes");
		
		var style_blue = OpenLayers.Util.extend();
            style_blue.strokeColor = '#0065A0';
            style_blue.strokeWidth = 3;
		
		var overlay = new OpenLayers.Layer.Vector("GPX-Track",
                             {protocol:   new OpenLayers.Protocol.HTTP({   
                                                       url:             "./assets/track1.gpx",
                                                       format:          new OpenLayers.Format.GPX }),
                              styleMap:   new OpenLayers.StyleMap({ 
                                                       strokeColor:     "#0065A0", 
                                                       strokeWidth:     3}),
                              strategies: [new OpenLayers.Strategy.Fixed()],
                              projection: new OpenLayers.Projection("EPSG:4326")
                              }); 

		map.addLayer(overlay);
			
      </script>	  

<?
include('footer.php');
?>
