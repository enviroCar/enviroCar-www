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

include('header.php');
?>

<!-- ==============================================
		 JavaScript below! 															-->

<!-- jQuery via Google + local fallback, see h5bp.com -->
	  <script src='./assets/js/jquery-1.7.1.min.js'></script>

<!-- Bootstrap JS -->
	  <script src="./assets/js/bootstrap.min.js"></script>

<!-- Validate plugin -->
		<script src="./assets/js/jquery.validate.min.js"></script>

<!-- Prettify plugin -->
		<script src="./assets/js/prettify/prettify.js"></script>

<!-- Scripts specific to this page -->
		<script src="./assets/js/validation.js"></script>
		
<link href="./assets/css/validation.css" rel="stylesheet">

<script type="text/javascript">
      //Sending the credentials to the authentification page
    function registration(){
        if($('#registrationemail').val() === ''){
          alert("<?php echo $freg_invalidemail;?>");
        }else if($('#name').val() === ''){
          alert("<?php echo $freg_empty_nickname;?>");
        }
        else if($('#password1').val() === ''){
          alert("<?php echo $freg_empty_password;?>");
        }
        else if($('#password2').val() === ''){
          alert("<?php echo $freg_empty_password;?>");
        }else{
        	if($('#password1').val() != $('#password2').val()){
          		alert("<?php echo $freg_notidentic_password;?>");
          	}else{
	          $.post('./assets/includes/authentification.php?registration', {email: $('#registrationemail').val(), password: $('#password1').val(), name: $('#name').val()}, 
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
		<form action="" id="contact-form" class="form-horizontal">
		
		        <h2 class="form-signin-heading"><?php echo $reg_registration;?></h2>
		        <input id="name" name="name" type="text" class="input-block-level" placeholder="<?php echo $reg_username;?>">
		        <input id="registrationemail" name="email"type="text" class="input-block-level" placeholder="<?php echo $reg_email;?>">
		        <input id="password1" name="password1" type="password" class="input-block-level" placeholder="<?php echo $reg_password;?>">
		        <input id="password2" name="password2" type="password" class="input-block-level" placeholder="<?php echo $reg_repeat_password;?>">
		        <button class="btn btn-large btn-primary" onclick="registration()"><?php echo $reg_btn_register;?></button> 
				<button style="float:right;" class="btn btn-large btn-primary" type="reset"><?php echo $reg_btn_reset;?></button>
		</form>
		</div>
		<div class="span3"></div>
	</div>
</div>

<?php 
include('footer.php');
