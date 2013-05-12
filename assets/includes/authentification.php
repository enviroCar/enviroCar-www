<?
if (!isset($_SESSION)) session_start();

require('connection.php');
$baseUrl = 'giv-car.uni-muenster.de:8080/stable/rest/';

//Login
if(isset($_GET['login'])){
	$_SESSION['name'] = $_POST['name'];
	$_SESSION['password'] = $_POST['password'];

	$response = get_request($baseUrl.'users/'.$_POST['name'], true);

	if($response["status"] == 200){
		error_log($response['response'],0);
		$response = json_decode($response["response"],true);
		$_SESSION['mail'] = $response['mail'];
		echo 'status:ok';
	}else{
		session_destroy();
		echo 'access_denied';
	}
}

//Registration
else if(isset($_GET['registration'])){
	error_log($_POST['name'].' '.$_POST['email'].' '.$_POST['password'],0);

	$newUser = array("name" => ''.$_POST['name'], "mail" => ''.$_POST['email'], "token" => ''.$_POST['password']);  
	$response = post_request($baseUrl.'users', $newUser);

	error_log($response['status'],0);

	if($response["status"] == 201){
		$_SESSION['name'] = $_POST['name'];
		$_SESSION['password'] = $_POST['password'];
		echo 'status:ok';
	}else{
		echo 'status:error';
	}

}

else if(isset($_GET['logout'])){
	session_destroy();
	header('Location: ../../index.php?logout');
}


else if(isset($_GET['delete'])){
	if(isset($_POST['delete'])){
		if($_POST['delete']){
			$response = delete_request('giv-car.uni-muenster.de:8080/stable/rest/users/'.$_SESSION['name']);
			if($response['status'] == 204){
				echo 'status:ok';
				session_destroy();
			}
			else{
				echo 'status:error';
			}
		}
	}
}

function is_logged_in(){
	if(isset($_SESSION['name']) && isset($_SESSION['password'])) return true;
	else return false;
}




?>