<?
include('header.php');
?>

<div class="container rightband" style="padding-left:20px">
	<div>
		<h2>Interactive map</h2>
		Get the <a href="community_lines.php">interactive map</a> showing the aggregated measurements of the enviroCar routes and see where ou contributed to the information products! <br>
		<i>(It may can take a while until your uploaded route has been integrated into the map.)</i><br><br>

		You can also check out our <a href="community_speed_difference.php">speed-map</a>. We calculated the differences between the maximum speed (based on OpenStreetMap) and the averaged speed (measured via enviroCar), which allows us to analyze, if the traffic flows as planned.
	</div>
	<br>
	<div>
		<h2>Data Analysis</h2>
		<div class="row-fluid">
			<div class="span5">
				<p><b>Overview measurement points</b></p>
				<img style= "width:100%; height:250px;" src="./assets/img/marketing/measurepoints_overview.jpg" />
			</div>	
			<div class="span5">
				<p><b>Detail of a measurement point</b></p>
				<img style="width:100%; height: 250px;"  src="./assets/img/marketing/measurepoints_detail.jpg" />
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
				<img class="offset2" style= "width:50%; height:200px;" src="./assets/img/marketing/co2_1.jpg"/>
			</div>
		</div>
            <br>
        <div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<p><b>Speed map</b></p>
				<br>
				<img class="offset2" style= "width:50%; height:200px;" src="./assets/img/marketing/speed1.jpg"/>
			</div>
		</div>
	<br></br>
	<p>
	 The measurement of coordinates and attribute values from the car that is collected through the mobile application like CO2 emission or speed values make further visualizations possible.
	 In this example the speed or CO2 values along the measurement route are visualized with an interpolation tool that just creates a continuous surface from sampled point values. 
	<br>
	<p>
	     <div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<p><b>Comparison of Speed and CO2 visualization</b></p>
				<br>
				<img class="offset2" style= "width:50%; height:200px;" src="./assets/img/marketing/co2_speed_compare.jpg"/>
			</div>
	<br>		
	<br>
	<p>
		Visualization of the measurement data is a useful tool for getting an overview or for making comparisons. Here for example you can easily see that high CO2 values are in the same area of the route as high speed values. 
		
	<p>
	<br>
		     <div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<p><b>Speed map detail</b></p>
				<br>
				<img class="offset2" style= "width:50%; height:200px;" src="./assets/img/marketing/speed_detail.jpg"/>
			</div>
	<br></br>
	<p>
		Moreover, the analysis of the measurement can visualize details like speed-up and slow-down areas.
	<p>
	
	

    </div>
</div>


<?
include('footer.php');
?>