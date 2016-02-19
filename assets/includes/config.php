<?php
/*
* This file is part of enviroCar.
* 
* enviroCar is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* enviroCar is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with enviroCar.  If not, see <http://www.gnu.org/licenses/>.
*
* This is the global config file for enviroCar.org
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

//Find out if stable or dev should be used
if(strpos($_SERVER['REQUEST_URI'], 'dev')){
	$serverurl = $serverurl_dev;
}


//WPS url variables
$wps_fuel_price = "http://processing.envirocar.org:8080/wps/WebProcessingService?Service=WPS&Request=Execute&Version=1.0.0&Identifier=org.envirocar.wps.GetFuelPriceProcess&RawDataOutput=fuelPrice&DataInputs=fuelType=";
