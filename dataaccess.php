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
			<div class="span12">
				<h2 id="dataaccess"><? echo $dataaccess_head ?></h2>
				<h3 id="data_api"><? echo $dataaccess_viaAPIHead ?></h3>
				<p style="text-align: justify">
					<? echo $dataaccess_viaAPIText ?>
				</p>
				<h4 id="data_endpoint"><? echo $dataaccess_endpointHead ?></h4>
				<p style="text-align: justify">
					<? echo $dataaccess_endpointText ?>
				</p>
				<h4 id="data_download"><? echo $dataaccess_downloadHead ?></h4>
				<p style="text-align: justify">
				<? echo $dataaccess_downloadText ?>
				</p>
				<h3 id="data_license"><? echo $dataaccess_licenseHead ?></h3>
				<p style="text-align: justify">
					<? echo $dataaccess_licenseText ?>
				</p>
			</div>
		</div>
	</div>

<?
include('footer.php');
?>