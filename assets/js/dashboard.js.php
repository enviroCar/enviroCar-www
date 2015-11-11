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
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script type="text/javascript">
  
  var acceptedTermsOfUseIssuedDate;
  
  var serverTermsOfUseIssuedDate;
  
  var friend;
  var values;
  var values2;
  var count;
  var phen;
  
  
  function init(){
		loggedInUser = '<?php echo $_SESSION["name"] ?>';
		user = '<?php echo $user; ?>';
		getUserInfo();
		getBadges();
		$('#username').html(user);
		
		friend = "<?php echo $user?>";
		values = [];
		values2 = [];
		count=0;
		phen=[];
		
		$('#loadingIndicator_graph').show();
		executeRequests();
    }
    
    function executeRequests() {
		
	  $.get('./assets/includes/users.php?userStatistics', function(data) {
		if(data >= 400){
		  console.log(data);
		  if(data == 400){
			error_msg("<?php echo $statisticsError ?>");
		  }
		  else if(data == 401 || data == 403){
			error_msg("<?php echo $statisticsNotAllowed ?>")
		  }
		  else if(data == 404){
			error_msg("<?php echo $statisticsNotFound ?>")
		  }
		  $('#loadingIndicator_overview').hide();
		}
		else{
		  data = JSON.parse(data);
		  if(data.statistics.length > 0){
			for(i = 0; i < data.statistics.length; i++){
			  addPhenomenonStatistics(data.statistics[i].phenomenon.name, data.statistics[i].avg, data.statistics[i].phenomenon.unit);
			}
			
		  }
		  else{
			$('#loadingIndicator_overview').hide();
		  }
		}
		$('#loadingIndicator_overview').hide();
	  }
	);

	  $.get('./assets/includes/users.php?track-number-user', function(data) {
		if(data >= 400){
		  console.log(data);
		  if(data == 400){
			error_msg("<?php echo $routeError ?>");
		  }
		  else if(data == 401 || data == 403){
			error_msg("<?php echo $routeNotAllowed ?>")
		  }
		  else if(data == 404){
			error_msg("<?php echo $routeNotFound ?>")
		  }
		}
		else{
		  if(data != "1"){
			addOverallStatistics("Tracks", data);
		  }
		}
		}
	  );
	  
	  $.get('./assets/includes/users.php?tracks', function(data) {
		if(data >= 400){
		  console.log(data);
		  if(data == 400){
			error_msg("<?php echo $routeError ?>");
		  }
		  else if(data == 401 || data == 403){
			error_msg("<?php echo $routeNotAllowed ?>")
		  }
		  else if(data == 404){
			error_msg("<?php echo $routeNotFound ?>")
		  }
		}
		else{
		  data = JSON.parse(data);
		  if(data.tracks != null){
			numberofTracks = data.tracks.length;
			/*
			* The above method "$.get('./assets/includes/users.php?track-number-user', function(data) { ..."
			* uses a workaround to get the number of total tracks a user has
			* When a user has zero tracks this method still displays 1, so we need to check again here
			*/
			if(data.tracks.length <= 1){
			  addOverallStatistics("Tracks", data.tracks.length);
			}
			if(data.tracks.length > 5){
			  addPaginationToTracks(numberofTracks, data);
			  data.tracks = data.tracks.slice(0,5);
			}
			addTracks(data);
		  }
		  
		}
		
		$('#loadingIndicator_tracks').hide();
	  });
	  
	  $.get('./assets/includes/users.php?friendsOf=<?php echo $_SESSION['name'] ?>', function(data) {
		if(data >= 400){
		  console.log(data);
		  if(data == 400){
			error_msg("<?php echo $friendError ?>");
		  }
		  else if(data == 401 || data == 403){
			error_msg("<?php echo $friendNotAllowed ?>")
		  }
		  else if(data == 404){
			error_msg("<?php echo $friendNotFound ?>")
		  }
		  $('#loadingIndicator_friends').hide();
		}
		else{
		  data = JSON.parse(data);
		  if(data.users.length > 0 ){
			for(i = 0; i < Math.min(10,data.users.length); i++){
			  addFriendToList(data.users[i].name);
			}
		  }else{
			$('#friendsList').html("<?php echo $madeNoFriends ?>");
		  }
		}
		$('#loadingIndicator_friends').hide();
	  }
	  );




	  $.get('./assets/includes/users.php?friend-requests-incoming', function(data){
		if(data >= 400){
		  console.log(data);
			error_msg("<?php echo $dashboard_friends_incoming_error ?>");
		}
		else{
		  data = JSON.parse(data);
		  data.users.forEach(function(entry){
			friendship_incoming_msg("<a href='profile.php?user="+entry.name+"'>"+entry.name+"</a><?php echo $dashboard_friend_request_received; ?> "
			  +"<div class='pull-right' style='padding-right: 20px;'><a onclick='acceptFriendship(&quot;"+entry.name+"&quot;); $(this).parent().parent().remove();' class='btn btn-primary btn-small'><?php echo $dashboard_accept_friend_request ?></a>"+" "
			  +"<a onclick='declineFriendship(&quot;"+entry.name+"&quot;); $(this).parent().parent().remove();' class='btn btn-primary btn-small'><?php echo $dashboard_ignore_friend_request ?></a></div>"
			  );
		  });
		}
		});

	  //This method needs to be executed AFTER all already accepted friends were added to the list
	  $.get('./assets/includes/users.php?friend-requests-outgoing', function(data){
		if(data >= 400){
		  console.log(data);
			error_msg("<?php echo $dashboard_friends_outgoing_error; ?>");
		}
		else{
		  data = JSON.parse(data);
		  if(data.users.length > 0) $('#show-all-friends').before("<strong><?php echo $dashboard_pending; ?></strong>");
		  data.users.forEach(function(entry){
			$('#show-all-friends').before('<dl><a href="profile.php?user='+entry.name+'"><img src='+getAvatar(entry.name, 30)+' style="height: 30px; margin-right: 10px; "/><a href="profile.php?user='+entry.name+'">'+entry.name+'</a></dl>');
		  });
		}
		});
		
	  $.get('./assets/includes/users.php?users', function(data){
		if(data >= 400){
		  console.log(data);
		  if(data == 400){
			error_msg("<?php echo $personError ?>");
		  }
		  else if(data == 401 || data == 403){
			error_msg("<?php echo $personNotAllowed ?>")
		  }
		  else if(data == 404){
			error_msg("<?php echo $personNotFound ?>")
		  }
		  $('#loadingIndicator').hide();
		}
		else{
		  data = JSON.parse(data);
		  for(i = 0; i < data.users.length; i++){
			users.push(data.users[i].name);
		  }
		  $('#searchfriends').typeahead({
			source: users, updater:function (item) {
			  window.location.href = "profile.php?user="+item;
			}
		  });
		}
	  });
	  
	  $.get('./assets/includes/users.php?groupsOf=<?php echo $_SESSION["name"] ?>', function(data) {
		if(data >= 400){
		  if(data == 400){
			error_msg("<?php echo $groupOfError ?>");
		  }
		  else if(data == 401 || data == 403){
			error_msg("<?php echo $groupOfNotAllowed ?>")
		  }
		  else if(data == 404){
			error_msg("<?php echo $groupOfNotFound ?>")
		  }
		  $('#loadingIndicator').hide();
		}
		else{
		  data = JSON.parse(data);
		  if(data.groups.length > 0 ){
			for(i = 0; i < Math.min(5,data.groups.length); i++){
			  addGroupToList(data.groups[i].name);
			}
		  }else{
			$('#groupsList').html("<?php echo $hasNoGroups ?>");
		  }
		}
	  }
		   );
	  
	  $.get('./assets/includes/groups.php?groups', function(data){
		if(data >= 400){
		  if(data == 400){
			error_msg("<?php echo $groupError ?>");
		  }
		  else if(data == 401 || data == 403){
			error_msg("<?php echo $groupNotAllowed ?>")
		  }
		  else if(data == 404){
			error_msg("<?php echo $groupNotFound ?>")
		  }
		  $('#loadingIndicator_groups').hide();
		}
		else{
		  data = JSON.parse(data);
		  for(i = 0; i < data.groups.length; i++){
			groups.push(data.groups[i].name);
		  }
		  $('#searchgroups').typeahead({
			source: groups, updater:function (item) {
			  window.location.href = "group.php?group="+item;
			}
		  });
		}
		$('#loadingIndicator_groups').hide();
	  });
	  
	  $.get('assets/includes/users.php?userStatistics=<?php echo $_SESSION['name'] ?>', function(data) {
		
		if(data >= 400){
		  error_msg("<?php echo $statisticsError ?>");
		  $('#loadingIndicator_graph').hide();
		}else{
		  data = JSON.parse(data);
		  count=data.statistics.length;
		  for(i = 0; i < data.statistics.length; i++){
			if(data.statistics[i].phenomenon.name == 'Speed' || data.statistics[i].phenomenon.name == 'CO2'){
			  values.push(Math.round(data.statistics[i].avg*100)/100);
			  phen.push(data.statistics[i].phenomenon.name);
			}
		  }
		  count=phen.length;
		  
		  //NOW start requesting the overall statistics
			$.get('assets/includes/users.php?allStatistics', function(data) {
			  
				if(data >= 400){
				  if(data === 401 || data === 403) noFriend();
				  else error_msg("<?php echo $statisticsNotFound ?>");
				  $('#loadingIndicator_graph').hide();
				}else{
				  data = JSON.parse(data);
				  console.info(data);
				  for (h=0; h<count; h++ ){
					values2[h]=0;
				  }
				  for(i = 0; i < data.statistics.length; i++){
					  console.info("i="+i); 
					for (j=0; j<count; j++ ){
						console.info("j="+j);
					  if ((data.statistics[i].phenomenon.name) === phen[j]){ 
						values2[j]= Math.round(data.statistics[i].avg*100)/100;
						break;
					  }
					}
				  }
				  if(data.statistics.length === 0){
					values2 = [0,0,0,0];
				  }
				  console.info(values2);
				  google.setOnLoadCallback(drawChart());
				}
			  });
		}
	  });
	  
	  
  }
  
  
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
    
    $.get('assets/includes/tracks.php', function(data) {
      $('#overallStatistics').append('<li id="number-of-tracks" rel="tooltip" data-placement="right" data-toggle="tooltip" data-original-title="<?php echo $dashboard_track_number_tooltip; ?>"><?php echo $dashboard_number_of_tracks; ?>:<strong> '+value + ' (' + data + ')</strong>');
    });
    
  }
  
  function getAvatar(name, size){
    return './assets/includes/get.php?redirectUrl=https://envirocar.org/api/stable/users/'+name+'/avatar&auth=true';
  }
  
  
  function addTrack(name, id){
    $('#tracks-list').append(
      '<div class="row row-narrow">'
      +'<div class="span3">'
      +'<a href="route.php?id='+id+'"><img src="./assets/img/track_preview.png" style="height: 60px; margin-right: 10px; "/></a>'
      +'</div>'
      +'<div class="span9">'
      +'<a href="route.php?id='+id+'">'+name+'</a>'
      +'</div>'
      +'</div>');
  }
  
  function addTracks(data){
    if(data.tracks.length > 0){
      for(i = 0; i < data.tracks.length; i++){
        var track = data.tracks[i];
        addTrack(track.name, track.id);
      }
    }
    else{
      $('#tracks-list').append("<?php echo $noroutesavailable ?>");
    }
  }

  
  /* $.get('./assets/includes/users.php?userActivities', function(data) {
    if(data >= 400){
      console.log(data);
      if(data == 400){
        error_msg("<?php echo $activityError ?>");
      }
      else if(data == 401 || data == 403){
        error_msg("<?php echo $activityNotAllowed ?>")
      }
      else if(data == 404){
        error_msg("<?php echo $activityNotFound ?>")
      }
      $('#loadingIndicator_activities').hide();
    }
    else{
      data = JSON.parse(data);
      if(data.activities.length > 0){
        for(i = 0; i < data.activities.length; i++){
          var activity = data.activities[i];
          if(activity.type == "JOINED_GROUP"){
            if(activity.group)addRecentActivities("./assets/img/person.svg", "group.php?group="+activity.group.name, activity.user.name+" <?php echo $joined ?> "+activity.group.name, convertToLocalTime(activity.time));
          }
          else if(activity.type == "CREATED_GROUP"){
            if(activity.group) addRecentActivities("./assets/img/person.svg", "group.php?group="+activity.group.name, activity.user.name+" <?php echo $createdGroup ?> "+activity.group.name, convertToLocalTime(activity.time));
          }
          else if(activity.type == "FRIENDED_USER"){
            addRecentActivities(getAvatar(activity.other.name, 30), "profile.php?user="+activity.other.name, activity.user.name+" <?php echo $friended ?> "+activity.other.name, convertToLocalTime(activity.time));
          }
          else if(activity.type == "CREATED_TRACK"){
            if(typeof activity.track != 'undefined') addRecentActivities("./assets/img/route.svg", "route.php?id="+activity.track.id, activity.user.name+" <?php echo $createdRoute ?>: "+activity.track.name, convertToLocalTime(activity.time));
          }
          else if(activity.type == "LEFT_GROUP"){
            if(activity.group) addRecentActivities("./assets/img/person.svg", "group.php?group="+activity.group.name, activity.user.name+" <?php echo $left ?> "+activity.group.name, convertToLocalTime(activity.time));
          }
          else if(activity.type == "CHANGED_GROUP"){
            if(activity.group) addRecentActivities("./assets/img/person.svg", "group.php?group="+activity.group.name, activity.user.name+" <?php echo $changedGroup ?> "+activity.group.name, convertToLocalTime(activity.time));
          }
          else if(activity.type == "CHANGED_PROFILE"){
            
            addRecentActivities(getAvatar(activity.user.name, 30), "<?php echo $user ?>" == "<?php echo $loggedInUser ?>" ? "editprofile.php?user="+activity.user.name : "profile.php?user="+activity.user.name, activity.user.name+" <?php echo $changedProfile ?>", convertToLocalTime(activity.time));
          }
        }
      }
      else{
        $('#recentActivities').append("<?php echo $norecentactivities ?>");
      }
      $('#loadingIndicator_activities').hide();
    }
  }
       );
*/
  

  
  function addPaginationToTracks(numberOfTracks){
    var options = {
      currentPage: 1,
      totalPages: Math.ceil(numberOfTracks/5),
      pageUrl: function(type, page, current){
        return null;
        
      }
      ,
      onPageClicked: function(e,originalEvent,type,page){
        $('#tracks-list').empty();
        $('#loadingIndicator_tracks').show();
        originalEvent.preventDefault();
        originalEvent.stopPropagation();
        
        $.get('./assets/includes/users.php?tracks-page=' + page, function(data) {
          if(data >= 400){
            console.log(data);
            if(data == 400){
              error_msg("<?php echo $routeError ?>");
            }
            else if(data == 401 || data == 403){
              error_msg("<?php echo $routeNotAllowed ?>")
            }
            else if(data == 404){
              error_msg("<?php echo $routeNotFound ?>")
            }
          }
          else{
            data = JSON.parse(data);
            if(data.tracks != null){
              addTracks(data);
            }  
          }
          $('#loadingIndicator_tracks').hide();
          }
        );
      }
    }
        
        $('#tracks-pagination').bootstrapPaginator(options);
  }
  
  
  function convertToLocalTime(serverDate) {
    var dt = new Date(Date.parse(serverDate));
    var localDate = dt;
    
    
    var gmt = localDate;
    var min = gmt.getTime() / 1000 / 60;
    // convert gmt date to minutes
    var localNow = new Date().getTimezoneOffset();
    // get the timezone
    // offset in minutes
    var localTime = min - localNow;
    // get the local time
    
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
    $('#friendsList').prepend('<dl><table><tr><td style="min-width:40px; padding: 0px;"><a href="profile.php?user='+name+'"><img src='+getAvatar(name, 30)+' style="height: 30px; margin-right: 10px; "/></a></td><td><a href="profile.php?user='+name+'">'+name+'</a></tr></table></dl>');
  }
  


  function acceptFriendship(name){
    $.post('./assets/includes/users.php?friend-request-accept', {acceptFriend: name}, 
      function(data){
        if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404){
          error_msg("<?php echo $dashboard_friends_accept_error ?>");
        }else{
          friendship_accepted_msg("<a href='profile.php?user="+name+"'>"+name+"</a><?php echo $dashboard_friend_added; ?>");
        }
      });
  }

  function declineFriendship(name){
    $.post('./assets/includes/users.php?friend-request-decline', {declineFriend: name}, 
      function(data){
        if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404){
          error_msg("<?php echo $dashboard_friend_decline_error; ?>");
        }else{
          friendship_declined_msg("<a href='profile.php?user="+name+"''>"+name+"</a><?php echo $dashboard_friend_declined; ?>");
        }
      });
  }





  
  var groups = Array();
  
  function addGroupToList(name){
    //$('#friendsList').append('<li class="customLi"><div style="float:left;"><img src="assets/img/user.jpg" style="height: 45px";/></div><div style="float:left;"><div class="profile_name"><a href="profile.php?user='+name+'">'+name+'</a></div></div></li>');
    $('#groupsList').prepend('<dl><a href="group.php?group='+name+'"><img src="assets/img/user.jpg" style="height: 30px; margin-right: 10px;"/></a><a href="group.php?group='+name+'">'+name+'</a></dl>');
  }
  
 
  function validateInput(input){
    var re = /[&=`\[\]"'<>\/]/;
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
  
  //Show profile
  function getUserInfo(){
    $.get('./assets/includes/users.php?user='+user, function(data){
      if(data >= 400){
        if(data == 400){
          error_msg("<?php echo $personError ?>");
        }else if(data == 401 || data == 403){
          noFriend();
        }else if(data == 404){
          error_msg("<?php echo $personNotFound ?>")
        }
        $('#loadingIndicator').hide();
      }else{
        data = JSON.parse(data);
        if(data.firstName){
          $('#userInformation').append('<li><?php echo $firstname ?>: <b>'+data.firstName+'</b></li>');
          $('#firstName').val(data.firstName);
        }
        if(data.mail){
          $('#mail').val(data.mail);
        }
        if(data.lastName){
          $('#userInformation').append('<li><?php echo $lastname ?>: <b>'+data.lastName+'</b></li>');
          $('#lastName').val(data.lastName);
        }
        if(data.gender){
          $('#userInformation').append('<li><?php echo $gender ?>: <b>'+(data.gender == 'm' ? '<?php echo $male ?>':'<?php echo $female ?>') +'</b></li>');
          $('#gender').val(data.gender);
        }
        if(data.dayOfBirth){
          $('#userInformation').append('<li><?php echo $birthday ?>: <b>'+data.dayOfBirth+'</b></li>');
          $('#dayOfBirth').val(data.dayOfBirth);
        }
        if(data.location){
          $('#userInformation').append('<li><?php echo $location ?>: <b>'+data.location+'</b></li>');
          $('#location').val(data.location);
        }
        if(data.country){
          $('#userInformation').append('<li><?php echo $country ?>: <b>'+data.country+'</b></li>');
          $('#country').val(data.country);
        }
        if(data.url){
          $('#userInformation').append('<li>Website: <b>'+data.url+'</b></li>');
          $('#url').val(data.url);
        }
        if(data.language){
          $('#userInformation').append('<li><?php echo $language ?>: <b>'+data.language+'</b></li>');
          $('#language').val(data.language);
        }
        if(data.aboutMe){
          $('#aboutMe').val(data.aboutMe);
        }
        if(data.badges){
          for(var i = 0; i < data.badges.length; i++){
            if(data.badges[i] === "contributor"){
              $('#badges').prepend('<dl rel="tooltip" data-placement="right" data-toggle="tooltip" class="label label-envirocar" data-original-title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >First Contributor</dl>');
            }else if(data.badges[i] === "friend"){
              $('#badges').prepend('<dl rel="tooltip" data-placement="right" data-toggle="tooltip" class="label label-envirocar" data-original-title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >Friend of enviroCar</dl>');
            }else if(data.badges[i] === "support"){
              $('#badges').prepend('<dl rel="tooltip" data-placement="right" data-toggle="tooltip" class="label label-envirocar" data-original-title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >First Supporters</dl>');
            }else if(data.badges[i] === "local-stakeholder"){
              $('#badges').prepend('<dl rel="tooltip" data-placement="right" data-toggle="tooltip" class="label label-envirocar" data-original-title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >First Local Stakeholder</dl>');
            }else if(data.badges[i] === "fan"){
              $('#badges').prepend('<dl rel="tooltip" data-placement="right" data-toggle="tooltip" class="label label-envirocar" data-original-title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >enviroCar Fan</dl>');
            }else if(data.badges[i] === "regional-stakeholder"){
              $('#badges').prepend('<dl rel="tooltip" data-placement="right" data-toggle="tooltip" class="label label-envirocar" data-original-title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >First Regional Stakeholder</dl>');
            }else if(data.badges[i] === "early-bid"){
              $('#badges').prepend('<dl rel="tooltip" data-placement="right" data-toggle="tooltip" class="label label-envirocar" data-original-title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >enviroCar Early Bid</dl>');
            }else if(data.badges[i] === "partner"){
              $('#badges').prepend('<dl rel="tooltip" data-placement="right" data-toggle="tooltip" class="label label-envirocar" data-original-title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >enviroCar Partner</dl>');
            }
          }
        }
        if(!data.acceptedTermsOfUseVersion){
        }else{
          acceptedTermsOfUseIssuedDate = data.acceptedTermsOfUseVersion;
        }
        
        getTerms();
      }
    });
 }
  
  
  function getTerms(){ 
    $.get('./assets/includes/terms.php?getTerms', function(data){
      data = JSON.parse(data);
      
      if (!data.termsOfUse[0]) {
		  return;
	  }
      
      serverTermsOfUseIssuedDate = data.termsOfUse[0].issuedDate;     
      
      if(acceptedTermsOfUseIssuedDate){
        if(serverTermsOfUseIssuedDate != acceptedTermsOfUseIssuedDate){
          toggle_visibility('accept_terms_div');
        }
      }else{        
        toggle_visibility('accept_terms_div');
      }   
    });
  }
  
  function acceptTerms(){   
    $.get('./assets/includes/users.php?updateAcceptedTermsofUse&date=' + serverTermsOfUseIssuedDate, function(data){    
      if(data >= 400){
        
        error_msg("<?php echo $error_setting_terms_on_server ?>");
        
      }else{        
        toggle_visibility('accept_terms_div');        
      }
      
    });
  }
  
  function getBadges(){ 
    $.get('./assets/includes/badges.php?badges', function(data){
      var lang = "<?php echo $lang ?>";
      data = JSON.parse(data);
      data.badges.forEach(function(badge){
        $('#all-badges').append('<li><a class="label label-envirocar" rel="tooltip" data-placement="right" title="'+badge.description[lang]+'">'+badge.displayName[lang]+'</a></li>');
      });
    });
  }
  
  google.load("visualization", "1", {packages:["corechart"]});
  
  function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('string','Measurement');
    
    var speedIndex = 0;
    var co2Index = 1;
    
    if(phen[0] == 'CO2'){
      speedIndex = 1;
      co2Index = 0;
    }                
    
    data.addColumn('number', 'Speed');
    data.addColumn('number', 'CO2');  
    
    data.addRow(['<?php echo $_SESSION['name'] ?>', values[speedIndex], values[co2Index]]);     
    data.addRow(['<?php echo $allUsers ?>', values2[speedIndex], values2[co2Index]]);
    
    var options = {
      title: '<?php echo $statistics ?>',
      backgroundColor: 'white',
      vAxes: {0: {title:'km/h', logScale: false, minValue:0}, 1: {title:'kg/h', logScale: false, minValue:0}},
      series: {
        0:{targetAxisIndex: 0 },
        1: {targetAxisIndex: 1}
      }
    };
    
    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div')).
        draw(data, options);
    $('#loadingIndicator_graph').hide();
  }
  
  $(function () {
    $('#createGroupForm').submit(function(){
      if($('#group_name').val() === '' || $('#group_description').val() === ''){
        alert("<?php echo $bothFieldsFilled ?>");
      }
      else{
        if(!validateInput($('#group_name').val()) && !validateInput($('#group_description').val())){
          $('#loadingIndicator').show();
          
          $.post('./assets/includes/groups.php?createGroup', {
            group_name: $('#group_name').val(), group_description: $('#group_description').val()}
                 , 
                 function(response){
                   if(response >= 400){
                     error_msg("<?php echo $creategrouperror ?>");
                   }
                   else{
                     window.location.href="group.php?group="+$('#group_name').val();
                   }
                 }
                );
        }
        else{
          $('#loadingIndicator').hide();
          alert("<?php echo $invalidCharacterError ?>");
        }
      }
      return false;
    });
	  
    init();
  });
  
  $(function(){
    $('body').tooltip({
      selector: '[rel=tooltip]'
    });
  });
</script>
