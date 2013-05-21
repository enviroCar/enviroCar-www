<?
include('header.php');
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>	
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">
	   
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(callData);
	
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
		
	function callData(){
		$.getJSON('http://giv-car.uni-muenster.de:8080/stable/rest/tracks/51944e28e4b017df94de8e2d')
		.success(function(data) {
			for(var i=0;i<data.features.length;i++){
				time[i] = data.features[i].properties.time;
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