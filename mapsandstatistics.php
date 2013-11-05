<?
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

	<div class="container rightband">
	<div class="row-fluid">
			<h2 class="featurette-heading"> <? echo $speed_titel ?></h2>
			<div class="span3">
				<a href="http://www.arcgis.com/home/webmap/viewer.html?webmap=3c37371867d64b9a83e1b4fe56a34e72&extent=7.3198,51.7552,7.9927,52.1116" class="thumbnail" target="_blank">
					<img src="http://www.arcgis.com/sharing/rest/content/items/3c37371867d64b9a83e1b4fe56a34e72/info/thumbnail/ago_downloaded.png" alt="">
				</a>
			</div>
        <div class="span6">
          <?php echo $speed_description ?>       
        </div>
		</div>
	</div>	
	
	<div class="container rightband">
	<div class="row-fluid">
			<h2 class="featurette-heading"> <? echo $hotspot_titel ?></h2>
			<div class="span3">
				<a href="http://www.arcgis.com/home/webmap/viewer.html?webmap=5db4e1ea445e4b4b8612443e7ba76119" class="thumbnail" target="_blank">
					<img src="http://www.arcgis.com/sharing/rest/content/items/5db4e1ea445e4b4b8612443e7ba76119/info/thumbnail/ago_downloaded.png" alt="">
				</a>
			</div>
        <div class="span6">
          <?php echo $hotspot_description ?>       
        </div>
		</div>
	</div>


	<div class="container rightband">
	<div class="row-fluid">
			<h2 class="featurette-heading"> <? echo $analyzing_with_R_titel ?></h2>
			<div class="span3">
				<a href="http://rpubs.com/edzer/enviroCar" target="_blank" class="thumbnail">
					<img src="./assets/img/analyzing_with_R_thumb.jpg" alt="">
				</a>
			</div>
        <div class="span6">
          <?php echo $analyzing_with_R_description ?>       
        </div>
		</div>
	</div>

<?
include('footer.php');
?>
