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
?>
<script src="http://js.arcgis.com/3.14/"></script>
<script src="./assets/leaflet.wms/lib/require.js" data-main="./assets/js/index.js.php"></script>
<script type="text/javascript">

$(document).ready(function() {
	var src = "";

	$('.modal').bind('hide', function () {
		var iframe = $(this).children('div.modal-body').find('iframe'); 
		src = iframe.attr('src');
		iframe.attr('src', '');
	});

	$('.modal').bind('show', function () {
		if(src != ""){
			var iframe = $(this).children('div.modal-body').find('iframe'); 
			iframe.attr('src', src);
		};
	});

    var map;

    require(["esri/map", "esri/layers/WMSLayer", "esri/config", "esri/urlUtils", "dojo/domReady!"],
        function(Map, WMSLayer, esriConfig, urlUtils) {

            esriConfig.defaults.io.proxyUrl = "assets/proxy/PHP";

            urlUtils.addProxyRule({
                urlPrefix: "ags.dev.52north.org",
                proxyUrl: "assets/proxy/PHP/proxy.php"
            });

            map = new Map("overlay-map", {
                basemap: "streets",
                center: [7.6333,51.9667],
                zoom: 9
            });

            var layer1 = new esri.layers.WMSLayerInfo({name:"envirocar_aggregation.arcgis.aggregation",title:"envirocar_aggregation.arcgis.aggregation"});
            var resourceInfo = {
                extent: new esri.geometry.Extent(-126.40869140625,31.025390625,-109.66552734375,41.5283203125,{wkid: 4326}),
                layerInfos: [layer1]
            };

            var wmsLayer = new WMSLayer("http://ags.dev.52north.org:6080/arcgis/services/enviroCar/aggregation/MapServer/WMSServer?", {
                format: "png",
                resourceInfo: resourceInfo,
                visibleLayers: ['envirocar_aggregation.arcgis.aggregation']
            });

            map.addLayer(wmsLayer);
        });
});
</script>