<?
require_once('connection.php');

//USAGE: Just call this page via GET with the specific parameters:
// users.php?user=username
// users.php?friends
// users.php?addFriend=friendname
// users.php?deleteFriend=friendname
// users.php?groups

//Possible error status: 303,400,401,403,303

if(isset($_GET['user'])){
	$response = get_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_GET['user'], true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['users'])){
	$response = get_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['friends'])){
	$response = get_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_SESSION['name'].'/friends', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['friendsOf'])){
	$response = get_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_GET['friendsOf'].'/friends', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['addFriend'])){
	$friend = array("name" => ''.$_POST['addFriend']); 
	$response = post_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_SESSION['name'].'/friends', $friend, true);
	if($response['status'] == 204){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['deleteFriend'])){ 
	$response = delete_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_SESSION['name'].'/friends/'.$_POST['deleteFriend']);
	if($response['status'] == 204){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['groups'])){
	$response = get_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_SESSION['name'].'/groups', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['groupsOf'])){
	$response = get_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_GET['groupsOf'].'/groups', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['createGroup'])){
	$group = array("name" => $_POST['group_name'], "description" => $_POST['group_description']);
	$response = post_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_SESSION['name'].'/groups',$group, true);
	if($response['status'] == 201){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['tracks'])){
	$response = get_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_SESSION['name'].'/tracks', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['track'])){
	$response = get_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_SESSION['name'].'/tracks/'.$_GET['track'], true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['trackStatistics'])){
	$response = get_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_SESSION['name'].'/tracks/'.$_GET['trackStatistics'].'/statistics', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['userStatistics'])){
	$response = get_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_SESSION['name'].'/statistics', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['userActivities'])){
	$response = get_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_SESSION['name'].'/activities', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}




?>