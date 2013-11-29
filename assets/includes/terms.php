<?php
/*
* This file is subject to the terms and conditions defined in
* file 'LICENSE', which is part of this source code package.
*/

require_once('connection.php');


//Possible error status: 303,400,401,403,303

if(isset($_GET['getTerms'])){
	$response = get_request(get_serverurl()."/termsOfUse", true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

?>