<?
include('header.php');
?>
  <script type="text/javascript">
    
    function addRecentActivities(img, id, titel, date){
      $('#recentActivities').append('<li class="customLi"><img src="'+img+'" style="height: 30px; margin-right: 10px; "/><a href="'+id+'">'+titel+'</a><br><div>'+date+'</div></li>');
    }

    function addFriendActivities(actionImg, friendImg, id, titel, date){
      $('#friendActivities').append('<li class="customLi"><img src="'+actionImg+'" style="height: 30px; margin-right: 10px; "/><a href="'+id+'">'+titel+'</a><img src="'+friendImg+'" style="height: 30px; margin-right: 10px; float:right; "/><br><div>'+date+'</div></li>');
    }

    function addPhenomenonStatistics(name, avg, unit){
      $('#phenomenonStatistics').append('<li class="customLi"><img src="./assets/img/route.svg" style="height: 30px; margin-right: 10px; "/>&Oslash;  '+name+':  '+Math.round(avg*100)/100+" "+unit);
    }

    function addOverallStatistics(name, value){
        $('#overallStatistics').append('<li class="customLi"><img src="./assets/img/route.svg" style="height: 30px; margin-right: 10px; "/>'+name+':  '+value);
    }
	
	function getAvatar(name, size){
		return './assets/includes/get.php?url=https://giv-car.uni-muenster.de/stable/rest/users/'+name+'/avatar?size='+size+'&auth=true';
	}

    $.get('./assets/includes/users.php?userActivities', function(data) {
      if(data >= 400){
            error_msg("<? echo $activityerror ?>");
      }else{
          data = JSON.parse(data);
          if(data.activities.length > 0){
            for(i = 0; i < data.activities.length; i++){
              var activity = data.activities[i];
              if(activity.type == "JOINED_GROUP"){
                if(activity.group)addRecentActivities("./assets/img/person.svg", "group.php?group="+activity.group.name, "<? echo $joined ?>: "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CREATED_GROUP"){
                if(activity.group) addRecentActivities("./assets/img/person.svg", "group.php?group="+activity.group.name, "<? echo $created ?>: "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "FRIENDED_USER"){
                addRecentActivities(getAvatar(activity.other.name, 30), "profile.php?user="+activity.other.name, "<? echo $friended ?>: "+activity.other.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CREATED_TRACK"){
                addRecentActivities("./assets/img/route.svg", "route.php?id="+activity.track.id, "<? echo $created ?>: "+activity.track.name, convertToLocalTime(activity.time));
              }else if(activity.type == "LEFT_GROUP"){
                if(activity.group) addRecentActivities("./assets/img/person.svg", "group.php?group="+activity.group.name, "<? echo $left ?>: "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CHANGED_GROUP"){
                if(activity.group) addRecentActivities("./assets/img/person.svg", "group.php?group="+activity.group.name, "<? echo $changed ?>: "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CHANGED_PROFILE"){
                addRecentActivities(getAvatar(activity.user.name, 30), "profile.php?user="+activity.user.name, "<? echo $updated ?>: "+activity.user.name, convertToLocalTime(activity.time));
              }
            }
        }else{
          $('#recentActivities').append("<? echo $norecentactivities ?>");
        }
      }
    });
    

    $.get('./assets/includes/users.php?friendActivities', function(data) {
      if(data >= 400){
            error_msg("<? echo $activityerror ?>");
      }else{
          data = JSON.parse(data);

          if(data.activities.length > 0){

            for(i = 0; i < data.activities.length; i++){
              var activity = data.activities[i];
              if(activity.type == "JOINED_GROUP"){
                if(activity.group)addFriendActivities("./assets/img/person.svg",getAvatar(activity.user.name, 30), "group.php?group="+activity.group.name, "<? echo $joined ?>: "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CREATED_GROUP"){
                if(activity.group) addFriendActivities("./assets/img/person.svg",getAvatar(activity.user.name, 30), "group.php?group="+activity.group.name, "<? echo $created ?>: "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "FRIENDED_USER"){
                addFriendActivities(getAvatar(activity.other.name, 30),getAvatar(activity.user.name, 30), "profile.php?user="+activity.other.name, "<? echo $friended ?>: "+activity.other.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CREATED_TRACK"){
                addFriendActivities("./assets/img/route.svg",getAvatar(activity.user.name, 30), "route.php?id="+activity.track.id, "<? echo $created ?>: "+activity.track.name, convertToLocalTime(activity.time));
              }else if(activity.type == "LEFT_GROUP"){
                if(activity.group) addFriendActivities("./assets/img/person.svg", getAvatar(activity.user.name, 30), "group.php?group="+activity.group.name, "<? echo $left ?>: "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CHANGED_GROUP"){
                if(activity.group) addFriendActivities("./assets/img/person.svg", getAvatar(activity.user.name, 30), "group.php?group="+activity.group.name, "<? echo $changed ?>: "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CHANGED_PROFILE"){
                addFriendActivities("./assets/img/user.jpg",getAvatar(activity.user.name, 30), "profile.php?user="+activity.user.name, "<? echo $updated ?>: "+activity.user.name, convertToLocalTime(activity.time));
              }
            }
            
        }else{
          $('#friendActivities').append("<? echo $norecentactivities ?>");
        }
      }
    });


    $.get('./assets/includes/users.php?userStatistics', function(data) {
      if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404){
            error_msg("Routes couldn't be loaded successfully.");
        }else{
          data = JSON.parse(data);
          if(data.statistics.length > 0){
            for(i = 0; i < data.statistics.length; i++){
               addPhenomenonStatistics(data.statistics[i].phenomenon.name, data.statistics[i].avg, data.statistics[i].phenomenon.unit);
            }

          }else{
            $('#loadingIndicator').hide();
          }
      }
    });

    $.get('./assets/includes/users.php?tracks', function(data) {
      if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404){
            error_msg("Routes couldn't be loaded successfully.");
        }else{
          data = JSON.parse(data);
          if(data.tracks != null){
            numberofTracks = data.tracks.length;
            addOverallStatistics("Tracks", numberofTracks);
          }

      }
    });

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


  </script>
  
	<div class="container rightband">
	<div class="row-fluid">
        <div class="span4">
          <h2><?php echo $dashboard_recent_avtivities; ?></h2>
		      <ul id="recentActivities" style="margin-bottom: 10px; max-height: 400px; overflow-y: auto;">
		      </ul>
        </div>

        <div class="span4">
          <h2><?php echo $dashboard_overview; ?></h2>
          <div style="max-height: 400px; overflow-y: auto;">
            <ul id="overallStatistics">
            </ul>
            <ul id="phenomenonStatistics">
            </ul>
          </div>
       </div>

        <div class="span4">
          <h2><?php echo $dashboard_friend_activities; ?></h2>
		  <ul id="friendActivities" style="margin-bottom: 10px; max-height: 400px; overflow-y:auto">
              
		  </ul>
		  <p> </p>
        </div>
      </div>

	</div>


<?
include('footer.php');
?>