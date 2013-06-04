<?php
include('header.php');
?>

  	<script type="text/javascript">
  		var users = Array();
  		var loggedInUser = '<? echo $_SESSION["name"] ?>';

  		function addMemberToList(name){
  			//$('#friendsList').append('<li class="customLi"><div style="float:left;"><img src="assets/img/user.jpg" style="height: 45px";/></div><div style="float:left;"><div class="profile_name"><a href="profile.php?user='+name+'">'+name+'</a></div></div></li>');
  			$('#memberList').append('<li class="customLi"><img src="assets/img/user.jpg" style="height: 30px; margin-right: 10px; "/><a href="profile.php?user='+name+'">'+name+'</a></li>');
  		}

  		function joinGroup(){
  			$.get('./assets/includes/groups.php?joinGroup=<? echo $_GET['group'] ?>', function(data){
  				if(data >= 400){
  					cerror_msg("The group couldn't be joined successfully.");
  				}else{
  					addMemberToList("<? echo $_SESSION['name'] ?>");
  					$('#join_leave_group').html('<a href="javascript:leaveGroup()">Leave Group</a>');
  				}
  			})
  		}

  		 function leaveGroup(){
  			$.get('./assets/includes/groups.php?leaveGroup=<? echo $_GET['group'] ?>', function(data){
  				if(data >= 400){
  					error_msg("The group couldn't be left successfully.");
  				}else{
  					window.location.reload();
  				}
  			})
  		}

  		function deleteGroup(){
  			if(confirm("Are you sure you want to delete this group? This can't be undone!")){
	  			$.get('./assets/includes/groups.php?deleteGroup=<? echo $_GET['group'] ?>', function(data){
	  				if(data >= 400){
	  					error_msg("The group couldn't be deleted successfully.");
	  				}else{
	  					window.location.reload();
	  				}
	  			});
	  		}
  		}

  		function addGroupActivities(actionImg, friendImg, id, titel){
      		$('#groupActivities').append('<li class="customLi"><img src="'+actionImg+'" style="height: 30px; margin-right: 10px; "/><a href="'+id+'">'+titel+'</a><img src="'+friendImg+'" style="height: 30px; margin-right: 10px; float:right; "/></li>');
    	}


    	$.get('./assets/includes/groups.php?group=<? echo $_GET['group'] ?>', function(data) {
	      	if(data >= 400){
	          error_msg("Group information couldn't be loaded successfully.");
	      	}else{
		        data = JSON.parse(data);
    			$('#group_headline').html(data.name);
		        $('#group_description').html(data.description);
		        $('#group_owner').append('<a href="profile.php?user='+data.owner.name+'">'+data.owner.name+'</a>');
		        if(data.owner.name == loggedInUser){
		        	$('#delete_group').html('- <a href="javascript:deleteGroup()">Delete Group</a>');
		        }
		    }
		});

  		$.get('./assets/includes/groups.php?groupMembers=<? echo $_GET['group'] ?>', function(data) {
	      	if(data >= 400){
	          error_msg("Group members couldn't be loaded successfully.");
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
		          		$('#join_leave_group').html('<a href="javascript:leaveGroup()">Leave Group</a>');
		          	}else{
		          		$('#join_leave_group').html('<a href="javascript:joinGroup()">Join Group</a>');
		        }
	      	}
	  	});

	  	$.get('./assets/includes/groups.php?groupActivities=<? echo $_GET['group'] ?>', function(data) {
	      	if(data >= 400){
	          error_msg("Group activities couldn't be loaded successfully.");
	      	}else{
		        data = JSON.parse(data);
	          	if(data.activities.length > 0){
		            for(i = 0; i < data.activities.length; i++){
		              	var activity = data.activities[i];
		              	if(activity.type == "JOINED_GROUP"){
		                	addGroupActivities("./assets/img/person.svg","./assets/img/user.jpg", "group.php?group="+activity.group.name, "Joined: "+activity.group.name);
		              	}else if(activity.type == "CREATED_GROUP"){
		                	addGroupActivities("./assets/img/person.svg","./assets/img/user.jpg", "group.php?group="+activity.group.name, "Created: "+activity.group.name);
		              	}else if(activity.type == "FRIENDED_USER"){
		                	addGroupActivities("./assets/img/user.jpg","./assets/img/user.jpg", "profile.php?user="+activity.other.name, "Friended: "+activity.other.name);
		              	}else if(activity.type == "CREATED_TRACK"){
		                	addGroupActivities("./assets/img/route.svg","./assets/img/user.jpg", "track.php?id="+activity.track.properties.id, "Created: "+activity.track.properties.name);
		              	}
		            }
		        }else{
		          $('#groupActivities').append("No recent activities available");
		        }   
	      	}
	  	});


  	</script>
	
		<div class="container rightband">
			<div class="span7">
				<h2 id="group_headline"></h2>
				<div id="group_description"></div> 
			</div>
			<div class="span3 offset1">
				<div id="group_owner">Founded by: </div>
				<div id="join_leave_group" style="display:inline"></div>
				<div id="delete_group" style="display:inline"></div>
			</div>
				
			</div>
		</div>

		<div class="container leftband">

			<div class="span5">
				<h2>Members</h2>
				<ul id="memberList" style="max-height: 400px; overflow-y: auto;">	

				</ul>          
	        </div>
			
			<div class="span4">
				<h2><? echo $activities ?></h2>	
			  	<ul id="groupActivities" style="max-height: 400px; overflow-y: auto;">
			  	</ul>
	        </div>
	      </div>
		</div>


<?
include('footer.php');
?>