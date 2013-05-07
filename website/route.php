<?
include('header.php');
?>

<script src="../assets/OpenLayers/OpenLayers.js"></script>
<style>
	  img.olTileImage {
        max-width: none;
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
          <p><a class="btn" href="#">View details &raquo;</a></p>
    </div>

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="span5" id="map" style="top: 0; left: 0; bottom: 0; right: 0; position: fixed;"></div>
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
		
		
		var overlay = new OpenLayers.Layer.Vector("Routes");
		
		var style_blue = OpenLayers.Util.extend();
            style_blue.strokeColor = '#0065A0';
            style_blue.strokeWidth = 3;
		
		var point1 = [];
		point1[0] = new OpenLayers.Geometry.Point(7.63,51.96).transform("EPSG:4326", "EPSG:900913");
        point1[1] = new OpenLayers.Geometry.Point(7.64,51.97).transform("EPSG:4326", "EPSG:900913");
        point1[2] = new OpenLayers.Geometry.Point(7.645,51.967).transform("EPSG:4326", "EPSG:900913");
        point1[3] = new OpenLayers.Geometry.Point(7.653,51.95).transform("EPSG:4326", "EPSG:900913");
        point1[4] = new OpenLayers.Geometry.Point(7.66,51.945).transform("EPSG:4326", "EPSG:900913");

        
		var line1 = new OpenLayers.Geometry.LineString(point1);
		var lineFeature1 = new OpenLayers.Feature.Vector(line1, null, style_blue);

		map.addLayer(overlay);
		overlay.addFeatures(lineFeature1);
			
      </script>	  

<?
include('footer.php');
?>