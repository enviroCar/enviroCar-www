<?
require_once('connection.php');

//USAGE: 
//Get all groups: call GET and groups.php?groups

//Create new group:
//groups.php?createGroup and POST "group_name" and "groupe_description"


if(isset($_GET['groups'])){
	$response = get_request('http://giv-car.uni-muenster.de:8080/stable/rest/groups/', false);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['createGroup'])){
	$group = array("name" => $_POST['group_name'], "description" => $_POST['group_description']);
	$response = post_request('http://giv-car.uni-muenster.de:8080/stable/rest/groups/', $group, true);
	if($response['status'] == 201){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['groupMembers'])){
	$response = get_request('http://giv-car.uni-muenster.de:8080/stable/rest/groups/'.$_GET['groupMembers'].'/members', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['groupActivities'])){
	$response = get_request('http://giv-car.uni-muenster.de:8080/stable/rest/groups/'.$_GET['groupActivities'].'/activities', true);
	if($response['status'] == 200){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['joinGroup'])){
	$user = array("name" => ''.$_SESSION['name']); 
	$response = post_request('http://giv-car.uni-muenster.de:8080/stable/rest/groups/'.$_GET['joinGroup'].'/members', $user, true);
	if($response['status'] == 204){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}

if(isset($_GET['leaveGroup'])){ 
	$response = delete_request('http://giv-car.uni-muenster.de:8080/stable/rest/groups/'.$_GET['leaveGroup'].'/members/'.$_SESSION['name']);
	if($response['status'] == 204){
		echo $response['response'];
	}else{
		echo $response['status'];
	}
}



?>