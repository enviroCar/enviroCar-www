<?
require_once('./assets/includes/authentification.php');

$logged_in = false; 
if(!is_logged_in()){
	$logged_in = false; 
	include('header-start.php');
}else{
	$logged_in = true;
	include('header.php');
}
?>    

  <div class="container rightband">
    <div class="row-fluid">
<? if ($logged_in == false) { ?>
      <div class="span8" style="margin: 0; padding: 0; background-image: url(./assets/img/marketing/envCar_Foto13.jpg); height: 250px; width 100%; background-size: cover;">
      </div>
      <div class="span4">
            <h2 class="form-signin-heading"><? echo $index_Please_sign_in;?></h2>
            <form name="login" action="index.php" method="post" style="display: inline;">
				<input type="hidden" name="login_form_attempt" value="<?echo $login_form_attempt+1;?>">
				<input type="text" 	id="login_name" 	name="login_name" 	class="input-block-level" placeholder="<? echo $index_user_name;?>" value="<?echo $login_name;?>"/>
				<input type="password" 	id="login_password" 	name="login_password" 	class="input-block-level" placeholder="<? echo $index_password;?>" />
				<input type="submit" class="btn btn-medium btn-primary" value="<? echo $index_sign_in;?>" style="float: left"/>
				<!--span title="this places a cookie on your device">
					<input type="checkbox" id="login_remember" name="login_remember" class="input-block-level" style="float: left; margin-left: 2%" />
					<label for="login_remember" style="float: left; margin-left: 2%" > &larr; remember me</label>
				</span-->
            </form>
			<a href="registration.php">
				<button class="btn btn-medium btn-primary" name="login_register" value="register" style="float: right;"><? echo $index_register;?></button>
			</a>
			<div style="clear:both"></div>
	<?
		if ($login_form_attempt >= 5){
	?>
		<? echo $index_having_account;?><br/> <? echo $index_create_new_one;?><br/>
	<?
		}
	?>
    </div>
<? 	} else { ?>
	<div class="span" style="margin: 0; padding: 0; background-image: url(./assets/img/marketing/envCar_Foto13.jpg); height: 250px; width 100%; background-size: cover;">
		<div style="margin-right: 1%; margin-top 60%; float:right; text-align: center">
			<h2 style="color:WhiteSmoke; text-shadow: 0.1em 0.1em 0.1em black; margin-bottom: 0em; padding-bottom: 0em;">
				<? echo  $index_welcome;?>, <span style="color: WhiteSmoke"><?echo $_SESSION["name"];?></span>
			</h2>
			<a href="./assets/includes/authentification?logout" style="color: white; font-size: small">
				<? echo  $index_wrong_name;?>
			</a>
			<br/>
			<a href="dashboard.php">
				<button class="btn btn-medium btn-inversed" name="dashboard" value="dashboard" style="margin-top: 2em"><? echo  $index_continue_dashboard;?></button>
			</a>
		</div>
	 </div>
<? } ?>

    </div>
  </div> <!-- /container -->

	<div class="container leftband">
	<div class="row-fluid">
        <div class="span4">
          <h2><? echo $index_get_App;?></h2>
          <a href="https://play.google.com/store/apps/details?id=enviroCar">
            <img alt="Get it on Google Play" style="margin-left: 50px; margin-top: 10px;"
                 src="https://developer.android.com/images/brand/en_generic_rgb_wo_60.png" />
          </a>
       </div>
        <div class="span4">
          <h2><? echo $index_be_a_citizen_scientist;?></h2>
          <p style="text-align: justify;"><? echo $index_help_the_world;?></p>
        </div>
        <div class="span4">
          <h2><? echo $index_support_indiegogo;?></h2>
          <a href="http://www.indiegogo.com/projects/envirocar" target='_blank'>
            <img style="width:70%;" src="http://www.indiegogo.com/assets/igg_logo_color_print_black_h.jpg"/>
          </a>
        </div>
      </div>

	</div>

	<div class="container rightband">
      <div class="featurette" style="margin-left: 2%">
		<img class="featurette-image pull-right" src="./assets/img/heatmap.PNG" style="width: 50%; padding: 3%" alt=""/>
		<h2 class="featurette-heading"><? echo $envirocar;?> <span class="muted"><? echo $index_make_smarter;?></span></h2>
		<p class="lead" style="text-align: justify">
			<? echo $index_this_is_community;?>
		</p>
      </div>

      <hr class="featurette-divider">

      <div class="featurette" style="margin-right: 2%">
		<img class="featurette-image pull-left" src="./assets/img/architecture.svg"  style="width: 50%; padding: 3%" alt=""/>
		<h2 class="featurette-heading"><? echo $index_how_it_works;?><span class="muted"><? echo ' '.$index_three_steps_to;?></span></h2>
		<p class="lead" style="text-align: justify">
		</p>
      </div>
	</div>
  <?
  include('footer.php');
  ?>
