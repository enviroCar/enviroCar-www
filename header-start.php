<?
require_once('assets/includes/commons.php');

$current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

//get the requested website, from request string
$login_referer = (isset($_GET["fwdref"])) ? $_GET["fwdref"] : "dashboard.php";
//overwrite if fwd_ref wad posted
$login_referer = (isset($_POST["fwdref"])) ? $_POST["fwdref"] : $login_referer;

$login_form_attempt = (isset($_POST["login_form_attempt"])) ? $_POST["login_form_attempt"] : 0;
$login_name = (isset($_POST["login_name"])) ? $_POST["login_name"] : "";
$login_password = (isset($_POST["login_password"])) ? $_POST["login_password"] : "";

$login_fail = false;
//Login Mechanism based on http Post and authentication PHP, instead of the java-script thing
if ($login_name != "" && $login_password != ""){
	
	require_once('./assets/includes/authentification.php');

	if (login($login_name, $login_password, true)){
		//successfully logged in
		header('Location: '.$login_referer);
	}else{
		if (isset($_SESSION)) session_destroy();
		$login_fail = true;
	}
}

?>


          

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>enviroCar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="root" >

    <!-- Le styles -->
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
    <link href="./assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="./assets/css/custom.css" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
    <link href="./assets/css/flags.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="./assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Favicons -->
    <link rel="shortcut icon" href="./assets/ico/favicon.ico" type="image/vnd.microsoft.icon" />
    <link rel="icon" href="./assets/ico/favicon.png" type="image/png" />

    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/bootstrap-tooltip.js"></script>
    <script src="./assets/js/jqBootstrapValidation.js"></script>
    
    <?php
      $captcha_incorrect_alert="";

      if(isset($_POST['recaptcha_challenge_field'])) {
        require_once('assets/includes/recaptchalib.php');
        $privatekey = "6LcUPeoSAAAAAPLBog_XkUhyMVZ3n0-AD1ercddQ";
        $resp = recaptcha_check_answer ($privatekey,
                                      $_SERVER["REMOTE_ADDR"],
                                      $_POST["recaptcha_challenge_field"],
                                      $_POST["recaptcha_response_field"]);

        if (!$resp->is_valid) {
          // What happens when the CAPTCHA was entered incorrectly
          $captcha_incorrect_alert='<div class="alert alert-block alert-error fade in">CAPTCHA '.$index_captcha_incorrect_try_again.'</div>';
          echo '<script>$( document ).ready(function() { $("#lost_password_modal").modal("show");});</script>';
        } else {
          header('Location: mailto:envirocar@52north.org?subject=Reset%20Password');
        }
      }
    ?>

    <?php 
      $current_file_name = basename($_SERVER['SCRIPT_FILENAME'], ".php");
      $jsfile = "./assets/js/$current_file_name.js";

      if (file_exists($jsfile)) {
          echo "<script src='$jsfile'></script>";
      }
    ?><br>
    
    <?php 
      $current_file_name = basename($_SERVER['SCRIPT_FILENAME'], ".php");
      $cssfile = "./assets/css/$current_file_name.css";

      if (file_exists($cssfile)) {
          echo "<link href='$cssfile' rel='stylesheet' type='text/css'>";
      }
    ?>

    <script type="text/javascript">

      var RecaptchaOptions = {
        custom_translations : {
                      instructions_visual : "<?php echo $index_captcha_instructions_visual ?>",
                      instructions_audio : "<?php echo $index_captcha_instructions_audio ?>",
                      play_again : "<?php echo $index_captcha_play_again ?>",
                      cant_hear_this : "<?php echo $index_captcha_cant_hear_this ?>",
                      visual_challenge : "<?php echo $index_captcha_visual_challenge ?>",
                      audio_challenge : "<?php echo $index_captcha_audio_challenge ?>",
                      refresh_btn : "<?php echo $index_captcha_refresh_btn ?>",
                      help_btn : "<?php echo $index_captcha_help_btn ?>",
                      incorrect_try_again : "<?php echo $index_captcha_incorrect_try_again ?>",
              },
        theme : 'white'
      };

      //enable form validation
      $(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );

      //Used slide down/up to toggle the visibility of a given element
      function toggle_visibility(id) {
        if ($('#'+id).is(":hidden")) {
          $('#'+id).slideDown("fast");
        } else {
          $('#'+id).slideUp("fast");
        }
      }
      
      function error_msg(msg){
        if ($('#error_div').is(":hidden")) {
          $('#error_div').append(msg);
          toggle_visibility("error_div");
        }
      }

      function changeLanguage(lang){
        $.get('assets/includes/language.php?lang='+lang, function(data) {
          window.location.reload();
        });

      }

      
      

    </script>
    <style>
      @media (min-width: 980px) {
      body {
              margin-top: -40px;
              padding-top: 40px;
              padding-bottom: 42px;
            }
          }

      @media (max-width: 980px) {
      body {
              margin-top: -40px;
              padding-top: 0px;
              padding-bottom: 42px;
            }
          }

      /* firefox specific */
      @-moz-document url-prefix() {

          @media (max-width: 980px) {
            body {
              margin-top: -20px;
              padding-bottom: 42px;
            }
        }

        @media (min-width: 980px) {
            body {
              margin-top: -20px;
              padding-bottom: 42px;
            }
        }

      }


    </style>

  </head>

  <body>
    <div class="modal hide fade" id="lost_password_modal">
      <div class="modal-header">
          <?php echo $captcha_incorrect_alert ?>
          <h3><?php echo $index_reset_password ?><span class="extra-title muted"></span></h3>
      </div>
      <form class="modal-body form-horizontal" id="reset-form" accept-charset="UTF-8" action="<?php echo basename($_SERVER['SCRIPT_FILENAME']); ?>" data-remote="true" method="post">
          <div class="control-group">
              <label for="email" class="control-label">E-Mail</label>
              <div class="controls">
                  <input id="reset-mail" type="email" name="email" required data-validation-required-message="<?php echo $required_validation_message ?>" aria-invalid="true" data-validation-email-message="<?php echo $email_validation_message ?>">
              </div>
          </div>

            <label for="recaptcha" class="control-label"><?php echo $index_recaptcha ?></label>
            <div class="controls">
              <script type="text/javascript" src="https://www.google.com/recaptcha/api/challenge?k=6LcUPeoSAAAAAETOO0Xnxx1TcyNaWLxj_-_z8Cli"></script>
              <noscript>
                <iframe src="https://www.google.com/recaptcha/api/noscript?k=6LcUPeoSAAAAAETOO0Xnxx1TcyNaWLxj_-_z8Cli" height="300" width="500" frameborder="0"></iframe><br>
                <textarea name="recaptcha_challenge_field" rows="3" cols="40">
                </textarea>
                <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
              </noscript>
            </div><br>
          <div class="control-group">
            <div class="controls">    
              <button href="#" type="submit" class="btn btn-primary" id="reset-form-submit"><?php echo $index_submit ?></button>
            </div>
          </div>
      </form>
    </div>
    
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <div class="container">
          <a  class="brand" href="index.php" >
            <img style="height:25px;" src="./assets/img/enviroCar_logo_white_13-06-08_165x50.png" />
          </a>
          
          <div class="nav-collapse collapse">
            <ul id="main-nav" class="nav pull-right droid-text">
              <li <?=echoActiveClassIfRequestMatches("about")?>><a href="about.php"><? echo $about ?></a></li>
              <li <?=echoActiveClassIfRequestMatches("mapsandstatistics")?>><a href="mapsandstatistics.php"><? echo $mapsandstatistics ?></a></li>
              <li <?=echoActiveClassIfRequestMatches("dataaccess")?>><a href="dataaccess.php"><? echo $data ?></a></li>
              <?php if(!is_logged_in()){ ?>
                <li><a href="./registration.php"><? echo $index_register;?></a></li>
                <li class="dropdown">
                <a class="dropdown-toggle sign_in" href="#" data-toggle="dropdown"><? echo $index_sign_in;?> <strong class="caret"></strong></a>
                <div class="dropdown-menu" id="sign-in-menu" style="padding: 15px;">
                  <form name="login" action="index.php" method="post" style="display: inline;">
                    <input type="hidden" name="login_form_attempt" value="<?echo $login_form_attempt+1;?>">
                    <input type="hidden" name="fwdref" value="<?echo $login_referer;?>">
                    <input type="text"  id="login_name"   name="login_name"   class="input-block-level" placeholder="<? echo $index_user_name;?>" value="<?echo $login_name;?>"/>
                    <input type="password"  id="login_password"   name="login_password"   class="input-block-level" placeholder="<? echo $index_password;?>" />
                    <input type="submit" class="btn btn-medium btn-primary" value="<? echo $index_sign_in;?>" style="float: left; width: 100%;"/>
                  </form>
                  <a href="#" class="link" data-target="#lost_password_modal" data-toggle="modal"><?php echo $index_lost_password ?></a>
                </div>
                </li>
              <?php }else{ ?>
                <li class="dropdown-toggle sign_in" hidefocus="hidefocus">
                  <a class="dropdown-toggle" data-target="#" data-toggle="dropdown" href="/users/martin/dashboard" hidefocus="hidefocus">
                    <?php echo $signedin; ?>: <?php echo $_SESSION["name"];?> 
                    <strong class="caret"></strong>
                  </a>
                  <ul id="session-menu" class="dropdown-menu">
                    <li><a href="editprofile.php?user=<?echo $_SESSION['name']?> "><? echo $changeprofile ?> </a></li>
                    <li><a href="dashboard.php"><? echo $dashboard ?></a></li>
                    <li class="divider"></li>
                    <li><a href="./assets/includes/authentification.php?logout"><? echo $logout ?></a></li>
                  </ul>
                </li>
              <?php } ?>
            </ul>
          </div> 
      </div>
    </div>
  </div> <!-- Navbar -->
    
 <div id="error_div" class="container alert alert-block alert-error fade in" style="display:none"> 
      <a class="close" data-dismiss="alert">×</a>  
      <h4 class="alert-heading">Error</h4>  
 </div>
 
<?
if(isset($_GET['accessdenied'])){
?>
  <div class="container alert alert-block alert-error fade in"> 
  <a class="close" data-dismiss="alert">×</a>  
  <h4 class="alert-heading"><? echo $index_cont3; ?></h4>  
  <? echo $currentlynotloggedin; ?>
  </div> 
<?
}
?>

<?
if(isset($_GET['lo'])){
?>
  <div class="container alert alert-block alert-info fade in"> 
  <a class="close" data-dismiss="alert">×</a>  
  <? echo $logoutsuccess; ?>
</div> 
<?
}
?>

<?
if(isset($_GET['registration_successful'])){
?>
<div id="registration_successful" class="container alert alert-block alert-success fade in"> 
  <a class="close" data-dismiss="alert">×</a>  
  <h4 class="alert-heading"><?echo $welcometoec;?></h4>  
  <? echo $regsuccessfull.' '.$logincontinue ?>
</div> 
<?
}
?>

<?
if(isset($_GET['deleted'])){
?>
<div id="deleted" class="container alert alert-block alert-info fade in"> 
  <a class="close" data-dismiss="alert">×</a>  
  <h4 class="alert-heading"><?echo $accountdeleted?></h4>  
  <?echo $accountdeletedsuccess?>
</div> 
<?
}
?>

<?         
if ($login_form_attempt>=1){

  if ($login_name != "" &&  $login_password == ""){
	?>
	<div class="container alert alert-block alert-error fade in">
		<a class="close" data-dismiss="alert">×</a>  
		<h4 class="alert-heading"><? echo $index_cont3;?></h4>
		<? echo $index_cont20;?>
	</div>
	<?
  }
  
  if ($login_name == "" && $login_password != ""){
	?>
	<div class="container alert alert-block alert-error fade in">
		<a class="close" data-dismiss="alert">×</a>
		<h4 class="alert-heading"><? echo $index_cont3;?></h4>
		<? echo $index_cont21;?>
	</div>
	<?
  }
  
  if ($login_name == "" && $login_password == ""){
	?>
	<div class="container alert alert-block alert-error fade in">
		<a class="close" data-dismiss="alert">×</a>  
		<h4 class="alert-heading"><? echo $index_cont3;?></h4>
		<? echo $index_cont22;?>
	</div>
	<?
  }
}
?>

<div id="login_fail" class="container alert alert-block alert-error fade in" style="display:none"> 
  <a class="close" data-dismiss="alert">×</a>   
	<? echo $usernameorpasswordwrong ?>
  <a href="#" class="link" data-target="#lost_password_modal" data-toggle="modal"><?php echo $index_lost_password ?></a>
	<div style="clear:both"></div>
	<?
		if ($login_form_attempt >= 5){
	?>
		<? echo $index_having_account;?><br/> <? echo $index_create_new_one;?><br/>
	<?
		}
	?>
</div> 

<div id="registration_fail" class="container alert alert-block alert-error fade in" style="display:none"> 
  <a class="close" data-dismiss="alert">×</a>  
 <? echo $registrationunsuccessfull.' '.$existingusername?>
</div> 

<?
if ($login_fail) {
?>
<div id="login_fail" class="container alert alert-block alert-error fade in"> 
  <a class="close" data-dismiss="alert">×</a>   
 <? echo $usernameorpasswordwrong ?><br>
 <a href="#" class="link" data-target="#lost_password_modal" data-toggle="modal"><?php echo $index_lost_password ?></a>
	<div style="clear:both"></div>
	<?
		if ($login_form_attempt >= 5){
	?>
		<? echo $index_having_account;?><br/> <? echo $index_create_new_one;?><br/>
	<?
		}
	?>
</div> 
<?
}
?>
