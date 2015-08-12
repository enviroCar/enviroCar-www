requirejs.config({
    'baseUrl': 'assets/leaflet.wms/lib',
    'paths': {
        'leaflet.wms': '../leaflet.wms' //.js'
    }
});

define(['leaflet', 'leaflet.wms'],
    function(L, wms) {

        var overlayMap = createMap('overlay-map', true);

        function createMap(div, tiled) {
            var map = L.map(div);
            map.setView([51.9667, 7.6333], 9);

            var basemaps = {
                'Basemap': basemap().addTo(map)
            };

            var source = wms.source(
                "http://ags.dev.52north.org:6080/arcgis/services/enviroCar/aggregation/MapServer/WMSServer?",
                {
                    "format": "image/png",
                    "transparent": true,
                    "tiled": tiled
                }
            );

            var layers = {
                'enviroCar aggregation': source.getLayer("envirocar_aggregation.arcgis.aggregation")
            };

            for (var name in layers) {
                layers[name].addTo(map);
            }

            L.control.layers(null, layers).addTo(map);

            return map;
        }

        function basemap() {
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

    });
