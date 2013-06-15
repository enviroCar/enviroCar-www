<?
include('header.php');
?>

<div id="loadingIndicator" class="loadingIndicator">
  <div style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
</div>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script src="./assets/js/geojsontools.js"></script>
    <script src="js/bootstrap-select.js" type="text/javascript"></script>
 
<div class="container leftband">
 <div class="span5 offset6">
  <div class="btn-group" style="float:right">
  	  <button class="btn dropdown-toggle" data-toggle="dropdown"  style="width:250px"><strong>Pick Friends to Compare with..</strong> <span class="caret"></span>
		  </button>
		  <ul id="sensorsDropdown" class="dropdown-menu" style=" max-height: 300px; width:200px; overflow-y: scroll;">

		  </ul>
		</div>
		</div>
 </div>

 <div class="container rightband">
 
  <div class="span5">
    <div style="max-height:400px; overflow:auto;">
      <div id="userStatistics">
	  <p style="font-size:25px">Statistics of  <? echo $_SESSION['name'] ?> :</p> 
	  </div>
	  
    </div>

 <!--   <div id="furtherInformation"></div> -->

          
  </div>
  <div class="span5" >
   <div id ="friendStatistics" style="font-size:25px"> </div> 
	<div id="fStatistics"></div>
   </div>
   </div>
<div class="container leftband">
       <div id="chart_div" style="width: 900px; height: 500px;"></div>
	   
</div>

<script type="text/javascript">


  	var values = [];
	var values2=[];

$(function(){
  
  $(".dropdown-menu li a").click(function(){
    $('#friendStatistics').text("");
	$('#fStatistics').text("");
    $(".btn:first-child").text('Your choice is : '+$(this).text());
     $(".btn:first-child").val($(this).text());
	 $('#friendStatistics').append('Statistics of '+$(this).text()+' :');
	 name2=$(this).text();
	
	$.get('assets/includes/users.php?userStatistics='+$_GET['name2'], function(data) {
    if(data == 200){
        error_msg("user statistics couldn't be loaded successfully3");
    }else{
      data = JSON.parse(data);
      for(i = 0; i < data.statistics.length; i++)
{
        $('#fStatistics').append('<p> '+data.statistics[i].phenomenon.name2+': &Oslash '+Math.round(data.statistics[i].avg*100)/100+'</p>');
	    values2[i]= Math.round(data.statistics[i].avg*100)/100;
	  }
 
    }
  });
  });
  });


  $.get('./assets/includes/users.php?friendsOf=<? echo $_SESSION['name'] ?>', function(data) {
	  	if(data >= 400){
	          error_msg("Friends couldn't be loaded successfully.");
	      	}else{
		        data = JSON.parse(data);
		        if(data.users.length > 0 ){
		        	for(i = 0; i < data.users.length; i++){
		            	//addFriendToList(data.users[i].name);
				 $('#sensorsDropdown').append('<li class="customLi"><img src="http://giv-car.uni-muenster.de:8080/stable/rest/users/'+data.users[i].name+'/avatar?size=30" style="height: 30px; margin-right: 10px; "/><a href="javascript:addRoutes2('+data.users[i].name+')">'+data.users[i].name+'</a></li>');

		          	}
		        }
	      	}
	  	});
		
			(function(){
    var s = window.location.search.substring(1).split('&');
      if(!s.length) return;
        var c = {};
        for(var i  = 0; i < s.length; i++)  {
          var parts = s[i].split('=');
          c[unescape(parts[0])] = unescape(parts[1]);
        }
      window.$_GET = function(name){return name ? c[name] : c;}
  }())

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


	$.get('assets/includes/users.php?userStatistics=<? echo $_SESSION['name'] ?>', function(data) {
    if(data == 200){
        error_msg("user statistics couldn't be loaded successfully.2");
    }else{
      data = JSON.parse(data);
      for(i = 0; i < data.statistics.length; i++){
        $('#userStatistics').append('<p> '+data.statistics[i].phenomenon.name+': &Oslash '+Math.round(data.statistics[i].avg*100)/100+'</p>');
	    values[i]= Math.round(data.statistics[i].avg*100)/100;
      $('#loadingIndicator').hide();

	  }
 
    }
    
  });
  
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);

      function drawChart() 
	  {
	  var data = new google.visualization.DataTable();
			data.addColumn('string','Measurement');
			data.addColumn('number', 'values');
			data.addColumn('number', 'values');

			data.addRows(4);
			data.setValue(0, 0, 'MAF');
			data.setValue(1, 0, 'Speed');
			data.setValue(2, 0, 'CO2');
			data.setValue(3, 0, 'Consumption');
			
	 for(i = 0; i < 4; i++)
			{	       
			data.setValue(i, 1, values[i]);
		    data.setValue(i, 2, values2[i]);

			}
 
        var options = {
          title: 'Statistics',
          vAxis: {title: '',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }

    </script>


<?
include('footer.php');
?>
