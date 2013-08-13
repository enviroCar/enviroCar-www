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
				<h2 id="licensing_datalicensing_head"><?echo $licensing_datalicensing; ?></h2>
				<p style="text-align: justify">
				<?echo $licensing_datalicensingtext; ?>
				</p>
			</div>
		</div>
	</div>

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<h2 id="licensing_allowed_head"><?echo $licensing_allowed; ?></h2>
				<p style="text-align: justify">
				<?echo $licensing_allowedtext; ?>
				</p>
			</div>
		</div>
	</div>
	
	<div class="container leftband">
		<div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<h2 id="licensing_aslongas_head"><?echo $licensing_aslongas; ?></h2>
				<p style="text-align: justify">
				<?echo $licensing_aslongastext; ?>
				</p>
			</div>
		</div>
	</div>

<?
include('footer.php');
?>