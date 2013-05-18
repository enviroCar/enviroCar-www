<?
include('header-start.php');
?>
    
    <script type="text/javascript">
      //Sending the credentials to the authentification page
      function login(ln, lp){
        if(ln === ''){
          alert("Invalid Login Name");
        }
        else if(lp === ''){
          alert('Password cannot be empty');
        }else{
          $.post('./assets/includes/authentification.php?login', {name: ln, password: lp}, 
            function(data){
              if(data === 'status:ok'){
                window.location.href = "dashboard.php";
              }else{
                toggle_visibility("login_fail");
              }
            });
        }
      }
    </script>
	    <?         
	    $login_form_attempt = (isset($_POST["login_form_attempt"])) ? $_POST["login_form_attempt"] : 0;
	    $login_name = (isset($_POST["login_name"])) ? $_POST["login_name"] : "";
	    $login_password = (isset($_POST["login_password"])) ? $_POST["login_password"] : "";
	    
	    if ($login_form_attempt>=1){
	    
	      if ($login_name != "" &&  $login_password == ""){
		echo "<div class=\"container alert alert-block alert-error fade in\"><a class=\"close\" data-dismiss=\"alert\">×</a>  
  <h4 class=\"alert-heading\">Access denied!</h4>sorry, but you can't have an empty password.</div>";
	      }
	      
	      if ($login_name == "" && $login_password != ""){
		echo "<div class=\"container alert alert-block alert-error fade in\"><a class=\"close\" data-dismiss=\"alert\">×</a>  
  <h4 class=\"alert-heading\">Access denied!</h4>everybody should have a name, even you.</div>";
	      }
	      
	      if ($login_name == "" && $login_password == ""){
		echo "<div class=\"container alert alert-block alert-error fade in\"><a class=\"close\" data-dismiss=\"alert\">×</a>  
  <h4 class=\"alert-heading\">Access denied!</h4>nice try, but empty credentials are invalid.</div>";
	      }
	      
	      if ($login_name != "" && $login_password != ""){
		echo "<script type=\"text/javascript\">login(\"". $login_name . "\",\"" . $login_password ."\");</script>";
	      }
	    }
	   ?>
  <div class="container leftband">
    <div class="row-fluid">
      <div class="span5 offset1">
        <p><img style="width:40%" src="./assets/img/play.svg"/></p>
        <h2>Watch our video </h2>
      </div>
      <div class="span5">
            <h2 class="form-signin-heading">Please sign in</h2>
            
            <p>
            <form name="login" action="" method="post" style="display: inline;">
	      <input type="hidden" name="login_form_attempt" value="<?echo $login_form_attempt+1;?>">
	      <input type="text" 	id="login_name" 	name="login_name" 	class="input-block-level" placeholder="User name" value="<?echo $login_name;?>"/>
	      <input type="password" 	id="login_password" 	name="login_password" 	class="input-block-level" placeholder="Password" />
	      <input type="submit" 	class="btn btn-large btn-primary" value="Sign in" style="float: left"/>
            </form>
	    <a href="registration.php">
	      <button class="btn btn-large btn-primary" name="login_register" value="register" style="float: right;">Register</button>
	    </a>
	    <div style="clear:both"></div>
	    </p>
            
	      <? if ($login_form_attempt >= 5){
		 echo "Are you sure, of having an account?<br/> You can create a new one. It's free!<br/>";
		}
	      ?>
      </div>
    
    </div>
  </div> <!-- /container -->

	<div class="container rightband">
	<div class="row-fluid">
        <div class="span4">
          <h2>Get our App!</h2>
          <a href="https://play.google.com/store/apps/details?id=enviroCar">
            <img alt="Get it on Google Play" style="margin-left: 50px; margin-top: 10px;"
                 src="https://developer.android.com/images/brand/en_generic_rgb_wo_60.png" />
          </a>
       </div>
        <div class="span4">
          <h2>Be a Citizen Scientist!</h2>
          <p>Help the world become a better place by sharing your data with scientists from all over the world! Or use existing data for your own research!</p>
        </div>
        <div class="span4">
          <h2>Support us on Indiegogo</h2>
          <a href="">
            <img style="width:70%;" src="http://www.pcgameshardware.de/screenshots/811x455/2012/12/igg_logo_color_print_black_h.jpg"/>
          </a>
        </div>
      </div>

	</div>

	<div class="container leftband">
      <!-- START THE FEATURETTES -->


      <div class="featurette">
        <img class="featurette-image pull-right" src="./assets/img/heatmap.PNG" style="margin-top:-80px;">
        <h2 class="featurette-heading">enviroCar <span class="muted">Make our cities smarter!</span></h2>
        <p class="lead">This is a community, it's an app and it's a website.<br> enviroCar is our contribution to a smarter world.<br> We will generate knowledge about car traffic and its emissions on our streets and we will raise awareness of environmental consequences of our driving behaviour.</p>
      </div>

      <hr class="featurette-divider">

      <div class="featurette">
        <img class="featurette-image pull-left" style="height:50%" src="./assets/img/paper_architecture.png">
        <h2 class="featurette-heading">How does it work? <span class="muted">Three steps to become a citizen scientist</span></h2>
        <p class="lead">
          <ul>
            <li>Connect your OBD2 adapter to your car</li>
            <li>Download the enviroCar App</li>
            <li>Drive & Share</li>
          </ul>
        </p>
      </div>


	</div>

  <?
  include('footer.php');
  ?>