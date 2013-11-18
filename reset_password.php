<?
require_once('./assets/includes/authentification.php');
include('header-start.php');
?>



<div class="container rightband">
	<div class="row-fluid">
		<div class="span12">
			<?php echo $captcha_incorrect_alert ?>
			<h3><?php echo $index_reset_password ?><span class="extra-title muted"></span></h3>

		  <form class="form-horizontal" id="reset-form" accept-charset="UTF-8" action="<?php echo basename($_SERVER['SCRIPT_FILENAME']); ?>" data-remote="true" method="post">
		      <div class="control-group">
		          <label for="email" class="control-label">E-Mail</label>
		          <div class="controls">
		              <input id="reset-mail" type="email" name="email" required data-validation-required-message="<?php echo $required_validation_message ?>" aria-invalid="true" data-validation-email-message="<?php echo $email_validation_message ?>">
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


