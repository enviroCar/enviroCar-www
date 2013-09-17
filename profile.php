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
  //Javascript function to receive GET variables (Syntax: $_GET(['variableName']) ) 
  (function(){
    var s = window.location.search.substring(1).split('&');
      if(!s.length) return;
        var c = {};
        for(var i  = 0; i < s.length; i++)  {
          var parts = s[i].split('=');
          c[unescape(parts[0])] = unescape(parts[1]);
        }
      window.$_GET = function(name){return name ? c[name] : c;}
  }())

  function addFriendActivities(actionImg, friendImg, id, titel, date){
     $('#friendActivities').append('<li class="customLi"><img src="'+actionImg+'" style="height: 30px; margin-right: 10px; "/><a href="'+id+'">'+titel+'</a><img src="'+friendImg+'" style="height: 30px; margin-right: 10px; float:right; "/><br><div>'+date+'</div></li>');
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
  
  function init(){
    loggedInUser = '<?php echo $_SESSION["name"] ?>';
    user = '<?php echo $user; ?>';
    getUserInfo();
    $('#username').html(user);
    getUserFriends();
    getUserGroups();
    getLoggedInUserFriends();
  }

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
        }
      }
    });
  }

  function noFriend(){
 $('#comparison').hide();
    $('#friendsgroups').hide();
    $('#nofriends').show();

  }


  function getUserGroups(){
    $.get('./assets/includes/users.php?groupsOf='+user, function(data) {
      if(data >= 400){
        if(data == 400){
          error_msg("<? echo $groupError ?>");
        }else if(data == 401 || data == 403){
          noFriend();
        }else if(data == 404){
          error_msg("<? echo $groupNotFound ?>")
        }
        $('#loadingIndicator_groups').hide();
      }else{
        data = JSON.parse(data);
        if(data.groups.length > 0 ){
          for(i = 0; i < data.groups.length; i++){
            $('#groups').append('<li class="customLi" style="height:30px"><a href="group.php?group='+data.groups[i].name+'">'+data.groups[i].name+'</a></li>');
          }
        }
      }
      $('#loadingIndicator_groups').hide();
    });
  }

  function getLoggedInUserFriends(){
    $.get('./assets/includes/users.php?friendsOf='+loggedInUser, function(data) {
      if(data >= 400){
        if(data == 400){
          error_msg("<? echo $friendError ?>");
        }else if(data == 401 || data == 403){
          noFriend();
        }else if(data == 404){
          error_msg("<? echo $friendNotFound ?>")
        }
        $('#loadingIndicator').hide();
      }else{
        data = JSON.parse(data);
        if(data.users.length > 0 ){
          for(i = 0; i < data.users.length; i++){
            if(user == data.users[i].name){
              $('#addAsFriendLink').html('<a href="javascript:removeAsFriend();"><? echo $removeasfriend ?></a>');
              break;
            }
            else{ 
              $('#addAsFriendLink').html('<a href="javascript:addAsFriend();"><? echo $addasfriend ?></a>');
            }
          }
        }
        else{ 
              $('#addAsFriendLink').html('<a href="javascript:addAsFriend();"><? echo $addasfriend ?></a>');
        }

      }
    });
  }

    function getAvatar(name, size){
      return './assets/includes/get.php?redirectUrl=https://giv-car.uni-muenster.de/stable/rest/users/'+name+'/avatar&amp;auth=true';
    }
	
  function getUserFriends(){
    $.get('./assets/includes/users.php?friendsOf='+user, function(data) {
      if(data >= 400){
        if(data == 400){
          error_msg("<? echo $friendError ?>");
        }else if(data == 401 || data == 403){
          noFriend();
        }else if(data == 404){
          error_msg("<? echo $friendNotFound ?>")
        }
        $('#loadingIndicator_friends').hide();
      }else{
        data = JSON.parse(data);
        if(data.users.length > 0 ){
          $('#friends').html("");
          for(i = 0; i < data.users.length; i++){
            $('#friends').append('<li class="customLi"><img src='+getAvatar(data.users[i].name,30)+' style="height: 30px; margin-right: 10px; "/><a href="profile.php?user='+data.users[i].name+'">'+data.users[i].name+'</a></li>');
          }
        }

      }
      $('#loadingIndicator_friends').hide();
    });
  }

  function removeAsFriend(){
    $.post('./assets/includes/users.php?deleteFriend', {deleteFriend: user}, 
      function(data){
        if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404){
          error_msg("Friend couldn't be removed.");
        }else{
          $('#addAsFriendLink').html('<a href="javascript:addAsFriend();"><? echo $addasfriend ?></a>');
        }
      });
  }

  function addAsFriend(){
    $.post('./assets/includes/users.php?addFriend', {addFriend: user}, 
      function(data){
        if(data == 400 || data == 401 || data == 402 || data == 403 || data == 404){
          error_msg("Friend couldn't be added successfully.");
        }else{
          $('#addAsFriendLink').html('<a href="javascript:removeAsFriend();"><? echo $removeasfriend ?></a>');
        }
      });
  }

  function deleteAccount(){
    if(confirm("Are you sure you want to delete your account? This can't be undone!")){
        $.post('./assets/includes/authentification.php?delete', {delete: true }, 
            function(data){
              console.log(data);
              if(data === 'status:ok'){
                window.location.href = "index.php?deleted";
              }else{
                error_msg("Deletion has failed. Please try again");
              }
      });
    }
  }

  function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
      if(n['value'] !== '') indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
  }

  function validateDate(date){
    re = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
    return re.test(date);
  }

  $(function(){
        $('#changeProfileForm').submit(function(){
          changeData = getFormData($('#changeProfileForm'));
          if($('#dayOfBirth').val() != ''){
            if(!validateDate($('#dayOfBirth').val())){
              alert("Birthday has to be in the format YYYY-MM-DD");
              return false;
            }
          }
          $.post('./assets/includes/users.php?updateUser', changeData, function(response){
            if(response >= 400){
              console.log('error');
            }else{
              alert("Profile has been changed");
              window.location.reload()
            }
          });
          return false;
        });
    });
 
//gets activities of current friend ($user)
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
              if(activity.user.name == "<? echo $user ?>"){
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
            }
            
        }else{
          $('#friendActivities').append("<? echo $norecentactivities ?>");
        }
        $('#loadingIndicator_friend_activities').hide();
      }
    }); 
  
  $(function () {
    init();
});

</script>
 
<div id="changeProfile" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><? echo $changeprofile; ?></h3>
  </div>
  <div class="modal-body">
    <? echo $avatarGravatar ?> <a href="http://www.gravatar.com" target='_blank'>Gravatar</a><br>
    <form id="changeProfileForm" action="./assets/includes/users.php?updateUser" method="post">
		<label for="mail"><? echo $email; ?></label>
		<input id="mail" name="mail" type="text" class="input-block-level" placeholder="<? echo $email; ?>">
		
		<label for="firstName"><? echo $firstname; ?></label>
		<input id="firstName" name="firstName" type="text" class="input-block-level" placeholder="<? echo $firstname; ?>">
		
		<label for="lastName"><? echo $lastname; ?></label>
		<input id="lastName"  name="lastName" type="text" class="input-block-level" placeholder="<? echo $lastname; ?>">
		
		<label for="country"><? echo $country; ?></label>
		<input id="country" name="country" type="text" class="input-block-level" placeholder="<? echo $country; ?>">
		
		<label for="dayOfBirth"><? echo $birthday; ?> (2000-12-31)</label>
		<input id="dayOfBirth" name="dayOfBirth" type="text" class="input-block-level" placeholder="<? echo $birthday; ?>">
		
		<label for="gender"><? echo $gender; ?></label>
		<select id="gender" name="gender" class="input-block-level">
			<option value="m"><? echo $male ?></option>
			<option value="f"><? echo $female ?></option>
		</select>
		
		<label for="language"><? echo $language; ?></label>
		<select id="language" name="language" class="input-block-level">
			<option value="de-DE">Deutsch</option>
			<option value="en-EN">English</option>
		</select>
		
		<input type="submit" class="btn btn-primary" value="<? echo $changeprofile;?>"/>
    </form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>

<div class="container rightband">
  <div class="row-fluid">
    <div class="span3">
      <div class="well sidebar-nav">
      <h2 id="username"></h2>
		<span style="text-align: center; display: block">
			<img src="./assets/includes/get.php?url=https://giv-car.uni-muenster.de/stable/rest/users/<? echo $user; ?>/avatar?size=200&amp;auth=true" style="height: 200px; width:200px; margin-right: auto; margin-left: auto;" alt="<? echo $user;?>"/>
		</span>
    <br>
        <ul id="userInformation" class="nav nav-list" style="text-align:center"></ul>
        <ul id="badges" class="nav nav-list" style="text-align:center"></ul>
		<?
			if($user == $loggedInUser){
		?>
			<span style="text-align: center; display: block">
				<a href="javascript:deleteAccount();" class="btn btn-primary btn-small" style="margin-top: 1em">
					<? echo $deletemyaccount; ?>
				</a>
				<a href="#changeProfile" class="btn btn-primary btn-small" style="margin-top: 1em" data-toggle="modal">
					<? echo $editaccount; ?>
				</a>
			</span>
		<?
			}else{
		?>
			<span id="addAsFriendLink"></span>
		<?
            }
		?>
      </div><!--/.well -->
    </div><!--/span-->


    <div id="nofriends" style="display:none" class="span3 offset2"><? echo $user.' '.$noFriendsYet ?></div>
    <div id="comparison" class="span5">
        <div id="chart_div" style="width: 700px; height: 400px;">   
          <div id="loadingIndicator_graph" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px; display:none">
          </div>
        </div>
      </div>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script> 

  <? if($user != $loggedInUser){ ?>
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
            values[i]= Math.round(data.statistics[i].avg*100)/100;
            phen[i]=data.statistics[i].phenomenon.name;
          }
        }
      });

      $.get('assets/includes/users.php?friendStatistics='+friend, function(data) {
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
          data.addColumn('number', '<? echo $_SESSION['name'] ?>');
          data.addColumn('number', friend);

          data.addRows(count);
               
        for(i = 0; i < count; i++){
          if(phen[i] == 'Rpm'){
            phen[i] = phen[i]+' (100/min)';
            values[i] = values[i]/100;
            values2[i] = values2[i]/100;
          }
          data.setValue(i, 0, phen[i]);
          data.setValue(i, 1, values[i]);
          data.setValue(i, 2, values2[i]);
        }
     
        var options = {
          title: '<? echo $statistics ?>',
          vAxis: {title: '',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        $('#loadingIndicator_graph').hide();
      }
    </script>  

<? }else{ ?>
   <script type="text/javascript">
      var values = [];
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
            values[i]= Math.round(data.statistics[i].avg*100)/100;
            phen[i]=data.statistics[i].phenomenon.name;
          }
          google.setOnLoadCallback(drawChart());
        }
      });

      google.load("visualization", "1", {packages:["corechart"]});

      function drawChart() {
        var data = new google.visualization.DataTable();
          data.addColumn('string','Measurement');
          data.addColumn('number', '<? echo $_SESSION['name'] ?>');

          data.addRows(count);
               
        for(i = 0; i < count; i++){
          if(phen[i] == 'Rpm'){
            phen[i] = phen[i]+' (100/min)';
            values[i] = values[i]/100;
          }
          data.setValue(i, 0, phen[i]);
          data.setValue(i, 1, values[i]);
        }
     
        var options = {
          title: '<? echo $statistics ?>',
          vAxis: {title: '',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        $('#loadingIndicator_graph').hide();
      }
    </script>  


<? } ?>

    </div>
</div>

	<div class="container leftband" id="friendsgroups">
		<div class="span4">
			<h2><? echo $friends ?></h2>
			<div id="loadingIndicator_friends" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
			<ul id="friends" style="margin-bottom: 10px; overflow-y:auto; max-height: 400px;">
			</ul>
		</div>
		<div class="span4">
			<h2><? echo $groups ?></h2>
			<ul id="groups" style="margin-bottom: 10px; overflow-y:auto; max-height: 400px;">
			</ul>
		<div id="loadingIndicator_groups" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;"></div>
	</div>
</div>
	<div class="container rightband">
	<div class="row-fluid">
        <div class="span5">
          <h2><?php echo $dashboard_activities_of; ?> <? echo $user ?></h2>
            <div id="loadingIndicator_friend_activities" style="background:url(./assets/img/ajax-loader.gif) no-repeat center center; height:100px;">
            </div>
		  <ul id="friendActivities" style="min-height: 93px; max-height: 400px; overflow-y:auto">
              
		  </ul>
		  <p> </p>
        </div>
		</div>
	</div>
<?
include('footer.php');
?>