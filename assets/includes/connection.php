<?
if (!isset($_SESSION)) session_start();

/*Example Usage:
$uri = 'giv-car.uni-muenster.de:8080/stable/rest/users/website';

echo get_request($uri, true);
echo '<br>';
echo get_request('giv-car.uni-muenster.de:8080/stable/rest/users/', false);
*/
function get_request($uri, $isAuthRequired){
    $ch = curl_init($uri);
    if($isAuthRequired){
        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER  => array('X-User: '.$_SESSION['name'], 'X-Token: '.$_SESSION['password']),  
            CURLOPT_RETURNTRANSFER  =>true,
            CURLOPT_VERBOSE     => 0,
            CURLOPT_CAPATH => "wwuca_chain.pem"
        ));
    }else{
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER  =>true,
            CURLOPT_VERBOSE     => 0
        ));
    }
    
    //Performs the curl GET request
    $out = curl_exec($ch);
    //Returns the HTTP status codes 
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    return array("status" => $http_status, "response" => $out);

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



// Update user: $user = array("mail" => "test@dennismail.com");
// put_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/dennis', $user);

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


//delete_request('giv-car.uni-muenster.de:8080/stable/rest/users/blablub');

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