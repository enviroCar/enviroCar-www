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
require_once('assets/includes/connection.php');

$logged_in = false; 
if(!is_logged_in()){
	$logged_in = false; 
	include('header-start.php');
}else{
  header("Location: index.php?lost_password_access_denied");
  die();
}
$code = $_GET["code"];
$user	= $_GET["user"];

?>

<div id="password-reset-error" class="container alert alert-block alert-error fade in" style="display: none;"> 
  <a class="close" data-dismiss="alert">×</a>
  <?php echo $index_password_reset_error ?>
</div>

<div class="container rightband">
	<div class="row-fluid">
		<div class="span6 offset2">

			<h3><?php echo $index_reset_password ?><span class="extra-title muted"></span></h3>

		  <form class="form" id="reset-password-form" accept-charset="UTF-8">
		  	<div class="control-group">
		      <div class="controls">
		  			<input id="code" name="code" type="hidden" class="input" value="<?php echo $code; ?>"/>
		  		</div>
	      </div>
		  	<div class="control-group">
		  		<div class="controls">
		  			<input id="password" name="user" type="hidden" class="input" value="<?php echo $user; ?>"/>
		  		</div>
		  	</div>
		  	
	      <div class="control-group">
		  		<label for="password"><?php echo $newPassword; ?></label>
		      <div class="controls">
		  			<input data-validation-minlength-message="<?php echo $password_validation_message ?>" minlength="6" id="password" name="password" type="password" class="input" placeholder="<?php echo $newPassword; ?>"/>
		  		</div>
	      </div>
	      
	      <div class="control-group">
	  			<label for="passwordRepeat"><?php echo $passwordRepeat; ?></label>
		      <div class="controls">
		  			<input data-validation-match-message="<?php echo $password_match_validation_message ?>" data-validation-match-match="password" id="passwordRepeat" name="passwordRepeat" type="password" class="input" placeholder="<?php echo $passwordRepeat; ?>"/>
	        </div>
	      </div>

		    <div class="control-group">
		      <div class="controls">    
		        <button type="button" class="btn btn-primary" onclick="submitForm()"><?php echo $index_submit ?></button>
		      </div>
		    </div>
	  	</form>
		</div>
	</div>
</div>


<?php 
  include('footer.php');
?>