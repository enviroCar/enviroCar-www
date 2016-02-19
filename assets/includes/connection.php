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


function get_wps_fuel_price()
{
  global $wps_fuel_price;
  return $wps_fuel_price;
}

/*
 * class for curl objects;
 * parses headers, status and response
 */
class cUrl {
    public $response;
    public $header = array();
    public $status;
    
    function cUrl($url, $isAuthRequired) {
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true, //Causes curl_exec() to return the response
            CURLOPT_HEADER         => false, //Suppress headers from returning in curl_exec()
            CURLOPT_HEADERFUNCTION => array($this, 'header_callback'),
        ));
        
        if ($isAuthRequired){
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-User: '.$_SESSION['name'], 'X-Token: '.$_SESSION['password']));
        }
        
        $this->response = curl_exec($ch);
        
        $this->status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);
        return $this->response;
    }

    function header_callback($ch, $header_line){
        $arr = explode(': ', $header_line);
        
        if (sizeof($arr) == 1) {
            return strlen($header_line);
        }
        
        $this->header[$arr[0]] = $arr[1];

        return strlen($header_line);
    }
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
    
    //Performs the curl GET request
    $out = curl_exec($ch);
    //Returns the HTTP status codes 
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $lastUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

    curl_close($ch);

    return array("status" => $http_status, "response" => $out, "url" => $lastUrl);

}

function get_request_with_headers($uri, $isAuthRequired){
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

function get_request_no_follow($uri, $isAuthRequired){
    $cObj = new cUrl($uri, $isAuthRequired);
    
//    $startTime = time();
//    error_log("Start request... ". $uri);
    
//    error_log("Finished request in (ms): ".  (time() - $startTime));
//    var_dump($cObj->header);

    $loc;
    if (array_key_exists('Location', $cObj->header)) {
        $loc = $cObj->header['Location'];
    }
    else {
        $loc = "";
    }
    
    return array("status" => $cObj->status, "response" => $cObj->response, "url" => $loc);
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

function processTrackNumberResponse($response) {
	if ($response['status'] == 200) {
		$header_array = explode("\n", $response['header']);
		
		$header_size = count($header_array);
		for ($i = 0; $i < $header_size; ++$i) {
			if (strpos($header_array[$i], "Content-Range") === 0) {
				return trim(substr($header_array[$i], strpos($header_array[$i], "/")+1, strlen($header_array[$i])));
			}
		}
		
		for ($i = 0; $i < $header_size; ++$i) {
			if (strpos($header_array[$i], "Link") === 0) {
				$links = explode(", ", $header_array[$i]);
				
				$links_size = count($links);
				for ($j = 0; $j < $links_size; ++$j) {
					if (strpos($links[$j], "rel=last")) {
						$pageIndex = strpos($links[$j], "page=");
						$pageEndIndex = strpos($links[$j], ">;", $pageIndex);

						return trim(substr($links[$j], $pageIndex+5, $pageEndIndex - ($pageIndex+5)));
					}
				}

			}
		}
		//echo $response['response'];
		return substr_count($response['response'], 'id');
	} else {
		return $response['status'];
	}
}