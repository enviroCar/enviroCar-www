<?php
/*
* This file is subject to the terms and conditions defined in
* file 'LICENSE', which is part of this source code package.
*/

require_once('./assets/includes/authentification.php');
$logged_in = false; 
if(!is_logged_in()){
  $logged_in = false; 
  include('header-start.php');
}else{
  header("Location: index.php?lost_password_access_denied");
  die();
}
?>

<div id="password-lost-error" class="container alert alert-block alert-error fade in" style="display: none;"> 
  <a class="close" data-dismiss="alert">×</a>
  <?echo $index_password_lost_error ?>
</div>

<div class="container rightband">
        <div class="row-fluid">
                <?php echo $captcha_incorrect_alert ?>
                <div class="span6 offset2">

                        <h3><?php echo $index_reset_password ?><span class="extra-title muted"></span></h3>

                  <form class="form-horizontal" id="lost-password-form" accept-charset="UTF-8" action="<?php echo basename($_SERVER['SCRIPT_FILENAME']); ?>" data-remote="true" method="post">
                      <div class="control-group">
		          <label for="user" class="control-label">Nickname</label>
		          <div class="controls">
		              <input id="lost-password-user" type="text" name="user" required value="<?php if(isset($user)) echo $user; ?>">
		          </div>
		      </div>
		      <div class="control-group">
		          <label for="email" class="control-label">E-Mail</label>
		          <div class="controls">
		              <input id="lost-password-mail" type="email" name="email" required data-validation-required-message="<?php echo $required_validation_message ?>" aria-invalid="true" data-validation-email-message="<?php echo $email_validation_message ?>" value="<?php if(isset($mail)) echo $mail; ?>">
		          </div>
		      </div>

		        
		    <div class="control-group">
                            <label for="recaptcha" class="control-label"><?php echo $index_recaptcha ?></label>
                            <div class="controls">
                            <script type="text/javascript" src="https://www.google.com/recaptcha/api/challenge?k=6LcUPeoSAAAAAETOO0Xnxx1TcyNaWLxj_-_z8Cli" ></script>

                      <noscript>
                        <iframe src="https://www.google.com/recaptcha/api/noscript?k=6LcUPeoSAAAAAETOO0Xnxx1TcyNaWLxj_-_z8Cli" height="300" width="500" frameborder="0"></iframe><br>
                        <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
                        <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
                      </noscript>
                      </div>
                    </div><br>
                    <div class="control-group">
                      <div class="controls">    
                        <button href="#" type="submit" class="btn btn-primary" id="reset-form-submit"><?php echo $index_submit ?></button>
                      </div>
                    </div>
                  </form>
                </div>
        </div>
</div>


<?
  include('footer.php');
?>