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
				<p style="text-align: justify">
				<?echo $terms_general; ?>
				</p>
			</div>
		</div>
	</div>

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<h2 id="licensing_allowed_head" class="featurette-heading"><?echo $terms_cookies_heading; ?></h2>
				<p style="text-align: justify">
				<?echo $terms_cookies_text; ?>
				</p>
				<p class="pull-right">
					<a href="#"><? echo $back_top ?></a>
				</p>
			</div>
		</div>
	</div>
	
	<div class="container leftband">
		<div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<h2 id="licensing_aslongas_head" class="featurette-heading"><?echo $terms_local_track_data_heading; ?></h2>
				<p style="text-align: justify">
				<?echo $terms_local_track_data_text; ?>
				</p>
				<p class="pull-right">
					<a href="#"><? echo $back_top ?></a>
				</p>
			</div>
		</div>
	</div>
	
		<div class="container leftband">
		<div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<h2 id="privacy_website_head" class="featurette-heading"><?echo $terms_remote_track_data_heading; ?></h2>
				<p style="text-align: justify;">
					<?echo $terms_remote_track_data_text; ?>
				</p>
			</div>
		</div>
	</div>

<?
include('footer.php');
?>