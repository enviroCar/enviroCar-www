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

if(isset($_GET['friends'])){
	$response = get_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_SESSION['name'].'/friends', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['addFriend'])){
	$friend = array("name" => ''.$_GET['addFriend']); 
	$response = post_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_SESSION['name'].'/friends', $friend, true);
	if($response['status'] == 204){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['deleteFriend'])){ 
	$response = delete_request('http://giv-car.uni-muenster.de:8080/stable/rest/users/'.$_SESSION['name'].'/friends/'.$_GET['deleteFriend']);
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




?>