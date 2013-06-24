<?
if (!isset($_SESSION)) session_start();

require('connection.php');
$baseUrl = $serverurl;

//Login
if(isset($_GET['login'])){
	$_SESSION['name'] = $_POST['name'];
	$_SESSION['password'] = $_POST['password'];
		
	$response = get_request($baseUrl.'/users/'.$_POST['name'], true);

	if($response["status"] == 200){
		$response = json_decode($response["response"],true);
		$_SESSION['mail'] = $response['mail'];
	
		if (isset ($_POST['login_remember']) && 	$_POST['login_remember'] == "on"){
			//ToDdo: generate a place and remember me cookie
		}
		
		echo 'status:ok';
	}else{
		session_destroy();
		echo 'access_denied';
	}
}

//Registration
else if(isset($_GET['registration'])){

	$newUser = array("name" => ''.$_POST['name'], "mail" => ''.$_POST['email'], "token" => ''.$_POST['password']);  
	$response = post_request($baseUrl.'/users', $newUser, false);


	if($response["status"] == 201){
		$_SESSION['name'] = $_POST['name'];
		$_SESSION['password'] = $_POST['password'];
		echo 'status:ok';
	}else{
		echo 'status:error';
	}

}

else if(isset($_GET['logout'])){
	if (isset($_SESSION)) session_destroy();
	header('Location: ../../index.php?lo=done');
}


else if(isset($_GET['delete'])){
	if(isset($_POST['delete'])){
		if($_POST['delete']){
			$response = delete_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_SESSION['name']);
			if($response['status'] == 204){
				echo 'status:ok';
				session_destroy();
			}
			else{
				echo $response['status'];
			}
		}
	}
}

function is_logged_in(){
	if(isset($_SESSION['name']) && isset($_SESSION['password'])) return true;
	else return false;
}



function login($name, $password, $permanent){

	$baseUrl = 'giv-car.uni-muenster.de:8080/stable/rest/';
	if (!isset($_SESSION)) session_start();
	
	$_SESSION['name'] = $name;
	$_SESSION['password'] = $password;
		
	$response = get_request($baseUrl.'users/'.$name, true);

	if($response["status"] == 200){
		$response = json_decode($response["response"],true);
		$_SESSION['mail'] = $response['mail'];
	
		if ($permanent == true){
			//ToDo: generate a place and remember me cookie
		}
		
		return true;
	}else{
		if (isset($_SESSION)) session_destroy();
		
		return false;
	}
}





//language
if(isSet($_GET['lang']))
{
$lang = $_GET['lang'];

// register the session and set the cookie
$_SESSION['lang'] = $lang;

setcookie('lang', $lang, time() + (3600 * 24 * 30));
}
else if(isSet($_SESSION['lang']))
{
$lang = $_SESSION['lang'];
}
else if(isSet($_COOKIE['lang']))
{
$lang = $_COOKIE['lang'];
}
else
{
$lang = 'en';
}



include('lang_'.$lang.'.php');


?>
