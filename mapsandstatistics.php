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

require_once('./assets/includes/authentification.php');
$logged_in = false; 
if(!is_logged_in()){
        $logged_in = false; 
        include('header-start.php');
}else{
        $logged_in = true;
        include('header.php');
}
?>
	<div id="data-preview" class="container">
		<div class="row-fluid">
			<div class="span6 well data-preview leftband first-row">
				<div class="span4">
					<a href="http://52north.maps.arcgis.com/apps/webappviewer/index.html?id=602699b2f09340f6bd4086cacf2916d4" class="thumbnail" target="_blank" title="Live track overview map">
						<img src="http://52north.maps.arcgis.com/sharing/rest/content/items/602699b2f09340f6bd4086cacf2916d4/info/thumbnail/aggregation_thumbnail.png" alt="map preview">
					</a>
				</div>
	      <div class="span8">
			<h2> <?php echo $speed_titel ?></h2>
	        <?php echo $speed_description ?>       
	      </div>
			</div>
			<div class="span6 well data-preview leftband first-row">
			<div class="span4">
					<a href="http://www.arcgis.com/home/webmap/viewer.html?webmap=5db4e1ea445e4b4b8612443e7ba76119" class="thumbnail" target="_blank" title="CO2 Hotspot Analysis Map">
						<img src="http://www.arcgis.com/sharing/rest/content/items/5db4e1ea445e4b4b8612443e7ba76119/info/thumbnail/ago_downloaded.png" alt="map preview">
					</a>
				</div>
	        <div class="span8">
	        	<h2><?php echo $hotspot_titel ?></h2>
	          <?php echo $hotspot_description ?>       
	        </div>
			</div>
		</div>
	</div>




	<div id="data-preview" class="container">
		<div class="row-fluid">
			<div class="span6 well data-preview leftband">
			<div class="span4">
					<a href="http://rpubs.com/edzer/enviroCar" target="_blank" class="thumbnail" title="Analyzing enviroCar trajectories with R">
						<img src="./assets/img/analyzing_with_R_thumb.jpg" alt="Thumbnail of R analysis script for envirocar data">
					</a>
				</div>
	        <div class="span8">
	        	<h2><?php echo $analyzing_with_R_titel ?></h2>
	          <?php echo $analyzing_with_R_description ?>         
	        </div>
			</div>
			<div class="span6 well data-preview leftband first-row">
			<div class="span4">
					<a href="http://52north.maps.arcgis.com/home/index.html" class="thumbnail" target="_blank" title="ArcGIS Online enviroCar page">
						<img src="./assets/img/agol_thumb.png" alt="preview">
					</a>
				</div>
	        <div class="span8">
	        	<h2><?php echo $agol_titel ?></h2>
	          <?php echo $agol_description ?>       
	        </div>
			</div>
		</div>
	</div>





<?php 
include('footer.php');
