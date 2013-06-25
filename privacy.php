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
				<h2 id="privacy_website_head"><?echo $privacy_website_head; ?></h2>
				<p style="text-align: justify;">
					<?echo $privacy_website_text_01; ?>
					<ul>
						<?echo $privacy_website_text_use_datalist; ?>
					</ul>
					<?echo $privacy_website_text_02; ?>
					<ul>
						<?echo $privacy_website_text_register_datalist; ?>
					</ul>
					<?echo $privacy_website_text_03; ?>
				</p>
			</div>
		</div>
	</div>

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<h2 id="privacy_cookies_head"><?echo $privacy_cookies_head; ?></h2>
				<p style="text-align: justify;">
					<?echo $privacy_cookies_text_01; ?>
					<ul>
						<?echo $privacy_cookies_text_use_datalist; ?>
					</ul>
					<?echo $privacy_cookies_text_02; ?>
				</p>
			</div>
		</div>
	</div>
	
	<div class="container leftband">
		<div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<h2 id="privacy_uploadeddata_head"><?echo $privacy_uploadeddata_head; ?></h2>
				<p style="text-align: justify;">
					<?echo $privacy_uploadeddata_text; ?>
					<ul>
						<?echo $privacy_uploadeddata_datalist; ?>
					</ul>
				</p>
			</div>
		</div>
	</div>

<?
include('footer.php');
?>
