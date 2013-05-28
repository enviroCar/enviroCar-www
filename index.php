<?
require_once('./assets/includes/authentification.php');
if(!is_logged_in()){
	include('header-start.php');
}else{
	include('header.php');
}
$login_referer = (isset($_GET["fwdref"])) ? $_GET["fwdref"] : "dashboard.php";
?>
    
    <script type="text/javascript">
      //Sending the credentials to the authentification page
      function login(ln, lp){
        if(ln === ''){
          alert("<? echo $index_cont1;?>");
        }
        else if(lp === ''){
          alert('<? echo $index_cont2;?>');
        }else{
          $.post('./assets/includes/authentification.php?login', {name: ln, password: lp}, 
            function(data){
              if(data === 'status:ok'){
                window.location.href = "<? echo $login_referer;?>";
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
	      
	      if ($login_name != "" && $login_password != ""){
			?>
			<script type="text/javascript">login("<? echo $login_name;?>","<?echo $login_password;?>");</script>
			<?
	      }
	    }
	   ?>


  <div class="container rightband">
    <div class="row-fluid">
<? if (!is_logged_in()) { ?>
      <div class="span8" style="margin: 0; padding: 0; background-image: url(./assets/img/marketing/envCar_Foto13.jpg); height: 250px; width 100%; background-size: cover;">
      </div>
      <div class="span4">
            <h2 class="form-signin-heading"><? echo $index_cont4;?></h2>
            <p>
            <form name="login" action="" method="post" style="display: inline;">
				<input type="hidden" name="login_form_attempt" value="<?echo $login_form_attempt+1;?>">
				<input type="text" 	id="login_name" 	name="login_name" 	class="input-block-level" placeholder="<? echo $index_cont18;?>" value="<?echo $login_name;?>"/>
				<input type="password" 	id="login_password" 	name="login_password" 	class="input-block-level" placeholder="<? echo $index_cont5;?>" />
				<input type="submit" class="btn btn-medium btn-primary" value="<? echo $index_cont17;?>" style="float: left"/>
				<!--span title="this places a cookie on your device">
					<input type="checkbox" id="login_remember" name="login_remember" class="input-block-level" style="float: left; margin-left: 2%" />
					<label for="login_remember" style="float: left; margin-left: 2%" > &larr; remember me</label>
				</span-->
            </form>
			<a href="registration.php">
				<button class="btn btn-medium btn-primary" name="login_register" value="register" style="float: right;"><? echo $index_cont16;?></button>
			</a>
			<div style="clear:both"></div>
	    </p>
	<?
		if ($login_form_attempt >= 5){
	?>
		<? echo $index_cont23;?><br/> <? echo $index_cont24;?><br/>"
	<?
		}
	?>
    </div>
<? 	} else { ?>
	<div class="span" style="margin: 0; padding: 0; background-image: url(./assets/img/marketing/envCar_Foto13.jpg); height: 250px; width 100%; background-size: cover;">
		<div style="margin-right: 1%; margin-top 60%; float:right; text-align: center">
			<h2 style="color:WhiteSmoke; text-shadow: 0.1em 0.1em 0.1em black; margin-bottom: 0em; padding-bottom: 0em;">
				<? echo  $index_cont27;?>, <span style="color: WhiteSmoke"><?echo $_SESSION["name"];?></span>
			</h2>
			<a href="./assets/includes/authentification?logout" style="color: white; font-size: small">
				<? echo  $index_cont25;?>
			</a>
			<br/>
			<a href="dashboard.php">
				<button class="btn btn-medium btn-inversed" name="dashboard" value="dashboard" style="margin-top: 2em"><? echo  $index_cont26;?></button>
			</a>
		</div>
	 </div>
<? } ?>

    </div>
  </div> <!-- /container -->

	<div class="container leftband">
	<div class="row-fluid">
        <div class="span4">
          <h2><? echo $index_cont8;?></h2>
          <a href="https://play.google.com/store/apps/details?id=enviroCar">
            <img alt="Get it on Google Play" style="margin-left: 50px; margin-top: 10px;"
                 src="https://developer.android.com/images/brand/en_generic_rgb_wo_60.png" />
          </a>
       </div>
        <div class="span4">
          <h2><? echo $index_cont10;?></h2>
          <p style="text-align: justify;"><? echo $index_cont11;?></p>
        </div>
        <div class="span4">
          <h2><? echo $index_cont12;?></h2>
          <a href="http://www.indiegogo.com/projects/envirocar" target='_blank'>
            <img style="width:70%;" src="http://www.indiegogo.com/assets/igg_logo_color_print_black_h.jpg"/>
          </a>
        </div>
      </div>

	</div>

	<div class="container rightband">
      <div class="featurette" style="margin-left: 2%">
		<img class="featurette-image pull-right" src="./assets/img/heatmap.PNG" style="width: 50%; padding: 3%"/>
		<h2 class="featurette-heading"><? echo $envirocar;?> <span class="muted"><? echo $index_cont19;?></span></h2>
		<p class="lead" style="text-align: justify">
			<? echo $index_cont13;?>
		</p>
      </div>

      <hr class="featurette-divider">

      <div class="featurette" style="margin-right: 2%">
		<img class="featurette-image pull-left" src="./assets/img/architecture.svg"  style="width: 50%; padding: 3%"/>
		<h2 class="featurette-heading"><? echo $index_cont14;?><span class="muted"><? echo ' '.$index_cont15;?></span></h2>
		<p class="lead" style="text-align: justify">
		</p>
      </div>
	</div>
  <?
  include('footer.php');
  ?>
