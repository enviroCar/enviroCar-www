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

require('connection.php');

//Registration
if(isset($_GET['registration'])){

	$newUser = array("name" => ''.$_POST['name'], "mail" => ''.$_POST['email'], "token" => ''.$_POST['password1']);  
	$response = post_request(get_serverurl().'/users', $newUser, false);


	if($response["status"] == 201){
		$_SESSION['name'] = $_POST['name'];
		$_SESSION['password'] = $_POST['password'];
		header('Location: ../../index.php?registration_successful');
	}elseif($response["status"] == 409){
		header('Location: ../../registration.php?name_taken');
	}else{
		echo $response['status'];
	}

}

else if(isset($_GET['logout'])){
	if (isset($_SESSION)) session_destroy();
	header('Location: ../../index.php?lo=done');
}


else if(isset($_GET['delete'])){
	if(isset($_POST['delete'])){
		if($_POST['delete']){
			$response = delete_request(get_serverurl().'/users/'.$_SESSION['name']);
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

else if(isset($_GET['test'])){
	echo login("jakob2", "jakob2", true);
}

function is_logged_in(){
	if(isset($_SESSION['name']) && isset($_SESSION['password'])) return true;
	else return false;
}



function login($name, $password, $permanent){
	
	$_SESSION['name'] = $name;
	$_SESSION['password'] = $password;

	error_log($_SESSION['name'].' '.$_SESSION['password']);

	$response = get_request(get_serverurl().'/users/'.$name, true);
	if($response["status"] == 200){
		$response = json_decode($response["response"],true);
		$_SESSION['mail'] = $response['mail'];
	
		if ($permanent == true){
			//ToDo: generate a place and remember me cookie
		}
		
		return true;
	}else{
		if (isset($_SESSION)) session_destroy();
		$_SESSION['name'] = null;
		$_SESSION['password'] = null;

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
