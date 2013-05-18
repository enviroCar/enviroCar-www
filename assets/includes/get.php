<?
require_once('connection.php');


if(isset($_GET['url'])){
	if(isset($_GET['auth'])){
		$response = get_request($_GET['url'], $_GET['auth']);
	}else{
		$response = get_request($_GET['url'], false);
	}
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}