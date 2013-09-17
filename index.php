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
      <div class="span12" style="margin: 0; padding: 0; background-image: url(./assets/img/marketing/envCar_Foto13.jpg); height: 250px; width 100%; background-size: cover;">
    	<div style="margin-right:1%;margin-top:15%;float:right">	
    		<img src="./assets/img/under_construction.png" style="height:70px"/><span style="color: white;background-color:black;"><?echo $under_construction;?> </span>
		</div>	
      </div>
<? 	} else { ?>
	<div class="span" style="margin: 0; padding: 0; background-image: url(./assets/img/marketing/envCar_Foto13.jpg); height: 250px; width 100%; background-size: cover;">
		<div style="margin-right: 1%; float:right; text-align: center">
			<h2 style="color:WhiteSmoke; text-shadow: 0.1em 0.1em 0.1em black; margin-bottom: 0em; padding-bottom: 0em;">
				<? echo  $index_welcome;?>, <?echo $_SESSION["name"];?>
			</h2>
			<a href="./assets/includes/authentification?logout" style="color: white; font-size: small">
				<? echo  $index_wrong_name;?>
			</a>
			<br/>
			<a href="dashboard.php">
				<button class="btn btn-medium btn-inversed" name="dashboard" value="dashboard" style="margin-top: 2em"><? echo  $index_continue_dashboard;?></button>
			</a>
			<br/>
			<br/>
			<img src="./assets/img/under_construction.png" style="height:70px"/><span style="color: white;background-color:black;"><?echo $under_construction;?> </span>
		</div>
	 </div>
<? } ?>
    </div>
  </div> <!-- /container -->

	<div class="container leftband">
	<div class="row-fluid">
        <div class="span4">
<a class="twitter-timeline" href="https://twitter.com/enviroCar_org" data-chrome="noscrollbar" data-widget-id="335068168525578241">Tweets von @enviroCar_org</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

       </div>
        <div class="span7">
          <h2 class="featurette-heading"><? echo $index_be_a_citizen_scientist;?></h2>
          <p style="text-align: justify;"><? echo $index_help_the_world;?></p>
        </div>
  <!--      <div class="span4">
          <h2><? echo $index_support_indiegogo;?></h2>
          <a href="http://www.indiegogo.com/projects/envirocar" target='_blank'>
            <img style="width:70%;" src="http://www.indiegogo.com/assets/igg_logo_color_print_black_h.jpg"/>
          </a>
        </div>-->
      </div>

	</div>

	<div class="container rightband">
      <div class="featurette" style="margin-left: 2%">
		<img class="featurette-image pull-right" src="./assets/img/enviroCarConceptOverview.png" style="width: 40%; padding: 3%" alt=""/>
		<h2 class="featurette-heading"><? echo $envirocar;?> <span class="muted"><? echo $index_here_we_go;?></span></h2>
		<p class="lead" style="text-align: justify">
			<? echo $index_this_is_community;?>
		</p>
      </div>
	</div>
  <?
  include('footer.php');
  ?>
