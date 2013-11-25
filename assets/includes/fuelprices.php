<?
require_once('connection.php');

if(isset($_GET['fuelType'])){
	$response = get_request(get_wps_fuel_price().rawurlencode($_GET['fuelType']));
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}
?>