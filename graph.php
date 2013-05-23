<?
include('header.php');
?>

<div id="loadingIndicator" class="loadingIndicator">
<div style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>	
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">
	
	function convertToLocalTime(serverDate) {
		var dt = new Date(Date.parse(serverDate));
		var localDate = dt;

		var gmt = localDate;
			var min = gmt.getTime() / 1000 / 60; // convert gmt date to minutes
			var localNow = new Date().getTimezoneOffset(); // get the timezone
			// offset in minutes
			var localTime = min - localNow; // get the local time

		var dateStr = new Date(localTime * 1000 * 60);
		var d = dateStr.getDate();
		var m = dateStr.getMonth() + 1;
		var y = dateStr.getFullYear();

		var totalSec = dateStr.getTime() / 1000;
		var hours = parseInt( totalSec / 3600 ) % 24;
		var minutes = parseInt( totalSec / 60 ) % 60;

		return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d) + ' ' + hours +':'+ minutes;
	}
	
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(callData);
	
	var serverTime = [];
	var time = [];
	var phen1 = [];
	var phen2 = [];
	var phen3 = [];
	var phen4 = [];
	var phen5 = [];
	var phen6 = [];
	var phen7 = [];
	var phen8 = [];
	var phen9 = [];
	var phen10 = [];
	
	var trackID = '<?php echo $_GET["id"]; ?>';
	
	function callData(){
		$.get('http://giv-car.uni-muenster.de:8080/stable/rest/tracks/' + trackID, function(data) {
		if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404){
			console.log('error in getting tracks');
			$('#loadingIndicator').hide();
		}else{
			data = JSON.parse(data);
			for(var i=0;i<data.features.length;i++){
				serverTime[i] = data.features[i].properties.time;
				time[i] = convertToLocalTime(serverTime[i]);
				phen1[0] = ['time','x'];
				phen1[i+1] = [time[i], data.features[i].properties.phenomenons.testphenomenon1.value];
				phen2[0] = ['time','x'];
				phen2[i+1] = [time[i], data.features[i].properties.phenomenons.testphenomenon2.value];
				phen3[0] = ['time','x'];
				phen3[i+1] = [time[i], data.features[i].properties.phenomenons.testphenomenon3.value];
				phen4[0] = ['time','x'];
				phen4[i+1] = [time[i], data.features[i].properties.phenomenons.testphenomenon4.value];
				phen5[0] = ['time','x'];
				phen5[i+1] = [time[i], data.features[i].properties.phenomenons.testphenomenon5.value];
				phen6[0] = ['time','x'];
				phen6[i+1] = [time[i], data.features[i].properties.phenomenons.testphenomenon6.value];
				phen7[0] = ['time','x'];
				phen7[i+1] = [time[i], data.features[i].properties.phenomenons.testphenomenon7.value];
				phen8[0] = ['time','x'];
				phen8[i+1] = [time[i], data.features[i].properties.phenomenons.testphenomenon8.value];
				phen9[0] = ['time','x'];
				phen9[i+1] = [time[i], data.features[i].properties.phenomenons.testphenomenon9.value];
				phen10[0] = ['time','x'];
				phen10[i+1] = [time[i], data.features[i].properties.phenomenons.testphenomenon10.value];
				}
			drawChart(phen1, 'chart1');
			drawChart(phen2, 'chart2');
			drawChart(phen3, 'chart3');
			drawChart(phen4, 'chart4');
			drawChart(phen5, 'chart5');
			drawChart(phen6, 'chart6');
			drawChart(phen7, 'chart7');
			drawChart(phen8, 'chart8');
			drawChart(phen9, 'chart9');
			drawChart(phen10, 'chart10');
			}
			$('#loadingIndicator').hide();
			});
		}
		
	function drawChart(phenomenons, chart) {
        data = google.visualization.arrayToDataTable(
			phenomenons
			);

        var options = {
		  colors: ['#048ABF']
        };

        var speedChart = new google.visualization.LineChart(document.getElementById(chart));
        speedChart.draw(data, options);
      }
	  

</script>

<div class="container rightband">
  <div class="span5">
    <h2>Testphenomenon1</h2>
    <div id="chart1" style="width: 500px; height: 400px;"></div>
  </div>
  <div class="span5">
    <h2>Testphenomenon2</h2>
    <div id="chart2" style="width: 500px; height: 400px;"></div>
  </div>
  <div class="span5">
    <h2>Testphenomenon3</h2>
    <div id="chart3" style="width: 500px; height: 400px;"></div>
  </div>
  <div class="span5">
    <h2>Testphenomenon4</h2>
    <div id="chart4" style="width: 500px; height: 400px;"></div>
  </div>
  <div class="span5">
    <h2>Testphenomenon5</h2>
    <div id="chart5" style="width: 500px; height: 400px;"></div>
  </div>
  <div class="span5">
    <h2>Testphenomenon6</h2>
    <div id="chart6" style="width: 500px; height: 400px;"></div>
  </div>
  <div class="span5">
    <h2>Testphenomenon7</h2>
    <div id="chart7" style="width: 500px; height: 400px;"></div>
  </div>
  <div class="span5">
    <h2>Testphenomenon8</h2>
    <div id="chart8" style="width: 500px; height: 400px;"></div>
  </div>
  <div class="span5">
    <h2>Testphenomenon9</h2>
    <div id="chart9" style="width: 500px; height: 400px;"></div>
  </div>
  <div class="span5">
    <h2>Testphenomenon10</h2>
    <div id="chart10" style="width: 500px; height: 400px;"></div>
  </div>
</div>

<?
include('footer.php');
?>