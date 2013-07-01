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

<script type="text/javascript">
function newWin(url,name, width, height) { 
window.open(url,name,'scrollbars=yes,resizable=yes, width=' + width + ',height='+height);
}</script>

<div class="container rightband" style="padding-left:20px">
	<div>
		<h2><? echo $interactivemap ?></h2>
		<? echo $interactivemap_text ?>
	</div>
	<br>
	<div>
		<h2><? echo $data_analysis ?></h2>
		<div class="row-fluid">
			<div class="span5">
				<p><b><? echo $points_overview ?></b></p>		
				<a href="javascript:newWin('./assets/img/marketing/measurepoints_overview.jpg', 'Bigger Image', '900', '600')"><img src="./assets/img/marketing/measurepoints_overview.jpg" width="100%" height="250" /></a>
			</div>	
			<div class="span5">
				<p><b><? echo $points_detail ?></b></p>
				<a href="javascript:newWin('./assets/img/marketing/measurepoints_detail.jpg', 'Bigger Image', '900', '600')"><img src="./assets/img/marketing/measurepoints_detail.jpg" width="100%" height="250" /></a>
			</div>
		</div>
	</div>
	<br>
	<p>
		<? echo $analysis_info ?>
		<a class="btn" target="_blank" href="assets/download/testdata.shp">Download (Shape)</a>
	<p>


</div>


	<br>
<div class="container rightband" style="padding-left:20px">
	<div>
		<h2><? echo $data_visualization ?></h2>
		<div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<p><b><? echo $co2_map ?></b></p>
				<br>
				<a href="javascript:newWin('./assets/img/marketing/co2_1.jpg', 'Bigger Image', '1100', '500')"><img class="offset2" src="./assets/img/marketing/co2_1.jpg" width="50%" height="200" /></a>
			</div>
		</div>
            <br>
        <div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<p><b><? echo $speed_map ?></b></p>
				<br>
				<a href="javascript:newWin('./assets/img/marketing/speed1.jpg', 'Bigger Image', '1100', '500')"><img class="offset2" src="./assets/img/marketing/speed1.jpg" width="50%" height="200" /></a>
			</div>
		</div>
	<br></br>
	<p>
	 <? echo $interpolation_info ?>
	<br>
	</p>
	     <div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<p><b><? echo $comparison_visualization ?></b></p>
				<br>
				<a href="javascript:newWin('./assets/img/marketing/co2_speed_compare.jpg', 'Bigger Image', '1100', '500')"><img class="offset2" src="./assets/img/marketing/co2_speed_compare.jpg" width="50%" height="250" /></a>
			</div>
	<br>		
	<br>
	<p>
		<? echo $comparison_info ?>
		
	</p>
	<br>
		     <div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<p><b><? echo $speed_map_detail ?></b></p>
				<br>
				<a href="javascript:newWin('./assets/img/marketing/speed_detail.jpg', 'Bigger Image', '1100', '500')"><img class="offset2" src="./assets/img/marketing/speed_detail.jpg" width="50%" height="200" /></a>
			</div>
	<br></br>
	<p>
		<? echo $detail_info ?>
	</p>
    </div>
</div>
</div>
</div>


<div class="container rightband" style="padding-left:20px">
	<div>
		<h2><? echo $visualization_multitude ?></h2>
		
	</div>
	<br>
	<div>
		<h4><? echo $GE_visualization ?></h4>
		<div class="row-fluid">
			<div class="span5">
		
				<a href="javascript:newWin('./assets/img/marketing/GE_speedmap1.jpg', 'Bigger Image', '900', '600')"><img src="./assets/img/marketing/GE_speedmap1.jpg" width="100%" height="250" /></a>
			</div>	
			<div class="span5">
				
				<a href="javascript:newWin('./assets/img/marketing/GE_speedmap2.jpg', 'Bigger Image', '900', '600')"><img src="./assets/img/marketing/GE_speedmap2.jpg" width="100%" height="250" /></a>
			</div>
		</div>
	</div>
	<br>
	<p>
		<? echo $multitude_possibilities ?><br>
		
	<p>


</div>



<?
include('footer.php');
?>