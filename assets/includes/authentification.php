<?
if (!isset($_SESSION)) session_start();

require('connection.php');
$baseUrl = 'giv-car.uni-muenster.de:8080/stable/rest/';

if(isset($_GET['login'])){
	$_SESSION['name'] = $_POST['name'];
	$_SESSION['password'] = $_POST['password'];

	$response = get_request($baseUrl.'users/'.$_POST['name'], true);

	if($response["status"] == 200){
		$response = json_encode($response["response"]);
		echo 'status:ok';
	}else{
		session_destroy();
		echo 'access_denied';
	}
}
else if(isset($_GET['registration'])){
	//TODO send registration information to the server

	/*
	echo $_POST['name'].'<br>';
	echo $_POST['password'];
	echo $_POST['name'];
	*/
}

else if(isset($_GET['logout'])){
	session_destroy();
	header('Location: ../../website/index.php?logout');
}


function is_logged_in(){
	if(isset($_SESSION['name']) && isset($_SESSION['password'])) return true;
	else return false;
}




?>