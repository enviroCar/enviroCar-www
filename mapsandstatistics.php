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
			<h2> <? echo $hotspot_titel ?></h2>
			<div class="span3">
				<a href="http://www.arcgis.com/home/webmap/viewer.html?webmap=d0a4bb0dd1d943d19ab7f66fd5a2cfb2" class="thumbnail" target="_blank">
					<img src="http://www.arcgis.com/sharing/rest/content/items/d0a4bb0dd1d943d19ab7f66fd5a2cfb2/info/thumbnail/ago_downloaded.png" alt="">
				</a>
			</div>
        <div class="span5">
          <?php echo $hotspot_description ?>       
        </div>
		</div>
	</div>

	<div class="container rightband">
	<div class="row-fluid">
			<h2> <? echo $speed_titel ?></h2>
			<div class="span3">
				<a href="http://www.arcgis.com/home/webmap/viewer.html?webmap=56f3d72eb2034b4ca2975bba3b2ba0b1" class="thumbnail" target="_blank">
					<img src="http://www.arcgis.com/sharing/rest/content/items/56f3d72eb2034b4ca2975bba3b2ba0b1/info/thumbnail/ago_downloaded.png" alt="">
				</a>
			</div>
        <div class="span5">
          <?php echo $speed_description ?>       
        </div>
		</div>
	</div>

	<div class="container rightband">
	<div class="row-fluid">
			<h2> <? echo $speedcomparison_titel ?></h2>
			<div class="span3">
				<a href="./community_speed_difference2.php" class="thumbnail">
					<img src="./assets/img/speed_comparison_thumb.png" alt="">
				</a>
			</div>
        <div class="span5">
          <?php echo $speedcomparison_description ?>       
        </div>
		</div>
	</div>

<?
include('footer.php');
?>