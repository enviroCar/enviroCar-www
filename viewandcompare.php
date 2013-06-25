<?
include('header.php');
?>

<div id="loadingIndicator" class="loadingIndicator">
  <div style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
</div>

<div class="container leftband">
 <div class="span5 offset6">
  <div class="btn-group" style="float:right">
      <button class="btn dropdown-toggle" data-toggle="dropdown"  style="width:250px"><strong>Pick Friends to Compare with..</strong> <span class="caret"></span>
      </button>
      <ul id="friendsDropdown" class="dropdown-menu" style=" max-height: 300px; width:200px; overflow-y: scroll;">

      </ul>
    </div>
    </div>
 </div>

 <div class="container rightband">
 
  <div class="span5">
      <div id="userStatistics" style="max-height:400px; overflow:auto;">
    <p style="font-size:25px">Statistics of  <? echo $_SESSION['name'] ?> :</p> 
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
  var values = [];
  var values2 = [];
  var fname;
  var count=0;
  var phen=[];
  var image="";

  $.get('assets/includes/users.php?userStatistics=<? echo $_SESSION['name'] ?>', function(data) {
    if(data >= 400){
        error_msg("user statistics couldn't be loaded successfully.2");
        $('#loadingIndicator').hide();
    }else{
      data = JSON.parse(data);
      count=data.statistics.length;
      for(i = 0; i < data.statistics.length; i++){
        $('#userStatistics').append('<p> '+data.statistics[i].phenomenon.name+': &Oslash '+Math.round(data.statistics[i].avg*100)/100+'</p>');
      
        values[i]= Math.round(data.statistics[i].avg*100)/100;
        phen[i]=data.statistics[i].phenomenon.name;
      }
      $('#loadingIndicator').hide();
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
    $('#fStatistics').text("");

    fname = friend;
    $.get('assets/includes/users.php?friendStatistics='+friend, function(data) {
      if(data >= 400){
          if(data == 401 || data == 403) error_msg("Permission denied. "+friend+" hasn't added you as a friend yet.");
          else error_msg("Statistics could not be found");
      }else{
        data = JSON.parse(data);
        if(data.length)
        for (h=0; h<count; h++ ){
          values2[h]=0;
        }
        $('#friendHeadline').html("Statistics of  "+friend+":");
        for(i = 0; i < data.statistics.length; i++){ 
          $('#fStatistics').append('<p> '+data.statistics[i].phenomenon.name+': &Oslash '+Math.round(data.statistics[i].avg*100)/100+'</p>');
          for (j=0; j<count; j++ ){
            if ((data.statistics[i].phenomenon.name)==phen[j]){ 
              values2[j]= Math.round(data.statistics[i].avg*100)/100;
              break;
            }
          }
        }
        if(data.statistics.length==0){
          $('#fStatistics').text("Sorry; "+friend+" did not share any data yet !!");
          values2 = [0,0,0,0];

        }
      }
      google.setOnLoadCallback(drawChart());

      $('#loadingIndicator_graph').hide();
      $('#loadingIndicator_friend_statistics').hide();

    });
  }

  $.get('./assets/includes/users.php?friendsOf=<? echo $_SESSION['name'] ?>', function(data) {
    if(data >= 400){
      error_msg("Friends couldn't be loaded successfully.");
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
          title: 'Statistics',
          vAxis: {title: '',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      };
  


  </script>
  
  
<?
include('footer.php');
?>
