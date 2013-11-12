$(document).ready(function() {
	var src = "";

	$('.modal').bind('hide', function () {
		var iframe = $(this).children('div.modal-body').find('iframe'); 
		src = iframe.attr('src');
		iframe.attr('src', '');
	});

	$('.modal').bind('show', function () {
		if(src != ""){
			var iframe = $(this).children('div.modal-body').find('iframe'); 
			iframe.attr('src', src);
		};
	});
});

google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['', ''],
    ['Km driven',  1000],
    ['CO2 per Km',  1170]
  ]);

  var options = {
    titlePosition: 'none',
    backgroundColor: 'transparent',
    axisTitlesPosition: 'none',
    fontSize: 16,
    legend: 'none',
    colors: ['#8CBF3F'],
    bar: {groupWidth: 20},
    vAxis: {
    	gridlines: {color: 'transparent'},
    	baselineColor: 'black',
    	textPosition: 'in',
    	minorGridlines: {count: 0, color: 'transparent'},
    	textStyle: {color: 'white', fontName: 'Droid Sans', fontSize: 16}
    },
    hAxis: {
    	gridlines: {color: 'transparent'},
    	baselineColor: 'black',
    	textPosition: 'in',
    	textStyle: {color: 'white', fontName: 'Droid Sans', fontSize: 16},
    	minorGridlines: {count: 0, color: 'transparent'}
    },
    fontName: 'Droid Sans'
  };

  var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
  chart.draw(data, options);
}



