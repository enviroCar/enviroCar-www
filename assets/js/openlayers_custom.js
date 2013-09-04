var map, layer;
function init() { 
    // Define a new map.  We want it to be loaded into the 'map_canvas' div in the view
    map = new OpenLayers.Map('map');

    // Add a LayerSwitcher controller
    map.addControl(new OpenLayers.Control.LayerSwitcher());

    // OpenStreetMaps
    var osm = new OpenLayers.Layer.OSM();

    // Add the layers defined above to the map  
    map.addLayers([osm]);

    // Set some styles 
    var myStyleMap = new OpenLayers.StyleMap({
        'strokeColor': 'magenta',
        'strokeOpacity': 1.0,
        'strokeWidth': 2
    });

    var lon = 5;
    var lat = 40;
    var zoom = 5;

    var featurecollection = {
        "type": "FeatureCollection",
        "features": [
          {
                    "type": "Feature",
                    "geometry": {
                            "type": "Point",
                            "coordinates": [15.87646484375, 44.1748046875]
                        },
                "properties": {}
            }
        ]
    };
    
    var geojson_format = new OpenLayers.Format.GeoJSON({
        'internalProjection': new OpenLayers.Projection("EPSG:900913"), //900913 for Google
        'externalProjection': new OpenLayers.Projection("EPSG:4326")
    });
    
    var vector_layer = new OpenLayers.Layer.Vector();
    map.addLayer(vector_layer);
    vector_layer.addFeatures(geojson_format.read(featurecollection));
    map.setCenter(new OpenLayers.LonLat(lon, lat), zoom);
    
/*    var url = "/measurement/1.json"
    OpenLayers.loadURL(url, {}, null, function (response){
    var geojson_format = new OpenLayers.Format.GeoJSON({
        'internalProjection': new OpenLayers.Projection("EPSG:900913"), //900913 for Google
        'externalProjection': new OpenLayers.Projection("EPSG:4326")
    });
    
    var vector_layer = new OpenLayers.Layer.Vector();
    map.addLayer(vector_layer);
    vector_layer.addFeatures(geojson_format.read(response.responseText));
    map.setCenter(new OpenLayers.LonLat(lon, lat), zoom);
  })*/
    
}

window.onload = init;