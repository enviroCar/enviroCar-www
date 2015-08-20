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
<meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no">
<link rel="stylesheet" href="http://js.arcgis.com/3.14/dijit/themes/claro/claro.css">
<link rel="stylesheet" href="http://js.arcgis.com/3.14/esri/css/esri.css">
<div class="container custom rightband" style="background-image: url(./assets/img/marketing/envCar_Foto19.jpg); width 100%; height: 250px; background-size: cover;">
    <div class="row">
		<div class="span4">
			<!-- <div class="chart">
			  <div style="width: 25%;">23</div>
			  <div style="width: 50%;">42</div>
			</div> -->
		</div>
		<!--<div id="cover-text" class="span4 offset3">
			<a data-toggle="modal" href="#myModal" data-youtube-id="_AyXNeRbpRk"><img id="youtube-thumb" src="./assets/img/youtube_thumb.jpg" style="width: 275px; height: 156px;"></a>
		  <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div id="myModal-body" class="modal-body">
			    <iframe width="560" height="315" src="https://www.youtube.com/embed/LTSuUEOfWa0?rel=0" frameborder="0" allowfullscreen></iframe>
			  </div>
			</div>
		</div>-->
	</div> 
</div>

    <!--<div class="row-fluid">
     	<div class="span12" style="margin: 0; padding: 0; background-image: url(./assets/img/marketing/envCar_Foto13.jpg); height: 250px; width 100%; background-size: cover;"></div> 
     	<a class="video-thumbnail" data-toggle="modal" href="#myModal" data-youtube-id="_AyXNeRbpRk"><img src="http://d1ncmx5azicmvc.cloudfront.net/website/img/video-thumbnail.79e01a2f7bb8.png" style="display:none;" onload="imageLoad()"></a>
		  <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			  <div class="modal-body">
			    <iframe width="560" height="315" src="http://www.youtube.com/embed/30Pjl31cyDY?rel=0" frameborder="0" allowfullscreen></iframe>
			  </div>
			</div>
	<div class="container" style="margin: 0; padding: 0; background-image: url(./assets/img/marketing/envCar_Foto13.jpg); height: 250px; width 100%; background-size: cover;">
		<div class="row">
			<div class="span4 offset6 well">
			<p>asddas</p>
			</div>
		</div>
	 </div>
    </div>
  </div> -->

	<div class="container custom leftband">
	<div class="row-fluid">
        <div class="span4">
<a class="twitter-timeline" href="https://twitter.com/enviroCar_org" data-chrome="noscrollbar" data-widget-id="335068168525578241">Tweets von @enviroCar_org</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

       </div>
        <div class="span6">
          <h2><? echo $envirocar;?> <span class="muted"><? echo $index_here_we_go;?></span></h2>
          
          <p>
			<? echo $index_this_is_community;?></p>
        </div>
  <!--      <div class="span4">
          <h2><? echo $index_support_indiegogo;?></h2>
          <a href="http://www.indiegogo.com/projects/envirocar" target='_blank'>
            <img style="width:70%;" src="http://www.indiegogo.com/assets/igg_logo_color_print_black_h.jpg"/>
          </a>
        </div>-->
      </div>

	</div>

	<div class="container custom leftband">
      <div class="row-fluid">
       <div class="span6" style="margin-left:10px;">
<!--		<img class="featurette-image pull-right" src="./assets/img/enviroCarConceptOverview.png" style="width: 40%; padding: 3%" alt=""/>-->
		<h2><? echo $index_be_a_citizen_scientist;?></h2>
		<p><? echo $index_help_the_world;?></p>

		</div>
          <div class="span5">
              <iframe width="480" height="340" style="z-index:-9999; border:none;" src="//www.youtube.com/embed/LTSuUEOfWa0?rel=0&amp;wmode=transparent" allowfullscreen></iframe>
          </div>
      </div>
	</div>

<div class="container custom leftband">
    <div class="row-fluid">
        <div class="span12" style="">
            <div id="overlay-map" style="height: 340px; width: 98%" ></div>
        </div>
    </div>
</div>
<?
  include('footer.php');
?>
