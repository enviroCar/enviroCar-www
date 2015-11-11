<?php
/*
* This file is part of enviroCar.
* 
* enviroCar is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* enviroCar is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with enviroCar.  If not, see <http://www.gnu.org/licenses/>.
*/

include('header.php');
?>

  	<script type="text/javascript">
  		var users = Array();

  		function addFriendToList(name){
  			//$('#friendsList').append('<li class="customLi"><div style="float:left;"><img src="assets/img/user.jpg" style="height: 45px";/></div><div style="float:left;"><div class="profile_name"><a href="profile.php?user='+name+'">'+name+'</a></div></div></li>');
  			$('#friendsList').append('<li class="customLi"><img src='+getAvatar(name, 30)+' style="height: 30px; margin-right: 10px; "/><a href="profile.php?user='+name+'">'+name+'</a></li>');
  		}

  		function addFriendActivities(actionImg, friendImg, id, titel, date){
      		$('#friendActivities').append('<li class="customLi"><img src="'+actionImg+'" style="height: 30px; margin-right: 10px; "/><a href="'+id+'">'+titel+'</a><img src="'+friendImg+'" style="height: 30px; margin-right: 10px; float:right; "/><br><div>'+date+'</div></li>');
    	}
		
		function getAvatar(name, size){
			return './assets/includes/get.php?redirectUrl=https://envirocar.org/api/stable/users/'+name+'/avatar&auth=true';
		}

  		$.get('./assets/includes/users.php?friendsOf=<?php echo $_SESSION['name'] ?>', function(data) {
          if(data >= 400){
            console.log(data);
            if(data == 400){
                error_msg("<?php echo $friendError ?>");
            }else if(data == 401 || data == 403){
              error_msg("<?php echo $friendNotAllowed ?>")
            }else if(data == 404){
              error_msg("<?php echo $friendNotFound ?>")
            }
            $('#loadingIndicator_friends').hide();
          }else{
		        data = JSON.parse(data);
            if(data.users.length > 0 ){
		        	for(i = 0; i < data.users.length; i++){
		            	addFriendToList(data.users[i].name);
		          	}
		        }else{
              $('#friendsList').html("<?php echo $madeNoFriends ?>");
            }
	      	}
          $('#loadingIndicator_friends').hide();
	  	});

	  	$.get('./assets/includes/users.php?users', function(data){
        if(data >= 400){
          console.log(data);
          if(data == 400){
              error_msg("<?php echo $personError ?>");
          }else if(data == 401 || data == 403){
            error_msg("<?php echo $personNotAllowed ?>")
          }else if(data == 404){
            error_msg("<?php echo $personNotFound ?>")
          }
          $('#loadingIndicator').hide();
        }
	  		else{
	  			data = JSON.parse(data);
	  			for(i = 0; i < data.users.length; i++){
	  				users.push(data.users[i].name);
	  			}
	  			$('#searchfriends').typeahead({source: users, updater:function (item) {
        			window.location.href = "profile.php?user="+item;
			    }});
	  		}
	  	});


	$.get('./assets/includes/users.php?friendActivities', function(data) {
      if(data >= 400){
        console.log(data);
        if(data == 400){
            error_msg("<?php echo $activityError ?>");
        }else if(data == 401 || data == 403){
          error_msg("<?php echo $activityNotAllowed ?>")
        }else if(data == 404){
          error_msg("<?php echo $activityNotFound ?>")
        }
        $('#loadingIndicator_activities').hide();
      }else{
          data = JSON.parse(data);

          if(data.activities.length > 0){

            for(i = 0; i < data.activities.length; i++){
              var activity = data.activities[i];
              if(activity.type == "JOINED_GROUP"){
                if(activity.group)addFriendActivities("./assets/img/person.svg",getAvatar(activity.user.name, 30), "group.php?group="+activity.group.name, activity.user.name+" <?php echo $joined ?> "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CREATED_GROUP"){
                if(activity.group) addFriendActivities("./assets/img/person.svg",getAvatar(activity.user.name, 30), "group.php?group="+activity.group.name, activity.user.name+"<?php echo $createdGroup ?>: "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "FRIENDED_USER"){
                if(activity.hasOwnProperty("other")) addFriendActivities(getAvatar(activity.other.name, 30),getAvatar(activity.user.name, 30), "profile.php?user="+activity.other.name, activity.user.name+" <?php echo $friended ?> "+activity.other.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CREATED_TRACK"){
                if(typeof activity.track != 'undefined') addFriendActivities("./assets/img/route.svg",getAvatar(activity.user.name, 30), "route.php?id="+activity.track.id, activity.user.name+" <?php echo $createdRoute ?>: "+activity.track.name, convertToLocalTime(activity.time));
              }else if(activity.type == "LEFT_GROUP"){
                if(activity.group) addFriendActivities("./assets/img/person.svg", getAvatar(activity.user.name, 30), "group.php?group="+activity.group.name, activity.user.name+" <?php echo $left ?>: "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CHANGED_GROUP"){
                if(activity.group) addFriendActivities("./assets/img/person.svg", getAvatar(activity.user.name, 30), "group.php?group="+activity.group.name, activity.user.name+" <?php echo $changedGroup ?>: "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CHANGED_PROFILE"){
                addFriendActivities("./assets/img/user.jpg",getAvatar(activity.user.name, 30), "profile.php?user="+activity.user.name, activity.user.name+' <?php echo $changedProfile?>', convertToLocalTime(activity.time));
              }
            }
            
        }else{
          $('#friendActivities').append("<?php echo $norecentactivities ?>");
        }
        $('#loadingIndicator_activities').hide();
      }
      $('#loadingIndicator_activities').hide();
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
	
		<div class="container leftband">
			<div class="row">
        <div class="span12">
				  <input id="searchfriends" type="text" name="text" placeholder="<?php echo $searchfriends ?>" data-provide="typeahead"/>
			  </div>
      </div>
      <div class="row"> 
  			<div class="span5">
  				<h2> <?php echo $friends ?></h2>
  				<div id="loadingIndicator_friends" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;">
  				</div>
  				<ul id="friendsList" style="max-height: 400px; overflow-y: auto;">	
  				</ul>          
  			</div>
  			<div class="span6">
  				<h2><?php echo $dashboard_friend_activities; ?></h2>
                  <div id="loadingIndicator_activities" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;">
                  </div>
  				<ul id="friendActivities" style="margin-bottom: 10px; max-height: 400px; overflow-y:auto">       
  				</ul>
  			</div>
      </div>
		</div>
<?php 
include('footer.php');