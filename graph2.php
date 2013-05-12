<?
include('header.php');
?>


<!-- https://google-developers.appspot.com/chart/interactive/docs/gallery/linechart -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Measurement', 'CO2'],
          ['1',    25],
          ['2',    50],
          ['3',    40],
          ['4',    90]
        ]);

        var data2 = google.visualization.arrayToDataTable([
          ['Measurement', 'Noise'],
          ['1',  1000],
          ['2',  1170],
          ['3',  660],
          ['4',  1030]
        ]);

        var data3 = google.visualization.arrayToDataTable([
          ['Measurement', 'Engine'],
          ['1',  0],
          ['2',  75],
          ['3',  70],
          ['4',  20]
        ]);

        var data4 = google.visualization.arrayToDataTable([
          ['Measurement', 'Fuel'],
          ['1',  6],
          ['2',  7],
          ['3',  6],
          ['4',  8]
        ]);

        var options = {
          title: 'Company Performance'
        };

        var chart = new google.visualization.LineChart(document.getElementById('co2_chart'));
        chart.draw(data, options);        

        var chart2 = new google.visualization.LineChart(document.getElementById('noise_chart'));
        chart2.draw(data2, options);        

        var chart3 = new google.visualization.LineChart(document.getElementById('engine_chart'));
        chart3.draw(data3, options);        

        var chart4 = new google.visualization.LineChart(document.getElementById('fuel_chart'));
        chart4.draw(data4, options);
      }
    </script>
<div class="container rightband">
  <div class="span5">
    <h2>CO2</h2>
    <div id="co2_chart" style="width: 500px; height: 400px;"></div>
  </div>
  <div class="span5">
    <h2>Noise</h2>
    <div id="noise_chart" style="width: 500px; height: 400px;"></div>
  </div>
  <div class="span5">
    <h2>Engine Load</h2>
    <div id="engine_chart" style="width: 500px; height: 400px;"></div>
  </div>
  <div class="span5">
    <h2>Fuel consumption</h2>
    <div id="fuel_chart" style="width: 500px; height: 400px;"></div>
  </div>


</div>


<?
include('footer.php');
?>

