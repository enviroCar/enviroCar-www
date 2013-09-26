<?
require_once('assets/includes/commons.php');

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
    <link href="./assets/css/custom.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="./assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="./assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Favicons -->
    <link rel="shortcut icon" href="./assets/ico/favicon.png" type="image/png" />
    <link rel="icon" href="./assets/ico/favicon.ico" type="image/png" />

    <script src="./assets/js/jquery.js"></script>

    <script type="text/javascript">

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
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top customNav">
      <div class="customNav">
        <div class="customNav">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="index.php" style="padding:0px;">
          <img src="./assets/img/enviroCar_logo_white_beta.png" class="brand" style="height: 50px; padding:0; margin:0; padding-right:15px;" alt="" />
          </a>
          <?
            if($lang == 'en'){ echo '<img src="./assets/img/deutschland-flagge.jpg" onClick="changeLanguage(\'de\')" class="brand" style="height: 20px; width: 35px; float:right; cursor:hand;cursor:pointer" alt="">';
            }else{
              echo '<img src="./assets/img/england-flagge.jpg" onClick="changeLanguage(\'en\')" class="brand" style="height: 20px; width: 35px; float:right; cursor:hand;cursor:pointer" alt="">';
            }
          ?>
          <div class="nav-collapse collapse">
            <ul class="nav">
            <li <?=echoActiveClassIfRequestMatches("about")?>><a href="about.php"><? echo $about ?></a></li>
              <li <?=echoActiveClassIfRequestMatches("mapsandstatistics")?>><a href="mapsandstatistics.php"><? echo $mapsandstatistics ?></a></li>
              <li <?=echoActiveClassIfRequestMatches("dataaccess")?>><a href="dataaccess.php"><? echo $data ?></a></li>
            </ul>
				<!-- The drop down menu -->
        		<ul class="nav pull-right">
              <li><img src="./assets/img/under_construction.png" alt="under_construction" style="height:50px" title="<?echo $under_construction;?>"/></li>
          		<li><a href="./registration.php"><? echo $index_register;?></a></li>
          		<!--<li class="divider-vertical"></li>-->
          		<li class="dropdown">
            	<a class="dropdown-toggle" href="#" data-toggle="dropdown"><? echo $index_sign_in;?> <strong class="caret"></strong></a>
            	<div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
               <h4 class="form-signin-heading"><? echo $index_Please_sign_in;?></h4>
            		<form name="login" action="index.php" method="post" style="display: inline;">
						<input type="hidden" name="login_form_attempt" value="<?echo $login_form_attempt+1;?>">
						<input type="hidden" name="fwdref" value="<?echo $login_referer;?>">
						<input type="text" 	id="login_name" 	name="login_name" 	class="input-block-level" placeholder="<? echo $index_user_name;?>" value="<?echo $login_name;?>"/>
						<input type="password" 	id="login_password" 	name="login_password" 	class="input-block-level" placeholder="<? echo $index_password;?>" />
						<input type="submit" class="btn btn-medium btn-primary" value="<? echo $index_sign_in;?>" style="float: left"/>
						<!--span title="this places a cookie on your device">
							<input type="checkbox" id="login_remember" name="login_remember" class="input-block-level" style="float: left; margin-left: 2%" />
							<label for="login_remember" style="float: left; margin-left: 2%" > &larr; remember me</label>
						</span-->
           			</form>
            	</div>
          		</li>
       	 	</ul>

          </div><!--/.nav-collapse -->      </div>
        </div>
    </div>
    
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
  <div class="container alert alert-block fade in"> 
  <a class="close" data-dismiss="alert">×</a>  
  <h4 class="alert-heading"><? echo $logout; ?></h4>  
 <? echo $logoutsuccess; ?>
</div> 
<?
}
?>

<?
if(isset($_GET['registration_successful'])){
?>
<div id="registration_successful" class="container alert alert-block fade in"> 
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
<div id="deleted" class="container alert alert-block fade in"> 
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
 <? echo $usernameorpasswordwrong ?>
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
