<?php
include('header-start.php');
?>
    
    <script type="text/javascript">
      //Sending the credentials to the authentification page
      function login(ln, lp){
        if(ln === ''){
          alert(<?php echo $index_cont1 ?>);
        }
        else if(lp === ''){
          alert(<?php echo $index_cont2 ?>);
        }else{
          $.post('./assets/includes/authentification.php?login', {name: ln, password: lp}, 
            function(data){
              if(data === 'status:ok'){
                window.location.href = "routes.php";
              }else{
                toggle_visibility("login_fail");
              }
            });
        }
      }
    </script>
	    <?php         
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
  <div class="container rightband">
    <div class="row-fluid">
        <div class="span8" style="margin: 0; padding: 0; background-image: url(./assets/img/marketing/envCar_Foto13.jpg); height: 250px; width 100%; background-size: cover;">
        </div>
      <div class="span4">
            <h2 class="form-signin-heading"><?php echo $index_cont6 ?></h2>
            
            <p>
            <form name="login" action="" method="post" style="display: inline;">
	      <input type="hidden" name="login_form_attempt" value="<?echo $login_form_attempt+1;?>">
	      <input type="text" 	id="login_name" 	name="login_name" 	class="input-block-level" placeholder="<?php echo $index_cont18 ?>" value="<?php echo $login_name;?>"/>
	      <input type="password" 	id="login_password" 	name="login_password" 	class="input-block-level" placeholder="<?php echo $index_cont5 ?>" />
	      <input type="submit" 	class="btn btn-medium btn-primary" value="<?php echo $index_cont17 ?>" style="float: left"/>
             <span title="this places a cookie on your device">
	      <input type="checkbox" id="login_remember" name="login_remember" class="input-block-level" style="float: left; margin-left: 2%" />
	      <label for="login_remember" style="float: left; margin-left: 2%" > &larr; remember me</label>
	      </span>
			</form>
	    <a href="registration.php">
	      <button class="btn btn-medium btn-primary" name="login_register" value="<?php echo $index_cont16 ?>" style="float: right;"><?php echo $index_cont7 ?></button>
	    </a>
	    <div style="clear:both"></div>
	    </p>
            
	      <?php if ($login_form_attempt >= 5){
		 echo "Are you sure, of having an account?<br/> You can create a new one. It's free!<br/>";
		}
	      ?>
      </div>
    </div>
  </div> <!-- /container -->

	<div class="container leftband">
	<div class="row-fluid">
        <div class="span4">
          <h2><?php echo $index_cont8 ?><h2>
          <a href="https://play.google.com/store/apps/details?id=enviroCar">
            <img alt="<?php echo $index_cont9 ?>" style="margin-left: 50px; margin-top: 10px;"
                 src="https://developer.android.com/images/brand/en_generic_rgb_wo_60.png" />
          </a>
       </div>
        <div class="span4">
          <h2><?php echo $index_cont10 ?></h2>
          <p><?php echo $index_cont11 ?></p>
        </div>
        <div class="span4">
          <h2><?php echo $index_cont12 ?></h2>
          <a href="http://www.indiegogo.com/projects/envirocar" target='_blank'>
            <img style="width:70%;" src="http://www.pcgameshardware.de/screenshots/811x455/2012/12/igg_logo_color_print_black_h.jpg"/>
          </a>
        </div>
      </div>

	</div>

	<div class="container rightband">
      <!-- START THE FEATURETTES -->


      <div class="featurette" style="margin-left: 20px;">
        <img class="featurette-image pull-right" src="./assets/img/heatmap.PNG" style="margin-top:-80px; height: 50%">
        <h2 class="featurette-heading">enviroCar <span class="muted"></span></h2>
        <p class="lead"><?php echo $index_cont13 ?></p>
      </div>

      <hr class="featurette-divider">

      <div class="featurette" style="margin-left: 20px;">
        <img class="featurette-image pull-left" style="height:50%" src="./assets/img/architecture_new3.svg">
        <h2 class="featurette-heading"><?php echo $index_cont14 ?> <span class="muted"><?php echo $index_cont15 ?></span></h2>
        <p class="lead">
        </p>
      </div>
      <hr class="featurette-divider">


	</div>

  <?php
  include('footer.php');
  ?>