<?php
include('header.php');

if(isset($_GET['group_deleted'])){
?>
<div id="deleted" class="container alert alert-block fade in"> 
  <a class="close" data-dismiss="alert">×</a>  
  <h4 class="alert-heading">Group deleted</h4>  
  	Group successfully deleted
</div> 
<?
}
?>

 	<script type="text/javascript">
  		var groups = Array();

  		function addGroupToList(name){
  			//$('#friendsList').append('<li class="customLi"><div style="float:left;"><img src="assets/img/user.jpg" style="height: 45px";/></div><div style="float:left;"><div class="profile_name"><a href="profile.php?user='+name+'">'+name+'</a></div></div></li>');
  			$('#groupsList').append('<li class="customLi"><img src="assets/img/user.jpg" style="height: 30px; margin-right: 10px; "/><a href="group.php?group='+name+'">'+name+'</a></li>');
  		}

  		$.get('./assets/includes/users.php?groupsOf=<? echo $_SESSION["name"] ?>', function(data) {
      		if(data >= 400){
      		  if(data == 400){
      		    error_msg("<? echo $groupOfError ?>");
      		  }else if(data == 401 || data == 403){
      		    error_msg("<? echo $groupOfNotAllowed ?>")
      		  }else if(data == 404){
      		    error_msg("<? echo $groupOfNotFound ?>")
      		  }
      		  $('#loadingIndicator').hide();
      		}else{
		        data = JSON.parse(data);
		        if(data.groups.length > 0 ){
		        	for(i = 0; i < data.groups.length; i++){
		            	addGroupToList(data.groups[i].name);
		          	}
		        }
	      	}
	  	});

	  	$.get('./assets/includes/groups.php?groups', function(data){
      		if(data >= 400){
      		  if(data == 400){
      		    error_msg("<? echo $groupError ?>");
      		  }else if(data == 401 || data == 403){
      		    error_msg("<? echo $groupNotAllowed ?>")
      		  }else if(data == 404){
      		    error_msg("<? echo $groupNotFound ?>")
      		  }
      		  $('#loadingIndicator_groups').hide();
      		}else{
	  			data = JSON.parse(data);
	  			for(i = 0; i < data.groups.length; i++){
	  				groups.push(data.groups[i].name);
	  			}
	  			$('#searchgroups').typeahead({source: groups, updater:function (item) {
        			window.location.href = "group.php?group="+item;
			    }});
	  		}
	  		$('#loadingIndicator_groups').hide();
	  	});

	  	$(function(){
		  	$('#createGroupForm').submit(function(){
		  		if($('#group_name').val() === '' || $('#group_description').val() === ''){
	  				alert("<? echo $bothFieldsFilled ?>");
	  			}else{
	  				if(!validateInput($('#group_name').val()) && !validateInput($('#group_description').val())){
	  					$('#loadingIndicator').show();	
		  				$.post('./assets/includes/groups.php?createGroup', {group_name: $('#group_name').val(), group_description: $('#group_description').val()}, 
			            	function(response){
			              		if(response >= 400){
			              			error_msg("<? echo $creategrouperror ?>");
			              		}else{
			              			window.location.href="group.php?group="+$('#group_name').val();
			              		}
			            });
		  			}else{
		  				$('#loadingIndicator').hide();
		  				alert("<? echo $invalidCharacterError ?>");
		  			}
	  			}
		  		return false;
		  	});
		});

		function validateInput(input){
			re = /[&=`\[\]"'<>\/]/;
			return re.test(input);
		}


  	</script>
<div id="loadingIndicator" class="loadingIndicator">
  <div style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px; display:none"></div>
</div>
  		<div id="create_group_modal" class="modal hide fade">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    <h3>Create Group</h3>
		  </div>
		  <div class="modal-body">
		  	<form id="createGroupForm" action="./assets/includes/groups.php?createGroup" method="post">
		    	<input id="group_name" type="text" class="input-block-level" placeholder="Group name">
		    	<input id="group_description" type="text" class="input-block-level" placeholder="Description">
		    	<input type="submit" class="btn btn-primary">
		    </form>
		  </div>
		  <div class="modal-footer">
		    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		  </div>
		</div>


		<div class="container leftband">
			<div class="span7">
				<h2 id="groups_headline"></h2> 
			</div>
			<div class="span3 offset1">
				<div id="create_group" style="float:right"><a href="#create_group_modal" role="button" class="btn" data-toggle="modal">Create Group</a></div>
			</div>
				
			</div>
		</div>
	
		<div class="container rightband"> 
			<input id="searchgroups" type="text" name="text" placeholder="Search Groups" style="float:right" data-provide="typeahead"/>


			<div class="span6">
				<h2>Groups</h2>
				 <div id="loadingIndicator_groups" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
				<ul id="groupsList" style="max-height: 400px; overflow-y: auto;">	

				</ul>          
	        </div>
			
	      </div>
		</div>


<?
include('footer.php');
?>