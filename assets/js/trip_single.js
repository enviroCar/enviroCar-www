function init() {

  var map = new OpenLayers.Map("map", {controls:[]});//, {controls:[]});

  var osm = new OpenLayers.Layer.OSM();
  var vectorLayer = new OpenLayers.Layer.Vector("Overlay");
  map.addLayers([osm, vectorLayer]);

  var style = {
    strokeColor: '#0000ff',
    strokeOpacity: 0.8,
    strokeWidth: 10
  };



  epsg4326 =  new OpenLayers.Projection("EPSG:4326"); //WGS 1984 projection
  projectTo = map.getProjectionObject(); //The map projection (Spherical Mercator)

  var lonLat = new OpenLayers.LonLat(-0.12, 51.503 ).transform(epsg4326, projectTo);

  //Get the coordinates from the gon measurements
  var gonPoints = [];
  for(var i=0; i<track.features.length; i++) {
    var measurement = track.features[i];
    gonPoints.push(
      new OpenLayers.Geometry.Point( measurement.geometry.coordinates[0], measurement.geometry.coordinates[1] ).transform(epsg4326, projectTo)
    )
  }
  
  var feature = new OpenLayers.Feature.Vector(
    new OpenLayers.Geometry.LineString(gonPoints),
    null,
    style
  );

  vectorLayer.addFeatures(feature);

  var bounds = new OpenLayers.Bounds();

  if(gonPoints) {
    if(gonPoints.constructor != Array) {
      gonPoints = [gonPoints];
    }

    // Iterate over the features and extend the bounds to the bounds of the geometries
    for(var i=0; i<gonPoints.length; i++) {
      if (!bounds) {
        bounds = gonPoints[i].getBounds();
      } else {
        bounds.extend(gonPoints[i].getBounds());
      }
    }
  }
  map.zoomToExtent(bounds);
 
}

window.onload = init;