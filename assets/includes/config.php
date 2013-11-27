<?php
/* This is the global config file for enviroCar.org
* if variables need to be accessible require_once this file and add a function to get the variable
* example:
* 
* require_once('config.php');
*
*function get_serverurl()
*{
*  global $serverurl;
*  return $serverurl;
*}
*
*/

//Server related variables
$serverurl	= "https://envirocar.org/api/stable";
$serverurl_dev 	= "https://envirocar.org/api/dev";
$chainfile = "wwuca_chain.pem";

//Find out if stable or dev should be used
if(strpos($_SERVER['REQUEST_URI'], 'dev')){
	$serverurl = $serverurl_dev;
}


//WPS url variables
$wps_fuel_price =  "http://geoprocessing.demo.52north.org:8080/wps/WebProcessingService?Service=WPS&Request=Execute&Version=1.0.0&Identifier=org.n52.wps.extension.GetFuelPriceProcess&RawDataOutput=fuelPrice&DataInputs=fuelType=";
$wps_tracks =  "http://geoprocessing.demo.52north.org:8081/enviroCar-wps/WebProcessingService?Service=WPS&Request=Execute&Version=1.0.0&Identifier=org.n52.wps.extension.GetNumberOfAllEnviroCarTracks&RawDataOutput=numberOfAllEnviroCarTracks&DataInputs=serverURL=https://envirocar.org/api/stable/tracks/";

?>