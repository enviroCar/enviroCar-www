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

    <script src="../assets/js/jquery.js"></script>

    <script type="text/javascript">

      //Sending the credentials to the authentification page
      function login(){
        if($('#login_email').val() === ''){
          alert("Invalid Email");
        }
        else if($('#login_password').val() === ''){
          alert('Password cannot be empty');
        }else{
          $.post('../assets/includes/authentification.php?login', {email: $('#login_email').val(), password: $('#login_password').val()}, 
            function(data){
              if(data === 'status:ok'){
                window.location.href = "dashboard.php";
              }
            });
        }
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
      <img src="../assets/img/cario.png" class="brand" style="height: 20px; ">
          <a class="brand" href="index.php">car.io</a>
          <div class="nav-collapse collapse">
            <ul class="nav" style="float:right">
                <li><h4 class="form-signin-heading" style="color:white; padding-top: 5px;margin-right:20px;">Please sign in</h4></li>
                <li style="padding-top: 10px;"><input id="login_email" type="text" class="input-block-level" placeholder="Email address" ></li>
                <li style="padding-top: 10px;"><input id="login_password" type="password" class="input-block-level" placeholder="Password"></li>
                <li><button class="btn btn-medium btn-primary" onclick="login()">Sign in</button> </li>
                <li><button class="btn btn-medium btn-primary"  onclick="window.location.href='registration.php'">Registration</button></li>
            </ul>
          </div><!--/.nav-collapse -->      </div>
      </div>
    </div>