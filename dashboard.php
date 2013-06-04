<?
include('header.php');
?>
  <script type="text/javascript">
    
    function addRecentActivities(img, id, titel){
      $('#recentActivities').append('<li class="customLi"><img src="'+img+'" style="height: 30px; margin-right: 10px; "/><a href="'+id+'">'+titel+'</a></li>');
    }

    function addFriendActivities(actionImg, friendImg, id, titel){
      $('#friendActivities').append('<li class="customLi"><img src="'+actionImg+'" style="height: 30px; margin-right: 10px; "/><a href="'+id+'">'+titel+'</a><img src="'+friendImg+'" style="height: 30px; margin-right: 10px; float:right; "/></li>');
    }

    $.get('./assets/includes/users.php?userActivities', function(data) {
      if(data >= 400){
            error_msg("Activities couldn't be loaded successfully.");
      }else{
          data = JSON.parse(data);
          if(data.activities.length > 0){
            for(i = 0; i < data.activities.length; i++){
              var activity = data.activities[i];
              if(activity.type == "JOINED_GROUP"){
                addRecentActivities("./assets/img/person.svg", "group.php?group="+activity.group.name, "Joined: "+activity.group.name);
              }else if(activity.type == "CREATED_GROUP"){
                addRecentActivities("./assets/img/person.svg", "group.php?group="+activity.group.name, "Created: "+activity.group.name);
              }else if(activity.type == "FRIENDED_USER"){
                addRecentActivities("./assets/img/user.jpg", "profile.php?user="+activity.other.name, "Friended: "+activity.other.name);
              }else if(activity.type == "CREATED_TRACK"){
                addRecentActivities("./assets/img/route.svg", "track.php?id="+activity.track.properties.id, "Created: "+activity.track.properties.name);
              }
            }
        }else{
          $('#recentActivities').append("No recent activities available");
        }
      }
    });


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