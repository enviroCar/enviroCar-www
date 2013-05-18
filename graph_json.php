<?
include('header.php');
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>	
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">
	   
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(callData);
	
	var time = [];
	var co2 = [];
	var co2Data = [];
	var speed = [];
	var speedData = [];
		
	function callData(){
		$.getJSON('track.json')
		.success(function(data) {
			for(var i=0;i<data.measurements.length;i++){
				time[i] = data.measurements[i].time;
				co2[i] = data.measurements[i].phenomenons[0].value;
				co2Data[0] = ['time','kg/h'];
				co2Data[i+1] = [time[i], co2[i]];
				speed[i] = data.measurements[i].phenomenons[1].value;
				speedData[0] = ['time','km/h'];
				speedData[i+1] = [time[i], speed[i]];
				}
			drawChartCO2();
			drawChartSpeed();
			});
		}
		
	function drawChartCO2() {
        data = google.visualization.arrayToDataTable(
			co2Data
			);

        var options = {
          title: 'Carbon dioxide in kg/h',
		  colors: ['#048ABF']
        };

        var speedChart = new google.visualization.LineChart(document.getElementById('co2_chart'));
        speedChart.draw(data, options);
      }
	  
	function drawChartSpeed() {
        data = google.visualization.arrayToDataTable(
			speedData
			);

        var options = {
          title: 'Speed in km/h',
		  colors: ['#048ABF']
        };

        var speedChart = new google.visualization.LineChart(document.getElementById('speed_chart'));
        speedChart.draw(data, options);
      }
</script>

<div class="container rightband">
  <div class="span5">
    <h2>CO2</h2>
    <div id="co2_chart" style="width: 500px; height: 400px;"></div>
  </div>
  <div class="span5">
    <h2>Speed</h2>
    <div id="speed_chart" style="width: 500px; height: 400px;"></div>
  </div>
</div>

<?
include('footer.php');
?>