<?

require_once('./assets/includes/authentification.php');

$logged_in = false; 
if(!is_logged_in()){
	$logged_in = false; 
	include('header-start.php');
}else{
	$logged_in = true;
	include('header.php');
}
?>

<!-- Validate plugin -->
<script src="./assets/js/jquery.validate.min.js"></script>
<style type="text/css">
	label.valid {
	  width: 24px;
	  height: 24px;
	  background: url(assets/img/valid.png) center center no-repeat;
	  display: inline-block;
	  text-indent: -9999px;
	}
	label.error {
		font-weight: bold;
		color: red;
		padding: 2px 8px;
		margin-top: 2px;
	}
</style>

<script type="text/javascript">
	$(function(){
        $('#contact-form').submit(function(){
        	
/*        	//check if terms of use checkbox was checked
        	if(!document.getElementById("accept_terms").checked){
        		alert('<? echo $terms_check_alert ?>');
        		return false;
        	}*/
        	
        	var invalid_inputs = $('#contact-form').validate(validation_rules).invalid;
        	if($('#contact-form').valid()){
        		//TODO add flag for accepted terms
          	$.post('./assets/includes/authentification.php?registration', {email: $('#registrationemail').val(), password: $('#password1').val()	, name: $('#name').val()}, 
	        	function(response){
	        		if(response == 201){
	        	      	window.location.href = "index.php?registration_successful";
	        	    }else if(response == 400){
	        	    	error_msg("<? echo $registrationError ?>");
	        	    }else if(response == 401){
	        	    	error_msg("<? echo $registrationInvalid ?>");
	        	    }else if(response == 403 || response == 405){
	        	    	error_msg("<? echo $registrationNotAllowed ?>");
	        	    }else{
	        	    	toggle_visibility('registration_fail');
	        	    }
	    		});
          	}else{
          		alert('<? echo $invalid_input ?>');
          	}
          return false;
        });
    });

    
	var validation_rules = {
		    rules: {
		      name: {
		        minlength: 4,
		        required: true
		      },
		      email: {
		        required: true,
		        email: true
		      },
		      password1: {
		      	minlength: 6,
		        required: true
		      },
		      password2: {
			    equalTo:'#password1',
		        minlength: 6,
		        required: true
		      }
		    },
				highlight: function(element) {
					$(element).closest('.control-group').removeClass('success').addClass('error');
				},
				success: function(element) {
					element
					.text('OK!').addClass('valid')
					.closest('.control-group').removeClass('error').addClass('success');
				}
		  };

    $(document).ready(function(){
		$('#contact-form').validate(validation_rules);

	});
</script>

<div class="container rightband">
	<div class="row-fluid">
		<div class="span6 offset2">
		<form action="./assets/includes/authentification.php?registration" id="contact-form" class="form-horizontal" method="post">
			<h2 class="form-signin-heading"><?php echo $reg_registration;?></h2>
		    <div class="control-group">
				<label class="control-label" for="name">Nick-Name</label>
				<div class="controls">
				    <input type="text" class="input-xlarge" name="name" id="name" placeholder="Nick-Name">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="registrationemail"><?php echo $reg_email;?></label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="email" id="registrationemail" placeholder="<?php echo $reg_email;?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="password1"><?php echo $reg_password;?></label>
				<div class="controls">
					<input class="input-xlarge" name="password1" type="password" id="password1" placeholder="<?php echo $reg_password;?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="password2"><?php echo $reg_repeat_password;?></label>
				<div class="controls">
					<input class="input-xlarge" name="password2" type="password" id="password2" placeholder="<?php echo $reg_repeat_password;?>">
				</div>
			</div>
	        <button type="submit" class="btn btn-medium btn-primary"><?php echo $reg_btn_register;?></button> 
			<button style="float:right;" class="btn btn-medium btn-primary" type="reset" value="Reset" onClick="window.location.reload()"><?php echo $reg_btn_reset;?></button>
		</form>
<!--		<input type="checkbox" id="accept_terms" name="accept_terms" value="accept_terms"> <?php echo $terms_check ?>-->
		</div>

    </div>
</div>

<?
include('footer.php');
?>
