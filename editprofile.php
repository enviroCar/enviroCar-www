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
require_once('assets/includes/connection.php');

$loggedInUser = $_SESSION["name"];
$user = (isset($_GET['user'])) ? $_GET['user'] : $loggedInUser;
?>

<div id="edit-profile-input-error" class="container alert alert-block alert-error fade in" style="display:none;"> 
  <a class="close" data-dismiss="alert">×</a> 
  <? echo $edit_profile_invalid_input; ?>
</div> 

<div id="edit-profile-error" class="container alert alert-block alert-error fade in" style="display:none;"> 
  <a class="close" data-dismiss="alert">×</a> 
  <? echo $edit_profile_error; ?>
</div> 

<div id="edit-profile-success" class="container alert alert-block alert-success fade in" style="display:none;"> 
  <a class="close" data-dismiss="alert">×</a> 
  <? echo $edit_profile_success; ?>
</div> 

<div class="container rightband">
  <div class="row-fluid">
    <div class="span3">
      <div class="sidebar-nav">
    		<span style="text-align: center; display: block">
          <a href="javascript:deleteAccount();" class="btn btn-primary btn-small" style="margin-top: 1em">
            <? echo $deletemyaccount; ?>
          </a><br>
          <br>
    			<img src="./assets/includes/get.php?redirectUrl=https://envirocar.org/api/stable/users/<? echo $user; ?>/avatar?size=200&amp;auth=true" style="height: 200px; width:200px; margin-right: auto; margin-left: auto;" alt="<? echo $user;?>"/>
    		  <h2 id="username"></h2>
          <br> 
          <h3>Badges</h3>
        </span>   
        <ul id="badges" class="nav nav-list" style="text-align:center"></ul>   
      </div><!--/.well -->
    </div><!--/span-->  
	 <div class="span6">
        
    <? echo $avatarGravatar ?> <a href="http://www.gravatar.com" target='_blank'>Gravatar</a><br>
    <form id="changeProfileForm" action="javascript:submitProfileChanges();">
      <div class="control-group">
        <label class="control-label" for="mail"><?php echo $email;?></label>
        <div class="controls">
      		<input id="mail" name="mail" type="email" class="input-block-level" placeholder="<? echo $email; ?>" required aria-invalid="true" data-validation-email-message="<?php echo $email_validation_message ?>">
  		  </div>
      </div>
      <div class="control-group">
  		<label for="firstName"><? echo $firstname; ?></label>
      <div class="controls">
  		<input id="firstName" name="firstName" type="text" class="input-block-level" placeholder="<? echo $firstname; ?>"/>
  		  </div>
      </div>

      <div class="control-group">
  		<label for="lastName"><? echo $lastname; ?></label>
      <div class="controls">
  		<input id="lastName"  name="lastName" type="text" class="input-block-level" placeholder="<? echo $lastname; ?>"/>
  		  </div>
      </div>
      
      <div class="control-group">
  		<label for="country"><? echo $country; ?></label>
      <div class="controls">
  		<input id="country" name="country" type="text" class="input-block-level" placeholder="<? echo $country; ?>"/>
  		  </div>
      </div>
      
      <div class="control-group">
  		<label for="dayOfBirth"><? echo $birthday; ?> (2000-12-31)</label>
      <div class="controls">
  		<input data-validation-regex-message="<?php echo $date_validation_message ?>" data-validation-regex-regex="^(19|20)\d\d([- /.])(0[1-9]|1[012])\2(0[1-9]|[12][0-9]|3[01])$" id="dayOfBirth" name="dayOfBirth" type="text" class="input-block-level" placeholder="<? echo $birthday; ?>"/>
  		  </div>
      </div>
      
      <div class="control-group">
  		<label for="gender"><? echo $gender; ?></label>
      <div class="controls">
  		<select id="gender" name="gender" class="input-block-level">
  			<option value="m"><? echo $male ?></option>
  			<option value="f"><? echo $female ?></option>
  		</select>
  		  </div>
      </div>
      
      <div class="control-group">
  		<label for="language"><? echo $language; ?></label>
      <div class="controls">
  		<select id="language" name="language" class="input-block-level">
  			<option value="de-DE">Deutsch</option>
  			<option value="en-EN">English</option>
  		</select>
  		  </div>
      </div>
      
  		<hr />
  		
  		<div><?php echo $password_change_info ?></div>
      <div class="control-group">
      <label for="oldPassword"><? echo $oldPassword; ?></label>
      <div class="controls">
      <input id="oldPassword" name="oldPassword" type="password" class="input-block-level" placeholder="<? echo $oldPassword; ?>"/>
  		  </div>
      </div>
      
      <div class="control-group">
  		<label for="password"><? echo $newPassword; ?></label>
      <div class="controls">
  		<input data-validation-minlength-message="<?php echo $password_validation_message ?>" minlength="6" id="password" name="password" type="password" class="input-block-level" placeholder="<? echo $newPassword; ?>"/>
  		</div>
      </div>
      
      <div class="control-group">
  		<label for="passwordRepeat"><? echo $passwordRepeat; ?></label>
      <div class="controls">
  		<input data-validation-match-message="<?php echo $password_match_validation_message ?>" data-validation-match-match="password" id="passwordRepeat" name="passwordRepeat" type="password" class="input-block-level" placeholder="<? echo $passwordRepeat; ?>"/>
        </div>
      </div>
      
  		<input type="submit" class="btn btn-primary" value="<? echo $editaccount; ?>">
    </form>      
  </div>
</div>
</div>


<?
  include('footer.php');
?>
