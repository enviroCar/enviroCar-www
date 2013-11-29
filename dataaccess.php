<?php
/*
* This file is subject to the terms and conditions defined in
* file 'LICENSE', which is part of this source code package.
*/

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

<!--	<div class="container leftband">
		<div class="row-fluid">
			<div class="span" style="padding-right: 1ex">
				<h2 id="licensing_allowed_head"><? echo $viaDownloadHead ?></h2>
				<p style="text-align: justify">
				<? echo $viaDownloadText ?>
				</p>
			</div>
		</div>
	</div>-->

	<div class="container leftband">
		<div class="row-fluid">
			<div class="span12">
				<h2 id="licensing_datalicensing_head"><? echo $dataaccess_viaAPIHead ?></h2>
				<p style="text-align: justify">
					<? echo $dataaccess_viaAPIText ?>
				</p>
				<h3 id="licensing_datalicensing_head"><? echo $dataaccess_endpointHead ?></h3>
				<p style="text-align: justify">
					<? echo $dataaccess_endpointText ?>
				</p>
			</div>
		</div>
	</div>

<?
include('footer.php');
?>