/*
 * TODO: write geoJSON validator
 *          incorporate formatter into validator
 *       build reversing function
 */

var GeoJSONTools = (function () {
    "use strict";
    var _geoJSONTemplate = function (features) {
            return {"type": "FeatureCollection", "features": features};
        };
    var _lineStringTemplate = function (coordinates, properties) {
        return {"type":"Feature", "geometry":{"type":"LineString", "coordinates":coordinates}, "properties":properties};
    };
    var _pointsTemplate = function (coordinates, properties) {
        return {"type":"Feature", "geometry":{"type":"Point", "coordinates":coordinates}, "properties":properties};
    };
    var _createNullArray = function (length) {
        var arr = [], i = length;
        while (i !== 0) {
            i = i - 1;
            arr[i] = null;
        }
        return arr;
    };
    var _findAdditionalProperties = function (a, b) {
        var keysA = Object.keys(a),
            out = [],
            key;

        for (key in b) {
            if (b.hasOwnProperty(key)) {
                if (keysA.indexOf(key) === -1) {
                    out.push(key);
                }
            }
        }
        return out;
    };
    var _createLineString = function (coordinates, properties) { //assemble a LineString
        return _geoJSONTemplate(_lineStringTemplate(coordinates, properties));
    };
    var _reverseArray = function (array) {
        var out = array,
            left = null,
            right = null,
            temporary;
        for (left = 0, right = out.length - 1; left < right; left += 1, right -= 1) {
            temporary = out[left];
            out[left] = out[right];
            out[right] = temporary;
        }
        return out;
    };
    var ptToLsOptions = {
        ignoreProperties:false
    };
    var public_gjt = {
        parse:function (geojson) {
            var input = {},
                //test an array if it contains two valid coordinates
                //assumes parameter point to be an array.
                testPointCoordinate = function (point) {
                    if(point.length === 2 || point.length === 3){
						var good = true;
						for(var i = 0; i<point.length; i++){
							if(isNaN(parseFloat(point[i]))){
								throw new Error("error: point coordinates not float");
							}	
						}
						return true;
                    } else {
                        throw new Error("error: invalid coordinate count");
                    }
                },                
                //test if the contents of an array 
                checkMultiPointLineString = function (coords) {
                    for(var i = 0; i< coords.length; i++){
                        if(Array.isArray(coords[i])){
                            return testPointCoordinate(coords[i]);
                        }else{
                            throw new Error("error: invalid coordinates");
                        }
                    }
                },
				checkMultiLineString = function (coords) {
					for(var i = 0; i< coords.length; i++){
						return checkMultiPointLineString(coords[i]);
					}
				},
                testGeometry = function (geometry) {
					if(Array.isArray(geometry.coordinates)){
						switch (geometry.type) {
							case "Point":
								return testPointCoordinate(geometry.coordinates);
							case "MultiPoint":
								return checkMultiPointLineString(geometry.coordinates);
							case "LineString":
								return checkMultiPointLineString(geometry.coordinates);
							case "MultiLineString":
								return checkMultiLineString(geometry.coordinates);
							case "Polygon":
								throw new Error("error: Polygon not implemented yet");
								break;
							case "MultiPolygon":
								throw new Error("error: MultiPolygon not implemented yet");
								break;
							default:
								throw new Error("error: unknown Geometry type '"+geometry.type+"'");
								break;
						}
					}else{
						throw new Error("error: property 'coordinates' not of type Array");
					}
                },
				testFeature = function (feature) {
					if(feature.hasOwnProperty('geometry')){
						return testGeometry(feature.geometry);
					} else {
						throw new Error("error: missing 'geometry' property");
					}
					if(!feature.hasOwnProperty('properties')){
						throw new Error("error: missing 'properties' property");
					}
				},
				testFeatureCollection = function (featureCollection) {
					if(featureCollection.hasOwnProperty('features')){
						if(Array.isArray(featureCollection.features)){
							for(var i = 0; i< featureCollection.features.length; i++){
								return testFeature(featureCollection.features[i]);
							}
						} else {
							throw new Error("error: property 'features' not of type Array");
						}
					} else {
						throw new Error("error: missing 'features' property");
					}
				};
			//determine if the input is already valid json
			if (typeof geojson === 'string'){
				input = jsonlint.parse(geojson);
			} else {
				input = geojson;
			}
			
            for (var key in input) {
                if (input.hasOwnProperty(key)) {
                    if (key === "type") {
                        if (input[key] === "Point" || 
							input[key] === "MultiPoint" || 
							input[key] === "LineString" || 
							input[key] === "MultiLineString" || 
							input[key] === "Polygon" || 
							input[key] === "MultiPolygon") {
								if(input.hasOwnProperty('coordinates')){
									return testGeometry(input);
								}else{
									throw new Error("error: missing property 'coordinates'");
								}
                        } else if (input[key] === "Feature") {
                            return testFeature(input);
						} else if (input[key] === "FeatureCollection") {
							return testFeatureCollection(input);
						} else if (input[key] === "GeometryCollection") {
							console.log('this is a GeometryCollection');
                        } else {
                            throw new Error("error: invalid value in property 'type'");
                        }
                    } else {
						throw new Error("error: missing property 'type'");
                    }
                }
            }

        },
        /* converts a GeoJson FeatureCollection consisting of points to
         * a FeatureCollection containing one Linestring
         * params: geojson: a valid GeoJSON Object
         *         options: a Object containing options regarding the conversion
         *               ignoreProperties: tells the converter to ignore the properties of the input
         */
        points_to_lineString:function (geojson, options) {
            var input = JSON.parse(geojson), //use jsonlint to check for valid JSON
                output_coordinates = [],
                output_properties = {},
                ct_properties = 0,
                i,
                j,
                key,
                additional_props;

            if (options === undefined) {
                options = ptToLsOptions;
            }

            //iterate over the input
            for (i = 0; i < input.features.length; i = i + 1) {
                if (options.hasOwnProperty("ignoreProperties") && options.ignoreProperties !== true) {
                    //has the current feature the same properties as its predecessor?
                    additional_props = _findAdditionalProperties(output_properties, input.features[i].properties);
                    if (i !== 0 && additional_props.length !== 0) {
                        //add the additional properties to the output_properties with null values
                        for (j = 0; j < additional_props.length; j = j + 1) {
                            Object.defineProperty(output_properties, additional_props[j], {value:_createNullArray(i), writable:true, enumerable:true, configurable:true});
                        }
                    }
                    //save the current count of properties
                    ct_properties = Object.keys(input.features[i].properties).length;

                    //create the properties in the output_properties
                    for (key in input.features[i].properties) {
                        if (input.features[i].properties.hasOwnProperty(key)) {
                            if (!output_properties.hasOwnProperty(key)) { //if the output dont have the property,.
                                Object.defineProperty(output_properties, key, {value:[], writable:true, enumerable:true, configurable:true});//create an array with the property name.
                            }
                        }
                    }

                    //input the properties to the output arrays
                    for (key in output_properties) {
                        if (output_properties.hasOwnProperty(key)) {
                            if (input.features[i].properties.hasOwnProperty(key)) {
                                output_properties[key].push(input.features[i].properties[key]); //add value to array
                            } else { // if there is no value for the current property
                                output_properties[key].push(null); //add null
                            }
                        }
                    }
                }
                //append the coordinates
                output_coordinates.push(input.features[i].geometry.coordinates);
            }

            return _createLineString(output_coordinates, output_properties);
        },
        reverse:function (geojson) {
            var input = jsonlint.parse(geojson);

            //determine the type of the input
            for (var i = 0; i < input.features.length; i = i + 1) {
                //cont when geojsonlint is ready
                console.log('not ready');
            }
        }
    };
    return public_gjt;
}());
