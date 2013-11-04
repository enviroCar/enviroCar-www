<?
require_once('connection.php');

$wpsRL =  "http://geoprocessing.demo.52north.org:8081/enviroCar-wps/WebProcessingService?Service=WPS&Request=Execute&Version=1.0.0&Identifier=org.n52.wps.extension.GetNumberOfAllEnviroCarTracks&RawDataOutput=numberOfAllEnviroCarTracks&DataInputs=serverURL=https://envirocar.org/api/stable/tracks/";

	$response = get_request($wpsRL, false);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}

?>
