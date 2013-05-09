<?
include('header-start.php');
?>

<script type="text/javascript">
      //Sending the credentials to the authentification page
    function registration(){
        if($('#registrationemail').val() === ''){
          alert("Invalid Email");
        }else if($('#name').val() === ''){
          alert('Nickname cannot be empty');
        }
        else if($('#password1').val() === ''){
          alert('Password cannot be empty');
        }
        else if($('#password2').val() === ''){
          alert('Password cannot be empty');
        }else{
        	if($('#password1').val() != $('#password2').val()){
          		alert('Passwords are not identic');
          	}else{
	          $.post('../assets/includes/authentification.php?registration', {email: $('#registrationemail').val(), password: $('#password1').val(), name: $('#name').val()}, 
	            function(response){
	              if(response === 'status:ok'){
	              	window.location.href = "index.php?registration_successful";
	              }else{
	              	toggle_visibility('registration_fail');
	              }
	            });
	        }
        }
      }
</script>


<div class="container rightband">
	<div class="row-fluid">
		<div class="span3"></div>
		<div class="span6">
		        <h2 class="form-signin-heading">Registration</h2>
		        <input id="name" type="text" class="input-block-level" placeholder="Nickname">
		        <input id="registrationemail" type="text" class="input-block-level" placeholder="Email Address">
		        <input id="password1" type="password" class="input-block-level" placeholder="Password">
		        <input id="password2" type="password" class="input-block-level" placeholder="Repeat Password">
		        <button class="btn btn-large btn-primary" onclick="registration()">Register</button> 
				<button style="float:right;" class="btn btn-large btn-primary" type="reset">Reset</button>
		</div>
		<div class="span3"></div>
	</div>
</div>



<?
include('footer.php');
?>
