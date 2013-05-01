<?
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
    <title>car.io</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/css/custom.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">

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
		  <img src="../assets/img/cario.png" class="brand" style="height: 20px; ">
		  <img src="../assets/img/settings.png" class="brand" style="height: 20px; float:right;">
          <a class="brand" href="#">car.io</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li <?=echoActiveClassIfRequestMatches("dashboard")?>><a href="#">Home</a></li>
              <li <?=echoActiveClassIfRequestMatches("route")?>><a href="route.php">Route Information</a></li>
              <li <?=echoActiveClassIfRequestMatches("friends")?>><a href="friends.php">Friends</a></li>
              <li <?=echoActiveClassIfRequestMatches("groups")?>><a href="groups.php">Groups</a></li>
              <li <?=echoActiveClassIfRequestMatches("dataaccess")?>><a href="dataaccess.php">Data Access</a></li>
              <li <?=echoActiveClassIfRequestMatches("help")?>><a href="help.php">Help</a></li>
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">Route Information</a></li>
              <li><a href="#contact">Friends</a></li>
              <li><a href="#contact">Groups</a></li>
              <li><a href="#contact">Data Access</a></li>
              <li><a href="#contact">Help</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>