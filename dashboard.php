<?
include('header.php');
require_once('assets/includes/connection.php');

$loggedInUser = $_SESSION["name"];
$user = (isset($_GET['user'])) ? $_GET['user'] : $loggedInUser;
?>
<style type="text/css">
  .badges{
    padding: 3px;
    background: #8CBF3F;
    max-width: 200px;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, 0.2);
    -webkit-border-radius: 6px;
    -moz-border-radius: 6px;
    border-radius: 6px;
    -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    -webkit-background-clip: padding-box;
    -moz-background-clip: padding;
    background-clip: padding-box;
  }
</style>  
  
  <script type="text/javascript">
  	
  	var acceptedTermsOfUseIssuedDate;  
  	var serverTermsOfUseIssuedDate;	

  	function init(){
    	loggedInUser = '<?php echo $_SESSION["name"] ?>';
    	user = '<?php echo $user; ?>';
    	getUserInfo();
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
						
			 $('#overallStatistics').append('<li class="customLi"><img src="./assets/img/route.svg" style="height: 30px; margin-right: 10px; "/><?php echo $dashboard_number_of_tracks; ?>: '+value + '(' + data + ')');
			
		});  

    }
	
    function getAvatar(name, size){
      return './assets/includes/get.php?redirectUrl=https://giv-car.uni-muenster.de/stable/rest/users/'+name+'/avatar&auth=true';
    }    
    
    function addTrack(name, id){
      $('#tracks').append('<li class="customLi"><img src="./assets/img/route.svg" style="height: 30px; margin-right: 10px; "/><a href="route.php?id='+id+'">'+name+'</a></li>');
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
            addTracks(data);
          }

      }    		
      $('#loadingIndicator_tracks').hide();
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
              $('#badges').append('<li class="badges" title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >First Contributor</li>');
            }else if(data.badges[i] === "friend"){
              $('#badges').append('<li class="badges" title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >Friend of enviroCar</li>');
            }else if(data.badges[i] === "support"){
              $('#badges').append('<li class="badges" title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >First Supporters</li>');
            }else if(data.badges[i] === "local-stakeholder"){
              $('#badges').append('<li class="badges" title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >First Local Stakeholder</li>');
            }else if(data.badges[i] === "fan"){
              $('#badges').append('<li class="badges" title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >enviroCar Fan</li>');
            }else if(data.badges[i] === "regional-stakeholder"){
              $('#badges').append('<li class="badges" title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >First Regional Stakeholder</li>');
            }else if(data.badges[i] === "early-bid"){
              $('#badges').append('<li class="badges" title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >enviroCar Early Bid</li>');
            }else if(data.badges[i] === "partner"){
              $('#badges').append('<li class="badges" title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >enviroCar Partner</li>');
            }
          }
        }if(!data.acceptedTermsOfUseVersion){
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

  $(function () {
    init();
	});

  </script>

    <div id="accept_terms_div" class="container alert alert-block alert-error fade in" style="display:none"> 
      <? echo $please_accept_terms ?> 
      <input type="button" name="Text 2" value="<? echo $confirm_accept_terms ?>"
      onclick="acceptTerms()"> 
    </div> 
  
<div class="container rightband">
  <div class="row-fluid">
    <div class="span4">
      <div class="well sidebar-nav">
      <h2 id="username"></h2>
		<span style="text-align: center; display: block">
			<img src="./assets/includes/get.php?url=https://giv-car.uni-muenster.de/stable/rest/users/<? echo $user; ?>/avatar?size=200&amp;auth=true" style="height: 200px; width:200px; margin-right: auto; margin-left: auto;" alt="<? echo $user;?>"/>
		</span>
    <br>
        <ul id="userInformation" class="nav nav-list" style="text-align:center"></ul>
        <ul id="badges" class="nav nav-list" style="text-align:center"></ul>

      </div><!--/.well -->
       <ul id="overallStatistics">
       </ul>
    </div><!--/span-->

    <div id="comparison" class="span5">
        <div id="chart_div" style="width: 700px; height: 400px;">   
          <div id="loadingIndicator_graph" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px; display:none">
          </div>
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
  
  
	<div class="container rightband">
	<div class="row-fluid">
			<div style="float:right"></div>
		<div style="clear: all">
		</div>
        <div class="span6">        
          <h2 class="featurette-heading"><?php echo $dashboard_my_tracks; ?></h2>
          <div id="loadingIndicator_tracks" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
		      <ul id="tracks" style="margin-bottom: 10px; max-height: 400px; overflow-y: auto;">
		      </ul>
        </div>
      </div>

	</div>

	<div class="container rightband">
	<div class="row-fluid">
			<div style="float:right"> 
				<input id="searchfriends" type="text" name="text" placeholder="<? echo $searchfriends ?>" data-provide="typeahead"/>
			</div>
			<div style="clear: all">
			</div>
			<div class="span6">
				<h2 class="featurette-heading"> <? echo $friends ?></h2>
				<div id="loadingIndicator_friends" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;">
				</div>
				<ul id="friendsList" style="max-height: 400px; overflow-y: auto;">	
				</ul>          
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
		<div style="float:right">
			<input id="searchgroups" type="text" name="text" placeholder="<? echo $searchgroups; ?>" style="float:right" data-provide="typeahead"/>
		</div>
		<div style="clear: all">
		</div>
		<div class="span6">
			<h2 class="featurette-heading" style="display: inline"><? echo $groups; ?></h2>
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

<?
include('footer.php');
?>