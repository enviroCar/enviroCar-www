<?php
include('header.php');
?>

  	<script type="text/javascript">
  		var groups = Array();

  		function addGroupToList(name){
  			//$('#friendsList').append('<li class="customLi"><div style="float:left;"><img src="assets/img/user.jpg" style="height: 45px";/></div><div style="float:left;"><div class="profile_name"><a href="profile.php?user='+name+'">'+name+'</a></div></div></li>');
  			$('#groupsList').append('<li class="customLi"><img src="assets/img/user.jpg" style="height: 30px; margin-right: 10px; "/><a href="group.php?group='+name+'">'+name+'</a></li>');
  		}

  		$.get('./assets/includes/users.php?groupsOf=<? echo $_SESSION["name"] ?>', function(data) {
	      	if(data >= 400){
	          console.log('error in getting groups');
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
	  			console.log("error in getting groups");
			}
	  		else{
	  			data = JSON.parse(data);
	  			for(i = 0; i < data.groups.length; i++){
	  				groups.push(data.groups[i].name);
	  			}
	  			$('#searchgroups').typeahead({source: groups, updater:function (item) {
        			window.location.href = "group.php?group="+item;
			    }});
	  		}
	  	});

  	</script>
	
		<div class="container rightband"> 
			<input id="searchgroups" type="text" name="text" placeholder="Search Groups" style="float:right" data-provide="typeahead"/>


			<div class="span5" style="max-height:400px">
				<h2>Groups</h2>
				<ul id="groupsList">	

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