<?
include('header.php');
?>

<div id="loadingIndicator" class="loadingIndicator">
  <div style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
</div>

<div class="container leftband">
 <div class="span5 offset6">
  <div class="btn-group" style="float:right">
      <button class="btn dropdown-toggle" data-toggle="dropdown"  style="width:250px"><strong><? echo $pickfriends ?></strong> <span class="caret"></span>
      </button>
      <ul id="friendsDropdown" class="dropdown-menu" style=" max-height: 300px; width:200px; overflow-y: scroll;">

      </ul>
    </div>
    </div>
 </div>

 <div class="container rightband">
 
  <div class="span5">
      <div id="userStatistics" style="max-height:400px; overflow:auto;">
    <p style="font-size:25px"><? echo $statisticsOf ?> <? echo $_SESSION['name'] ?>:</p> 
  </div>
        
  </div>
  <div class="span5" >
   <div id ="friendStatistics" style="font-size:25px"> </div> 
   <p id="friendHeadline" style="font-size:25px"></p>
   <div id="loadingIndicator_friend_statistics" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px; display:none"></div>
  <div id="fStatistics"></div>
   </div>
   </div>
<div class="container leftband">
      <div id="chart_div" style="width: 900px; height: 500px;">   
        <div id="loadingIndicator_graph" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px; display:none"></div>
      </div>
     
</div>
    
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
   
 
<script type="text/javascript">
  var values = []; //  user statistical data
  var values2 = []; // friend statistical data
  var fname;
  var count=0; // count of statsical values according to the user 
  var phen=[];

 //Display the user Statistics.. Append the statistics values, icons, tooltips.... if any statistical value equal to Zero, do not display 0 display '<strong>Not Calculated</strong>'
//fetch the statiscial values from the server
 $.get('assets/includes/users.php?userStatistics=<? echo $_SESSION['name'] ?>', function(data) {
    if(data >= 400){
        error_msg("<? echo $statisticsError ?>");
        $('#loadingIndicator').hide();
    }else{
      data = JSON.parse(data);
      count=data.statistics.length;
	
      for(i = 0; i < data.statistics.length; i++){
      
			if (data.statistics[i].phenomenon.name=="Speed")
				{
				if(Math.round(data.statistics[i].avg*100)/100==0)
					$('#userStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Average Driving Speed"><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Speed.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');    
				else
					$('#userStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Average Driving Speed"><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Speed.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');    
				}
			else if (data.statistics[i].phenomenon.name=="CO2")
				{
				if(Math.round(data.statistics[i].avg*100)/100==0)
					$('#userStatistics').append('<p data-toggle="tooltip" data-placement="left" title="CO2 Emission"><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/CO2.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');
				else
					$('#userStatistics').append('<p data-toggle="tooltip" data-placement="left" title="CO2 Emission"><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/CO2.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');
				}
			else if (data.statistics[i].phenomenon.name=="MAF")
				{	
				if(Math.round(data.statistics[i].avg*100)/100==0)
				
			        $('#userStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Mass Air Flow"><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/MAF.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');
				else
					$('#userStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Mass Air Flow"><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/MAF.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');
				}
			else if (data.statistics[i].phenomenon.name=="Calculated MAF")
				{
				if(Math.round(data.statistics[i].avg*100)/100==0)
					$('#userStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Calculated Mass Air Flow"><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Calculated MAF.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');
				else
					$('#userStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Calculated Mass Air Flow"><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Calculated MAF.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');
				}
			else if (data.statistics[i].phenomenon.name=="Intake Temperature")
				{
				if(Math.round(data.statistics[i].avg*100)/100==0)
					$('#userStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Intake Air Temperature"><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Intake Temperature.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');		
				else
					$('#userStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Intake Air Temperature"><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Intake Temperature.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');
				}
			else if (data.statistics[i].phenomenon.name=="Intake Pressure")
				{				 
				if(Math.round(data.statistics[i].avg*100)/100==0)
					$('#userStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Intake Air Pressure"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Intake Pressure.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');		
				else
					$('#userStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Intake Air Pressure"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Intake Pressure.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');
				}

			else if (data.statistics[i].phenomenon.name=="Consumption")
				{	
				if(Math.round(data.statistics[i].avg*100)/100==0)
					$('#userStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Average Gasoline Consumption"><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Consumption.png"/>'+data.statistics[i].phenomenon.name+':  '+'<strong>Not Calculated</strong>'+'</p>');
				else
					$('#userStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Average Gasoline Consumption"><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Consumption.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');
				}
				
			else if (data.statistics[i].phenomenon.name=="Rpm")
				{
				if(Math.round(data.statistics[i].avg*100)/100==0)
					$('#userStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Revolutions Per Minute"><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Rpm.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');    
				else
					$('#userStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Revolutions Per Minute"><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Rpm.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');    
				}

			else
			   {
	   			if(Math.round(data.statistics[i].avg*100)/100==0)
	   				$('#userStatistics').append('<p><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/others.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');
				else
	   				$('#userStatistics').append('<p><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/others.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');
				}
	  
	  values[i]= Math.round(data.statistics[i].avg*100)/100;
        phen[i]=data.statistics[i].phenomenon.name;
		$('#loadingIndicator').hide();
    }
    }
  });


google.load("visualization", "1", {packages:["corechart"]});


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

  
  function getAvatar(name){
     return './assets/includes/get.php?redirectUrl=https://giv-car.uni-muenster.de/stable/rest/users/'+name+'/avatar&auth=true';
  }
  
  function getFriendStatistics(friend){
    $('#loadingIndicator_graph').show();
    $('#loadingIndicator_friend_statistics').show();

    fname = friend;
    $.get('assets/includes/users.php?friendStatistics='+friend, function(data) {
      if(data >= 400){
          if(data == 401 || data == 403) error_msg(friend+" <? echo $noFriendsYet ?>.");
          else error_msg("<? echo $statisticsNotFound ?>");
      }else{
        $('#fStatistics').text("");
        data = JSON.parse(data);
        if(data.length)
        for (h=0; h<count; h++ ){
          values2[h]=0;
        }
        $('#friendHeadline').html("<? echo $statisticsOf ?> "+friend+":");
        for(i = 0; i < data.statistics.length; i++){ 
    		if (data.statistics[i].phenomenon.name=="Speed")
				{
				if(Math.round(data.statistics[i].avg*100)/100==0)
					$('#fStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Average Driving Speed"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Speed.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');

				else
					$('#fStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Average Driving Speed"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Speed.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');
				}
				
			else if (data.statistics[i].phenomenon.name=="CO2")
     			{
				if(Math.round(data.statistics[i].avg*100)/100==0)
					$('#fStatistics').append('<p data-toggle="tooltip" data-placement="left" title="CO2 Emission"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/CO2.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');
 				else
					$('#fStatistics').append('<p data-toggle="tooltip" data-placement="left" title="CO2 Emission"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/CO2.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');
				}
			else if (data.statistics[i].phenomenon.name=="MAF")
				{
				if(Math.round(data.statistics[i].avg*100)/100==0)
					$('#fStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Mass Air Flow"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/MAF.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');
				else				
					$('#fStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Mass Air Flow"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/MAF.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');
				}		
			else if (data.statistics[i].phenomenon.name=="Calculated MAF")
				{
				if(Math.round(data.statistics[i].avg*100)/100==0)
					$('#fStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Calculated Mass Air Flow"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Calculated MAF.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');
				else
					$('#fStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Calculated Mass Air Flow"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Calculated MAF.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');
				}
			else if (data.statistics[i].phenomenon.name=="Intake Temperature")
				{	
				if(Math.round(data.statistics[i].avg*100)/100==0)
					$('#fStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Intake Air Temperature"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Intake Temperature.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');
				else
					$('#fStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Intake Air Temperature"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Intake Temperature.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');
				}
			else if (data.statistics[i].phenomenon.name=="Intake Pressure")
				{				 
				if(Math.round(data.statistics[i].avg*100)/100==0)
					$('#fStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Intake Air Pressure"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Intake Pressure.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');		
				else
					$('#fStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Intake Air Pressure"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Intake Pressure.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');
				}
      	         	else if (data.statistics[i].phenomenon.name=="Consumption")
				{				
				if(Math.round(data.statistics[i].avg*100)/100==0)
					$('#fStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Aerage Gasoline Consumption"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Consumption.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');
				else
					$('#fStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Aerage Gasoline Consumption"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Consumption.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');
				}
         		
			else if (data.statistics[i].phenomenon.name=="Rpm")
				{
				if(Math.round(data.statistics[i].avg*100)/100==0)
					$('#fStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Revolutions Per Minute"><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Rpm.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');    
				else
					$('#fStatistics').append('<p data-toggle="tooltip" data-placement="left" title="Revolutions Per Minute"><img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/Rpm.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');    
				}
				
			else
				{
					if(Math.round(data.statistics[i].avg*100)/100==0)
						$('#fStatistics').append('<p"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/others.png"/>'+data.statistics[i].phenomenon.name+': '+'<strong>Not Calculated</strong>'+'</p>');
					else
						$('#fStatistics').append('<p"> <img  style="height: 30px; width: 30px; padding-right:15px " src="./assets/img/others.png"/>'+data.statistics[i].phenomenon.name+': '+Math.round(data.statistics[i].avg*100)/100+" "+data.statistics[i].phenomenon.unit+'</p>');
				}
          for (j=0; j<count; j++ ){
            if ((data.statistics[i].phenomenon.name)==phen[j]){ 
              values2[j]= Math.round(data.statistics[i].avg*100)/100;
              break;
            }
          }
        }
        if(data.statistics.length==0){
          $('#fStatistics').text(friend+" <? echo $noDataYet ?>");
          values2 = [0,0,0,0];

        }
        google.setOnLoadCallback(drawChart());
      }
      

      $('#loadingIndicator_graph').hide();
      $('#loadingIndicator_friend_statistics').hide();

    });
  }

  $.get('./assets/includes/users.php?friendsOf=<? echo $_SESSION['name'] ?>', function(data) {
    if(data >= 400){
      error_msg("<? echo $friendsError ?>");
    }else{
      data = JSON.parse(data);
      if(data.users.length > 0 ){
        for(i = 0; i < data.users.length; i++){
          $('#friendsDropdown').append('<li class="customLi" onclick="getFriendStatistics(\''+data.users[i].name+'\')"><img src="'+getAvatar(data.users[i].name)+'" style="height: 30px; margin-right: 10px; "/><a style="display:inline;">'+data.users[i].name+'</a></li>');
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



function drawChart() 
    {
    var data = new google.visualization.DataTable();
      data.addColumn('string','Measurement');
      data.addColumn('number', '<? echo $_SESSION['name'] ?>');
      data.addColumn('number', fname);

      data.addRows(count);
      
      
   for(i = 0; i < count; i++)
      {
      data.setValue(i, 0, phen[i]);
      data.setValue(i, 1, values[i]);
        data.setValue(i, 2, values2[i]);
      }
 
        var options = {
          title: '<? echo $statistics ?>',
          vAxis: {title: '',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      };
  


  </script>
  
  
<?
include('footer.php');
?>
