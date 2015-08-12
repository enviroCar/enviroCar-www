requirejs.config({
    'baseUrl': '../lib',
    'paths': {
        'leaflet.wms': '../leaflet.wms' //.js'
    }
});

define(['leaflet', 'leaflet.wms'],
function(L, wms) {

var overlayMap = createMap('overlay-map', true);
//var tiledMap = createMap('tiled-map', true);

function createMap(div, tiled) {
    // Map configuration
    var map = L.map(div);
    map.setView([45, -93.2], 6);

    var basemaps = {
        'Basemap': basemap().addTo(map)
     };

    // Add WMS source/layers
    var source = wms.source(
        "http://ags.dev.52north.org:6080/arcgis/services/enviroCar/aggregation/MapServer/WMSServer?",
        {
            "format": "image/png",
            "transparent": true,
            "tiled": tiled
        }        
    );

    var layers = {
        'EnviroCar': source.getLayer("envirocar_aggregation.arcgis.aggregation"),
    };

    // Create layer control
    L.control.layers(null, layers).addTo(map);

    return map;
}

function basemap() {
    // Attribution (https://gist.github.com/mourner/1804938)
    var mqcdn = "http://otile{s}.mqcdn.com/tiles/1.0.0/{type}/{z}/{x}/{y}.png";
    var osmAttr = 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>';
    var mqTilesAttr = 'Tiles &copy; <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png" />';
    return L.tileLayer(mqcdn, {
        'subdomains': '1234',
        'type': 'map',
	'zIndex': -1,
        'attribution': osmAttr + ', ' + mqTilesAttr
    });
}

function blank() {
    var layer = new L.Layer();
    layer.onAdd = layer.onRemove = function() {};
    return layer;
}

// Export maps for console experimentation
return {
    'maps': {
        'overlay': overlayMap,
        'tiled': tiledMap
    }
};

});

