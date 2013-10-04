<?
require_once('connection.php');


$baseURL = $serverurl; //as defined in connection.php
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

if(isset($_GET['updateUser'])){
	$changeData = array("firstName" => ''.$_POST['firstName'], "lastName" => ''.$_POST['lastName'], "country" => ''.$_POST['country'], "gender" => ''.$_POST['gender'], "language" => ''.$_POST['language'], "dayOfBirth" => ''.$_POST['dayOfBirth']);
	//$changeData = array("firstName" => ''.$_GET['firstName'], "lastName" => ''.$_GET['lastName'], "country" => ''.$_GET['country'], "gender" => ''.$_GET['gender'], "language" => ''.$_GET['language'], "dayOfBirth" => ''.$_GET['dayOfBirth']);  
	$response = put_request($baseURL.'/users/'.rawurlencode($_SESSION['name']), $changeData);
	if($response['status'] == 204){
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