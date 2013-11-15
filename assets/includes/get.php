<?
require_once('connection.php');


if(isset($_GET['url'])){
	$host = parse_url($_GET['url'], PHP_URL_HOST);
	if($host == 'envirocar.org'){
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
}

if(isset($_GET['redirectUrl'])){
	$host = parse_url($_GET['redirectUrl'], PHP_URL_HOST);
	if($host == 'envirocar.org'){
		if(isset($_GET['auth'])){
			$response = get_request($_GET['redirectUrl'], $_GET['auth']);
		}else{
			$response = get_request($_GET['redirectUrl'], false);
		}
		if($response['status'] == 200){
			header('Location:'.$response['url']);
		}else{
			echo $response['status'];

		}
	}
}




