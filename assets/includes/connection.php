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

require_once('config.php');

function get_serverurl()
{
  global $serverurl;
  return $serverurl;
}

function get_wps_tracks()
{
  global $wps_tracks;
  return $wps_tracks;
}

function get_wps_fuel_price()
{
  global $wps_fuel_price;
  return $wps_fuel_price;
}




if (!isset($_SESSION)) session_start();

/*Example Usage:
$uri = 'example.com:80/api/stable/users/website';

echo get_request($uri, true);
echo '<br>';
echo get_request('example.com:80/api/stable/users/', false);
*/


function get_request($uri, $isAuthRequired){
    $ch = curl_init($uri);
    if($isAuthRequired){
        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER  => array('X-User: '.$_SESSION['name'], 'X-Token: '.$_SESSION['password']),  
            CURLOPT_RETURNTRANSFER  =>true,
            CURLOPT_VERBOSE     => 0,
            CURLOPT_FOLLOWLOCATION => TRUE
        ));
    }else{
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER  =>true,
            CURLOPT_VERBOSE     => 0,
            CURLOPT_FOLLOWLOCATION => TRUE
        ));
    }
    curl_setopt($ch, CURLOPT_HEADER, 1);
    
    //Performs the curl GET request
    $out = curl_exec($ch);
    
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$header = substr($out, 0, $header_size);
	$body = substr($out, $header_size);
    
    //Returns the HTTP status codes 
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $lastUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

    curl_close($ch);

    return array("status" => $http_status, "response" => $body, "url" => $lastUrl, "header" => $header);

}


//Method to perform a POST request
function post_request($url, $data, $isAuthRequired){
    $data_string = json_encode($data);                                                                                   
     
    $ch = curl_init($url);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_VERBOSE,0);                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	if($isAuthRequired){
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string),
			'X-User: '.$_SESSION['name'], 
			'X-Token: '.$_SESSION['password'])
		);      
	}
	else{
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))
		);                                            
	}
    $result = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return array("status" => $http_status, "response" => $result);
}

//Method to perform a PUT request
function put_request($url, $data){
    $data_string = json_encode($data);
    $ch = curl_init($url);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);   
    curl_setopt($ch, CURLOPT_VERBOSE,0);                                                               
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                   
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string),
        'X-User: '.$_SESSION['name'], 
        'X-Token: '.$_SESSION['password'])                                                                       
    );                                                                                                                   
    
    $result = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return array("status" => $http_status, "response" => $result);
}

//Method to perform a DELETE request
function delete_request($url){                                                                                
     
    $ch = curl_init($url);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_VERBOSE,0);                                                                                                
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                   
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'X-User: '.$_SESSION['name'], 
        'X-Token: '.$_SESSION['password'])                                                                       
    );                                                                                                  
    $result = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    return array("status" => $http_status, "response" => $result);
}

?>
