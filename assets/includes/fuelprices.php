<?
require_once('connection.php');

$wpsURL =  "http://geoprocessing.demo.52north.org:8080/wps/WebProcessingService?Service=WPS&Request=Execute&Version=1.0.0&Identifier=org.n52.wps.extension.GetFuelPriceProcess&RawDataOutput=fuelPrice&DataInputs=fuelType=";

if(isset($_GET['fuelType'])){
	$response = get_request($wpsURL.rawurlencode($_GET['fuelType']));
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}
?>