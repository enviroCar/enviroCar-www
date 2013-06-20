<?
include('header.php');
require_once('assets/includes/connection.php');

$loggedInUser = $_SESSION["name"];
$user = (isset($_GET['user'])) ? $_GET['user'] : $loggedInUser;
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
          error_msg("<? echo $personNotAllowed ?>")
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
      }
    });
  }


  function getUserGroups(){
    $.get('./assets/includes/users.php?groupsOf='+user, function(data) {
      if(data >= 400){
        if(data == 400){
          error_msg("<? echo $groupError ?>");
        }else if(data == 401 || data == 403){
          error_msg("<? echo $groupNotAllowed ?>")
        }else if(data == 404){
          error_msg("<? echo $groupNotFound ?>")
        }
        $('#loadingIndicator').hide();
      }else{
        data = JSON.parse(data);
        if(data.groups.length > 0 ){
          $('#groups').append('<ul style="margin-bottom: 10px; overflow-y:auto; max-height: 400px;">');
          for(i = 0; i < data.groups.length; i++){
            $('#groups').append('<li class="customLi"><a href="group.php?group='+data.groups[i].name+'">'+data.groups[i].name+'</a></li>');
          }
          $('#groups').append('</ul>');
        }
      }
    });
  }

  function getLoggedInUserFriends(){
    $.get('./assets/includes/users.php?friendsOf='+loggedInUser, function(data) {
      if(data >= 400){
        if(data == 400){
          error_msg("<? echo $friendError ?>");
        }else if(data == 401 || data == 403){
          error_msg("<? echo $friendNotAllowed ?>")
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
          error_msg("<? echo $friendNotAllowed ?>")
        }else if(data == 404){
          error_msg("<? echo $friendNotFound ?>")
        }
        $('#loadingIndicator').hide();
      }else{
        data = JSON.parse(data);
        if(data.users.length > 0 ){
          $('#friends').html("");
          for(i = 0; i < data.users.length; i++){
            $('#friends').append('<li class="customLi"><img src='+getAvatar(data.users[i].name,30)+' style="height: 30px; margin-right: 10px; "/><a href="profile.php?user='+data.users[i].name+'">'+data.users[i].name+'</a></li>');
          }
        }

      }
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
        $('#changeProfilForm').submit(function(){
          changeData = getFormData($('#changeProfilForm'));
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
  
  $(function () {
    init();
});

</script>
 
<div id="changeProfil" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Change Profil</h3>
  </div>
  <div class="modal-body">
    <form id="changeProfilForm" action="./assets/includes/users.php?updateUser" method="post">
      Email: <input id="mail" name="mail" type="text" class="input-block-level" placeholder="Email">
      <? echo $firstname ?>: <input id="firstName" name="firstName" type="text" class="input-block-level" placeholder="First Name">
      <? echo $lastname ?>:<input id="lastName"  name="lastName" type="text" class="input-block-level" placeholder="Last Name">
      <? echo $country ?>:<input id="country" name="country" type="text" class="input-block-level" placeholder="Country">
      <? echo $location ?>:<input id="location" name="location" type="text" class="input-block-level" placeholder="Location">
      Website:<input id="url" name="url" type="text" class="input-block-level" placeholder="Website">
      <? echo $birthday ?>:<input id="dayOfBirth" name="dayOfBirth" type="text" class="input-block-level" placeholder="Birthday">
      <? echo $gender ?>:<br>
      <select id="gender" name="gender">
        <option value="m"><? echo $male ?></option>
        <option value="f"><? echo $female ?></option>
      </select><br>
      <? echo $language ?>:<br>
      <select id="language" name="language">
        <option value="de-DE">Deutsch</option>
        <option value="en-EN">English</option>
      </select><br>
      <? echo $aboutme ?>:<input id="aboutMe" name="aboutMe" type="text" class="input-block-level" placeholder="aboutMe">
      <input type="submit" class="btn btn-primary">
    </form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>

<div class="container rightband">
  <div class="row-fluid">
    <div class="span4">
      <div class="well sidebar-nav">
        <ul class="nav nav-list">
          <img src="./assets/includes/get.php?url=https://giv-car.uni-muenster.de/stable/rest/users/<? echo $user; ?>/avatar?size=200&auth=true" align="center" style="height: 200px; width:200px; margin-right: 100px; "/>
          <li class="nav-header"></li>
          <li><b id="username"></b></li>
        </ul>
        <ul id="userInformation" class="nav nav-list">
        </ul>
        <ul class="nav nav-list">
          <?
            if($user == $loggedInUser){
          ?>
              <p>
				<a href="javascript:deleteAccount();" class="btn btn-primary btn-small">
					<? echo $deletemyaccount; ?>
				</a>
				<a href="#changeProfil" class="btn btn-primary btn-small" data-toggle="modal">
					<? echo $editaccount; ?>
				</a>
			</p>
          <?
            }else{
          ?>
              <li id="addAsFriendLink"></li>
           <?
            }
          ?>
        </ul>
      </div><!--/.well -->
    </div><!--/span-->

    <div id="friendsgroups" class="span8">
      <div class="span5">
        <h2><? echo $friends ?></h2>
        <ul id="friends" style="margin-bottom: 10px; overflow-y:auto; max-height: 400px;">
        </ul>
      </div>
      <div id="groups" class="span5">
        <h2><? echo $groups ?></h2>
      </div>
    </div>
  </div>
</div>
      
<?
include('footer.php');
?>
      
         
        
        

     

     
    


    

