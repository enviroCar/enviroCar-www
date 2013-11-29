<?php
/*
* This file is subject to the terms and conditions defined in
* file 'LICENSE', which is part of this source code package.
*/

include('header.php');
?>

<div id="loadingIndicator" class="loadingIndicator">
<div style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>	

<div id="graphs" class="container rightband">
</div>

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

		return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d) + ' ' + hours +':'+ (minutes <= 9 ? '0' + minutes : minutes);
	}
	
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(callPhens);
	
	var serverTime = [];
	var time = [];
	var phen = [];
	var phenName = [];
	var tracks;
	
	var trackID = '<?php echo $_GET["id"]; ?>';
	
	function callPhens(){
		$.get('./assets/includes/users.php?atrackStatistics=' + trackID, function(data) {
			if(data >= 400){
		        console.log(data);
		        if(data == 400){
		            error_msg("<? echo $statisticsError ?>");
		        }else if(data == 401 || data == 403){
		          error_msg("<? echo $statisticsNotAllowed ?>")
		        }else if(data == 404){
		          error_msg("<? echo $statisticsNotFound ?>")
		        }
		        $('#loadingIndicator').hide();
		    }else{
				data = JSON.parse(data);
				for(var i=0;i<data.statistics.length;i++){
					phenName[i] = data.statistics[i].phenomenon.name;
					}
				callData();
				$('#loadingIndicator').hide();
			}

		});
	}
	
	function callData(){
		$.get('./assets/includes/users.php?atrack=' + trackID, function(data) {
		    if(data >= 400){
		      if(data == 400){
		          error_msg("<? echo $routeError ?>");
		      }else if(data == 401 || data == 403){
		        error_msg("<? echo $routeNotAllowed ?>")
		      }else if(data == 404){
		        error_msg("<? echo $routeNotFound ?>")
		      }
		      $('#loadingIndicator').hide();
		    }else{
				data = JSON.parse(data);
				tracks = data;
				for(var i=0;i<phenName.length;i++){
					$('#graphs').append('<div class="span5"><h2>'+phenName[i]+'</h2><div id="chart'+i+'" style="width: 500px; height: 400px;"></div><a class="btn" onclick="zoomIn('+i+')">Zoom in</a></div>');
					phen[0] = ['time', eval('data.features[0].properties.phenomenons["'+phenName[i]+'"].unit')];
					for(var j=0;j<data.features.length;j++){
						serverTime[j] = data.features[j].properties.time;
						time[j] = convertToLocalTime(serverTime[j]);
						phen[j+1] = [time[j], eval('data.features['+j+'].properties.phenomenons["'+phenName[i]+'"].value')];
					}
					chartName = 'chart'+i;
					drawChart(phen, chartName);
				}
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
	
	function zoomIn(number){
		$('.span5').remove();
		$('#graphs').append('<div class="largeGraph"><h2>'+phenName[number]+'</h2><div id="bigChart"></div><a class="btn" onclick="zoomOut()">Go back</a></div>');
		phen[0] = ['time', eval('tracks.features[0].properties.phenomenons["'+phenName[number]+'"].unit')];
		for(var j=0;j<tracks.features.length;j++){
					serverTime[j] = tracks.features[j].properties.time;
					time[j] = convertToLocalTime(serverTime[j]);
					phen[j+1] = [time[j], eval('tracks.features['+j+'].properties.phenomenons["'+phenName[number]+'"].value')];
		}
		drawChart(phen, 'bigChart');
	}
	
	function zoomOut(){
		$('.largeGraph').remove();
		callData();
		}

</script>
<?
include('footer.php');
?>