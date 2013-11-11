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

	function submitProfileChanges(){

	        changeData = getFormData($('#changeProfileForm'));
          if($('#dayOfBirth').val() != ''){
            if(!validateDate($('#dayOfBirth').val())){
              alert("Birthday has to be in the format YYYY-MM-DD");
              return false;
            }
          }
          newPw = $('#password').val();

          if(newPw != '') {
            if (newPw.length < 6) {
              alert("Password too short. Please use more than five characters");
              return false;
            }
            repeatePw = $('#passwordRepeat').val();
            result = newPw.localeCompare(repeatePw);
                  if (result != 0) {
              alert("Password mismatch");
              return false;
            }
          }
          var r = "";
          $.post('./assets/includes/users.php?updateUser', changeData, function(response){
            r = response;
            if(response >= 400){
              alert("Something is wrong.");
              console.log('error');
            }else{
              alert("Success!");
              location.reload(true);
              console.log('changed');
            }
            console.log(response);
          });
      return false;	
	}

    function getAvatar(name, size){
      return './assets/includes/get.php?redirectUrl=https://envirocar.org/api/stable/users/'+name+'/avatar&amp;auth=true';
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
      
  function init(){
    loggedInUser = '<?php echo $_SESSION["name"] ?>';
    user = '<?php echo $user; ?>';
    getUserInfo();
    $('#username').html(user);
  }      
      
  	$(function () {
    init();
	});

</script>

<div class="container rightband">
  <div class="row-fluid">
    <div class="span3">
      <div class="well sidebar-nav">
      <h2 id="username"></h2>
		<span style="text-align: center; display: block">
			<img src="./assets/includes/get.php?url=https://envirocar.org/api/stable/users/<? echo $user; ?>/avatar?size=200&amp;auth=true" style="height: 200px; width:200px; margin-right: auto; margin-left: auto;" alt="<? echo $user;?>"/>
		</span>
    <br>        
        <ul id="badges" class="nav nav-list" style="text-align:center"></ul>
       <span style="text-align: center; display: block">
				<a href="javascript:deleteAccount();" class="btn btn-primary btn-small" style="margin-top: 1em">
					<? echo $deletemyaccount; ?>
				</a>
		</span>   
      </div><!--/.well -->
    </div><!--/span-->  
	 <div class="span6">
        
    <? echo $avatarGravatar ?> <a href="http://www.gravatar.com" target='_blank'>Gravatar</a><br>
    <form id="changeProfileForm">
  		<label for="mail"><? echo $email; ?></label>
  		<input id="mail" name="mail" type="text" class="input-block-level" placeholder="<? echo $email; ?>"/>
  		
  		<label for="firstName"><? echo $firstname; ?></label>
  		<input id="firstName" name="firstName" type="text" class="input-block-level" placeholder="<? echo $firstname; ?>"/>
  		
  		<label for="lastName"><? echo $lastname; ?></label>
  		<input id="lastName"  name="lastName" type="text" class="input-block-level" placeholder="<? echo $lastname; ?>"/>
  		
  		<label for="country"><? echo $country; ?></label>
  		<input id="country" name="country" type="text" class="input-block-level" placeholder="<? echo $country; ?>"/>
  		
  		<label for="dayOfBirth"><? echo $birthday; ?> (2000-12-31)</label>
  		<input id="dayOfBirth" name="dayOfBirth" type="text" class="input-block-level" placeholder="<? echo $birthday; ?>"/>
  		
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
  		
  		<hr />
  		
  		<div><?php echo $password_change_info ?></div>
      <label for="oldPassword"><? echo $oldPassword; ?></label>
      <input id="oldPassword" name="oldPassword" type="password" class="input-block-level" placeholder="<? echo $oldPassword; ?>"/>
  		
  		<label for="password"><? echo $newPassword; ?></label>
  		<input id="password" name="password" type="password" class="input-block-level" placeholder="<? echo $newPassword; ?>"/>
  		
  		<label for="passwordRepeat"><? echo $passwordRepeat; ?></label>
  		<input id="passwordRepeat" name="passwordRepeat" type="password" class="input-block-level" placeholder="<? echo $passwordRepeat; ?>"/>

  		<input type="button" class="btn btn-primary" value="<? echo $editaccount; ?>" onclick="submitProfileChanges()">
    </form>      
  </div>
</div>
<?
include('footer.php');
?>
