<?
require_once('connection.php');


//Possible error status: 303,400,401,403,303

if(isset($_GET['getTerms'])){
	$response = get_request($serverurl."/termsOfUse", true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

?>