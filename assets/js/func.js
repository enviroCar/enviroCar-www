/*
 * Functions for the website
 */
var testPoints = {"type":"FeatureCollection","features":[{"type":"Feature","properties":{"timestamp":"2013-02-06T12:58:22"},"geometry":{"type":"Point","coordinates":[7.6102587,51.9414473,0]}},{"type":"Feature","properties":{"hazardId":"27"},"geometry":{"type":"Point","coordinates":[7.614268,51.942944,0]}},{"type":"Feature","properties":{"description":null},"geometry":{"type":"Point","coordinates":[7.614486,51.942403,0]}},{"type":"Feature","properties":{"hazardId":"25","timestamp":"2013-02-06T11:08:47","description":null},"geometry":{"type":"Point","coordinates":[7.61356,51.941266,0]}},{"type":"Feature","properties":{"hazardId":"11","timestamp":"2013-02-04T16:03:38","description":"evaluation hazards"},"geometry":{"type":"Point","coordinates":[7.616154,51.962964,0]}},{"type":"Feature","properties":{"hazardId":"10","timestamp":"2013-02-04T16:03:15","description":"evaluation hazards"},"geometry":{"type":"Point","coordinates":[7.616261,51.964518,0]}}]};
var testGeom = { "type": "LinesString",
  "coordinates": [100.0, 0.0]
  };
var func = (function () {
    "use strict";

    var f = {
        convert: function () {
            var input = $('#input').val();
            var output = JSON.stringify(GeoJSONTools.points_to_lineString($('#input').val(),{ignoreProperties: true}));
            $('#input').val(JSON.stringify($('#input').val(),null,2));
            $('#output').val(JSON.stringify(output,null,2));
            //$('#output').val(formatter.formatJson($('#output').val()));
        },
        test: function () {
            var input = $('#input').val();
			console.log(GeoJSONTools.parse(input));
        }
    };

    return f;
}());

//console.log(GeoJSONTools.parse(testPoints));
