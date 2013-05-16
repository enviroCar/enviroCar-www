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


?>