<?
require_once('connection.php');


$baseURL = get_serverurl(); //as defined in config.php
//USAGE: Just call this page via GET with the specific parameters:
// users.php?user=username
// users.php?friends
// users.php?addFriend=friendname
// users.php?deleteFriend=friendname
// users.php?groups

//Possible error status: 303,400,401,403,303


if(isset($_GET['avatar'])){
	if(isset($_GET['size'])) $response = get_image_request($baseURL.'/users/'.rawurlencode($_GET['avatar']).'/avatar&size='.$_GET['size']);
	else $response = get_image_request($baseURL.'/users/'.rawurlencode($_GET['avatar']).'/avatar');
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
		echo $response['response'];
	}
}

if(isset($_GET['user'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_GET['user']), true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['users'])){
	$response = get_request($baseURL.'/users/', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['friends'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/friends', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['friendsOf'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_GET['friendsOf']).'/friends', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['addFriend'])){
	$friend = array("name" => ''.$_POST['addFriend']); 
	$response = post_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/friends', $friend, true);
	if($response['status'] == 204){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['deleteFriend'])){ 
	$response = delete_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/friends/'.rawurlencode($_POST['deleteFriend']));
	if($response['status'] == 204){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['groups'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/groups', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['groupsOf'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_GET['groupsOf']).'/groups', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['createGroup'])){
	$group = array("name" => rawurlencode($_POST['group_name']), "description" => rawurlencode($_POST['group_description']));
	$response = post_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/groups',$group, true);
	if($response['status'] == 201){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['tracks'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/tracks', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['tracks-page'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/tracks'.'?limit=5&page='.rawurlencode($_GET['tracks-page']), true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['track'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/tracks/'.rawurlencode($_GET['track']), true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['atrack'])){
	$response = get_request($baseURL.'/tracks/'.rawurlencode($_GET['atrack']), true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['trackStatistics'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/tracks/'.rawurlencode($_GET['trackStatistics']).'/statistics', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['atrackStatistics'])){
	$response = get_request($baseURL.'/tracks/'.rawurlencode($_GET['atrackStatistics']).'/statistics', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['allStatistics'])){
	$response = get_request($baseURL.'/statistics', false);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['userStatistics'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/statistics', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['friendStatistics'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_GET['friendStatistics']).'/statistics', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}


if(isset($_GET['userActivities'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/activities', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['friendActivities'])){
	$response = get_request($baseURL.'/users/'.rawurlencode($_SESSION['name']).'/friendActivities', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['lostPassword'])){
	$changeData = array("user" => array("name" => $_POST['user'], "mail" => $_POST['email']));
	$response = post_request($baseURL.'/resetPassword', $changeData, false);

	if($response['status'] == 200){
		echo json_encode($response);
	}else{
		echo json_encode($response);
	}
}

if(isset($_GET['resetPassword'])){
	$changeData = array("user" => array("name" => $_POST['user'], "token" => $_POST['password']), "code" => $_POST['code']);

	$response = put_request($baseURL.'/resetPassword', $changeData);
	if($response['status'] == 200){
		echo json_encode($response);
	}else{
		echo json_encode($response);
	}
}

if(isset($_GET['updateUser'])){
	$changeData = array();
	$response = [];

	if (!empty($_POST['firstName'])) {
		$changeData['firstName'] = $_POST['firstName'];
	}
	if (!empty($_POST['lastName'])) {
		$changeData['lastName'] = $_POST['lastName'];
	}
	if (!empty($_POST['country'])) {
		$changeData['country'] = $_POST['country'];
	}
	if (!empty($_POST['mail'])) {
		$changeData['mail'] = $_POST['mail'];
	}
	if (!empty($_POST['gender'])) {
		$changeData['gender'] = $_POST['gender'];
	}
	if (!empty($_POST['language'])) {
		$changeData['language'] = $_POST['language'];
	}
	if (!empty($_POST['dayOfBirth'])) {
		$changeData['dayOfBirth'] = $_POST['dayOfBirth'];
	}
	if (!empty($_POST['password'])) {
		if(isset($_POST['oldPassword'])){
			if($_SESSION['password'] == $_POST['oldPassword']){
				$changeData['token'] = $_POST['password'];
				$response = put_request($baseURL.'/users/'.rawurlencode($_SESSION['name']), $changeData);
			}else{
				$response['status'] = 401;
			}
		}
	}

	//$changeData = array("firstName" => ''.$_GET['firstName'], "lastName" => ''.$_GET['lastName'], "country" => ''.$_GET['country'], "gender" => ''.$_GET['gender'], "language" => ''.$_GET['language'], "dayOfBirth" => ''.$_GET['dayOfBirth']);  
	if(empty($_POST['password'])){
		$response = put_request($baseURL.'/users/'.rawurlencode($_SESSION['name']), $changeData);
	}

	if($response['status'] == 204){
		if (!empty($_POST['password'])) {
			//update the session password
			error_log("Updating user password due to change");
			$_SESSION['password'] = $_POST['password'];
		}
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['updateAcceptedTermsofUse'])){
	$changeData = array("acceptedTermsOfUseVersion" => ''.$_GET['date']);
	$response = put_request($baseURL.'/users/'.rawurlencode($_SESSION['name']), $changeData);
	if($response['status'] == 204){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}


?>
