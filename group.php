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


  	</script>
	
		<div class="container rightband"> 
			<div id="join_leave_group" style="float:right">
				
			</div>


			<div class="span5" style="max-height:400px">
				<h2>Members</h2>
				<ul id="memberList">	

				</ul>          
	        </div>
			
			<div class="span4">
				<h2><? echo $activities ?></h2>
				<!--
			  	<ul>
			  	<li class="customLi">
					<a href="">Albert Remke</a>
					<br/>
					awards economic driver today
				</li>
				<li class="customLi">
					<a href="">Jakob </a>
					<br/>
					moving towards muenster city
				</li>
				<li class="customLi">
					<a href="">Dennis</a>
					<br/>
					 spend 20 euro for travelling 100 km
				</li>
				<li class="customLi">
					<a href="">Stephnie</a>
					<br/>
					release4 gml co2 during last drive
				</li>
			  </ul>
			-->
	        </div>
	      </div>
		</div>


<?
include('footer.php');
?>