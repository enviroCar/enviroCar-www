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

include('header.php');
?>

<script type="text/javascript" src="./assets/OpenLayers/OpenLayers.light.js"></script>  
<script src="./assets/js/geojsontools.js"></script>
<script src="./assets/js/canvasjs.js" type="text/javascript"></script>
<link href="./assets/css/jquery.share.css" rel="stylesheet">


<div class="container leftband" id="route-information-container">
  <div class="row-fluid" >
    <div class="span10">
      <div id="routeInformation" style="margin-left: 30px;">
      </div>
      <ul class="inline-stats" id="statistics">
        <li><p id="dist"></p><p id="time"></p><span class="muted"><?php echo $route_distance; ?></span></li>
        <li><p id="avg-consum"></p><p id="total-consum"></p><span class="muted"><?php echo $route_fuelConsumption; ?></span></li>
        <li><p id="avg-co2"></p><p id="total-co2"></p><span class="muted"><?php echo $route_CO2; ?></span></li>
        <li><p><br></p><p id="idle-time"></p><span class="muted"><?php echo $route_idleTime; ?></span></li>
        <li><p><br></p><p id="avg-speed"></p><span class="muted"><?php echo $route_avgSpeed; ?></span></li>   
      </ul>
    </div>
    <div rel="tooltip" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo $route_sharing_info; ?>" class="onoffswitch">
      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="share-switch" onclick="toggleSharing()">
      <label class="onoffswitch-label" for="share-switch">
        <div class="onoffswitch-inner">
          <div class="onoffswitch-active"><div class="onoffswitch-switch"><?php echo $route_sharing_on; ?></div></div>
          <div class="onoffswitch-inactive"><div class="onoffswitch-switch"><?php echo $route_sharing_off; ?></div></div>
        </div>
      </label>
    </div>
    <div id="share-buttons" class="share-buttons">
      <a class='pop share-square share-square-googleplus-disabled'></a><a class='pop share-square share-square-facebook-disabled'></a><a class='pop share-square share-square-twitter-disabled'></a>
    </div>
  </div>
</div>

<div id="loadingIndicator_route" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>


<div class="row-fluid" id="full-map-span">
</div>

<div class="container leftband" id="map-and-chart-container">
<div class="row-fluid" id="mapAndChart">
<div class="span6" id="small-map-span">
    <div class="simple-map" id="map">
      <p id="enviroCar-license">Tracks ODbL by <a href="https://envirocar.org/terms.php">enviroCar</a></p>
      <div class="btn-group sensorswitch">
        <a class="btn btn-primary btn-full-screen" id="btn-full-screen"><?php echo $route_fullscreen ?></a>
        <div class="btn btn-group dropup">
          <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#" id="sensorswitch">
            Download
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
              <li id="download-geojson">
              </li>
              <li id="download-shapefile">
              </li>
              <li id="download-csv">
              </li>
          </ul>
        </div>
        <div class="btn btn-group dropup">
          <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#" id="sensorswitch">
            Sensor
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
              <li>
                <a id="change-sensor-consumption" ><?php echo $route_dropup_fuelConsumption; ?></a>
              </li>
              <li>
                <a id="change-sensor-rpm"><?php echo $route_dropup_rpm; ?></a>
              </li>
              <li>
                <a id="change-sensor-speed"><?php echo $route_dropup_speed; ?></a>
              </li>
              <li>
                <a id="change-sensor-intake-temp"><?php echo $route_dropup_intake_temp; ?></a>
              </li>
              <li>
                <a id="change-sensor-intake-pressure"><?php echo $route_dropup_intake_pressure; ?></a>
              </li>
              <li>
                <a id="change-sensor-co2"><?php echo $route_dropup_co2; ?></a>
              </li>
              <li>
                <a id="change-sensor-maf"><?php echo $route_dropup_maf; ?></a>
              </li>
          </ul>
        </div>
      </div>
      <div class="well" id="legend"  style="display:inline">
        <p><strong><?php echo $route_legend ?></strong></p>
        <p id="legend-title"><?php echo $route_legend_title.$route_dropup_speed ?></p>
        <table>
          <tr>
            <td><img src="./assets/img/legend_green.png" class="legend"></img></td>
            <td id="legend1"></td>
          </tr>
          <tr>
            <td><img src="./assets/img/legend_dark_green.png" class="legend"></img></td>
            <td id="legend2"></td>
          </tr>
          <tr>
            <td><img src="./assets/img/legend_orange.png" class="legend"></img></td>
            <td id="legend3"></td>
          </tr>
          <tr>
            <td><img src="./assets/img/legend_light_red.png" class="legend"></img></td>
            <td id="legend4"></td>
          </tr>
          <tr>
            <td><img src="./assets/img/legend_red.png" class="legend"></img></td>
            <td id="legend5"></td>
          </td>
        </table>
      </div>
  </div>
    </div>
  <div class="span6 graph-span">
    <div id="chartContainer" style="position: relative, height: 100%; width: 100%;"></div>
    <div class="dropdown" id="graph-dropdown">
      <a class="dropdown-toggle btn btn-primary" data-toggle="dropdown" href="#">
          Select Data
          <b class="caret"></b>
      </a>
      <div class="dropdown-menu graph-selection pull-right">
        <div class="span6">
        <p><strong>Primary Axis</strong></p>
              <label class="radio">
                  <input type="radio" name="primary" checked onclick="addSeries($.extend({},chartSeries[0]), 'primary')">
                  <?php echo $route_dropup_speed; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="primary" onclick="addSeries($.extend({},chartSeries[1]), 'primary')">
                  <?php echo $route_dropup_fuelConsumption; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="primary" onclick="addSeries($.extend({},chartSeries[2]), 'primary')">
                  <?php echo $route_dropup_intake_temp; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="primary" onclick="addSeries($.extend({},chartSeries[3]), 'primary')">
                  <?php echo $route_dropup_intake_pressure; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="primary" onclick="addSeries($.extend({},chartSeries[4]), 'primary')">
                  <?php echo $route_dropup_co2; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="primary" onclick="addSeries($.extend({},chartSeries[5]), 'primary')">
                  <?php echo $route_dropup_maf ?>
              </label>
        </div>
        <div class="span6">
        <p><strong>Secondary Axis</strong></p>
              <label class="radio">
                  <input type="radio" name="secondary" onclick="addSeries($.extend({},chartSeries[0]), 'secondary')">
                  <?php echo $route_dropup_speed; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="secondary" checked onclick="addSeries($.extend({},chartSeries[1]), 'secondary')">
                  <?php echo $route_dropup_fuelConsumption; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="secondary" onclick="addSeries($.extend({},chartSeries[2]), 'secondary')">
                  <?php echo $route_dropup_intake_temp; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="secondary" onclick="addSeries($.extend({},chartSeries[3]), 'secondary')">
                  <?php echo $route_dropup_intake_pressure; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="secondary" onclick="addSeries($.extend({},chartSeries[4]), 'secondary')">
                  <?php echo $route_dropup_co2; ?>
              </label>
              <label class="radio">
                  <input type="radio" name="secondary" onclick="addSeries($.extend({},chartSeries[5]), 'secondary')">
                  <?php echo $route_dropup_maf ?>
              </label>
        </div>
        
        
      </div>
    </div>
  </div>
</div>

</div>
<script type="text/javascript">
  


</script>

<?
include('footer.php');
?>
