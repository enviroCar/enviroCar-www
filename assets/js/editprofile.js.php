<?php
/*
* This file is subject to the terms and conditions defined in
* file 'LICENSE', which is part of this source code package.
*/
?>

<script type="text/javascript">
//enable form validation
$(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation({
	submitError: function ($form, event, errors) {
		$('.alert-block').hide();
		window.scrollTo(0,0);
		$('#edit-profile-input-error').show();
	}
}); } );

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
	          $('#badges').append('<li rel="tooltip" data-placement="right" data-toggle="tooltip" class="label label-envirocar" data-original-title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >First Contributor</li>');
	        }else if(data.badges[i] === "friend"){
	          $('#badges').append('<li rel="tooltip" data-placement="right" data-toggle="tooltip" class="label label-envirocar" data-original-title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >Friend of enviroCar</li>');
	        }else if(data.badges[i] === "support"){
	          $('#badges').append('<li rel="tooltip" data-placement="right" data-toggle="tooltip" class="label label-envirocar" data-original-title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >First Supporters</li>');
	        }else if(data.badges[i] === "local-stakeholder"){
	          $('#badges').append('<li rel="tooltip" data-placement="right" data-toggle="tooltip" class="label label-envirocar" data-original-title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >First Local Stakeholder</li>');
	        }else if(data.badges[i] === "fan"){
	          $('#badges').append('<li rel="tooltip" data-placement="right" data-toggle="tooltip" class="label label-envirocar" data-original-title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >enviroCar Fan</li>');
	        }else if(data.badges[i] === "regional-stakeholder"){
	          $('#badges').append('<li rel="tooltip" data-placement="right" data-toggle="tooltip" class="label label-envirocar" data-original-title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >First Regional Stakeholder</li>');
	        }else if(data.badges[i] === "early-bid"){
	          $('#badges').append('<li rel="tooltip" data-placement="right" data-toggle="tooltip" class="label label-envirocar" data-original-title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >enviroCar Early Bid</li>');
	        }else if(data.badges[i] === "partner"){
	          $('#badges').append('<li rel="tooltip" data-placement="right" data-toggle="tooltip" class="label label-envirocar" data-original-title="'+user+' has this badge because he supported enviroCar on it\'s Indiegogo campain" >enviroCar Partner</li>');
	        }
	      }
	    }
	  }
	});
}

function submitProfileChanges(){

  changeData = getFormData($('#changeProfileForm'));
  var r = "";
  $.post('./assets/includes/users.php?updateUser', changeData, function(response){
  	debugger;
    r = response;
    if(response >= 400){
    	$('.alert-block').hide();
    	window.scrollTo(0,0);
			$('#edit-profile-error').show();
    }else{
    	$('.alert-block').hide();
      window.scrollTo(0,0);
			$('#edit-profile-success').show();
    }
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
	  indexed_array[n['name']] = n['value'];
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