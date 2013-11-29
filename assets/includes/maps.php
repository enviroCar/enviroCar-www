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
*/

require_once('connection.php');


//$baseURL = 'http://envirocar.maps.arcgis.com/sharing/rest/search?num=100&sortField=numviews&sortOrder=desc&f=json&q=orgid%3APB9SnOIIMtO6Bham%20-type:%22Web%20Map%22';
$baseURL = 'http://envirocar.maps.arcgis.com/sharing/rest/search?q=orgid%3APB9SnOIIMtO6Bham%20-type:%22Layer%22%20-type:%20%22Map%20Document%22%20-type:%22Map%20Package%22%20-type:%22ArcPad%20Package%22%20-type:%22Explorer%20Map%22%20-type:%22Globe%20Document%22%20-type:%22Scene%20Document%22%20-type:%22Published%20Map%22%20-type:%22Map%20Template%22%20-type:%22Windows%20Mobile%20Package%22%20-type:%22Layer%20Package%22%20-type:%22Explorer%20Layer%22%20-type:%22Geoprocessing%20Package%22%20-type:%22Application%20Template%22%20-type:%22Code%20Sample%22%20-type:%22Geoprocessing%20Package%22%20-type:%22Geoprocessing%20Sample%22%20-type:%22Locator%20Package%22%20-type:%22Workflow%20Manager%20Package%22%20-type:%22Windows%20Mobile%20Package%22%20-type:%22Explorer%20Add%20In%22%20-type:%22Desktop%20Add%20In%22%20-type:%22Feature%20Collection%20Template%22&num=100&sortField=numviews&sortOrder=desc&f=json';
//USAGE: Just call this page via GET with the specific parameters:
// maps.php?maps

//Possible error status: 303,400,401,403,303

if(isset($_GET['maps'])){
	$response = get_request($baseURL, true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

?>