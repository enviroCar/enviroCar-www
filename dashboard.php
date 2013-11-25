<?
include('header.php');
require_once('assets/includes/connection.php');

$loggedInUser = $_SESSION["name"];
$user = (isset($_GET['user'])) ? $_GET['user'] : $loggedInUser;

//language
$lang = 'en';
if(isSet($_GET['lang'])){
  $lang = $_GET['lang'];
}else if(isSet($_SESSION['lang'])){
  $lang = $_SESSION['lang'];
}else if(isSet($_COOKIE['lang'])){
  $lang = $_COOKIE['lang'];
}else{
  $lang = 'en';
}
?>
 
  
  <script type="text/javascript">
  	
  	var acceptedTermsOfUseIssuedDate;  
  	var serverTermsOfUseIssuedDate;	

  	function init(){
    	loggedInUser = '<?php echo $_SESSION["name"] ?>';
    	user = '<?php echo $user; ?>';
    	getUserInfo();
      getBadges();
    	$('#username').html(user);
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
			 $('#overallStatistics').append('<li><?php echo $dashboard_number_of_tracks; ?>:<strong> '+value + '(' + data + ')</strong>');
			
		});  

    }
	
    function getAvatar(name, size){
      return './assets/includes/get.php?redirectUrl=https://envirocar.org/api/stable/users/'+name+'/avatar&auth=true';
    }    
    
    function addTrack(name, id){
      $('#tracks-list').append(
        '<div class="row row-narrow">'
          +'<div class="span3">'
            +'<a href="route.php?id='+id+'"><img src="http://giv-dueren.uni-muenster.de/assets/trips/109.png" style="height: 60px; margin-right: 10px; "/></a>'
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
        }else{
          $('#tracks').append("<? echo $noroutesavailable ?>");
        }
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
                addRecentActivities(getAvatar(activity.user.name, 30), "<? echo $user ?>" == "<? echo $loggedInUser ?>" ? "editprofile.php?user="+activity.user.name : "profile.php?user="+activity.user.name, activity.user.name+" <? echo $changedProfile ?>", convertToLocalTime(activity.time));
              }
            }
        }else{
          $('#recentActivities').append("<? echo $norecentactivities ?>");
        }
        $('#loadingIndicator_activities').hide();
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
            addPaginationToTracks(numberofTracks, data);
            data.tracks = data.tracks.slice(0,5);
            addTracks(data);
          }

      }    		
      $('#loadingIndicator_tracks').hide();
    });

    function addPaginationToTracks(numberOfTracks){
      var options = {
        currentPage: 1,
        totalPages: Math.ceil(numberOfTracks/5),
        pageUrl: function(type, page, current){
          return null;

        },
        onPageClicked: function(e,originalEvent,type,page){
          $('#tracks-list').empty();
          $('#loadingIndicator_tracks').show();
          originalEvent.preventDefault();
          originalEvent.stopPropagation();

          $.get('./assets/includes/users.php?tracks-page=' + page, function(data) {
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
                  addTracks(data);
                }

            }       
            $('#loadingIndicator_tracks').hide();
          });
        }
      }

      $('#tracks-pagination').bootstrapPaginator(options);
    }
    

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
  			$('#friendsList').prepend('<dl><a href="profile.php?user='+name+'"><img src='+getAvatar(name, 30)+' style="height: 30px; margin-right: 10px; "/><a href="profile.php?user='+name+'">'+name+'</a></dl>');
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
		        	for(i = 0; i < Math.min(data.users.length, 10); i++){
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
  			$('#groupsList').prepend('<dl><a href="group.php?group='+name+'"><img src="assets/img/user.jpg" style="height: 30px; margin-right: 10px;"/></a><a href="group.php?group='+name+'">'+name+'</a></dl>');
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
		        	for(i = 0; i < Math.min(data.groups.length, 5); i++){
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

//Show profile
 function getUserInfo(){
    $.get('./assets/includes/users.php?user='+user, function(data){
      if(data >= 400){
        if(data == 400){
          error_msg("<? echo $personError ?>");
        }else if(data == 401 || data == 403){
          noFriend();
        }else if(data == 404){
          error_msg("<? echo $personNotFound ?>")
        }
        $('#loadingIndicator').hide();
      }else{
        data = JSON.parse(data);
        if(data.firstName){
           $('#userInformation').append('<li><? echo $firstname ?>: <b>'+data.firstName+'</b></li>');
           $('#firstName').val(data.firstName);
         }
        if(data.mail){
           $('#mail').val(data.mail);
        }
        if(data.lastName){
           $('#userInformation').append('<li><? echo $lastname ?>: <b>'+data.lastName+'</b></li>');
           $('#lastName').val(data.lastName);
         }
        if(data.gender){
           $('#userInformation').append('<li><? echo $gender ?>: <b>'+(data.gender == 'm' ? '<? echo $male ?>':'<? echo $female ?>') +'</b></li>');
           $('#gender').val(data.gender);
         }
        if(data.dayOfBirth){
           $('#userInformation').append('<li><? echo $birthday ?>: <b>'+data.dayOfBirth+'</b></li>');
           $('#dayOfBirth').val(data.dayOfBirth);
         }
        if(data.location){
           $('#userInformation').append('<li><? echo $location ?>: <b>'+data.location+'</b></li>');
           $('#location').val(data.location);
         }
        if(data.country){
           $('#userInformation').append('<li><? echo $country ?>: <b>'+data.country+'</b></li>');
           $('#country').val(data.country);
         }
        if(data.url){
           $('#userInformation').append('<li>Website: <b>'+data.url+'</b></li>');
           $('#url').val(data.url);
         }
        if(data.language){
           $('#userInformation').append('<li><? echo $language ?>: <b>'+data.language+'</b></li>');
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
        
        error_msg("<? echo $error_setting_terms_on_server ?>");
        
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

  $(function () {
    init();
	});

  </script>

  <div id="badgesModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="myModalLabel"><?php echo $availableBadges ?></h3>
    </div>
    <div class="modal-body">
      <ul id="all-badges"></ul>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
  </div>

  <div id="accept_terms_div" class="container alert alert-block alert-info fade in" style="display:none"> 
    <? echo $please_accept_terms ?> 
    <input type="button" name="Text 2" value="<? echo $confirm_accept_terms ?>" onclick="acceptTerms()"> 
  </div> 

<div class="container leftband">
  <div class="row-fluid">
    <div class="span3">
  		<div class="row">
        <div class="span12">
          <img src="./assets/includes/get.php?url=https://envirocar.org/api/stable/users/<? echo $user; ?>/avatar?size=200&amp;auth=true" style="height: 200px; width:200px; margin-right: auto; margin-left: auto;" alt="<? echo $user;?>"/>
          <h2 id="username"></h2>
          <ul id="userInformation" class="nav nav-list"></ul>
          <ul id="overallStatistics" class="nav nav-list"></ul>
          <h3 class="muted"><?php echo $badges ?></h3>
          <ul class="nav nav-list" id="badges">
            <li><small><a href="#" data-toggle="modal" data-target="#badgesModal" class="link"><i class="icon-plus-sign"></i><?php echo $availableBadges ?></a></small></li> 
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="span12">
          <h3 class="muted"><? echo $friends ?></h3>
          <input id="searchfriends" type="text" name="text" placeholder="<? echo $searchfriends ?>" data-provide="typeahead"/>
          <div id="loadingIndicator_friends" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div> 
          <ul class="nav nav-list" id="friendsList">
            <li><small><a href="friends.php"><i class="icon-plus-sign"></i><?php echo $dashboard_show_all; ?></a></small></li> 
          </ul> 
        </div>
      </div>
      <div class="row">
        <div class="span12">
          <h3 class="muted"><? echo $groups; ?></h3>
          <input id="searchgroups" type="text" name="text" placeholder="<? echo $searchgroups; ?>" data-provide="typeahead"/>
          <small><a href="#create_group_modal" class="link" data-toggle="modal"><i class="icon-plus-sign"></i><? echo $creategroup; ?></a></small>
          <div id="loadingIndicator_groups" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
          <ul class="nav nav-list" id="groupsList">
          <li><small><a href="groups.php"><i class="icon-plus-sign"></i><?php echo $dashboard_show_all; ?></a></small></li> 
          </ul>         
        </div>
      </div>
    </div>


    <div class="span9">
      <div class="row-fluid">
        <div class="span12" id="comparison">
          <h2><?php echo $dashboard_overview; ?></h2>
          <div id="chart_div" style="width: 700px; height: 400px;">   
            <div id="loadingIndicator_graph" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px; display:none"></div>
          </div>
        </div>
        <hr class="featurette-divider">
      </div>
    
    <div class="row-fluid">
        <div class="span12" id="tracks-span">
          <h2><?php echo $dashboard_my_tracks; ?></h2>
          <div id="tracks-pagination"></div>
          <div id="loadingIndicator_tracks" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
          <div id="tracks-list" class="span12">
          </div>
        </div>
      </div>
    </div>
  </div>
  
  </div>


  <div class="container leftband">

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




    <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
 
   <script type="text/javascript">

      


      var friend = "<? echo $user?>";
      var values = [];
      var values2 = [];
      var count=0;
      var phen=[];

      $.get('assets/includes/users.php?userStatistics=<? echo $_SESSION['name'] ?>', function(data) {
        $('#loadingIndicator_graph').show();
        if(data >= 400){
            error_msg("<? echo $statisticsError ?>");
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
        }
      });

      $.get('assets/includes/users.php?allStatistics', function(data) {
        if(data >= 400){
            if(data == 401 || data == 403) noFriend();
            else error_msg("<? echo $statisticsNotFound ?>");
            $('#loadingIndicator_graph').hide();
        }else{
          data = JSON.parse(data);
          for (h=0; h<count; h++ ){
            values2[h]=0;
          }
          for(i = 0; i < data.statistics.length; i++){ 
            for (j=0; j<count; j++ ){
            if ((data.statistics[i].phenomenon.name)==phen[j]){ 
              values2[j]= Math.round(data.statistics[i].avg*100)/100;
              break;
            }
          }
          }
          if(data.statistics.length==0){
            values2 = [0,0,0,0];
          }
          google.setOnLoadCallback(drawChart());
        }
      });


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
          
			data.addRow(['<? echo $_SESSION['name'] ?>', values[speedIndex], values[co2Index]]);     
			data.addRow(['<? echo $allUsers ?>', values2[speedIndex], values2[co2Index]]);
     
        var options = {
          title: '<? echo $statistics ?>',
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
      
    </script>  
    
    </div>
</div>  
	
	<!--div class="container rightband">
	<div class="row-fluid">
			<div style="float:right"></div>
		<div style="clear: all">
		</div>

        <div class="span4">
          <h2><?php echo $dashboard_overview; ?> </h2>
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

	</div-->	
  
  
	

<?
include('footer.php');
?>