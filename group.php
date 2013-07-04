<?php
include('header.php');
?>

  	<script type="text/javascript">
  		var users = Array();
  		var loggedInUser = '<? echo $_SESSION["name"] ?>';
		
    function getAvatar(name, size){
      return './assets/includes/get.php?redirectUrl=https://giv-car.uni-muenster.de/stable/rest/users/'+name+'/avatar&auth=true';
    }

  		function addMemberToList(name){
  			//$('#friendsList').append('<li class="customLi"><div style="float:left;"><img src="assets/img/user.jpg" style="height: 45px";/></div><div style="float:left;"><div class="profile_name"><a href="profile.php?user='+name+'">'+name+'</a></div></div></li>');
  			$('#memberList').append('<li class="customLi"><img src='+getAvatar(name, 30)+' style="height: 30px; margin-right: 10px; "/><a href="profile.php?user='+name+'">'+name+'</a></li>');
  		}

  		function joinGroup(){
        $('#loadingIndicator').show();
  			$.get('./assets/includes/groups.php?joinGroup=<? echo $_GET['group'] ?>', function(data){
	      		if(data >= 400){
      			  if(data == 400){
      			    error_msg("<? echo $groupError ?>");
      			  }else if(data == 401 || data == 403){
      			    error_msg("<? echo $joinGroupNotAllowed ?>")
      			  }else if(data == 404){
      			    error_msg("<? echo $groupNotFound ?>")
      			  }
      			  $('#loadingIndicator').hide();
      			}else{
  					window.location.reload();
  				}
  			$('#loadingIndicator').hide();
        })
  		}

  		 function leaveGroup(){
        $('#loadingIndicator').show();
  			$.get('./assets/includes/groups.php?leaveGroup=<? echo $_GET['group'] ?>', function(data){
  				if(data >= 400){
            $('#loadingIndicator').hide();
  					error_msg("The group couldn't be left successfully.");
  				}else{
  					window.location.reload();
  				}
  			})
  		}

  		function deleteGroup(){
  			if(confirm("Are you sure you want to delete this group? This can't be undone!")){
          $('#loadingIndicator').show();
	  			$.get('./assets/includes/groups.php?deleteGroup=<? echo $_GET['group'] ?>', function(data){
	  				if(data >= 400){
              $('#loadingIndicator').hide();
	  					error_msg("The group couldn't be deleted successfully.");
	  				}else{
	  					window.location.href = "groups.php?group_deleted";
	  				}
	  			});
	  		}
  		}

  		function addGroupActivities(actionImg, friendImg, id, titel, date){
      		$('#groupActivities').append('<li class="customLi"><img src="'+actionImg+'" style="height: 30px; margin-right: 10px; "/><a href="'+id+'">'+titel+'</a><img src="'+friendImg+'" style="height: 30px; margin-right: 10px; float:right; "/><br><div>'+date+'</div></li>');
    	}


    	$.get('./assets/includes/groups.php?group=<? echo $_GET['group'] ?>', function(data) {
	      	if(data >= 400){
      		  if(data == 400){
      		    error_msg("<? echo $groupError ?>");
      		  }else if(data == 401 || data == 403){
      		    error_msg("<? echo $groupNotAllowed ?>")
      		  }else if(data == 404){
      		    error_msg("<? echo $groupNotFound ?>")
      		  }
      		  $('#loadingIndicator').hide();
      		}else{
		        data = JSON.parse(data);
    			$('#group_headline').html(data.name);
		        $('#group_description').html(data.description);
		        $('#group_owner').append('<a href="profile.php?user='+data.owner.name+'">'+data.owner.name+'</a>');
		        if(data.owner.name == loggedInUser){
		        	$('#delete_group').html('- <a href="javascript:deleteGroup()"><? echo $deletegroup ?></a>');
		        }
		    }
		});

  		$.get('./assets/includes/groups.php?groupMembers=<? echo $_GET['group'] ?>', function(data) {
      		if(data >= 400){
      		  if(data == 400){
      		    error_msg("<? echo $groupError ?>");
      		  }else if(data == 401 || data == 403){
      		   	$('#memberList').html("<? echo $groupMemberNotAllowed ?>");
      		    $('#join_leave_group').html('<a href="javascript:joinGroup()"><? echo $joingroup ?></a>');
      		  }else if(data == 404){
      		    error_msg("<? echo $groupNotFound ?>")
      		  }
      		  $('#loadingIndicator_members').hide();
      		}else{
		        data = JSON.parse(data);
		        var member = false;
		        if(data.users.length > 0 ){
		        	for(i = 0; i < data.users.length; i++){
		            	addMemberToList(data.users[i].name);

		            	if(loggedInUser == data.users[i].name){
		            		member = true;
		            	}

		          	}
		        }
		        if(member){
		          		$('#join_leave_group').html('<a href="javascript:leaveGroup()"><? echo $leavegroup ?></a>');
		          	}else{
		          		$('#join_leave_group').html('<a href="javascript:joinGroup()"><? echo $joingroup ?></a>');
		        }
	      	}
          $('#loadingIndicator_members').hide();
	  	});

	  	$.get('./assets/includes/groups.php?groupActivities=<? echo $_GET['group'] ?>', function(data) {
      		if(data >= 400){
      		  if(data == 400){
      		    error_msg("<? echo $activityError ?>");
      		  }else if(data == 401 || data == 403){
      		  	$('#groupActivities').html("<? echo $activityNotAllowed ?>");
      		  }else if(data == 404){
      		    error_msg("<? echo $activityNotFound ?>")
      		  }
      		  $('#loadingIndicator_activities').hide();
      		}else{
		        data = JSON.parse(data);
	          	if(data.activities.length > 0){
		            for(i = 0; i < data.activities.length; i++){
		              	var activity = data.activities[i];
		              	if(activity.type == "JOINED_GROUP"){
		                	if(activity.group) addGroupActivities("./assets/img/person.svg",getAvatar(activity.user.name,30), "group.php?group="+activity.group.name, activity.user.name+" <? echo $joined ?>: "+activity.group.name, convertToLocalTime(activity.time));
		              	}else if(activity.type == "CREATED_GROUP"){
		                	if(activity.group) addGroupActivities("./assets/img/person.svg",getAvatar(activity.user.name,30), "group.php?group="+activity.group.name, activity.user.name+" <? echo $createdGroup ?>: "+activity.group.name, convertToLocalTime(activity.time));
		              	}else if(activity.type == "FRIENDED_USER"){
		                	addGroupActivities(getAvatar(activity.user.name,30),getAvatar(activity.other.name,30), "profile.php?user="+activity.other.name, activity.user.name+" <? echo $friended ?>: "+activity.other.name, convertToLocalTime(activity.time));
		              	}else if(activity.type == "CREATED_TRACK"){
		                	addGroupActivities("./assets/img/route.svg",getAvatar(activity.user.name,30), "route.php?id="+activity.track.id, activity.user.name+" <? echo $createdRoute ?>: "+activity.track.name, convertToLocalTime(activity.time));
		              	}else if(activity.type == "LEFT_GROUP"){
		                	if(activity.group) addGroupActivities("./assets/img/person.svg",getAvatar(activity.user.name,30), "group.php?group="+activity.group.name, activity.user.name+" <? echo $left ?>: "+activity.group.name, convertToLocalTime(activity.time));
		              	}else if(activity.type == "CHANGED_PROFILE"){
		                	addGroupActivities("./assets/img/person.svg",getAvatar(activity.user.name,30), "profile.php?user="+activity.user.name, activity.user.name+' <? echo $changedProfile?>', convertToLocalTime(activity.time));
		              	}else if(activity.type == "CHANGED_GROUP"){
		                	if(activity.group) addGroupActivities("./assets/img/person.svg",getAvatar(activity.user.name,30), "group.php?group="+activity.group.name, activity.user.name+" <? echo $changedGroup ?>: "+activity.group.name, convertToLocalTime(activity.time));
		              	}
		            }
		        }else{
		          $('#groupActivities').append("<? echo $norecentactivities ?>");
		        }   
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


      return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d) + ' ' + hours +':'+ minutes;
    }


  	</script>
	<div id="loadingIndicator" class="loadingIndicator" style="display:none">
    <div style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
  </div>
		<div class="container rightband">
			<div class="span7">
				<h2 id="group_headline"></h2>
				<div id="group_description"></div> 
			</div>
			<div class="span3 offset1">
				<div id="group_owner"><? echo $foundedby ?>: </div>
				<div id="join_leave_group" style="display:inline"></div>
				<div id="delete_group" style="display:inline"></div>
			</div>
				
			</div>
		</div>

		<div class="container leftband">

			<div class="span5">
				<h2><? echo $member ?></h2>
          <div id="loadingIndicator_members" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
				<ul id="memberList" style="max-height: 400px; overflow-y: auto;">	

				</ul>          
	        </div>
			
			<div class="span4">
				<h2><? echo $dashboard_group_activities ?></h2>	
          <div id="loadingIndicator_activities" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
			  	<ul id="groupActivities" style="max-height: 400px; overflow-y: auto;">
			  	</ul>
	        </div>
	      </div>
		</div>


<?
include('footer.php');
?>