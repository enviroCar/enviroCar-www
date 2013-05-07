<?
session_start();

if(isset($_GET['login'])){
	//TODO send credentials to the server and validate output
	//Change according to server response
	if(true){
		
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['password'] = $_POST['password'];
		echo 'status:ok';
	}
}
else if(isset($_GET['registration'])){
	//TODO send registration information to the server
	echo $_POST['email'].'<br>';
	echo $_POST['password'];
	echo $_POST['name'];
}

else if(isset($_GET['logout'])){
	session_destroy();
	header('Location: ../../website/index.php');
}


function is_logged_in(){
	if(isset($_SESSION['email']) && isset($_SESSION['password'])) return true;
	else return false;
}




?>