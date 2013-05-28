<?
function echoActiveClassIfRequestMatches($requestUri)
{
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

    if ($current_file_name == $requestUri)
        echo 'class="active"';
}

require_once('assets/includes/language.php');




?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>enviroCar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

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

    <!-- Fav and touch icons -->
    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="./assets/ico/favicon.png" type="image/png" />
    <link rel="icon" href="./assets/ico/favicon.png" type="image/png" />

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
          <img src="./assets/img/Logo_icon.svg" class="brand" style="height: 50px; padding:0; margin:0; padding-right:15px; ">
          <a class="brand" href="index.php">enviroCar</a>
          <?
            if($lang == 'en'){ echo '<img src="./assets/img/deutschland-flagge.jpg" onClick="changeLanguage(\'de\')" class="brand" style="height: 20px; float:right; cursor:hand;cursor:pointer">';
            }else{
              echo '<img src="./assets/img/england-flagge.jpg" onClick="changeLanguage(\'en\')" class="brand" style="height: 20px; float:right; cursor:hand;cursor:pointer">';
            }
          ?>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li <?=echoActiveClassIfRequestMatches("support")?>><a href="support_new.php">Help</a></li>
            </ul>


          </div><!--/.nav-collapse -->      </div>
        </div>
    </div>
 
<?
if(isset($_GET['accessdenied'])){
?>
  <div class="container alert alert-block alert-error fade in"> 
  <a class="close" data-dismiss="alert">×</a>  
  <h4 class="alert-heading">Access denied!</h4>  
   You are currently not logged in!  
  </div> 
<?
}
?>

<?
if(isset($_GET['logout'])){
?>
  <div class="container alert alert-block fade in"> 
  <a class="close" data-dismiss="alert">×</a>  
  <h4 class="alert-heading">Logout!</h4>  
 Successfully logged out... 
</div> 
<?
}
?>

<?
if(isset($_GET['registration_successful'])){
?>
<div id="registration_successful" class="container alert alert-block fade in"> 
  <a class="close" data-dismiss="alert">×</a>  
  <h4 class="alert-heading">Welcome to enviroCar</h4>  
  Your registration was successful. Please login to continue.
</div> 
<?
}
?>

<?
if(isset($_GET['deleted'])){
?>
<div id="deleted" class="container alert alert-block fade in"> 
  <a class="close" data-dismiss="alert">×</a>  
  <h4 class="alert-heading">Account deleted.</h4>  
  Your Account has been successfully deleted.
</div> 
<?
}
?>

<div id="login_fail" class="container alert alert-block alert-error fade in" style="display:none"> 
  <a class="close" data-dismiss="alert">×</a>   
 Username or Password are wrong, or the user does not exist!
</div> 

<div id="registration_fail" class="container alert alert-block alert-error fade in" style="display:none"> 
  <a class="close" data-dismiss="alert">×</a>  
 Registration not successful. This combination of username and email already exists.
</div> 
