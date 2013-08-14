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
      return './assets/includes/get.php?redirectUrl=https://giv-car.uni-muenster.de/stable/rest/users/'+name+'/avatar&auth=true';
    }

    $.get('./assets/includes/users.php?userActivities', function(data) {
      if(data >= 400){
        console.log(data);
        if(data == 400){
            error_msg("<? echo $activityError ?>");
        }else if(data == 401 || data == 403){
          error_msg("<? echo $activityNotAllowed ?>")
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
                if(activity.group)addRecentActivities("./assets/img/person.svg", "group.php?group="+activity.group.name, activity.user.name+" <? echo $joined ?> "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CREATED_GROUP"){
                if(activity.group) addRecentActivities("./assets/img/person.svg", "group.php?group="+activity.group.name, activity.user.name+" <? echo $createdGroup ?> "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "FRIENDED_USER"){
                addRecentActivities(getAvatar(activity.other.name, 30), "profile.php?user="+activity.other.name, activity.user.name+" <? echo $friended ?> "+activity.other.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CREATED_TRACK"){
                if(typeof activity.track != 'undefined') addRecentActivities("./assets/img/route.svg", "route.php?id="+activity.track.id, activity.user.name+" <? echo $createdRoute ?>: "+activity.track.name, convertToLocalTime(activity.time));
              }else if(activity.type == "LEFT_GROUP"){
                if(activity.group) addRecentActivities("./assets/img/person.svg", "group.php?group="+activity.group.name, activity.user.name+" <? echo $left ?> "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CHANGED_GROUP"){
                if(activity.group) addRecentActivities("./assets/img/person.svg", "group.php?group="+activity.group.name, activity.user.name+" <? echo $changedGroup ?> "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CHANGED_PROFILE"){
                addRecentActivities(getAvatar(activity.user.name, 30), "profile.php?user="+activity.user.name, activity.user.name+" <? echo $changedProfile ?>", convertToLocalTime(activity.time));
              }
            }
        }else{
          $('#recentActivities').append("<? echo $norecentactivities ?>");
        }
        $('#loadingIndicator_activities').hide();
      }
    });
    

    $.get('./assets/includes/users.php?friendActivities', function(data) {
      if(data >= 400){
        console.log(data);
        if(data == 400){
          error_msg("<? echo $activityError ?>");
        }else if(data == 401 || data == 403){
          error_msg("<? echo $activityNotAllowed ?>")
        }else if(data == 404){
          error_msg("<? echo $activityNotFound ?>")
        }
        $('#loadingIndicator_friend_activities').hide();
      }else{
          data = JSON.parse(data);

          if(data.activities.length > 0){

            for(i = 0; i < data.activities.length; i++){
              var activity = data.activities[i];
              if(activity.type == "JOINED_GROUP"){
                if(activity.group)addFriendActivities("./assets/img/person.svg",getAvatar(activity.user.name, 30), "group.php?group="+activity.group.name, activity.user.name+" <? echo $joined ?> "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CREATED_GROUP"){
                if(activity.group) addFriendActivities("./assets/img/person.svg",getAvatar(activity.user.name, 30), "group.php?group="+activity.group.name, activity.user.name+" <? echo $createdGroup ?> "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "FRIENDED_USER"){
                addFriendActivities(getAvatar(activity.other.name, 30),getAvatar(activity.user.name, 30), "profile.php?user="+activity.other.name, activity.user.name+" <? echo $friended ?> "+activity.other.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CREATED_TRACK"){
                if(typeof activity.track != 'undefined') addFriendActivities("./assets/img/route.svg",getAvatar(activity.user.name, 30), "route.php?id="+activity.track.id, activity.user.name+" <? echo $createdRoute ?> "+activity.track.name, convertToLocalTime(activity.time));
              }else if(activity.type == "LEFT_GROUP"){
                if(activity.group) addFriendActivities("./assets/img/person.svg", getAvatar(activity.user.name, 30), "group.php?group="+activity.group.name, activity.user.name+" <? echo $left ?> "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CHANGED_GROUP"){
                if(activity.group) addFriendActivities("./assets/img/person.svg", getAvatar(activity.user.name, 30), "group.php?group="+activity.group.name, activity.user.name+" <? echo $changedGroup ?> "+activity.group.name, convertToLocalTime(activity.time));
              }else if(activity.type == "CHANGED_PROFILE"){
                addFriendActivities("./assets/img/user.jpg",getAvatar(activity.user.name, 30), "profile.php?user="+activity.user.name, activity.user.name+" <? echo $changedProfile ?>", convertToLocalTime(activity.time));
              }
            }
            
        }else{
          $('#friendActivities').append("<? echo $norecentactivities ?>");
        }
        $('#loadingIndicator_friend_activities').hide();
      }
    });


    $.get('./assets/includes/users.php?userStatistics', function(data) {
      if(data >= 400){
        console.log(data);
        if(data == 400){
            error_msg("<? echo $statisticsError ?>");
        }else if(data == 401 || data == 403){
          error_msg("<? echo $statisticsNotAllowed ?>")
        }else if(data == 404){
          error_msg("<? echo $statisticsNotFound ?>")
        }
        $('#loadingIndicator_overview').hide();
      }else{
          data = JSON.parse(data);
          if(data.statistics.length > 0){
            for(i = 0; i < data.statistics.length; i++){
               addPhenomenonStatistics(data.statistics[i].phenomenon.name, data.statistics[i].avg, data.statistics[i].phenomenon.unit);
            }

          }else{
            $('#loadingIndicator_overview').hide();
          }
      }
      $('#loadingIndicator_overview').hide();
    });

    $.get('./assets/includes/users.php?tracks', function(data) {
      if(data >= 400){
        console.log(data);
        if(data == 400){
            error_msg("<? echo $routeError ?>");
        }else if(data == 401 || data == 403){
          error_msg("<? echo $routeNotAllowed ?>")
        }else if(data == 404){
          error_msg("<? echo $routeNotFound ?>")
        }
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

		var users = Array();

  		function addFriendToList(name){
  			//$('#friendsList').append('<li class="customLi"><div style="float:left;"><img src="assets/img/user.jpg" style="height: 45px";/></div><div style="float:left;"><div class="profile_name"><a href="profile.php?user='+name+'">'+name+'</a></div></div></li>');
  			$('#friendsList').append('<li class="customLi"><img src='+getAvatar(name, 30)+' style="height: 30px; margin-right: 10px; "/><a href="profile.php?user='+name+'">'+name+'</a><a style="margin-left: 70px;" href="javascript:removeAsFriend(' + "'" + name + "'" + ');"><? echo $removeasfriend ?></a></li>');
  		}

  		$.get('./assets/includes/users.php?friendsOf=<? echo $_SESSION['name'] ?>', function(data) {
          if(data >= 400){
            console.log(data);
            if(data == 400){
                error_msg("<? echo $friendError ?>");
            }else if(data == 401 || data == 403){
              error_msg("<? echo $friendNotAllowed ?>")
            }else if(data == 404){
              error_msg("<? echo $friendNotFound ?>")
            }
            $('#loadingIndicator_friends').hide();
          }else{
		        data = JSON.parse(data);
            if(data.users.length > 0 ){
		        	for(i = 0; i < data.users.length; i++){
		            	addFriendToList(data.users[i].name);
		          	}
		        }else{
              $('#friendsList').html("<? echo $madeNoFriends ?>");
            }
	      	}
          $('#loadingIndicator_friends').hide();
	  	});

	  	$.get('./assets/includes/users.php?users', function(data){
        if(data >= 400){
          console.log(data);
          if(data == 400){
              error_msg("<? echo $personError ?>");
          }else if(data == 401 || data == 403){
            error_msg("<? echo $personNotAllowed ?>")
          }else if(data == 404){
            error_msg("<? echo $personNotFound ?>")
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

  function removeAsFriend(user){
    $.post('./assets/includes/users.php?deleteFriend', {deleteFriend: user}, 
      function(data){
        if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404){
          error_msg("Friend couldn't be removed.");
        }else{
          //reload page
        }
      });
  }

  </script>
  
	<div class="container rightband">
	<div class="row-fluid">
			<div style="float:right"></div>
		<div style="clear: all">
		</div>
        <div class="span6">        
          <h2><?php echo $dashboard_recent_avtivities; ?></h2>
          <div id="loadingIndicator_activities" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
		      <ul id="recentActivities" style="margin-bottom: 10px; max-height: 400px; overflow-y: auto;">
		      </ul>
        </div>

        <div class="span4">
          <h2><?php echo $dashboard_overview; ?> (<a href="support.php#phen">?</a>)</h2>
          <div id="loadingIndicator_overview">
            <div style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
          </div>
          <div style="max-height: 400px; overflow-y: auto;">
            <ul id="overallStatistics">
            </ul>
            <ul id="phenomenonStatistics">
            </ul>
          </div>
       </div>
      </div>

	</div>
	
	<div class="container rightband">
	<div class="row-fluid">
			<div style="float:right"> 
				<label for="searchfriends"><? echo $searchfriends ?></label>
				<input id="searchfriends" type="text" name="text" placeholder="<? echo $searchfriends ?>" data-provide="typeahead"/>
			</div>
			<div style="clear: all">
			</div>
			<div class="span4">
				<h2> <? echo $friends ?></h2>
				<div id="loadingIndicator_friends" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;">
				</div>
				<ul id="friendsList" style="max-height: 400px; overflow-y: auto;">	
				</ul>          
			</div>
        <div class="span5">
          <h2><?php echo $dashboard_friend_activities; ?></h2>
            <div id="loadingIndicator_friend_activities" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;">
            </div>
		  <ul id="friendActivities" style="min-height: 93px; max-height: 400px; overflow-y:auto">
              
		  </ul>
		  <p> </p>
        </div>
		</div>
	</div>
		
	<div id="loadingIndicator" class="loadingIndicator" style="display:none">
		<div style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px">
		</div>
	</div>
	<div id="create_group_modal" class="modal hide fade">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h3><? echo $creategroup; ?></h3>
	  </div>
	  <div class="modal-body">
	  	<form id="createGroupForm" action="./assets/includes/groups.php?createGroup" method="post">
			<label for="group_name"><? echo $groupname; ?></label>
	    	<input id="group_name" type="text" class="input-block-level" placeholder="<? echo $groupname; ?>">
	    	<label for="group_description"><? echo $groupdescription; ?></label>
	    	<input id="group_description" type="text" class="input-block-level" placeholder="<? echo $groupdescription; ?>">
	    	<input type="submit" class="btn btn-primary" value="<? echo $creategroup;?>">
	    </form>
	  </div>
	  <div class="modal-footer">
	    <button class="btn" data-dismiss="modal" aria-hidden="true"><? echo $close; ?></button>
	  </div>
	</div>

	<div class="container rightband">
	<div class="row-fluid">
		<div style="float:right">
			<label for="searchgroups"><? echo $searchgroups ?></label>
			<input id="searchgroups" type="text" name="text" placeholder="<? echo $searchgroups; ?>" style="float:right" data-provide="typeahead"/>
		</div>
		<div style="clear: all">
		</div>
		<div class="span6">
			<h2><? echo $groups; ?></h2>
			<div id="create_group" style="float: right">
				<a href="#create_group_modal" role="button" class="btn" data-toggle="modal"><? echo $creategroup; ?></a>
			</div>
			
			<div style="clear: all">
			</div>
			
			<div id="loadingIndicator_groups" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
			<ul id="groupsList" style="max-height: 400px; overflow-y: auto;">
			</ul>          
		</div>
	</div>
	</div>

<?
include('footer.php');
?>