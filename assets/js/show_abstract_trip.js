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

function init(){
 initMap();
 initChart();
 addHeatmapLayer();
 heatmap.setVisibility(true);
}

function initChart(){
  
  //defining data and setting up the hash for lookup
  var seriesData = [[],[],[]];
  epsg4326 =  new OpenLayers.Projection("EPSG:4326"); //WGS 1984 projection
  projectTo = map.getProjectionObject();

  for(var i = 0; i < gon.measurements.length; i++) {
    var coords = gon.measurements[i].latlon.replace("(", "").replace(")","").split(" ")
    var date = new Date(gon.measurements[i].recorded_at).getTime();
    //co2
    seriesData[0][i] = {
      x: date,
      y: gon.measurements[i].co2,
      label: "kg/100 km"
    }
    //consumption
    seriesData[1][i] = {
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
        title: "Verbrauch",
        titleFontSize: 15
        //valueFormatString: " "
    },
    axisY2: {
        title: "CO2",
        titleFontSize: 15
        //valueFormatString: " "
    },
    data: [//array of dataSeries
    { //dataSeries object

      /*** Change type "column" to "bar", "area", "line" or "pie"***/
      axisYType: "secondary",
      type: "spline",
      name: "CO2 in kg/100 km",
      showInLegend: true,
      xValueType: "dateTime",
      dataPoints: seriesData[0]
    },
    { //dataSeries object

      /*** Change type "column" to "bar", "area", "line" or "pie"***/
      axisYType: "primary",
      type: "spline",
      name: "Verbrauch in l/100 km",
      showInLegend: true,
      xValueType: "dateTime",
      dataPoints: seriesData[1]
    }
    ]
  });

  chart.render();
}

function initMap() {

  var osm = new OpenLayers.Layer.OSM("Base Layer");
  vectorLayer = new OpenLayers.Layer.Vector("Driven Route");
  map.addLayers([osm, vectorLayer]);

  //map.addControl(new OpenLayers.Control.PanZoomBar());
  map.addControl(new OpenLayers.Control.LayerSwitcher());
  //map.addControl(new OpenLayers.Control.MousePosition());
  //map.addControl(new OpenLayers.Control.OverviewMap());
  //map.addControl(new OpenLayers.Control.KeyboardDefaults());
  //map.addControl(new OpenLayers.Control.DragPan());
  map.events.register("move", map, function() {
            postAnalytics();
        });

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
      new OpenLayers.Feature.Vector(g, {count: measurement.consumption})
    )
  }

  //create our vectorial layer using heatmap renderer
  heatmap = new OpenLayers.Layer.Vector("Heatmap Layer", {
    visibility: true,
    renderers: ['Heatmap'],
    rendererOptions: {
      weight: 'count',
      heatmapConfig: {
        "radius": 10,
        "visible": true,
        "opacity": 40,
        "gradient": { 0.45: "rgb(0,0,255)", 0.55: "rgb(0,255,255)", 0.65: "rgb(0,255,0)", 0.95: "yellow", 1.0: "rgb(255,0,0)" }
      }
    }
  });
  heatmap.addFeatures(features);
  map.addLayers([heatmap]);
}

function selectPoint(point){
  postAnalytics();
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

function changeSensor(sensor){
    for(i = 0; i < vectorLayer.features.length; i++){
        var style = {
          strokeColor: getColor(sensor, gon.measurements[i][sensor]), 
          strokeOpacity: 0.8,
          strokeWidth: 5
        };
        vectorLayer.features[i].style = style;
    }
    vectorLayer.redraw();
}

function getColor(sensor, value){
    var steps = gon.statistics["max_" + sensor]/5;
    if(value < steps) return "#1BE01B";
    else if(value < steps * 2) return "#B5E01B";
    else if(value < steps * 3) return "#E0C61B";
    else if(value < steps * 4) return "#E08B1B";
    else return "#E01B1B";
}

var lastPost = new Date().getTime();
function postAnalytics(){
  if(lastPost != 0 && (new Date().getTime() - lastPost) > 3000){
    console.log("interaction");
    $.post("http://giv-dueren.uni-muenster.de/analytics/create", { user_id: gon.user, group: gon.user_group, action_name: gon.params.action, url: "/" + gon.params.controller + "/" + gon.params.action + "/", category: "interaction", description: JSON.stringify(gon.params) } );

    lastPost = new Date().getTime();
  }
}

//call init
window.onload = init;

$('a#change-sensor-speed').click(function(){ changeSensor("speed");});
$('a#change-sensor-rpm').click(function(){ changeSensor("rpm");});
$('a#change-sensor-consumption').click(function(){ changeSensor("consumption");});

