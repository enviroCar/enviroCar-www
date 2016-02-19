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

<?php 
if(isset($_GET['name_taken'])){
?>
  <div class="container alert alert-block alert-info fade in"> 
  <a class="close" data-dismiss="alert">×</a>  
  <?php echo $index_register_name_taken; ?>
</div> 
<?php 
}
?>

<div class="container rightband">
	<div class="row-fluid">
		<div class="span6 offset2">
		<form action="./assets/includes/authentification.php?registration" id="contact-form" class="form-horizontal" method="post">
			<h3 class="form-signin-heading"><?php echo $reg_registration;?></h3>
		    <div class="control-group">
				<label class="control-label" for="name">Nick-Name</label>
				<div class="controls">
				    <input type="text" class="input-xlarge" name="name" id="name" placeholder="Nick-Name" required data-validation-ajax-ajax='./assets/includes/users.php?user-exists' data-validation-username-message="<?php echo $username_validation_message ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="registrationemail"><?php echo $reg_email;?></label>
				<div class="controls">
					<input type="email" class="input-xlarge" name="email" id="registrationemail" placeholder="<?php echo $reg_email;?>" required data-validation-required-message="<?php echo $required_validation_message ?>" aria-invalid="true" data-validation-email-message="<?php echo $email_validation_message ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="password1"><?php echo $reg_password;?></label>
				<div class="controls">
					<input class="input-xlarge" name="password1" type="password" required data-validation-required-message="<?php echo $required_validation_message ?>" minlength="6" data-validation-minlength-message="<?php echo $password_validation_message ?>" id="password1" placeholder="<?php echo $reg_password;?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="password2" ><?php echo $reg_repeat_password;?></label>
				<div class="controls">
					<input class="input-xlarge" name="password2" type="password" id="password2" placeholder="<?php echo $reg_repeat_password;?>" required data-validation-required-message="<?php echo $required_validation_message ?>" data-validation-match-match="password1" data-validation-match-message="<?php echo $password_match_validation_message ?>">
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<!-- <button class="btn btn-medium btn-primary" type="reset" value="Reset" onClick="window.location.reload()"><?php echo $reg_btn_reset;?></button> -->
        			<button type="submit" class="btn btn-medium btn-primary"><?php echo $reg_btn_register;?></button>
      			</div>
			</div>
		</form>
<!--		<input type="checkbox" id="accept_terms" name="accept_terms" value="accept_terms"> <?php echo $terms_check ?>-->
		</div>

    </div>
</div>


<script src="./assets/js/jqBootstrapValidation.js"></script>
<?php 
	include('footer.php');
?>

