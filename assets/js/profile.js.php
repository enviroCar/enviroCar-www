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
      return './assets/includes/get.php?redirectUrl=https://envirocar.org/api/stable/users/'+name+'/avatar&amp;auth=true';
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