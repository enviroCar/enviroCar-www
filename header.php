<?
require_once('./assets/includes/authentification.php');
require_once('./assets/includes/language.php');

if(!is_logged_in()){
 header('Location: index.php?accessdenied&fwdref='.$_SERVER['REQUEST_URI']);
}

function echoActiveClassIfRequestMatches($requestUri)
{
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

    if ($current_file_name == $requestUri)
        echo 'class="active"';
}
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
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="./assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="./assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="./assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="./assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="./assets/ico/favicon.png">
    
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
      <?
        if($lang == 'en'){ echo '<img src="./assets/img/deutschland-flagge.jpg" onClick="changeLanguage(\'de\')" class="brand" style="height: 20px; float:right;">';
        }else{
          echo '<img src="./assets/img/england-flagge.jpg" onClick="changeLanguage(\'en\')" class="brand" style="height: 20px; float:right;">';
        }
      ?>
		  <img src="./assets/img/settings.png" onClick="toggle_visibility('settings');" class="brand" style="height: 20px; float:right;">
          <a class="brand" href="dashboard.php"><b>enviroCar</b></a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li <?=echoActiveClassIfRequestMatches("dashboard")?>><a href="dashboard.php">Activities</a></li>
              <li <?=echoActiveClassIfRequestMatches("routes")?>><a href="routes.php">Routes</a></li>
              <li <?=echoActiveClassIfRequestMatches("friends")?>><a href="friends.php">Friends</a></li>
              <li <?=echoActiveClassIfRequestMatches("groups")?>><a href="groups.php">Groups</a></li>
             <!-- <li <?=echoActiveClassIfRequestMatches("dataaccess")?>><a href="dataaccess.php">Data Access</a></li> -->
              <li <?=echoActiveClassIfRequestMatches("help")?>><a href="http://giv-cario.uni-muenster.de/working-folder/support">Help</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <div id="settings" class="settings">
      <h4><a style="padding-left:15px;" href="profile.php?user=<?echo $_SESSION['name']?> ">Profile</a></h4><br>
      <h4><a style="padding-left:15px;" href="./assets/includes/authentification?logout">Logout</a></h4>
    </div>
