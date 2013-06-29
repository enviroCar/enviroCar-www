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
		<h2>Data Analysis</h2>
		<div class="row-fluid">
			<div class="span5">
				<p><b>Overview measurement points</b></p>		
				<a href="javascript:newWin('./assets/img/marketing/measurepoints_overview.jpg', 'Bigger Image', '900', '600')"><img src="./assets/img/marketing/measurepoints_overview.jpg" width="100%" height="250" /></a>
			</div>	
			<div class="span5">
				<p><b>Detail of a measurement point</b></p>
				<a href="javascript:newWin('./assets/img/marketing/measurepoints_detail.jpg', 'Bigger Image', '900', '600')"><img src="./assets/img/marketing/measurepoints_detail.jpg" width="100%" height="250" /></a>
			</div>
		</div>
	</div>
	<br>
	<p>
		The collected data through the mobile application allow further analysis for example with a GIS program.
		To learn more about how to get access to the enviroCar data, visit the <a href="">developer documentation</a> and create your own products!<br>
		For making your own analysis here you can download an example data set as shape file format.<br>
		<a class="btn" target="_blank" href="assets/download/testdata.shp">Download (Shape)</a>
	<p>


</div>


	<br>
<div class="container rightband" style="padding-left:20px">
	<div>
		<h2>Data Visualization</h2>
		<div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<p><b>CO2 emission map</b></p>
				<br>
				<a href="javascript:newWin('./assets/img/marketing/co2_1.jpg', 'Bigger Image', '1100', '500')"><img class="offset2" src="./assets/img/marketing/co2_1.jpg" width="50%" height="200" /></a>
			</div>
		</div>
            <br>
        <div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<p><b>Speed map</b></p>
				<br>
				<a href="javascript:newWin('./assets/img/marketing/speed1.jpg', 'Bigger Image', '1100', '500')"><img class="offset2" src="./assets/img/marketing/speed1.jpg" width="50%" height="200" /></a>
			</div>
		</div>
	<br></br>
	<p>
	 The measurement of coordinates and attribute values from the car that is collected through the mobile application like CO2 emission or speed values make further visualizations possible.
	 In this example the speed or CO2 values along the measurement route are visualized with an interpolation tool that just creates a continuous surface from sampled point values. 
	<br>
	</p>
	     <div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<p><b>Comparison of Speed and CO2 visualization</b></p>
				<br>
				<a href="javascript:newWin('./assets/img/marketing/co2_speed_compare.jpg', 'Bigger Image', '1100', '500')"><img class="offset2" src="./assets/img/marketing/co2_speed_compare.jpg" width="50%" height="250" /></a>
			</div>
	<br>		
	<br>
	<p>
		Visualization of the measurement data is a useful tool for getting an overview or for making comparisons. Here for example you can easily see that high CO2 values are in the same area of the route as high speed values. 
		
	</p>
	<br>
		     <div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<p><b>Speed map detail</b></p>
				<br>
				<a href="javascript:newWin('./assets/img/marketing/speed_detail.jpg', 'Bigger Image', '1100', '500')"><img class="offset2" src="./assets/img/marketing/speed_detail.jpg" width="50%" height="200" /></a>
			</div>
	<br></br>
	<p>
		Moreover, the analysis of the measurement can visualize details like speed-up and slow-down areas.
	</p>
    </div>
</div>
</div>
</div>



<?
include('footer.php');
?>