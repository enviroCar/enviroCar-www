<?
require_once('./assets/includes/authentification.php');
require_once('./assets/includes/language.php');

// If you try to open a page, but are not logged in, you will be forwarded to the index.php.
// a forwarding referer will be added to the request string, enabling a redirection to the target you requested after logging in.
if(!is_logged_in()){
 header('Location: index.php?accessdenied&fwdref='.$_SERVER['REQUEST_URI']);
}

//Kick the user to the page which was requested BEFORE authorization and access was denied
if(isset($_POST["fwdref"])){
 header('Location: '.$_POST["fwdref"]);
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
    <meta name="author" content="root" >

    <!-- Le styles -->
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
    <link href="./assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="./assets/css/custom.css" rel="stylesheet">
    <link href="./assets/css/flags.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>

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
    <script src="./assets/js/bootstrap-paginator.min.js"></script>
    <script src="./assets/js/share.min.js"></script>
    
    <?php 
      $current_file_name = basename($_SERVER['SCRIPT_FILENAME'], ".php");
      $jsfile = "./assets/js/$current_file_name.js";

      if (file_exists($jsfile)) {
          echo "<script type='text/javascript' src='$jsfile'></script>";
      }
    ?>
    
    <?php 
      $current_file_name = basename($_SERVER['SCRIPT_FILENAME'], ".php");
      $cssfile = "./assets/css/$current_file_name.css";

      if (file_exists($cssfile)) {
          echo "<link href='$cssfile' rel='stylesheet' type='text/css' />";
      }
    ?>
    
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

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse" style="position: relative;">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <div class="container">
          <a  class="brand" href="index.php" >
            <img style="height:25px;" src="./assets/img/enviroCar_logo_white_13-06-08_165x50.png" alt="enviroCar Logo"/>
          </a>
          
          <div class="nav-collapse collapse">
            <ul id="main-nav" class="nav pull-right droid-text">
              <li <?=echoActiveClassIfRequestMatches("about")?>><a href="about.php"><? echo $about ?></a></li>
              <li <?=echoActiveClassIfRequestMatches("dashboard")?>><a href="dashboard.php"><? echo $dashboard ?></a></li>
              <li <?=echoActiveClassIfRequestMatches("mapsandstatistics")?>><a href="mapsandstatistics.php"><? echo $mapsandstatistics ?></a></li>
              <li <?=echoActiveClassIfRequestMatches("dataaccess")?>><a href="dataaccess.php"><? echo $data ?></a></li>
              <?php if(!is_logged_in()){ ?>
                <li><a href="./registration.php"><? echo $index_register;?></a></li>
                <li class="dropdown">
                <a class="dropdown-toggle sign_in" href="#" data-toggle="dropdown"><? echo $index_sign_in;?> <strong class="caret"></strong></a>
                <div class="dropdown-menu" style="padding: 15px;">
                 <h4 class="form-signin-heading"><? echo $index_Please_sign_in;?></h4>
                  <form name="login" action="index.php" method="post" style="display: inline;">
                    <input type="hidden" name="login_form_attempt" value="<?echo $login_form_attempt+1;?>">
                    <input type="hidden" name="fwdref" value="<?echo $login_referer;?>">
                    <input type="text"  id="login_name"   name="login_name"   class="input-block-level" placeholder="<? echo $index_user_name;?>" value="<?echo $login_name;?>"/>
                    <input type="password"  id="login_password"   name="login_password"   class="input-block-level" placeholder="<? echo $index_password;?>" />
                    <input type="submit" class="btn btn-medium btn-primary" value="<? echo $index_sign_in;?>" style="float: left"/>
                  </form>
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

<!--    <div id="settings" class="settings">
      <h4><a style="padding-left:15px;" href="profile.php?user=<?echo $_SESSION['name']?> "><? echo $profile ?> </a></h4><br>
      <h4><a style="padding-left:15px;" href="./assets/includes/authentification?logout"><? echo $logout ?></a></h4>
    </div>-->

    <div id="error_div" class="container alert alert-block alert-error fade in" style="display:none"> 
      <a class="close" data-dismiss="alert">×</a>  
      <h4 class="alert-heading">Error</h4>  
    </div> 

<?
if(isset($_GET['lost_password_access_denied'])){
?>
  <div class="container alert alert-block alert-error fade in"> 
  <a class="close" data-dismiss="alert">×</a> 
  <? echo $index_lost_password_access_denied; ?>
  </div> 
<?
}
?>