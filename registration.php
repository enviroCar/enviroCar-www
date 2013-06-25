<?
include('header-start.php');

?>

<!-- Validate plugin -->
<script src="./assets/js/jquery.validate.min.js"></script>


<script type="text/javascript">
	$(function(){
        $('#contact-form').submit(function(){
          	$.post('./assets/includes/authentification.php?registration', {email: $('#registrationemail').val(), password: $('#password1').val(), name: $('#name').val()}, 
	        function(response){
	        	if(response === 'status:ok'){
	              	window.location.href = "index.php?registration_successful";
	            }else{
	            	toggle_visibility('registration_fail');
	            }
	    	});
          return false;
        });
    });
        
    $(document).ready(function(){
		$('#contact-form').validate({
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
		  });

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
				<label class="control-label" for="registrationemail"><?php echo $reg_email;?></label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="email" id="registrationemail" placeholder="<?php echo $reg_email;?>">
				</div>
				<label class="control-label" for="password1"><?php echo $reg_password;?></label>
				<div class="controls">
					<input class="input-xlarge" name="password1" type="password" id="password1" placeholder="<?php echo $reg_password;?>">
				</div>
				<label class="control-label" for="password2"><?php echo $reg_repeat_password;?></label>
				<div class="controls">
					<input class="input-xlarge" name="password2" type="password" id="password2" placeholder="<?php echo $reg_repeat_password;?>">
				</div>
			</div>
	        <button type="submit" class="btn btn-medium btn-primary"><?php echo $reg_btn_register;?></button> 
			<button style="float:right;" class="btn btn-medium btn-primary" type="reset"><?php echo $reg_btn_reset;?></button>
		</form>
		</div>

</div>

<?
include('footer.php');
?>
