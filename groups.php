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

if(isset($_GET['group_deleted'])){
?>
<div id="deleted" class="container alert alert-block fade in"> 
  <a class="close" data-dismiss="alert">×</a>  
  <h4 class="alert-heading"><?php echo $deletedgroup; ?></h4>  
  	<?php echo $deletegroupsuccess; ?>
</div> 
<?php 
}
?>

 	<script type="text/javascript">
  		var groups = Array();

  		function addGroupToList(name){
  			//$('#friendsList').append('<li class="customLi"><div style="float:left;"><img src="assets/img/user.jpg" style="height: 45px";/></div><div style="float:left;"><div class="profile_name"><a href="profile.php?user='+name+'">'+name+'</a></div></div></li>');
  			$('#groupsList').append('<li class="customLi"><img src="assets/img/user.jpg" style="height: 30px; margin-right: 10px; "/><a href="group.php?group='+name+'">'+name+'</a></li>');
  		}

  		$.get('./assets/includes/users.php?groupsOf=<?php echo $_SESSION["name"] ?>', function(data) {
      		if(data >= 400){
      		  if(data == 400){
      		    error_msg("<?php echo $groupOfError ?>");
      		  }else if(data == 401 || data == 403){
      		    error_msg("<?php echo $groupOfNotAllowed ?>")
      		  }else if(data == 404){
      		    error_msg("<?php echo $groupOfNotFound ?>")
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
      		    error_msg("<?php echo $groupError ?>");
      		  }else if(data == 401 || data == 403){
      		    error_msg("<?php echo $groupNotAllowed ?>")
      		  }else if(data == 404){
      		    error_msg("<?php echo $groupNotFound ?>")
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
	  				alert("<?php echo $bothFieldsFilled ?>");
	  			}else{
	  				if(!validateInput($('#group_name').val()) && !validateInput($('#group_description').val())){
	  					$('#loadingIndicator').show();	
		  				$.post('./assets/includes/groups.php?createGroup', {group_name: $('#group_name').val(), group_description: $('#group_description').val()}, 
			            	function(response){
			              		if(response >= 400){
			              			error_msg("<?php echo $creategrouperror ?>");
			              		}else{
			              			window.location.href="group.php?group="+$('#group_name').val();
			              		}
			            });
		  			}else{
		  				$('#loadingIndicator').hide();
		  				alert("<?php echo $invalidCharacterError ?>");
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
	<div id="loadingIndicator" class="loadingIndicator" style="display:none">
		<div style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px">
		</div>
	</div>
	<div id="create_group_modal" class="modal hide fade">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h3><?php echo $creategroup; ?></h3>
	  </div>
	  <div class="modal-body">
	  	<form id="createGroupForm" action="./assets/includes/groups.php?createGroup" method="post">
			<label for="group_name"><?php echo $groupname; ?></label>
	    	<input id="group_name" type="text" class="input-block-level" placeholder="<?php echo $groupname; ?>">
	    	<label for="group_description"><?php echo $groupdescription; ?></label>
	    	<input id="group_description" type="text" class="input-block-level" placeholder="<?php echo $groupdescription; ?>">
	    	<input type="submit" class="btn btn-primary" value="<?php echo $creategroup;?>">
	    </form>
	  </div>
	  <div class="modal-footer">
	    <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $close; ?></button>
	  </div>
	</div>

	<div class="container leftband">
		<div class="row">
			<div class="span5">
				<div id="create_group">
					<a href="#create_group_modal" role="button" class="btn btn-primary" data-toggle="modal"><?php echo $creategroup; ?></a>
				</div>
			</div>
			<div class="span6">
				<input id="searchgroups" type="text" name="text" placeholder="<?php echo $searchgroups; ?>" style="float:right" data-provide="typeahead"/>
			</div>
		</div>
		<div class="row">
			<div class="span6">
				<h2><?php echo $groups; ?></h2>
				
				<div id="loadingIndicator_groups" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
				<ul id="groupsList" style="max-height: 400px; overflow-y: auto;">
				</ul>          
			</div>
		</div>
	</div>


<?php 
include('footer.php');