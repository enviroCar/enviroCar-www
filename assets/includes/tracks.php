<?
require_once('connection.php');

	$response = get_request(get_wps_tracks(), false);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}

?>
