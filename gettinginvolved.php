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

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<h2 id="licensing_datalicensing_head"><?echo $aboutEnviroCarHead; ?></h2>
				<p style="text-align: justify">
				<?echo $aboutEnviroCarText; ?>
				</p>
			</div>
		</div>
	</div>

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<h2 id="licensing_allowed_head"><?echo $asACitizenHead; ?></h2>
				<p style="text-align: justify">
				<?echo $asACitizenText; ?>
				</p>
			</div>
		</div>
	</div>
	
	<div class="container leftband">
		<div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<h2 id="licensing_aslongas_head"><?echo $asAScientistHead; ?></h2>
				<p style="text-align: justify">
				<?echo $asAScientistText; ?>
				</p>
			</div>
		</div>
	</div>
	
	<div class="container leftband">
		<div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<h2 id="licensing_aslongas_head"><?echo $asAPlannerHead; ?></h2>
				<p style="text-align: justify">
				<?echo $asAPlannerText; ?>
				</p>
			</div>
		</div>
	</div>
	
	<div class="container leftband">
		<div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<h2 id="licensing_aslongas_head"><?echo $asADeveloperHead; ?></h2>
				<p style="text-align: justify">
				<?echo $asADeveloperText; ?>
				</p>
			</div>
		</div>
	</div>

<?
include('footer.php');
?>