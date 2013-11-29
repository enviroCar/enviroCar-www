<?php
/*
* This file is subject to the terms and conditions defined in
* file 'LICENSE', which is part of this source code package.
*/

require_once('connection.php');

	$response = get_request(get_wps_tracks(), false);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}

?>
